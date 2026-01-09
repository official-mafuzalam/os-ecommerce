<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LowStockAlert
{
    use Dispatchable, SerializesModels;

    public $product;
    public $stockLevel;

    public function __construct(Product $product, $stockLevel = null)
    {
        $this->product = $product;
        $this->stockLevel = $stockLevel;
    }
}