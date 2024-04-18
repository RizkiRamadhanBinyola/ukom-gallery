<div class="container masonry">
    <?php
    // Fungsi untuk mendapatkan data foto secara acak, tetapi tidak termasuk yang baru ditambahkan
    function getRandomPhotos($conn, $limit, $exclude_ids = array())
    {
        // Jika ada foto yang dikecualikan, gunakan NOT IN dalam kueri untuk menghindari pengambilan gambar yang sama
        $exclude_condition = "";
        if (!empty($exclude_ids)) {
            $exclude_condition = "AND Id_Foto NOT IN (" . implode(",", $exclude_ids) . ")";
        }
        $query = "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User WHERE 1=1 $exclude_condition ORDER BY RAND() LIMIT $limit";
        return mysqli_query($conn, $query);
    }

    // Fungsi untuk mendapatkan data foto
    function getPhotos($conn, $start, $limit, $exclude_ids = array())
    {
        $query = "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User LIMIT $start, $limit";
        return mysqli_query($conn, $query);
    }

    // Tampilkan 10 foto pertama
    $limit = 10;
    $result = array();
    // Ambil 10 gambar pertama dari hasil acak
    $result_random = getRandomPhotos($conn, $limit);
    // Simpan ID gambar yang diambil secara acak
    $random_photo_ids = array();
    foreach ($result_random as $random_photo) {
        $result[] = $random_photo;
        $random_photo_ids[] = $random_photo['Id_Foto'];
    }

    // Hitung berapa banyak lagi gambar yang perlu diambil untuk mencapai batas
    $remaining_limit = $limit - count($result);

    // Jika masih ada gambar yang perlu diambil, ambil gambar dari fungsi getPhotos
    if ($remaining_limit > 0) {
        $result_regular = getPhotos($conn, 0, $remaining_limit, $random_photo_ids);
        foreach ($result_regular as $regular_photo) {
            $result[] = $regular_photo;
        }
    }

    foreach ($result as $tampils):
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
    <?php endforeach; ?>

</div>

<!-- Tombol Load More -->
<center class="mb-5 mt-5">
    <button id="load-more" class="btn btn-light border">Load More</button>
</center>

<script>
    // Event listener untuk tombol "Load More"
    document.getElementById('load-more').addEventListener('click', function () {
        var xhr = new XMLHttpRequest();
        var start = document.querySelectorAll('.box').length; // Hitung jumlah gambar yang sudah ditampilkan
        xhr.open('GET', 'load-more.php?start=' + start, true);
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Tambahkan gambar tambahan ke kontainer gambar
                document.querySelector('.container').insertAdjacentHTML('beforeend', xhr.responseText);
            } else {
                console.error('Request failed');
            }
        };
        xhr.send();
    });
</script>