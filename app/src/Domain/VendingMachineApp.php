<?php

namespace App\Domain;

use App\Application\Helpers\Singleton;
use App\Domain\Repositories\CashRepository;
use App\Domain\Repositories\CoinRepository;
use App\Domain\Repositories\ProductRepository;
use App\Domain\Enum\ValidCoins;
use App\Domain\Models\Product;
use App\Domain\Services\BaseSlot;
use App\Domain\Services\CoinSlot;
use App\Domain\Services\CashSlot;
use App\Domain\Services\ProductSlot;
use App\Domain\Services\Display;
use App\Domain\Services\ChangeDispenser;
use App\Domain\Validators;
use App\Domain\Exceptions;

final class VendingMachineApp
{
	use Singleton;

	public $cashRepository;
	public $coinRepository;
	public $productRepository;
	private $cashSlot;
	private $coinSlot;
	private $productSlot;
	private $display;
	private $changeDispenser;

	/**
	 * @todo DI container, please!!
	 * @param CashRepository    $cashRepository    
	 * @param CoinRepository    $coinRepository    
	 * @param ProductRepository $productRepository 
	 */
	private final function __construct(CashRepository $cashRepository,
									   CoinRepository $coinRepository,
									   ProductRepository $productRepository,
									   CoinSlot $coinSlot,
									   CashSlot $cashSlot,
									   ProductSlot $productSlot,
									   Display $display,
									   ChangeDispenser $changeDispenser
									)
	{
		$this->cashRepository = $cashRepository;
		$this->coinRepository = $coinRepository;
		$this->productRepository = $productRepository;
		$this->coinSlot = $coinSlot;
		$this->cashSlot = $cashSlot;
		$this->productSlot = $productSlot;
		$this->display = $display;
		$this->changeDispenser = $changeDispenser;
	}

/* PUBLIC API */

	/**
	 * Stores the coins inserted
	 * @param  array $coins
	 * @return VendingMachineApp
	 */
	public function insertMoney(array $coins = []): self
	{
		// User could have executed INSERT-MONEY command without arguments
		if(empty($coins)) {
			return $this;
		}
		$this->cashSlot->setItems($coins);
		$addedCoins = $this->restock($this->cashSlot);

		return $this;
	}

	public function returnCoin(): self
	{
		if($this->cashRepository->isEmpty()) {
			$this->display->nothingToReturnMessage();
		} else {
			$coins = $this->cashRepository->flush();
			$this->display->addReturnCoinMessage($coins);
		}

		return $this;
	}

	public function credit(): self
	{
		$this->display->addUserCreditMessage($this->cashRepository->getCashTotal());
		return $this;
	}

	public function service(array $coins = [], array $products = []): self
	{
		$this->coinSlot->setItems($coins);
		$restockedCoins = $this->restock($this->coinSlot, true);

		$this->productSlot->setItems($products);
		$restockedProducts = $this->restock($this->productSlot, true);

		return $this;
	}

	public function status(): self
	{
		$this->display->addSummaryMessage($this->cashRepository->getAllInventory(), 'Cash slot:');
		$this->display->addSummaryMessage($this->productRepository->getAllInventory(), 'Products:');
		$this->display->addSummaryMessage($this->coinRepository->getAllInventory(), 'Coins deposit:');
		return $this;
	}

	public function getProduct(string $productName): self
	{
		// get product specifications
		$product = $this->getProductObject($productName);
		// check product stock
		$this->checkStock($productName);
		// check enough credit
		$this->checkCredit($product);
		// get change coins
		if(-1 == $changeCoins = $this->calculateChange($product)) {
			$this->display->notEnoughChange();
			return $this->returnCoin();
		}

		// moves money from cash slot to coins deposit
		$this->cashToCoins();
		// decrements the stock of the selected product
		$this->removeProductFromStock($product);

		if(!empty($changeCoins)) {
			// decrements the stock of the coins in change
			$this->removeChangeFromStock($changeCoins);
			$this->display->productWithChangeMessage($product->getName(), $changeCoins);
		} else {
			$this->display->addMessage($product->getName());
		}

		return $this;
	}

