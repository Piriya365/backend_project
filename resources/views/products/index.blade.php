<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee & Friend</title>
    <link rel="icon" type="png" href="imgs/logo">
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
            <div class="col-12">
                @if(Auth::user()->type == 1)
                <a class="btn btn-outline-light mb-3" style="margin-top: 10px;"
                    href="{{ route('products.create') }}"><i class="bi bi-house-add"></i> สร้างสินค้า</a>
                @endif
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                    @foreach ($products as $item)
                    <div class="col">
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                            <div class="card" style="border-radius: 0%; border: hidden;">
                                <img class="card-img-top" src="{{ asset('storage/' . $item->image) }}" alt=""
                                    style="object-fit: cover; border-radius: 0%;">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $item->name }}</h4>
                                    <p class="card-text">ราคา : {{ $item->price }}</p>
                                    <div class="card-body text-center">
                                        <button class="btn btn-outline-success" style="margin-top: 20px"
                                            type="submit"><i class="bi bi-bag"></i> เพิ่มลงในตะกร้า</button><br>
                                        <a class="btn btn-outline-warning" style="margin-top: 10px; width: 70%;"
                                            href="{{ route('products.more', $item->id) }}"><i class="bi bi-bag"></i>
                                            เพิ่มเติม</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if(Auth::user()->type == 1)
                        <a class="btn btn-outline-danger mt-2" href="{{ route('products.edit', $item->id) }}"><i
                                class="bi bi-pen"></i> แก้ไข</a>
                        <form action="{{ route('products.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-dark mt-2"><i class="bi bi-trash"></i>
                                ลบข้อมูล</button>
                        </form>
                        @endif()
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>

<style>
body {
    background-color: #ccc4a3;
    font-family: "Sarabun", sans-serif;
    font-weight: 300;
    font-style: normal;
}

.card-header {
    background-color: #374151;
    color: #ffffff;
    padding: 15px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card {
    width: 100%;
    margin: 0 auto;
    margin-top: 50px;
}

.card-img-top {
    object-fit: cover;
    max-height: 100%;
}

@media screen and (min-width: 768px) {
    .row-cols-md-3>.col {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media screen and (min-width: 1024px) {
    .row-cols-md-3>.col {
        flex: 0 0 33.33%;
        max-width: 33.33%;
    }
}
</style>

</html>