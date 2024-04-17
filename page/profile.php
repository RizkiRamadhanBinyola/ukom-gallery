<div class="container">
    <?php
    // Ambil data pengguna yang sedang login dari sesi
    $userId = $_SESSION['user_id'];
    $userData = mysqli_query($conn, "SELECT * FROM user WHERE Id_User = '$userId'");
    $user = mysqli_fetch_assoc($userData);

    // Hitung jumlah foto yang diunggah oleh pengguna
    $jumlahFoto = mysqli_query($conn, "SELECT COUNT(*) AS total FROM foto WHERE Id_User = '$userId'");
    $jumlahFoto = mysqli_fetch_assoc($jumlahFoto)['total'];

    // Hitung jumlah album yang dimiliki pengguna
    $jumlahAlbum = mysqli_query($conn, "SELECT COUNT(*) AS total FROM album WHERE Id_User = '$userId'");
    $jumlahAlbum = mysqli_fetch_assoc($jumlahAlbum)['total'];
    ?>
    <div class="text-center">
        <h4><?= $user['Nama_User'] ?></h4>
        <small><i class="far fa-image"></i> <?= $jumlahFoto ?>·</small>
        
        <small><i class="far fa-images"></i> <?= $jumlahAlbum ?></small>
    </div>
    <div class="d-flex justify-content-center">
        <div class="row">
            <ul class="nav nav-underline mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Album</button>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
            tabindex="0">
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
                                <p class="content-text"><?= substr($tampils['Deskripsi'], 0, 20); ?>...</p>
                                <!-- Teks edit di bawah setiap gambar -->
                                <div class="edit-text d-flex flex-row justify-content-center">
                                    <div class="me-1">
                                        <a href="?url=upload&&edit&&fotoid=<?= $tampils['Id_Foto']; ?>"
                                            class="btn btn-sm btn-primary">Edit</a>
                                    </div>

                                    <div>
                                        <a href="?url=upload&&hapus&&fotoid=<?= $tampils['Id_Foto']; ?>"
                                            class="btn btn-sm btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
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
    </div>
</div>