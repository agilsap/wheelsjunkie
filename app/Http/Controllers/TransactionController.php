<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\Notification;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    private $transaction_status_list = [
        'Waiting Payment', //0
        'Paid',//1
        'Approved', //2
        'Delivered', //3
        'Received', //4
        'Done', //5
        'Canceled', //6
        'Rejected' //7
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        if($user->user_type == 'admin' || $user->user_type == 'principal'){
            $transactions = Transaction::all();
        }else if($user->user_type == 'seller'){
            $transactions = Transaction::where('seller_user_id',$user->user_id)->get();
        }
        foreach ($transactions as $transaction) {
            $customer = User::where('user_id',$transaction->buyer_user_id)->first();
            $transaction->setAttribute('customer',$customer);
            if($user->user_type == 'admin'){
                $seller = User::where('user_id',$transaction->seller_user_id)->first();
                $transaction->setAttribute('seller',$seller);
            }
            if($user->user_type == 'seller'){
                if($transaction->admin_id){
                    $admin = User::where('user_id',$transaction->admin_id)->first();
                    $transaction->setAttribute('admin',$admin);
                }
            }
            $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
            $transaction->setAttribute('details',$transaction_details);
            $product = Product::where('product_id',$transaction_details->product_id)->first();
            $thumbnail = Gallery::where('product_id',$product->product_id)->first();
            $product->setAttribute('thumbnail',$thumbnail);
            $transaction->setAttribute('product',$product);
            $can_approve = false;
            $can_reject = false;
            $can_transfer_to_seller = false;
            $can_be_sent = false;
            if($transaction->transaction_status == 1){
                $can_approve = true;
                $can_reject = true;
            }
            if($transaction->transaction_status == 4){
                $can_transfer_to_seller = true;
            }
            if($transaction->transaction_status == 2){
                $can_be_sent = true;
            }
            $transaction->setAttribute('can_approve',$can_approve);
            $transaction->setAttribute('can_reject',$can_reject);
            $transaction->setAttribute('can_transfer_to_seller',$can_transfer_to_seller);
            $transaction->setAttribute('can_be_sent',$can_be_sent);
            $transaction->transaction_status = Utils::maskNumberedList($transaction->transaction_status,$this->transaction_status_list);
            $transaction->transaction_total_cost = Utils::formatPrice($transaction->transaction_total_cost);
        }
        return view('transactions')->with([
            'user'=>$user,
            'transactions'=>$transactions,
        ]);
    }
    public function paymentsIndex()
    {
        $user = Auth::user();
        $transactions = Transaction::where('buyer_user_id',$user->user_id)->get();
        foreach ($transactions as $transaction) {
            $seller = User::where('user_id',$transaction->seller_user_id)->first();
            $transaction->setAttribute('seller',$seller);
            $admin = User::where('user_id',$transaction->admin_id)->first();
            $transaction->setAttribute('admin',$admin);
            $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
            $transaction->setAttribute('details',$transaction_details);
            $product = Product::where('product_id',$transaction_details->product_id)->first();
            $thumbnail = Gallery::where('product_id',$product->product_id)->first();
            $product->setAttribute('thumbnail',$thumbnail);
            $transaction->setAttribute('product',$product);
            $can_be_canceled = false;
            $can_upload_receipt = false;
            if($transaction->transaction_status == 0){
                $can_be_canceled = true;
                $can_upload_receipt = true;
            }
            $can_receive = false;
            if($transaction->transaction_status == 3){
                $can_receive = true;
            }
            $transaction->setAttribute('can_be_canceled',$can_be_canceled);
            $transaction->setAttribute('can_upload_receipt',$can_upload_receipt);
            $transaction->setAttribute('can_receive',$can_receive);
            $transaction->transaction_status = Utils::maskNumberedList($transaction->transaction_status,$this->transaction_status_list);
            $transaction->transaction_total_cost = Utils::formatPrice($transaction->transaction_total_cost);
        }
        $sukses = session()->get('sukses');
        return view('payments')->with([
            'sukses'=>$sukses,
            'user'=>$user,
            'transactions'=>$transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $transaction = Transaction::where('transaction_id',$id)->first();
        $user = Auth::user();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        $transaction->transaction_status = Utils::maskNumberedList($transaction->transaction_status,$this->transaction_status_list);
        $transaction->transaction_total_cost = Utils::formatPrice($transaction->transaction_total_cost);
        $transaction_details->total_cost = Utils::formatPrice($transaction_details->total_cost);
        return view('front.uploadPayment')->with([
            'product'=>$product,
            'user'=>$user,
            'transaction_detail'=>$transaction_details,
            'transaction'=>$transaction
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if($id != $request->get('transaction_id')){
            return back()->with([
                'error'=> 'Wrong Transaction ID'
            ]);
        }
        $user = Auth::user();
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction->transaction_status = 1;
        $transaction->bank_account_owner = $request->get('bank_account_owner');
        $transaction->payment_date = $request->get('payment_date');
        $transaction->additional_info = $request->get('additional_info');
        if($request->hasFile('proof_of_payment')){
            $base_path = public_path('img/images/receipt');
            if(!File::isDirectory($base_path)){
                File::makeDirectory($base_path, 0777, true, true);
            }
            $time = Carbon::now()->format('dmyhms');
            $file_name = 'T'.$transaction->transaction_id.'B'.$user->user_id.$time.'.png'; //filename
            $img = Image::make($request->file('proof_of_payment')->getRealPath());
            $transaction->proof_of_payment = $file_name;
            $img->save('img/images/receipt/'.$file_name, 80);
        }
        $transaction->save();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        $admins = User::where('user_type','admin')->get();
        foreach ($admins as $key => $admin) {
            $notification = Notification::create([
                'receiver_id'=>$admin->user_id,
                'Subject'=>'Product Payment',
                'notification'=>$user->name.' just uploaded a payment receipt for '.$product->product_name,
                'notification_link'=>'/transactions',
                'is_seen'=>false,
            ]);
        }
        $notification = Notification::create([
            'receiver_id'=>$product->user_id,
            'Subject'=>'Product Payment',
            'notification'=>$user->name.' just uploaded a payment receipt for '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        return redirect()->route('transaction.paymentsIndex')->with([
            'sukses'=>'Successfully uploaded payment confirmation. Please wait for your order to be processed'
        ]);
    }

    public function cancel($id){
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction->transaction_status = 6;
        $transaction->save();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        $product->quantity += $transaction_details->quantity;
        $admins = User::where('user_type','admin')->get();
        $user = Auth::user();
        foreach ($admins as $key => $admin) {
            $notification = Notification::create([
                'receiver_id'=>$admin->user_id,
                'Subject'=>'Transaction Canceled',
                'notification'=>$user->name.' just canceled transaction for'.$product->product_name,
                'notification_link'=>'/transactions',
                'is_seen'=>false,
            ]);
        }
        $notification = Notification::create([
            'receiver_id'=>$product->user_id,
            'Subject'=>'Transaction Canceled',
            'notification'=>$user->name.' just canceled transaction for'.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        $product->save();
        return redirect()->route('transaction.paymentsIndex');
    }

    public function approve($id){
        $user = Auth::user();
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction->transaction_status = 2;
        $transaction->admin_id = $user->user_id; 
        $transaction->save();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        $notification = Notification::create([
            'receiver_id'=>$transaction->buyer_user_id,
            'Subject'=>'Payment Approved',
            'notification'=>'WheelsJunkie admin just approved your payment for '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        $notification = Notification::create([
            'receiver_id'=>$product->user_id,
            'Subject'=>'Payment Approved',
            'notification'=>'WheelsJunkie admin just approved a payment for '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        return redirect()->route('transactions.index');
    }

    public function reject($id){
        $user = Auth::user();
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction->transaction_status = 7;
        $transaction->admin_id = $user->user_id;
        $transaction->save();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        $notification = Notification::create([
            'receiver_id'=>$transaction->buyer_user_id,
            'Subject'=>'Payment Approved',
            'notification'=>'WheelsJunkie admin just rejected your payment for, '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        $notification = Notification::create([
            'receiver_id'=>$product->user_id,
            'Subject'=>'Payment Approved',
            'notification'=>'WheelsJunkie admin just rejected a payment for '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        return redirect()->route('transactions.index');
    }

    public function done($id){
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction->transaction_status = 5;
        $transaction->save();
        $admin = Auth::user();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        $notification = Notification::create([
            'receiver_id'=>$product->user_id,
            'Subject'=>'Transaction Done',
            'notification'=>$admin->name.' just finished a transaction for your product, '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        return redirect()->route('transactions.index');
    }

    public function received($id){
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction->transaction_status = 4;
        $delivery = Delivery::where('transaction_id',$transaction->transaction_id)->first();
        $today = Carbon::now()->format('d-m-y h:m:s');
        $delivery->delivered_date = $today;
        $delivery->save();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        $admins = User::where('user_type','admin')->get();
        $user = Auth::user();
        foreach ($admins as $key => $admin) {
            $notification = Notification::create([
                'receiver_id'=>$admin->user_id,
                'Subject'=>'Product Received',
                'notification'=>$user->name.' just received a product, '.$product->product_name,
                'notification_link'=>'/transactions',
                'is_seen'=>false,
            ]);
        }
        $notification = Notification::create([
            'receiver_id'=>$product->user_id,
            'Subject'=>'Product Received',
            'notification'=>$user->name.' just received your product, '.$product->product_name,
            'notification_link'=>'/transactions',
            'is_seen'=>false,
        ]);
        $transaction->save();
        return redirect()->route('transaction.paymentsIndex');
    }

    public function send($id){
        $transaction = Transaction::where('transaction_id',$id)->first();
        $transaction_details = TransactionDetail::where('transaction_detail_id',$transaction->transaction_detail_id)->first();
        $product = Product::where('product_id',$transaction_details->product_id)->first();
        // $transaction->save();
        return view('front.createDelivery')->with([
            'transaction'=>$transaction,
            'transaction_detail'=>$transaction_details,
            'product'=>$product,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
