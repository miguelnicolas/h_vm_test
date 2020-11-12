<?php

namespace App\Domain;

use App\Application\Helpers\Singleton;
use App\Domain\Repositories;
use App\Domain\Models\Product;
use App\Domain\Services\CashSlot;
use App\Domain\Services\Display;
use App\Infrastructure\Storage\MemoryStorage;
use App\Domain\Exceptions\InvalidCoinException;

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

		try {
			$cashSlot->validate();
		} catch (InvalidCoinException $e) {
			$this->display->addMessage($e->getMessage());
		}

		// Execution keeps going because user could have inserted valid coins, even
		// if there are invalid ones

		$validCoins = $cashSlot->getValidCoins();
		if(!empty($validCoins)) {
			// Adding valid coins to the user credit
			$this->cashRepository->addCoins($validCoins);
		}

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

	public function service(): self
	{
		return $this;
	}

	public function status(): self
	{
		return $this;
	}

	public function getResponse(): string
	{
		return $this->display->flush();
	}

/* end PUBLIC API */

	private function init(array $productsCatalog) 
	{
		foreach($productsCatalog as $product){
			$this->productRepository->addProductToCatalog($product);
		}
	}

	private static function getNewInstance(): VendingMachineApp
	{
        $class = self::class;
    	$memoryStorage = MemoryStorage::getInstance();

        return new $class(
        	new Repositories\CashRepository() ,
        	new Repositories\CoinRepository(),
        	new Repositories\ProductRepository(),
        	new Display
        );
	}
}