    <div class="d-flex justify-content-center">
        <div class="row">
            <!-- Tombol-tombol album -->
            <!-- Navigasi tab -->
            <ul class="nav nav-underline justify-content-center py-5" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Foto</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="album-tab" data-bs-toggle="tab" data-bs-target="#album-tab-pane"
                        type="button" role="tab" aria-controls="album-tab-pane" aria-selected="false">Album</button>
                </li>
            </ul>
        </div>
    </div>


    <!-- Konten tab foto -->
    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <!-- Tampilkan foto-foto yang diunggah oleh pengguna -->
        <div class="container masonry">
            <?php
            $tampil = mysqli_query($conn, "SELECT * FROM Foto WHERE Id_User='" . @$_SESSION['user_id'] . "'");
            foreach ($tampil as $tampils):
                ?>
                <div class="box content">
                    <a href="?url=detail&&id=<?= $tampils['Id_Foto']; ?>" style="cursor: zoom-in;">
                        <div class="content-overlay"></div>
                        <img src="uploads/<?= $tampils['Lokasi_File']; ?>" alt="">
                        <div class="content-details fadeIn-bottom">
                            <h5 class="content-title"><?= $tampils['Judul_Foto']; ?></h5>
                            <p class="content-text"><?= substr($tampils['Deskripsi'], 0, 100); ?>...</p>
                            <!-- Teks edit di bawah setiap gambar -->
                            <div class="edit-text">
                            <a href="?url=upload&&edit&&fotoid=<?= $tampils['Id_Foto']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?url=upload&&hapus&&fotoid=<?= $tampils['Id_Foto']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <!-- Konten tab album -->
    <div class="tab-pane fade" id="album-tab-pane" role="tabpanel" aria-labelledby="album-tab" tabindex="0">
        <ol class="list-group list-group-numbered">
            <!-- Tampilkan album-album pengguna -->
            <?php
            // Query untuk mengambil data album pengguna
            $queryAlbum = mysqli_query($conn, "SELECT * FROM album WHERE Id_User = '$userId'");
            if (mysqli_num_rows($queryAlbum) > 0) {
                while ($album = mysqli_fetch_assoc($queryAlbum)) {
                    // Hitung jumlah foto dalam album
                    $albumId = $album['Id_Album'];
                    $queryFoto = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM foto WHERE Id_Album = '$albumId'");
                    $jumlahFoto = mysqli_fetch_assoc($queryFoto)['jumlah'];
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><?= $album['Nama_Album'] ?></div>
                            <?= $album['Deskripsi'] ?>
                        </div>
                        <span class="badge text-bg-primary rounded-pill"><?= $jumlahFoto ?></span>
                    </li>
                    <?php
                }
            } else {
                echo "<p>Belum ada album yang dibuat.</p>";
            }
            ?>
        </ol>
    </div>