	public function getResponse(): string
	{
		return $this->display->flush();
	}

/* end PUBLIC API */

	private function getProductObject(string $productName): Product
	{
		if(!($product = $this->productRepository->getProductByName($productName))) {
			throw new Exceptions\ProductNotFoundException($productName);
		}
		return $product;
	}

	private function checkStock(string $productName): void
	{
		if(!$this->productRepository->hasStock($productName)) {
			throw new Exceptions\ProductNoStockException($productName);
		}
	}

	private function checkCredit(Product $product): void
	{
		$cashTotal = $this->cashRepository->getCashTotal();
		if($product->getPrice() > $cashTotal) {
			throw new Exceptions\NotEnoughMoneyException($product, $cashTotal);
		}
	}

	private function removeProductFromStock(Product $product): void
	{
		$this->productRepository->decrementStock($product->getName());
	}

	private function removeChangeFromStock(array $coinsChange): void
	{
		foreach($coinsChange as $coin) {
			$this->coinRepository->decrementStock($coin);
		}
	}

	private function calculateChange(Product $product)
	{
		$coinsStock = $this->coinRepository->getAllInventoryGrouped();
		// Adds the cash stock to the coins stock
		foreach($this->cashRepository->getAllInventory() as $coin) {
			$coin = strval($coin);
			if(!isset($coinsStock[$coin])) {
				$coinsStock[$coin] = 0;
			}
			$coinsStock[$coin]++;
		}
		$changeCoins = $this->changeDispenser->getChange($product->getPrice(), 
										  				 floatval($this->cashRepository->getCashTotal()), 
										  				 $coinsStock);
		return $changeCoins;
	}

	private function cashToCoins(): void
	{
		$cash = $this->cashRepository->flush();
		$this->coinRepository->restock($cash);
	}

	private function restock(BaseSlot $slot, bool $flush = false): array
	{
		$restockItems = [];
		if(!$slot->isEmpty()) {

			$slot->validate();

			$restockItems = $slot->getValidItems();
			if(!empty($restockItems)) {
				$repositoryAttributeName = null;

				// Selecting the corresponding repository based on the Slot class
				switch ((substr(get_class($slot), strrpos(get_class($slot), '\\') + 1))) {
					case 'CashSlot':
						$repositoryAttributeName = 'cashRepository';
						break;
					case 'CoinSlot':
						$repositoryAttributeName = 'coinRepository';
						break;
					case 'ProductSlot':
						$repositoryAttributeName = 'productRepository';
						break;
				}
				if(is_null($repositoryAttributeName) || !property_exists(self::class, $repositoryAttributeName)) {
					throw new Exceptions\SomethingWentWrongException();
				}

				if($flush) {
					$this->$repositoryAttributeName->flush();
				}
				$this->$repositoryAttributeName->restock($restockItems);
			}
		}
		return $restockItems;
	}

	private static function getNewInstance(): VendingMachineApp
	{
        $class = self::class;

        $cashRepository = new CashRepository;
        $coinRepository = new CoinRepository;
        $productRepository = new ProductRepository([
			new Product('WATER', 0.65),
			new Product('JUICE', 1),
			new Product('SODA', 1.50)
		]);

        $validCoins = ValidCoins::getValidValues();

        $productValidator = new Validators\ProductValidator($productRepository->getCatalogProductNames());
        $coinValidator = new Validators\CoinValidator($validCoins);

    	$coinSlot = new CoinSlot($coinValidator);
    	$cashSlot = new CashSlot($coinValidator);
    	$productSlot = new ProductSlot($productValidator);
    	$display = new Display;
        $changeDispenser = new ChangeDispenser($validCoins);

        return new $class(
        	$cashRepository,
        	$coinRepository,
        	$productRepository,
        	$coinSlot,
        	$cashSlot,
        	$productSlot,
        	$display,
        	$changeDispenser
        );
	}
}