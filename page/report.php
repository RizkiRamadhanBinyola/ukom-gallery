<div class="container mb-5">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center">User Activity Report</h2>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Activity</th>
                        <th scope="col">Nama Foto/Album</th>
                        <th scope="col">Date</th>
                        <th scope="col">User</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;

                    // Query to retrieve user activities
                    $sql = "
                                SELECT
                                    'Upload Foto' AS Activity,
                                    f.Judul_Foto AS Item,
                                    f.Tgl_Unggah AS Activity_Date,
                                    f.Id_Foto AS Id_Foto,
                                    u.Username AS User
                                FROM
                                    foto f
                                JOIN
                                    user u ON f.Id_User = u.Id_User
                                UNION
                                SELECT
                                    'Upload Album' AS Activity,
                                    a.Nama_Album AS Item,
                                    a.Tgl_Dibuat AS Activity_Date,
                                    NULL AS Id_Foto, -- Kolom dummy
                                    u.Username AS User
                                FROM
                                    album a
                                JOIN
                                    user u ON a.Id_User = u.Id_User

                                    UNION
SELECT
    'Beri Komentar' AS Activity,
    k.Isi_Komen AS Item,
    k.Tgl_Komen AS Activity_Date,
    f.Id_Foto AS Id_Foto, -- Kolom Id_Foto untuk aktivitas Beri Komentar
    u.Username AS User
FROM
    komentar k
JOIN
    user u ON k.Id_User = u.Id_User
JOIN
    foto f ON k.Id_Foto = f.Id_Foto

UNION
SELECT
    'Beri Like' AS Activity,
    CONCAT('Foto: ', f.Judul_Foto) AS Item,
    l.Tgl_Like AS Activity_Date,
    f.Id_Foto AS Id_Foto, -- Kolom Id_Foto untuk aktivitas Beri Like
    u.Username AS User
FROM
    `like` l
JOIN
    foto f ON l.Id_Foto = f.Id_Foto
JOIN
    user u ON l.Id_User = u.Id_User
                                    
                                ORDER BY
                                    Activity_Date DESC;
                            ";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <tr>
                                <th><?= $no++; ?></th>
                                <td><?= $row["Activity"] ?></td>
                                <!-- Updated code to create link -->
                                <td>
                                    <?php
                                    if ($row["Activity"] === "Upload Album") {
                                        echo $row["Item"]; // Menampilkan nama album tanpa tautan
                                    } else {
                                        // Menampilkan nama foto dengan tautan ke detail foto
                                        echo '<a href="?url=detail&&id=' . $row['Id_Foto'] . '" style="cursor: zoom-in;">' . $row["Item"] . '</a>';
                                    }
                                    ?>
                                </td>

                                <td><?= $row["User"] ?></td>
                            </tr>
                            <?php
                        }

                    } else {
                        echo "No activities found";
                    }

                    $conn->close();
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>