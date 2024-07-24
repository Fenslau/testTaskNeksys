<?php

namespace App\Services;

use App\Events\DealSuccess;
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

    public function buy(int $product)
    {
        $buyer = auth()->user();
        $errorMessage = null;
        DB::transaction(function () use ($product, $buyer, &$errorMessage) {
            $product = Product::lockForUpdate()->findOrFail($product);
            if ($product->user->id == $buyer->id) {
                $errorMessage = __('You can not buy your own product');
                return;
            }
            if ($product->count == 0) {
                $errorMessage = __('Out of Product');
                return;
            }
            if ($product->cost > $buyer->wallet->balance) {
                $errorMessage = __('Not enough money');
                return;
            }
            $buyer->wallet->balance -= $product->cost;
            $buyer->wallet->save();
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
            DealSuccess::dispatch($buyer, $product->user, $product, $product->cost);
        });

        if ($errorMessage) {
            return $this->result->error($errorMessage);
        }
        return $this->result->success(
            __('Deal!')
        );
    }
}
