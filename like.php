<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photoId = $_POST['photo_id'];
    $userId = $_SESSION['user_id'];

    $query = "SELECT * FROM `like` WHERE `Id_Foto` = $photoId AND `Id_User` = $userId";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // User has already liked the photo, unlike it
        $unlikeQuery = "DELETE FROM `like` WHERE `Id_Foto` = $photoId AND `Id_User` = $userId";
        mysqli_query($conn, $unlikeQuery);
        $response = 'unliked';
    } else {
        // User hasn't liked the photo yet, like it
        $likeQuery = "INSERT INTO `like` (`Id_Foto`, `Id_User`, `Tgl_Like`) VALUES ($photoId, $userId, NOW())";
        mysqli_query($conn, $likeQuery);
        $response = 'liked';
    }

    // Get total like count
    $likeCountQuery = "SELECT COUNT(*) AS like_count FROM `like` WHERE `Id_Foto` = $photoId";
    $likeCountResult = mysqli_query($conn, $likeCountQuery);
    $likeCountData = mysqli_fetch_assoc($likeCountResult);
    $likeCount = $likeCountData['like_count'];

    echo json_encode(['status' => $response, 'like_count' => $likeCount]);
} else {
    header('Location: index.php'); // Redirect to homepage if accessed directly
}
?>
