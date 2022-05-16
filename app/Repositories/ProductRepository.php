<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;


class ProductRepository implements ProductInterface
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProducts()
    {
        return $this->product->orderBy('id', 'DESC')->get();
    }

    public function createProduct($dataProduct)
    {
        return $this->product->create($dataProduct);
    }

    public function getProductById($productId)
    {
        return $this->product->where('id', $productId)->first();
    }

    public function updateProduct($dataProduct, $productId)
    {
        $this->product->where('id', $productId)->update($dataProduct);
    }

    public function deleteProduct($productId)
    {
        $this->product->where('id', $productId)->delete();
    }
}
