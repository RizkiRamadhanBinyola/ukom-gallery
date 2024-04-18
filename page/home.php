<div class="container masonry">
    <?php
    // Fungsi untuk mendapatkan data foto
    function getPhotos($conn, $start, $limit) {
        $query = "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User LIMIT $start, $limit";
        return mysqli_query($conn, $query);
    }

    // Tampilkan 10 foto pertama
    $limit = 10;
    $result = getPhotos($conn, 0, $limit);
    foreach ($result as $tampils) :
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
<center class="mb-5">
    <button id="load-more" class="btn btn-light border">Load More</button>
</center>

<script>
    // Event listener untuk tombol "Load More"
    document.getElementById('load-more').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        var start = document.querySelectorAll('.box').length; // Hitung jumlah gambar yang sudah ditampilkan
        xhr.open('GET', 'load-more.php?start=' + start, true);
        xhr.onload = function() {
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
