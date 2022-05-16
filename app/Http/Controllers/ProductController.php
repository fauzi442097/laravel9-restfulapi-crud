<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ModelResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all();

        return (new ModelResource($products))->message('Sukses Get Collection');

        // Contoh Menggunakan Resource Collection bawaan Laravel
        // return new UserResourceCollection($products);

        return $this->responseSuccess($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        try {
            $arrRequest = $request->all();
            $product = Product::create([
                'prod_name' => $arrRequest['ProductName'],
                'scheme_no' => $arrRequest['SchemeNo'],
                'duration_cert' => $arrRequest['DurationCert'],
                'scheme_cert' => $arrRequest['SchemeCert'],
                'price' => $arrRequest['Price']
            ]);

            return $this->responseSuccess($product);
        } catch (\Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ];
            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, null, $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $productId)
    {
        //
        $product = Product::find($productId);
        return (new ModelResource($product))->message('Sukses Get Data');

        // Contoh Menggunakan API Resource Bawaan Laravel
        // $resp = new UserResource($product);


        if (is_null($product)) {
            return $this->responseError(Response::HTTP_NOT_FOUND, 'Data tidak ditemukan');
        }
        return $this->responseSuccess($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        //
        try {
            $arrRequest = $request->all();
            $product::where('id', $product->id)
                ->update([
                    'prod_name' => $arrRequest['ProductName'],
                    'scheme_no' => $arrRequest['SchemeNo'],
                    'duration_cert' => $arrRequest['DurationCert'],
                    'scheme_cert' => $arrRequest['SchemeCert'],
                    'price' => $arrRequest['Price']
                ]);

            return $this->responseSuccess($product);
        } catch (\Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ];
            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, null, $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $productId)
    {
        $product = Product::where('id', $productId);
        if (is_null($product->first())) {
            return $this->responseError(Response::HTTP_NOT_FOUND, 'Data tidak ditemukan');
        }

        $product->delete();
        return $this->responseSuccess();
    }
}
