<?php
include 'koneksi.php';
session_start();

// Fungsi untuk memeriksa apakah pengguna sudah login
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Daftar halaman yang hanya dapat diakses setelah login
$protected_pages = array('upload', 'album', 'logout', 'profile');

$url = isset($_GET['url']) ? $_GET['url'] : 'home';

// Jika pengguna belum login dan mencoba mengakses halaman yang dilindungi
if (!isLoggedIn() && in_array($url, $protected_pages)) {
    // Redirect ke halaman login
?>
    <script>
        alert("HARUS LOGIN TERLEBIH DAHULU!");
        window.open('login.php', '_self');
    </script>
<?php
    exit(); // Hentikan eksekusi skrip setelah mengalihkan
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ukom</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel=" stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
</head>

<body>
    <!-- Navbar section -->
    <?php
    // Cek apakah pengguna sudah login
    if (isLoggedIn()) {
        // Tampilkan navigasi untuk pengguna yang sudah login
    ?>
        <!-- Tampilkan navigasi untuk pengguna yang sudah login -->
        <!-- Start Navbar -->
        <!-- <div class="pinterest">
            <div class="left">
                <a href="#" class="logo"><i class="fab fa-pinterest"></i></a>
                <a class="nav-link home" href="?url=home">Home</a>
                <a class="nav-link" href="?url=upload">Upload</a>
                <a class="nav-link" href="?url=album">Album</a>
            </div>
            <div class="right">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <input type="search" name="" placeholder="Search..." id="">
                </div>

                <a href="#" class="items"><i class="fas fa-bell"></i></a>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= ucwords($_SESSION['username']) ?>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?url=profile">Profile</a></li>
                        <li><a class="dropdown-item" href="?url=logout">Logout</a></a></li>
                    </ul>
                </div>
            </div>
        </div> -->

        <nav class="nav sticky-top">
            <i class="uil uil-bars navOpenBtn"></i>
            <a href="#" class="logo">Webster</a>

            <ul class="nav-links">
                <i class="uil uil-times navCloseBtn"></i>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>

            <i class="uil uil-search search-icon" id="searchIcon"></i>
            <div class="search-box">
                <i class="uil uil-search search-icon"></i>
                <input type="text" placeholder="Search here..." />
            </div>
        </nav>
        <!-- End Navbar -->
    <?php
    } else {
        // Tampilkan navigasi untuk pengguna yang belum login
    ?>
        <!-- Start Navbar -->
        <!-- <div class="pinterest">
            <div class="left">
                <a href="#" class="logo"><i class="fab fa-pinterest"></i></a>
                <a class="nav-link home" href="?url=home">Home</a>
                    <a class="nav-link" href="login.php">Login</a>
                    <a class="nav-link" href="daftar.php">Daftar</a>
            </div>
            <div class="right">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <input type="search" name="" placeholder="Search..." id="">
                </div>
            </div>
        </div> -->

        <nav class="nav sticky-top">
            <i class="uil uil-bars navOpenBtn"></i>
            <a href="#" class="logo">Webster</a>

            <ul class="nav-links">
                <i class="uil uil-times navCloseBtn"></i>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>

            <i class="uil uil-search search-icon" id="searchIcon"></i>
            <div class="search-box">
                <i class="uil uil-search search-icon"></i>
                <input type="text" placeholder="Search here..." />
            </div>
        </nav>

        <!-- End Navbar -->


    <?php
    }
    // Tampilkan konten sesuai URL
    if ($url == 'home') {
        include 'page/home.php';
    } elseif ($url == 'profile') {
        include 'page/profile.php';
    } elseif ($url == 'upload') {
        include 'page/upload.php';
    } elseif ($url == 'album') {
        include 'page/album.php';
    } elseif ($url == 'detail') {
        include 'page/detail.php';
    } elseif ($url == 'logout') {
        session_destroy();
        header("Location: ?url=home");
        exit(); // tambahkan exit() setelah header untuk menghentikan eksekusi skrip
    } else {
        include 'page/home.php';
    }
    ?>


    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        const nav = document.querySelector(".nav"),
            searchIcon = document.querySelector("#searchIcon"),
            navOpenBtn = document.querySelector(".navOpenBtn"),
            navCloseBtn = document.querySelector(".navCloseBtn");

        searchIcon.addEventListener("click", () => {
            nav.classList.toggle("openSearch");
            nav.classList.remove("openNav");
            if (nav.classList.contains("openSearch")) {
                return searchIcon.classList.replace("uil-search", "uil-times");
            }
            searchIcon.classList.replace("uil-times", "uil-search");
        });

        navOpenBtn.addEventListener("click", () => {
            nav.classList.add("openNav");
            nav.classList.remove("openSearch");
            searchIcon.classList.replace("uil-times", "uil-search");
        });
        navCloseBtn.addEventListener("click", () => {
            nav.classList.remove("openNav");
        });
    </script>
</body>

</html>