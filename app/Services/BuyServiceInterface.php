<?php

namespace App\Services;

use App\Models\Product;

interface BuyServiceInterface
{
    public function buy(Product $product);
}
