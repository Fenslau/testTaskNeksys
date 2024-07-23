<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements RepositoryInterface
{

    public function index(?array $params = array())
    {
        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? env('PAGINATE_PER_PAGE');
        $path = 'products/' .  $page . '/' . $limit;
        $products = Cache::tags(['products'])->rememberForever($path, function () use ($limit) {
            $products = Product::query()
                ->orderBy('updated_at', 'desc')
                ->paginate($limit)
                ->withQueryString();
            return $products;
        });
        return $products;
    }

    public function show($model): Product|bool
    {
        $product = Product::findOrFail($model);
        return $product;
    }

    public function store(array $modelData): Product|bool
    {
        $user = auth()->user();
        if ($user) $modelData['user_id'] = $user->id;
        $product = Product::create($modelData);
        return $product;
    }

    public function update($model, array $modelData): Product|bool
    {
        $model->update($modelData);
        return $model;
    }

    public function destroy($model): void
    {
        $model->delete();
    }
}
