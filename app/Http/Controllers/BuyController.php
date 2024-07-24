<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyRequest;
use App\Models\Product;
use App\Repositories\RepositoryInterface;
use App\Services\BuyServiceInterface;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    public function __construct(
        private BuyServiceInterface $buyService,
        private RepositoryInterface $repo
    ) {
    }

    public function buy($product)
    {
        $product = $this->repo->show($product);
        return $this->buyService->buy($product);
    }
}
