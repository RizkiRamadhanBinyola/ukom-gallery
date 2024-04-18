<?php
include 'koneksi.php';

// Periksa apakah 'keyword' ada dalam $_POST sebelum mengaksesnya
$s_keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

if (!empty($s_keyword)) { // Periksa apakah keyword tidak kosong
    $search_keyword = '%' . $s_keyword . '%';
    $query = "SELECT * FROM foto WHERE Judul_Foto LIKE ? OR Deskripsi LIKE ? OR Lokasi_File LIKE ? ORDER BY Id_Foto DESC LIMIT 5"; // Menggunakan LIMIT 5 untuk membatasi hanya 5 data
    $dewan1 = $conn->prepare($query);
    $dewan1->bind_param('sss', $search_keyword, $search_keyword, $search_keyword);
    $dewan1->execute();
    $res1 = $dewan1->get_result();

    if ($res1->num_rows > 0) {
        while ($row = $res1->fetch_assoc()) {
            $judul_foto = $row['Judul_Foto'];
            $deskripsi = $row['Deskripsi'];
            $tgl_unggah = $row['Tgl_Unggah'];
            $lokasi_file = $row['Lokasi_File'];
            ?>

            <a href="?url=detail&&id=<?= $row['Id_Foto']; ?>" style="cursor: zoom-in;">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="uploads/<?= $row['Lokasi_File'] ?>" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['Judul_Foto'] ?></h5>
                                <p class="card-text"><?= substr($row['Deskripsi'], 0, 100); ?>...</p>
                                <p class="card-text"><small class="text-body-secondary"><?= $row['Tgl_Unggah']?></small></p>
                            </div>
                        </div>
                    </div>
            </a>
            </div>

        <?php }
    } else { ?>

        Tidak ada data ditemukan

    <?php }
} else {
    echo "Masukkan kata kunci untuk mencari.";
}
?>
