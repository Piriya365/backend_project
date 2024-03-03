<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerDetail;
use Illuminate\Support\Facades\Auth;

class CustomerDetailController extends Controller
{
    public function index()
    {
        $customers = CustomerDetail::all();
        return view('customer.index')->with('customers', $customers);

    }

    public function store(Request $request)
    {
        $latest_customer = CustomerDetail::where('user_id', Auth::id())->latest()->first();

        $id_detail = ($latest_customer) ? $latest_customer->id_detail + 1 : 1;

        $customer_detail = [
            'user_id' => Auth::id(),
            'id_detail' => $id_detail,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        $customer = CustomerDetail::create($customer_detail);

        return redirect()->route('CustomerDetail.index');
    }

    public function create()
    {
        return view('customer.create');
    }
    public function edit($id)
    {
        $customer = CustomerDetail::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }


    public function update(Request $request, $id)
    {
        $customer = CustomerDetail::findOrFail($id);
        $customer->update($request->all());
        return redirect()->route('CustomerDetail.index');
    }

    public function destroy($id)
    {
        $customer = CustomerDetail::findOrFail($id);
        $deleted_id_detail = $customer->id_detail;

        $customer->delete();

        // หา Order ID ที่มีค่ามากกว่า Order ID ที่ถูกลบ
        $higher_order_ids = CustomerDetail::where('id_detail', '>', $deleted_id_detail)->get();

        // อัพเดท Order ID ของแต่ละข้อมูลที่มี Order ID มากกว่า Order ID ที่ถูกลบ
        foreach ($higher_order_ids as $higher_order) {
            $higher_order->update(['id_detail' => $higher_order->id_detail - 1]);
        }

        return redirect()->route('CustomerDetail.index');
    }




}
