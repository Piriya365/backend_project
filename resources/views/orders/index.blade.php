<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้า</title>
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
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>จัดการ</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($order)
                        @foreach ($order->order_details as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>
                                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" value="decrease" name="value">
                                    <input type="hidden" value="{{ $item->product_id }}" name="product_id">
                                    <button class="btn btn-outline-danger" type="submit">-</button>
                                </form>

                                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" value="increase" name="value">
                                    <input type="hidden" value="{{ $item->product_id }}" name="product_id">
                                    <button class="btn btn-outline-success" type="submit">+</button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('orders.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <button class="btn btn-outline-danger" type="submit"><i class="bi bi-trash"></i>
                                        Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right">ราคารวม : {{ $order->total }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($order && count($order->order_details) > 0)
    <div class="container-form">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="{{ route('orders.histories') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">ที่อยู่</label>
                        <textarea type="text" class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}" maxlength="10" placeholder="กรอกเบอร์โทรศัพท์(10หลัก)" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">หมายเหตุ</label>
                        <textarea class="form-control" id="note" name="note" placeholder="หมายเหตุ (ไม่จำเป็น)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">ชำระเงิน</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="" disabled selected>กรุณาเลือกวิธีการชำระ</option>
                            <option value="cash">เก็บปลายทาง</option>
                            <option value="cash">รับที่ร้าน</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-bag-check"></i> Place
                        Order</button>
                    <a href="/CustomerDetail" class="btn btn-outline-primary"><i class="bi bi-bag-check"></i>ที่อยู่</a>
                </form>
            </div>
        </div>
    </div>
    @endif
</body>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const addressInput = document.getElementById('address');
    const phoneInput = document.getElementById('phone');

    const customerId = sessionStorage.getItem('customerId');
    const customerName = sessionStorage.getItem('customerName');
    const customerAddress = sessionStorage.getItem('customerAddress');
    const customerPhone = sessionStorage.getItem('customerPhone');

    if (customerId) {
        nameInput.value = customerName;
        addressInput.value = customerAddress;
        phoneInput.value = customerPhone;
    }
});
</script>


<style>
body {
    background-color: #ccc4a3;
    font-family: "Sarabun", sans-serif;
    font-weight: 300;
    font-style: normal;
}
.container{
    margin-top:20px;
}

.card-header {
    background-color: #374151;
    color: #ffffff;
    padding: 15px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card {
    margin-top: 50px;
    padding: 20px;
}

.container-form {
    background-color: white;
    border-radius: 10px;
    margin: 0 auto;
    padding: 20px;
}

/* Media Query for phones */
@media (max-width: 576px) {
    .container-form {
        width: 90%;
    }

    .table-responsive {
        max-width: 100%;
    }
}

@media (min-width: 768px) {
    .container-form {
        width: 90%;
    }
}
</style>
</html>
