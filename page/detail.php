<?php

// Masukkan koneksi database Anda di sini
include 'koneksi.php';

// Periksa apakah tombol kirim komentar diklik
if (isset($_POST['submit'])) {
    // Tangkap data dari form
    $komentar = $_POST['komentar'];
    $id_foto = $_GET['id']; // ID foto yang sedang dilihat

    // Simpan komentar ke dalam database
    $user_id = $_SESSION['user_id']; // Mengambil ID pengguna dari sesi
    $query_simpan = "INSERT INTO komentar (Id_Foto, Id_User, Isi_Komen, Tgl_Komen) VALUES ('$id_foto', '$user_id', '$komentar', NOW())";
    mysqli_query($conn, $query_simpan);

    // Redirect kembali ke halaman detail
    header("Location: ?url=detail&id=$id_foto");
    exit();
}

// Ambil data foto berdasarkan ID yang dikirimkan melalui parameter URL
$id_foto = $_GET['id'];
$query_detail = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User WHERE foto.Id_Foto = $id_foto");
$data = mysqli_fetch_assoc($query_detail);

// Periksa apakah tombol Like diklik
if (isset($_GET['like']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query_check_like = mysqli_query($conn, "SELECT * FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
    if (mysqli_num_rows($query_check_like) == 0) {
        // Jika pengguna belum melakukan Like sebelumnya, tambahkan Like ke database
        $query_add_like = "INSERT INTO `like` (Id_Foto, Id_User, Tgl_Like) VALUES ('$id_foto', '$user_id', NOW())";
        mysqli_query($conn, $query_add_like);
        
        // Redirect kembali ke halaman detail
        header("Location: ?url=detail&id=$id_foto");
        exit();
    } else {
        // Pengguna telah memberikan like sebelumnya, Anda bisa memberikan pesan atau mengarahkan mereka kembali ke halaman detail
        echo "Anda telah memberikan like pada foto ini sebelumnya.";
        exit();
    }
}

// Periksa apakah pengguna sudah memberikan like pada foto ini
$button_disabled = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query_check_like = mysqli_query($conn, "SELECT * FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
    if (mysqli_num_rows($query_check_like) > 0) {
        $button_disabled = 'disabled'; // Tombol menjadi disabled jika pengguna sudah memberikan like
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto</title>
    <!-- Tambahkan stylesheet Anda di sini -->
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="card border-secondary mb-3">
                    <div class="card-body text-secondary">
                        <img src="uploads/<?= $data['Lokasi_File'] ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="card border-secondary mb-3">
                    <div class="card-body text-secondary">
                        <div class="d-flex flex-row">
                            <div class="me-1">
                                <h4><?= $data['Judul_Foto'] ?></h4>
                            </div>
                            <div>
                                <form action="?url=detail&id=<?= $data['Id_Foto'] ?>&like=1" method="post">
                                    <button style="background-color: #E72929;" type="submit" class="btn btn-sm" <?php echo $button_disabled; ?>>
                                        <i class="fas fa-heart" style="color: #ffffff;"></i>
                                    </button>
                                </form>
                            </div>                           
                        </div>
                        <small>by <?= $data['Nama_User'] ?> · <?= $data['Tgl_Unggah'] ?></small>
                        <p><?= $data['Deskripsi'] ?></p>
                        
                        <!-- Form Komentar -->
                        <form action="?url=detail&id=<?= $data['Id_Foto'] ?>" method="post">
                            <div class="form-group d-flex flex-row">
                                <input type="text" name="komentar" class="form-control me-2" placeholder="Masukkan komentar...">
                                <input type="submit" value="Kirim" name="submit" class="btn btn-secondary">
                            </div>
                        </form>
                        <!-- Menampilkan Komentar -->
                        <?php
                        $query_komentar = mysqli_query($conn, "SELECT komentar.*, user.Nama_User FROM komentar INNER JOIN user ON komentar.Id_User = user.Id_User WHERE komentar.Id_Foto = '" . $data['Id_Foto'] . "' ORDER BY komentar.Tgl_Komen DESC");

                        // Loop untuk menampilkan setiap komentar
                        while ($komentar = mysqli_fetch_assoc($query_komentar)) {
                            echo '<div class="card border-secondary mb-3 mt-3">';
                            echo '<div class="card-body text-secondary">';
                            echo '<small>' . $komentar['Tgl_Komen'] . ' by ' . $komentar['Nama_User'] . '</small>';
                            echo '<p>' . $komentar['Isi_Komen'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
