<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Histories;
use App\Models\OrderDetail;
use App\Models\CustomerDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function storePayment(Request $request)
    {

        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        if ($order) {
            $orderDetails = $order->order_details;

            $productName = $orderDetails->isNotEmpty() ? $orderDetails->first()->product_name : 'Unknown Product';

            foreach ($orderDetails as $orderDetail) {
                $productName = $orderDetail->product_name;

                $paymentInformation = [
                    'order_id' => $order->order_id,
                    'user_id' => Auth::id(),
                    'product_name' => $productName,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'note' => $request->note,
                    'price' => $orderDetail->price,
                    'amount' => $orderDetail->amount,
                    'total' => $order->total,
                    'payment_method' => $request->payment_method,
                    'product_image' => $orderDetail->product_image,
                ];

                Histories::create($paymentInformation);
            }

            $order->update([
                'status' => 1
            ]);
        }

        return redirect()->route('products.index');
    }




    public function index()
    {
        // 0 = cart 1=checkout
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        return view('orders.index')->with('order', $order);
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
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        if ($order && $order->user_id === Auth::id()) {
            $orderDetail = $order->order_details()->where('product_id', $product->id)->first();

            if ($orderDetail) {
                $amountNew = $orderDetail->amount + 1;
                $orderDetail->update([
                    'amount' => $amountNew
                ]);
            } else {
                $prepareCartDetail = [
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'amount' => 1,
                    'price' => $product->price,
                ];
                $orderDetail = OrderDetail::create($prepareCartDetail);
            }
        } else {
            $newUserId = Auth::id();
            $lastOrder = Order::where('user_id', $newUserId)->orderBy('id', 'desc')->first();
            if ($lastOrder && $lastOrder->user_id === $newUserId) {
                // รีเซ็ต order_id ใหม่เป็น 1 สำหรับผู้ใช้ใหม่
                $lastOrder->update(['order_id' => 1]);
            }

            $newOrderId = Order::where('user_id', Auth::id())->max('order_id') + 1;

            $existingOrders = Order::where('user_id', Auth::id())->get();

            foreach ($existingOrders as $order) {
                $order->update(['order_id' => $newOrderId]);
            }

            $prepareCart = [
                'status' => 0,
                'user_id' => Auth::id(),
                'order_id' => $newOrderId,
            ];


            $order = Order::create($prepareCart);

            $product = Product::find($request->product_id);
            $productName = $product->name;
            $prepareCartDetail = [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'product_name' => $productName,
                'product_image' => $product->image,
                'amount' => 1,
                'price' => $product->price,
            ];
            $orderDetail = OrderDetail::create($prepareCartDetail);
        }
        $totalRaw = 0;
        $total = $order->order_details->map(function ($orderDetail) use (&$totalRaw) {
            $totalRaw += $orderDetail->amount * $orderDetail->price;
            return $totalRaw;
        })->toArray();
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        $historyData = [
            'order_id' => $order->id,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'note' => $request->input('note'),
            'payment_method' => $request->input('payment_method'),
        ];

        $order->update([
            'total' => array_sum($total)
        ]);

        return redirect()->route('products.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $orderDetail = $order->order_details()->where('product_id', $request->product_id)->first();

        if ($request->value == "checkout") {
            $order->update([
                'status' => 1
            ]);
        } else {
            if ($orderDetail) {
                if ($request->value == "increase") {
                    $amountNew = $orderDetail->amount + 1;
                } else {
                    $amountNew = $orderDetail->amount - 1;
                }

                if ($amountNew <= 0) {
                    $orderDetail->update(['amount' => 1]);
                } else {
                    $orderDetail->update(['amount' => $amountNew]);
                }

                $totalRaw = 0;
                $total = $order->order_details->map(function ($orderDetail) use (&$totalRaw) {
                    $totalRaw += $orderDetail->amount * $orderDetail->price;
                    return $totalRaw;
                })->toArray();

                $order->update([
                    'total' => array_sum($total)
                ]);
            }

        }

        return redirect()->route('orders.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        $product_id = $request->input('product_id');

        if ($order) {
            $orderDetail = $order->order_details()->where('product_id', $product_id)->first();

            if ($orderDetail) {
                $orderDetail->delete();

                $totalRaw = 0;
                $total = $order->order_details->map(function ($orderDetail) use (&$totalRaw) {
                    $totalRaw += $orderDetail->amount * $orderDetail->price;
                    return $totalRaw;
                })->toArray();

                $order->update([
                    'total' => array_sum($total)
                ]);
            }
        }

        return redirect()->route('orders.index');
    }

}