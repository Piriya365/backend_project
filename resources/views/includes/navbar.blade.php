<nav class="navbar navbar-expand-lg navbar-light" style="background-color: white;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/products"
            style="font-family: 'Caveat', cursive; font-size: 28px; color: black;">Coffee & Friend</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index') }}" style="color: black;">ตะกร้า</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/histories" style="color: black;">คำสั่งซื้อ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/CustomerDetail" style="color: black;">Profile</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" style="color: black;">
                        เพิ่มเติม
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <form action="/logout" method="POST">
                                @csrf
                                <a class="dropdown-item" href="#" style="color: black;"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<style>
.sarabun-regular {
    font-family: "Sarabun", sans-serif;
    font-weight: 400;
    font-style: normal;
}

.navbar-brand {
    font-size: 24px;
}

.navbar-nav .nav-link {
    font-size: 18px;
}

.navbar-toggler {
    font-size: 24px;
}

.navbar-collapse {
    font-size: 18px;
}
</style>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree&family=IBM+Plex+Sans+Thai+Looped&family=IBM+Plex+Sans+Thai:wght@300&family=Noto+Sans+Thai:wght@500&family=Noto+Sans:wght@500&family=Poppins:wght@300&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>