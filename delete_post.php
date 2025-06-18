<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Verificar se o post pertence ao usuário
    $check = $conn->prepare("SELECT image FROM posts WHERE id = ? AND user_id = ?");
    $check->bind_param("ii", $post_id, $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Apagar imagem se existir
        $check->bind_result($image);
        $check->fetch();
        if ($image && file_exists("uploads/$image")) {
            unlink("uploads/$image");
        }

        // Deletar o post
        $delete = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $delete->bind_param("i", $post_id);
        $delete->execute();
    }
}

header("Location: index.php");
exit();
