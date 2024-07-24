<?php

namespace App\Services;

use App\Helpers\Result;
use App\Models\Product;
use App\Models\User;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\DB;

class BuyService implements BuyServiceInterface
{

    public function __construct(
        private RepositoryInterface $repo,
        private Result $result
    ) {
    }

    public function buy(Product $product)
    {
        $buyer = auth()->user();
        if ($product->user->id == $buyer->id) return $this->result->error(
            __('You can not buy your own product')
        );
        if ($product->count == 0) return $this->result->error(
            __('Out of Product')
        );
        if ($product->cost > $buyer->wallet->balance) return $this->result->error(
            __('Not enough money')
        );
        DB::transaction(function () use ($product, $buyer) {
            $buyer->wallet->balance -= $product->cost;
            $product->count--;
            $product->save();
            $product->user->wallet->balance += $product->cost;
            $product->user->wallet->save();
            $sameProduct = $buyer->products->where('title', $product->title)->first();
            if ($sameProduct) {
                $sameProduct->count++;
                $sameProduct->save();
            } else {
                $this->repo->store([
                    'user_id' => $buyer->id,
                    'title' => $product->title,
                    'count' => 1,
                    'cost' => $product->cost
                ]);
            }
            $buyer->wallet->save();
        });
        return $this->result->success(
            __('Deal!')
        );
    }
}
