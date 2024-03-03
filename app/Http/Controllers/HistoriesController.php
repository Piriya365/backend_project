<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Histories;

class HistoriesController extends Controller
{
    public function index()
    {
        $orders = Histories::where('user_id', Auth::id())
            ->whereNotNull('payment_method')
            ->orderBy('order_id', 'asc')
            ->get();

        return view('orders.histories', ['orders' => $orders]);
    }
}
