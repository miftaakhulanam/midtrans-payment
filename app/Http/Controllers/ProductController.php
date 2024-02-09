<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'status' => 'pending'
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // $item_details = array(
        //     'id' => $product->id,
        //     'price' => $product->price,
        //     'quantity' => '1',
        //     'name' => $product->name,
        // );
        // $item_details_json = json_encode($item_details);

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $product->price,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
            // 'item_details' => json_decode($item_details_json, true)
            // 'item_details' => $item_details
        );

        // $item_details = [
        //     [
        //         'id' => $product->id,
        //         'price' => $product->price,
        //         'quantity' => 1,
        //         'name' => $product->name,
        //     ],
        // ];

        // $item_details_json = json_encode($item_details);

        // $params = array([
        //     'transaction_details' => array(
        //         'order_id' => rand(),
        //         'gross_amount' => $product->price,
        //     ),
        //     'item_details' => $item_details_json,
        //     'customer_details' => array(
        //         'first_name' => Auth::user()->name,
        //         'email' => Auth::user()->email,
        //     )
        // ]);

        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => rand(),
        //         'gross_amount' => $product->price,
        //         'item_details' => array(
        //             array(
        //                 'id' => $product->id,
        //                 'price' => $product->price,
        //                 'quantity' => '1',
        //                 'name' => $product->name,
        //             )
        //         )
        //     ),
        //     'customer_details' => array(
        //         'first_name' => Auth::user()->name,
        //         'email' => Auth::user()->email,
        //     )
        // );

        // dd($params);

        // $item_details_array = json_decode($params['item_details'], true);

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;
        $transaction->save();
        // dd($transaction);

        $products = config('products');
        $productTransaction = collect($products)->firstWhere('id', $transaction->product_id);

        return view('product', compact('transaction', 'productTransaction', 'product'), [
            'product' => $product,
            'transaction' => $transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
