<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
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
        <div class="row justify-content-center">
            <div class="row mb-3">
                <div class="col-md-6" style="color : white;">
                    <h1>Customer Details</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @foreach ($customers as $customer)
                    @if ($customer->user_id == Auth::id())
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">ที่อยู่ที่ : {{ $customer->id_detail }}</h5>
                            <p class="card-text">ชื่อ: {{ $customer->name }}</p>
                            <p class="card-text">ที่อยู่: {{ $customer->address }}</p>
                            <p class="card-text">เบอร์โทรศัพท์: {{ $customer->phone }}</p>

                            @if ($customer->address)
                            <a href="/orders?customer_id={{ $customer->id }}" class="btn btn-outline-success" data-customer-id="{{ $customer->id }}"
                                data-customer-name="{{ $customer->name }}"
                                data-customer-address="{{ $customer->address }}"
                                data-customer-phone="{{ $customer->phone }}">
                                <i class="bi bi-house-check"></i>ใช้
                            </a>
                            @endif



                            <a href="{{ route('CustomerDetail.edit', $customer->id) }}"
                                class="btn btn-outline-warning"><i class="bi bi-pen"></i> แก้ไข</a>
                            <form action="{{ route('CustomerDetail.destroy', $customer->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')"><i
                                        class="bi bi-trash"></i> ลบ</button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <a class="btn btn-outline-dark" href="{{ route('CustomerDetail.create') }}"><i
                            class="bi bi-house-add"></i> สร้าง</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const useButtons = document.querySelectorAll('.btn-outline-success');
        useButtons.forEach(button => {
            button.style.display = button.dataset.customerAddress ? 'inline-block' : 'none';
            button.addEventListener('click', function() {
                const customerId = this.dataset.customerId;
                const customerName = this.dataset.customerName;
                const customerAddress = this.dataset.customerAddress;
                const customerPhone = this.dataset.customerPhone;

                sessionStorage.setItem('customerId', customerId);
                sessionStorage.setItem('customerName', customerName);
                sessionStorage.setItem('customerAddress', customerAddress);
                sessionStorage.setItem('customerPhone', customerPhone);
            });
        });
    });
    </script>


    <style>
    body {
        background-color: #ccc4a3;
        font-family: "Sarabun", sans-serif;
        font-weight: 300;
        font-style: normal;
    }

    .container {
        margin-top: 50px;
        background-color: #816451;
        border-radius: 10px;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .container {
            margin-top: 30px;
            /* ระยะห่างด้านบนของ container ในขนาดจอเล็กกว่า 768px */
        }
    }
    </style>
</body>

</html>