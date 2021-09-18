<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        //
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction_detail = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $delivery_cost = $transaction->transaction_total_cost - $transaction_detail->total_cost;
        $delivery = Delivery::create([
            'transaction_id'=>$transaction->transaction_id,
            'courier_name'=>$request->get('courier_name'),
            'delivery_cost'=>$delivery_cost,
            'receipt_number'=>$request->get('receipt_number'),
            'delivery_date'=>$request->get('delivery_date'),
            'status'=>$request->get('status')
        ]);
        $transaction->transaction_status = 3;
        $transaction->save();
        $product = Product::where('product_id',$transaction_detail->product_id)->first();
        $admins = User::where('user_type','admin')->get();
        $user = Auth::user();
        foreach ($admins as $admin) {
            $notification = Notification::create([
                'receiver_id'=>$admin->user_id,
                'Subject'=>'Product Delivered',
                'notification'=>$user->name.' just delivered a product, '.$product->product_name,
                'notification_link'=>'/transactions',
                'is_seen'=>false,
            ]);
        }
        $notification = Notification::create([
            'receiver_id'=>$transaction->buyer_user_id,
            'Subject'=>'Product Delivered',
            'notification'=>$user->name.' just delivered your product, '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        return redirect()->route('transactions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
