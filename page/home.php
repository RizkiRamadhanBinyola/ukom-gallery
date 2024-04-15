<div class="container masonry">
<?php
    $tampil = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.Id_User=user.Id_User");
    foreach ($tampil as $tampils) :
      # code...
    ?>
  <div class="box content">
    <a href="?url=detail&&id=<?= $tampils['Id_Foto']; ?>" style="cursor: zoom-in;">
      <div class="content-overlay"></div>
      <img src="uploads/<?= $tampils['Lokasi_File']; ?>" alt="">
      <div class="content-details fadeIn-bottom">
        <h5 class="content-title"><?= $tampils['Judul_Foto']; ?></h5>
        <p class="content-text"><?= $tampils['Deskripsi'] ?></p>
      </div>
    </a>
  </div>
  <?php endforeach; ?>
</div>