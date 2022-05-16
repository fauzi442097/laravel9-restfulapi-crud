<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Interfaces\ProductInterface;
use App\Http\Resources\ModelResource;
use Illuminate\Http\Response;
use App\Traits\StringResponseError;

class ProductService
{
    use StringResponseError;

    protected $productRepository;
    protected $product;
    protected $products;

    public function __construct(ProductInterface $product)
    {
        $this->productRepository = $product;
    }

    public function getProducts()
    {
        $this->products = $this->productRepository->getProducts();
        return $this->products;
    }

    public function getProductsUsingResources()
    {
        return (new ModelResource($this->getProducts()))->message('Sukses Get Collection');
    }

    public function getProductById($productId)
    {
        $product = $this->productRepository->getProductById($productId);

        if (is_null($product)) {
            $message = $this->makeErrorMessage('Data tidak ditemukan');
            throw new ServiceException($message, Response::HTTP_NOT_FOUND);
        }

        return $product;
    }

    public function getProductByIdUsingResoruce($productId)
    {
        return (new ModelResource($this->getProductById($productId)))->message('Sukses Get Data');
    }

    public function createProduct($arrRequest)
    {
        $product = [
            'prod_name' => $arrRequest['ProductName'],
            'scheme_no' => $arrRequest['SchemeNo'],
            'duration_cert' => $arrRequest['DurationCert'],
            'scheme_cert' => $arrRequest['SchemeCert'],
            'price' => $arrRequest['Price']
        ];

        $productCreated = $this->productRepository->createProduct($product);
        return $productCreated;
    }

    public function updateProduct($arrRequest, $productId)
    {

        $product = [
            'prod_name' => $arrRequest['ProductName'],
            'scheme_no' => $arrRequest['SchemeNo'],
            'duration_cert' => $arrRequest['DurationCert'],
            'scheme_cert' => $arrRequest['SchemeCert'],
            'price' => $arrRequest['Price']
        ];

        $this->productRepository->updateProduct($product, $productId);

        return $this->getProductById($productId);
    }

    public function deleteProduct($productId)
    {
        $productDeleted = $this->getProductById($productId);
        $this->productRepository->deleteProduct($productId);
    }
}
