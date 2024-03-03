<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดสินค้า</title>
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

    <style>
    body {
        background-color: #ccc4a3;
        font-family: "Sarabun", sans-serif;
        font-weight: 300;
        font-style: normal;
    }

    .card {
        width: 100%;
        /* กำหนดความกว้างของการ์ด */
        margin: 0 auto;
        /* จัดการ์ดไว้ตรงกลางของหน้าเว็บ */
        margin-top: 50px;
        /* ระยะห่างด้านบนของการ์ด */
    }

    .card-img-top {
        object-fit: cover;
        /* จัดตำแหน่งของรูปภาพให้เต็มพื้นที่ของการ์ดโดยไม่ยืดตัว */
        max-height: 100%;
        /* กำหนดความสูงสูงสุดของรูปภาพ */
    }
    </style>
</head>

<body>
    @include('includes.navbar')
    <div class="container">
        <div class="row justify-content-center">
            <!-- จัดให้อยู่ตรงกลาง -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <img src="{{ asset('storage/' . $products->image) }}" class="card-img-top"
                        alt="{{ $products->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $products->name }}</h5>
                        <p class="card-text">ราคา: {{ $products->price }}</p>
                        <p class="card-text">{{ $products->description }}</p>
                    </div>
                    <div class="card-body text-center">
                        <a href="/products" class="btn btn-outline-danger" style="width: 50%"><i
                                class="bi bi-arrow-return-left"></i> ย้อนกลับ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FLbP4Ejc4c+KUiWbIEfKbHVRnp8v/qqEUTZ/xHD8zD3DoJap1yC2WZXalvPnvosB" crossorigin="anonymous">
    </script>
</body>

</html>