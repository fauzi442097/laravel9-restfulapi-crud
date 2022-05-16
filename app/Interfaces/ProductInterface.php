<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getProducts();
    public function createProduct($product);
    public function getProductById($productId);
    public function updateProduct($product, $productId);
    public function deleteProduct($productId);
}
