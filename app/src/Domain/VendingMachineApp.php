<?php

namespace App\Domain;

use App\Application\Helpers\Singleton;
use App\Domain\Repositories;
use App\Domain\Models\Product;
use App\Domain\Services\CashSlot;
use App\Infrastructure\Storage\MemoryStorage;

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
							Repositories\ProductRepository $productRepository
							)
	{
		$this->cashRepository = $cashRepository;
		$this->coinRepository = $coinRepository;
		$this->productRepository = $productRepository;

		$this->init([
			new Product('WATER', 0.65),
			new Product('JUICE', 1),
			new Product('SODA', 1.50)
		]);
	}

	private function init(array $productsCatalog) 
	{
		foreach($productsCatalog as $product){
			$this->productRepository->addProductToCatalog($product);
		}
	}

	public function getProduct(CashSlot $cashSlot, $productName)
	{
		if(!$cashSlot->isEmpty()) {
			$this->insertMoney($cashSlot);
		}
	}

	public function insertMoney(CashSlot $cashSlot)
	{

	}

	public function returnCoin()
	{
	}

	public function service()
	{
	}

	public function status()
	{
	}

	private static function getNewInstance(): VendingMachineApp
	{
        $class = self::class;
    	$memoryStorage = Storage();

        return new $class(
        	new Repositories\CashRepository() ,
        	new Repositories\CoinRepository(),
        	new Repositories\ProductRepository()
        );
	}
}