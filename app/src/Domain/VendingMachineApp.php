<?php

namespace App\Domain;

use App\Application\Helpers\Singleton;
use App\Domain\Repositories;
use App\Domain\Models\Product;
use App\Domain\Services\BaseSlot;
use App\Domain\Services\CoinSlot;
use App\Domain\Services\CashSlot;
use App\Domain\Services\ProductSlot;
use App\Domain\Services\Display;
use App\Domain\Exceptions\InvalidCashException;
use App\Domain\Exceptions\InvalidCoinException;
use App\Domain\Exceptions\InvalidProductException;
use App\Domain\Exceptions\SomethingWentWrongException;

final class VendingMachineApp
{
	use Singleton;

	public $cashRepository;
	public $coinRepository;
	public $productRepository;

	/**
	 * @todo DI container, please!!
	 * @param Repositories\CashRepository    $cashRepository    
	 * @param Repositories\CoinRepository    $coinRepository    
	 * @param Repositories\ProductRepository $productRepository 
	 */
	private final function __construct(Repositories\CashRepository $cashRepository,
									   Repositories\CoinRepository $coinRepository,
									   Repositories\ProductRepository $productRepository,
									   Display $display
									)
	{
		$this->cashRepository = $cashRepository;
		$this->coinRepository = $coinRepository;
		$this->productRepository = $productRepository;
		$this->display = $display;

		$this->init([
			new Product('WATER', 0.65),
			new Product('JUICE', 1),
			new Product('SODA', 1.50)
		]);
	}

/* PUBLIC API */

	public function getProduct(CashSlot $cashSlot, $productName): self
	{
	}

	/**
	 * Stores the coins inserted
	 * @param  CashSlot $cashSlot
	 * @return VendingMachineApp
	 */
	public function insertMoney(CashSlot $cashSlot): self
	{
		// User could have executed INSERT-MONEY command without arguments
		if($cashSlot->isEmpty()) {
			return $this;
		}

		$addedCoins = $this->restock($cashSlot);

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

	public function service(CoinSlot $coinSlot, ProductSlot $productSlot): self
	{
		$restockedCoins = $this->restock($coinSlot);
		if(!empty($restockedCoins)) {
			$this->display->addSummaryMessage($restockedCoins, 'Coins added:');
		}

		$restockedProducts = $this->restock($productSlot);
		if(!empty($restockedProducts)) {
			$this->display->addSummaryMessage($restockedProducts, 'Products added:');
		}

		return $this;
	}

	public function status(): self
	{
		$this->display->addSummaryMessage($this->cashRepository->getAllInventory(), 'Cash slot:');
		$this->display->addSummaryMessage($this->coinRepository->getAllInventory(), 'Coins deposit:');
		$this->display->addSummaryMessage($this->productRepository->getAllInventory(), 'Products:');
		return $this;
	}

	public function getResponse(): string
	{
		return $this->display->flush();
	}

/* end PUBLIC API */

	private function restock(BaseSlot $slot): array
	{
		$restockItems = [];
		if(!$slot->isEmpty()) {

			try {
				$slot->validate();
			} catch (\Exception $e) {
				$this->display->addMessage($e->getMessage());
			}

			// Execution keeps going because user could have inserted valid items, even
			// if there are invalid ones
			
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
					throw new SomethingWentWrongException();
				}

				$this->$repositoryAttributeName->restock($restockItems);
			}
		}
		return $restockItems;
	}

	private function init(array $productsCatalog) 
	{
		foreach($productsCatalog as $product){
			$this->productRepository->addProductToCatalog($product);
		}
	}

	private static function getNewInstance(): VendingMachineApp
	{
        $class = self::class;

        return new $class(
        	new Repositories\CashRepository() ,
        	new Repositories\CoinRepository(),
        	new Repositories\ProductRepository(),
        	new Display
        );
	}
}