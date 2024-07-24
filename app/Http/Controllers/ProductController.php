<?php

namespace App\Http\Controllers;

use App\Helpers\Result;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private RepositoryInterface $repo,
        private Result $result
    ) {
    }

    public function index(ProductRequest $request)
    {
        $products = $this->repo->index($request->validated());
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = $this->repo->show($id);
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->repo->store($request->validated());
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->repo->update($product, $request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->repo->destroy($product);
        return $this->result->success(
            __('Deleted successfully')
        );
    }
}
