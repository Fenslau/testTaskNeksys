<?php

namespace App\Http\Controllers;

use App\Services\BuyServiceInterface;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    public function __construct(
        private BuyServiceInterface $buyService,
    ) {
    }

    public function buy($product)
    {
        return $this->buyService->buy($product);
    }
}
