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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel=" stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
</head>

<body>
    <!-- Navbar section -->
    <?php
    // Cek apakah pengguna sudah login
    if (isLoggedIn()) {
        // Tampilkan navigasi untuk pengguna yang sudah login
        ?>
        <nav class="nav-home sticky-top">
            <i class="uil uil-bars navOpenBtn"></i>
            <a href="?url=home" class="logo">Galernih</a>

            <ul class="nav-links">
                <i class="uil uil-times navCloseBtn"></i>
                <li><a href="?url=home">Home</a></li>
                <li><a href="?url=upload">Upload</a></li>
                <li><a href="?url=album">Album</a></li>
                <li><a href="?url=form-report">ReportActivity</a></li>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= ucwords($_SESSION['username']) ?>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?url=profile">Profile</a></li>
                        <li><a class="dropdown-item" href="?url=logout">Logout</a></a></li>
                    </ul>
                </div>
            </ul>
            <i class="uil uil-search search-icon" id="searchIcon"></i>
            <!-- Di dalam tag form, ubah action menjadi "?url=search" dan method menjadi "GET" -->
            <div class="search-box">
                <i class="uil uil-search search-icon"></i>
                <input type="text" name="s_keyword" id="s_keyword">
                <div class="data card p-2 mt-3" id="scroll" style="max-height: 520px;"></div>
            </div>



        </nav>
        <!-- End Navbar -->
        <?php
    } else {
        // Tampilkan navigasi untuk pengguna yang belum login
        ?>
        <nav class="nav-home sticky-top">
            <i class="uil uil-bars navOpenBtn"></i>
            <a href="?url=home" class="logo">Galernih</a>

            <ul class="nav-links">
                <i class="uil uil-times navCloseBtn"></i>
                <li><a href="?url=home">Home</a></li>
                <li><a href="?url=form-report">ReportActivity</a></li>
                <li><a href="login">Login</a></li>
                <li><a href="daftar">Daftar</a></li>
            </ul>

            <i class="uil uil-search search-icon" id="searchIcon"></i>
            <!-- Di dalam tag form, ubah action menjadi "?url=search" dan method menjadi "GET" -->
            <div class="search-box">
                <i class="uil uil-search search-icon"></i>
                <input type="text" name="s_keyword" id="s_keyword">
                <div class="data card p-2 mt-3" id="scroll" style="max-height: 520px;"></div>
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
    } elseif ($url == 'search') {
        include 'page/search.php';
    } elseif ($url == 'form-report') {
        include 'page/report.php';
    } elseif ($url == 'logout') {
        session_destroy();
        header("Location: ?url=home");
        exit(); // tambahkan exit() setelah header untuk menghentikan eksekusi skrip
    } else {
        include 'page/home.php';
    }
    ?>

    <!-- Footer menggunakan Bootstrap 5.3 -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">© 2024 Photo Gallery. All rights reserved.</span>
        </div>
    </footer>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.table').DataTable();
        });
    </script>

    <script>
        $(document).ready(function () {
            load_data();
            function load_data(keyword) {
                $.ajax({
                    method: "POST",
                    url: "data.php",
                    data: { keyword: keyword },
                    success: function (hasil) {
                        $('.data').html(hasil);
                    }
                });
            }
            $('#s_keyword').keyup(function () {
                var keyword = $("#s_keyword").val();
                load_data(keyword);
            });
        });
    </script>
    <script>
        const nav = document.querySelector(".nav-home"),
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