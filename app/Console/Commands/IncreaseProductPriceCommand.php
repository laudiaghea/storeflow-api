<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class IncreaseProductPriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:increase-product-price-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increase all product prices by 5 percent';

    private $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();

        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->productService->increasePrice(5);

        $this->info('Harga semua produk berhasil dinaikkan.');
    }
}
