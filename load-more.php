<?php
include 'koneksi.php'; // Gantilah ini sesuai dengan file yang berisi koneksi database

$start = $_GET['start'];
$limit = 10; // Jumlah gambar yang ingin ditampilkan setiap kali "Load More" ditekan

// Fungsi untuk mendapatkan data foto tambahan
function getMorePhotos($conn, $start, $limit) {
    $query = "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User LIMIT $start, $limit";
    return mysqli_query($conn, $query);
}

// Dapatkan data foto tambahan
$result = getMorePhotos($conn, $start, $limit);

// Tampilkan hasil dalam format HTML
foreach ($result as $tampils) {
    ?>
    <div class="box content">
        <a href="?url=detail&&id=<?= $tampils['Id_Foto']; ?>" style="cursor: zoom-in;">
            <div class="content-overlay"></div>
            <img src="uploads/<?= $tampils['Lokasi_File']; ?>" alt="">
            <div class="content-details fadeIn-bottom">
                <h5 class="content-title"><?= $tampils['Judul_Foto']; ?></h5>
                <p class="content-text"><?= substr($tampils['Deskripsi'], 0, 100); ?>...</p>
            </div>
        </a>
    </div>
    <?php
}
?>
