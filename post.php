<?php
include 'db.php';
session_start();

// Garante que o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$content = trim($_POST['content'] ?? '');
$image_name = null;

// Garante que o conteúdo não está vazio
if (empty($content) && (empty($_FILES['image']) || $_FILES['image']['error'] != 0)) {
    die("Você deve escrever algo ou adicionar uma imagem.");
}

// Se houver imagem válida
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($ext, $allowed)) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target = 'uploads/' . $image_name;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            die("Erro ao salvar a imagem.");
        }
    } else {
        die("Formato de imagem não permitido.");
    }
}

// Inserir post no banco
$stmt = $conn->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $content, $image_name);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    die("Erro ao postar: " . $stmt->error);
}
