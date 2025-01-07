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
     * จัดการการบันทึกข้อมูลการชำระเงินสำหรับคำสั่งซื้อ
     * อัปเดตสถานะคำสั่งซื้อเป็น "ชำระแล้ว" (status = 1) และบันทึกรายละเอียดการชำระเงินลงในตาราง Histories
     */
    public function storePayment(Request $request)
    {
        // ค้นหาคำสั่งซื้อของผู้ใช้ที่สถานะยังไม่ชำระเงิน (status = 0)
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        if ($order) {
            $orderDetails = $order->order_details;

            // ตั้งชื่อสินค้าพื้นฐานในกรณีไม่มีรายละเอียดสินค้า
            $productName = $orderDetails->isNotEmpty() ? $orderDetails->first()->product_name : 'Unknown Product';

            // วนลูปบันทึกรายละเอียดคำสั่งซื้อแต่ละรายการลงในตาราง Histories
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

                // บันทึกข้อมูลการชำระเงินลงในฐานข้อมูล
                Histories::create($paymentInformation);
            }
            // อัปเดตสถานะคำสั่งซื้อเป็น "ชำระแล้ว"
            $order->update([
                'status' => 1
            ]);
        }

        return redirect()->route('products.index');
    }



    /**
     * แสดงคำสั่งซื้อที่ยังไม่ได้ชำระเงิน (ตะกร้าสินค้า)
     */
    public function index()
    {
        // 0 = cart 1=checkout
        // ดึงคำสั่งซื้อของผู้ใช้ที่สถานะเป็น 0 (ตะกร้าสินค้า)
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
     * เพิ่มสินค้าในตะกร้าหรืออัปเดตคำสั่งซื้อที่มีอยู่
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id); //ค้นหาสินค้าที่ผู้ใช้เลือก
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();//ตรวจสอบว่าผู้ใช้มีคำสั่งซื้อที่ยังไม่ได้ชำระหรือไม่

        if ($order && $order->user_id === Auth::id()) {
            // ตรวจสอบว่าสินค้านั้นมีอยู่ในตะกร้าหรือไม่
            $orderDetail = $order->order_details()->where('product_id', $product->id)->first();

            if ($orderDetail) {
                // ถ้าสินค้ามีอยู่ในตะกร้า เพิ่มจำนวนสินค้า
                $amountNew = $orderDetail->amount + 1;
                $orderDetail->update([
                    'amount' => $amountNew
                ]);
            } else {
                // ถ้าสินค้ายังไม่มีในตะกร้า ให้เพิ่มลงในคำสั่งซื้อ
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
            // ถ้าไม่มีคำสั่งซื้อ ให้สร้างคำสั่งซื้อใหม่
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
        // คำนวณราคาทั้งหมดของคำสั่งซื้อ
        $total = $order->order_details->sum(function ($orderDetail) {
            return $orderDetail->amount * $orderDetail->price;
        });
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        $historyData = [
            'order_id' => $order->id,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'note' => $request->input('note'),
            'payment_method' => $request->input('payment_method'),
        ];

        $order->update(['total' => $total]);// อัปเดตราคาสุทธิในคำสั่งซื้อ

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
     * อัปเดตจำนวนสินค้าหรือเปลี่ยนสถานะคำสั่งซื้อ
     */
    public function update(Request $request, Order $order)//จัดการการอัปเดตรายละเอียดคำสั่งซื้อ เช่น เพิ่มหรือลดจำนวนสินค้า
    {
        $orderDetail = $order->order_details()->where('product_id', $request->product_id)->first();

        if ($request->value == "checkout") {
            // อัปเดตสถานะคำสั่งซื้อเป็น "ชำระแล้ว"  
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
            
                // อัปเดตจำนวนสินค้า
                $orderDetail->update(['amount' => max(1, $amountNew)]);
            
                // คำนวณราคารวมใหม่
                $total = $order->order_details->sum(function ($orderDetail) {
                    return $orderDetail->amount * $orderDetail->price;
                });
            
                // อัปเดตราคารวมใน Order
                $order->update(['total' => $total]);
            }
            

        }

        return redirect()->route('orders.index');
    }



    /**
     * ลบสินค้าจากตะกร้าสินค้า
     */
    public function destroy(Request $request)//ฟังก์ชันนี้จัดการการลบสินค้าจากตะกร้าของผู้ใช้
    {
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        $product_id = $request->input('product_id');

        if ($order) {
            $orderDetail = $order->order_details()->where('product_id', $product_id)->first();

            if ($orderDetail) {
                // ลบสินค้านั้นออกจากคำสั่งซื้อ
                $orderDetail->delete();
            
                // คำนวณราคารวมใหม่
                $total = $order->order_details->sum(function ($orderDetail) {
                    return $orderDetail->amount * $orderDetail->price;
                });
            
                // อัปเดตราคารวมใน Order
                $order->update(['total' => $total]);
            }
            
        }

        return redirect()->route('orders.index');
    }

}