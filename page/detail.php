<?php
// Masukkan koneksi database Anda di sini
include 'koneksi.php';

// Periksa apakah tombol kirim komentar diklik
if (isset($_POST['submit'])) {
    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['user_id'])) {
        // Jika belum, tampilkan alert dan redirect ke halaman login
        echo "<script>alert('Anda harus login terlebih dahulu untuk komentar foto'); window.location.href = 'login.php';</script>";
        exit();
    } else {
        // Pengguna sudah login, lanjutkan proses pengiriman komentar
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
}
// Periksa apakah tombol Like diklik
if (isset($_GET['like'])) {
    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['user_id'])) {
        // Jika belum, tampilkan alert dan redirect ke halaman login
        echo "<script>alert('Anda harus login terlebih dahulu untuk like foto'); window.location.href = 'login.php';</script>";
        exit();
    } else {
        // Pengguna sudah login, lanjutkan proses Like
        $id_foto = $_GET['id'];
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
            // Pengguna telah memberikan like sebelumnya, tampilkan pesan
            echo "<script>alert('Anda telah memberikan like pada foto ini sebelumnya.'); window.location.href = '?url=detail&id=$id_foto';</script>";
            exit();
        }
    }
}

// Periksa apakah tombol Unlike diklik
if (isset($_GET['unlike'])) {
    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['user_id'])) {
        // Jika belum, tampilkan alert dan redirect ke halaman login
        echo "<script>alert('Anda harus login terlebih dahulu untuk unlike foto'); window.location.href = 'login.php';</script>";
        exit();
    } else {
        // Pengguna sudah login, lanjutkan proses Unlike
        $id_foto = $_GET['id'];
        $user_id = $_SESSION['user_id'];
        $query_check_like = mysqli_query($conn, "SELECT * FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
        if (mysqli_num_rows($query_check_like) > 0) {
            // Hapus like dari database
            $query_delete_like = mysqli_query($conn, "DELETE FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
            // Redirect kembali ke halaman detail
            header("Location: ?url=detail&id=$id_foto");
            exit();
        } else {
            // Jika pengguna belum melike foto sebelumnya, tampilkan pesan
            echo "<script>alert('Anda belum memberikan like pada foto ini.'); window.location.href = '?url=detail&id=$id_foto';</script>";
            exit();
        }
    }
}


// Ambil data foto berdasarkan ID yang dikirimkan melalui parameter URL
$id_foto = $_GET['id'];
$query_detail = mysqli_query($conn, "SELECT *, (SELECT COUNT(*) FROM `like` WHERE Id_Foto = foto.Id_Foto) AS total_like, (SELECT COUNT(*) FROM komentar WHERE Id_Foto = foto.Id_Foto) AS total_komentar FROM foto INNER JOIN user ON foto.Id_User=user.Id_User WHERE foto.Id_Foto = $id_foto");
$data = mysqli_fetch_assoc($query_detail);

// Button untuk pengguna yang sudah login
$button_action = '<a href="?url=detail&id=' . $data['Id_Foto'] . '&like=1" class="btn btn-sm btn-light border"><i class="far fa-heart"></i> ' . $data['total_like'] . '</a>';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query_check_like = mysqli_query($conn, "SELECT * FROM `like` WHERE Id_Foto = '$id_foto' AND Id_User = '$user_id'");
    if (mysqli_num_rows($query_check_like) > 0) {
        // Jika pengguna sudah melike foto, tampilkan tombol untuk unlike
        $button_action = '<a href="?url=detail&id=' . $data['Id_Foto'] . '&unlike=1" class="btn btn-sm btn-danger"><i class="fas fa-heart"></i> ' . $data['total_like'] . '</a>';
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="uploads/<?= $data['Lokasi_File'] ?>" alt="" class="img-fluid rounded-3">
                </div>

                <div class="col-md-6">
                    <div class="d-flex flex-row">
                        <div class="me-1">
                            <h4 style="font-family: ' Comic Neue', cursive; font-weight: 400; font-style: normal;"><?= $data['Judul_Foto'] ?> · </h4>
                        </div>

                        <div>
                            <!-- Menampilkan tombol Like/Unlike -->
                            <?= $button_action ?>
                        </div>

                    </div>
                    <small><i class="far fa-user"></i> <?= $data['Nama_User'] ?> · <i class="far fa-calendar-alt"></i>
                        <?= $data['Tgl_Unggah'] ?></small>
                    <hr>
                    <p style="font-family: ' Comic Neue', cursive; font-weight: 400; font-style: normal;">
                        <?= $data['Deskripsi'] ?></p>
                    <!-- Form Komentar -->
                    <form action="?url=detail&id=<?= $data['Id_Foto'] ?>" method="post" class="mt-5">
                        <div class="form-group d-flex flex-row">
                            <div class="col-lg-8">
                                <input type="text" name="komentar" class="form-control me-2"
                                    placeholder="Masukkan komentar...">
                            </div>

                            <div>
                                <button class="btn btn-light border me-2 ms-2" style="cursor: default;" disabled><i
                                        class="far fa-comment"></i> <?= $data['total_komentar'] ?> </button>
                            </div>

                            <div>
                                <input type="submit" value="Kirim" name="submit" class="btn btn-secondary">
                            </div>
                        </div>
                    </form>
                    <!-- Menampilkan Komentar -->
                    <div class="card mt-3">
                        <div class="card-body" id="comment">
                            <?php
                            $query_komentar = mysqli_query($conn, "SELECT komentar.*, user.Nama_User FROM komentar INNER JOIN user ON komentar.Id_User = user.Id_User WHERE komentar.Id_Foto = '" . $data['Id_Foto'] . "' ORDER BY komentar.Tgl_Komen DESC");

                            // Loop untuk menampilkan setiap komentar
                            while ($komentar = mysqli_fetch_assoc($query_komentar)) {
                                echo '<div class="card border-secondary mb-3 mt-3">';
                                echo '<div class="card-body text-secondary">';
                                echo '<small style="font-family: " Comic Neue", cursive; font-weight: 400; font-style: normal;"><i class="far fa-user"></i> ' . $komentar['Nama_User'] . ' · <i class="far fa-calendar-alt"></i> ' . $komentar['Tgl_Komen'] . '</small>';
                                echo '<p style="font-family: " Comic Neue", cursive; font-weight: 400; font-style: normal;">' . $komentar['Isi_Komen'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="text-center" style="font-family: ' Comic Neue', cursive; font-weight: 400; font-style: normal;">Jelajahi lainnya</h4>
    <div class="container masonry">
        <?php
        // Mengambil data foto-foto lainnya secara acak dengan batasan 20 foto
        $tampil_lainnya = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User WHERE foto.Id_Foto != $id_foto ORDER BY RAND() LIMIT 20");
        foreach ($tampil_lainnya as $foto_lainnya):
            ?>
            <div class="box content">
                <a href="?url=detail&id=<?= $foto_lainnya['Id_Foto']; ?>" style="cursor: zoom-in;">
                    <div class="content-overlay"></div>
                    <img src="uploads/<?= $foto_lainnya['Lokasi_File']; ?>" alt="">
                    <div class="content-details fadeIn-bottom">
                        <h5 class="content-title"><?= $foto_lainnya['Judul_Foto']; ?></h5>
                        <p class="content-text"><?= substr($foto_lainnya['Deskripsi'], 0, 100); ?>...</p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>