<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\DB;

use App\Services\ProductService;


class ProductController extends Controller
{
    public $productService, $modelResource;

    public function __construct(
        ProductService $product,
    ) {
        $this->productService = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::beginTransaction();
        try {

            // User Laravel Resources
            // $products = $this->productService->getProductsUsingResources();

            $products = $this->productService->getProducts();
            DB::commit();

            return $this->responseSuccess($products);
        } catch (ServiceException $e) {
            DB::rollBack();
            return $this->ServiceExceptionHandler($e);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e); // Reporting to Handler Without rendering error page
            return $this->internalServerError($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        DB::beginTransaction();
        try {

            $arrRequest = $request->all();
            $products = $this->productService->createProduct($arrRequest);
            DB::commit();

            return $this->responseSuccess($products);
        } catch (ServiceException $e) {
            DB::rollBack();
            return $this->ServiceExceptionHandler($e);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e); // Reporting to Handler Without rendering error page
            return $this->internalServerError($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($productId)
    {
        DB::beginTransaction();
        try {

            // User Resource
            // $product = $this->productService->getProductByIdUsingResoruce($productId);
            // return $product;

            $product = $this->productService->getProductById($productId);
            DB::commit();

            return $this->responseSuccess($product);
        } catch (ServiceException $e) {
            DB::rollBack();
            return $this->ServiceExceptionHandler($e);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e); // Reporting to Handler Without rendering error page
            return $this->internalServerError($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $productId)
    {
        //
        DB::beginTransaction();
        try {

            $arrRequest = $request->all();
            $productUpdated = $this->productService->updateProduct($arrRequest, $productId);
            DB::commit();

            return $this->responseSuccess($productUpdated);
        } catch (ServiceException $e) {
            DB::rollBack();
            return $this->ServiceExceptionHandler($e);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e); // Reporting to Handler Without rendering error page
            return $this->internalServerError($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        DB::beginTransaction();
        try {

            $this->productService->deleteProduct($productId);
            DB::commit();

            return $this->responseSuccess();
        } catch (ServiceException $e) {
            DB::rollBack();
            return $this->ServiceExceptionHandler($e);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e); // Reporting to Handler Without rendering error page
            return $this->internalServerError($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
