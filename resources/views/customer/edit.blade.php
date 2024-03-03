<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรายละเอียด</title>
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
    <div class="container mx-auto">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">แก้ไขรายละเอียด</h1>
                <form action="{{ route('CustomerDetail.update', $customer->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อ :</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">ที่อยู่ :</label>
                        <textarea class="form-control" id="address"
                            name="address">{{ $customer->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">เบอร์โทรศัพท์ :</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $customer->phone }}">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-warning"><i class="bi bi-pen"></i> แก้ไข</button>
                        <a href="javascript:history.back()" class="btn btn-outline-dark"><i
                                class="bi bi-arrow-return-left"></i> ย้อนกลับ</a>
                    </div>
                </form>
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


.container {
    background-color: #816451;
    color: white;
    margin-top: 40px;
    border-radius: 15px;
    padding: 20px;
}
</style>

</html>