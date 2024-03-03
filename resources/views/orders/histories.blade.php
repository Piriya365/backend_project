<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติคำสั่งซื้อ</title>
    <link rel="icon" type="png" href="imgs/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+2a5ZPeDVRqAuyz/Rly3Se+RznQER6U4jkWBk0B" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-y5W9+1eBcKQ67r1grIXZw5TcLh7OskwapBPrA0P3R+u8m5mwq+HaRff+PQxFQZ8R" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&family=IBM+Plex+Sans+Thai+Looped&family=IBM+Plex+Sans+Thai:wght@300&family=Noto+Sans+Thai:wght@100..900&family=Noto+Sans:wght@500&family=Poppins:wght@300&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
</head>

<body>
    @include('includes.navbar')
    <div class="container">
        <h1 class="mt-5 mb-4" style="color: white;">ประวัติคำสั่งซื้อ</h1>

        @if(isset($orders) && count($orders) > 0)
        @foreach($orders->groupBy('order_id') as $order_id => $grouped_orders)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Order #{{ $order_id }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 20%;">รูปสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคาต่อชิ้น</th>
                            <th>จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total_order_price = 0;
                        @endphp
                        @foreach($grouped_orders as $order)
                        <tr>
                            <td><img src="{{ asset('storage/' . $order->product_image) }}" class="card-img-top"
                                    alt="Product Image"></td>
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->amount }}</td>
                        </tr>
                        @php
                        $total_order_price += $order->total;
                        @endphp
                        @endforeach
                        <td colspan="4" align="right">ราคารวม : {{ $total_order_price }} บาท</td>
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
        @else
        <div class="container-fluid bg-white rounded-pill p-3">
            <div class="row justify-content-start">
                <div class="col-md-6">
                    <div class="alert" role="alert">
                        <p>ไม่พบประวัติคำสั่งซื้อ</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</body>

<style>
body {
    background-color: #ccc4a3;
    font-family: "Sarabun", sans-serif;
    font-weight: 300;
    font-style: normal;
}

.card {
    margin-bottom: 20px;
    border: 2px solid #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #816451;
    font-weight: bold;
    border-bottom: none;
}

.card-title {
    margin-bottom: 0;
    color: white;
}

.table th,
.table td {
    vertical-align: middle;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-primary:focus,
.btn-primary.focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
}
</style>

</html>