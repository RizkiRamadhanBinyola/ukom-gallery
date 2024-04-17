<!-- page/search.php -->
<?php

if (isset($_GET['q'])) {
    $keyword = $_GET['q'];

    // Query untuk mencari foto berdasarkan judul
    $query = "SELECT * FROM foto WHERE Judul_Foto LIKE '%$keyword%'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Search Results for '$keyword'</h2>";
        echo "<div class='photo-grid'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='photo-item'>";
            echo "<img src='" . $row['Lokasi_File'] . "' alt='" . $row['Judul_Foto'] . "'>";
            echo "<h3>" . $row['Judul_Foto'] . "</h3>";
            echo "<p>" . $row['Deskripsi'] . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<h2>No results found for '$keyword'</h2>";
    }
} else {
    echo "<h2>Please enter a search keyword</h2>";
}
?>