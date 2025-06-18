<?php
include 'db.php';
session_start();

if ( !isset( $_SESSION[ 'user_id' ] ) ) {
    header( 'Location: login.php' );
    exit();
}

$user_id = $_SESSION[ 'user_id' ];

// Buscar dados do usuário logado
$stmt = $conn->prepare( 'SELECT name, bio, profile_pic FROM users WHERE id = ?' );
$stmt->bind_param( 'i', $user_id );
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();

// Buscar posts com info do autor
$posts = $conn->query( "
    SELECT posts.id, posts.content, posts.image, posts.created_at, posts.user_id,
           users.name, users.profile_pic
    FROM posts
    JOIN users ON posts.user_id = users.id
    ORDER BY posts.created_at DESC
" );

$users = $conn->query( 'SELECT name,bio, profile_pic FROM users' );
?>
<!DOCTYPE html>
<html lang = 'pt-br'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<link rel = 'stylesheet' href = './css/index.css'>
<link rel = 'stylesheet' href = './css/mobile.css'>
<link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css' integrity = 'sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==' crossorigin = 'anonymous' referrerpolicy = 'no-referrer' />
<title>VSocial</title>
</head>
<body>
<div class="hamburger-menu">
    <button id="refreshBtn" onclick="refreshPage()">
        <i class="fa-solid fa-rotate"></i>
    </button>
    <button id="menuBtn">
        <i class="fa-solid fa-bars"></i>
    </button>
</div>
<div class = 'container'>
<aside class = 'sidebar'>
<div class = 'user-profile'>
<div class = 'case'>
<img src = "uploads/<?= htmlspecialchars($user_data['profile_pic']) ?>" alt = 'Foto de perfil'>
<div class = 'user-info'>
<div class = 'nome_bio'>
<i class = 'fa-solid fa-user'></i><strong><?= htmlspecialchars( $user_data[ 'name' ] ) ?></strong>
</div>
<div class = 'nome_bio'>
<i class = 'fa-solid fa-comment'></i><small><?= htmlspecialchars( $user_data[ 'bio' ] ) ?></small>
</div>
<span>

</div>

</div>
</div>

<div class = 'nav-links'>
<span>
<i class = 'fa-solid fa-house'></i>
<a href = 'index.php'>Início</a>
</span>

<span>

<a href = 'logout.php'>Sair</a>
 <i class = 'fa-solid fa-person-running'></i>
</span>

</div>
<div class = 'usuarios_cadastrados'>
<h3>Usuários Cadastrados</h3>

<?php while ( $row = $users->fetch_assoc() ): ?>
<div class = 'profile-card'>
<img src = "uploads/<?= $row['profile_pic'] ?>" >
<div class="cad_username">
    <strong><?= htmlspecialchars( $row[ 'name' ] ) ?></strong>

<small><?= htmlspecialchars( $row[ 'bio' ] ) ?></small>
</div>

</div>
<?php endwhile;
?>

</div>
</aside>
<main class = 'main-content'>
<div class = 'new-post'>
<form action = 'post.php' method = 'POST' enctype = 'multipart/form-data'>
<div>
<textarea name = 'content' placeholder = 'Escreva algo...' required></textarea>
</div>
<div>
<input type = 'file' name = 'image' accept = 'image/*'>
<button type = 'submit'>Postar</button>
</div>
</form>
</div>

<div class = 'posts-section'>
<div class = 'feed'>
<h3>Feed </h3>
<p>Veja oque esta rolando...</p>
</div>

<?php while ( $row = $posts->fetch_assoc() ): ?>
<div class = 'post'>
<div class = 'post-header'>
<img src = "uploads/<?= htmlspecialchars($row['profile_pic']) ?>" alt = 'Foto do autor'>
<strong><?= htmlspecialchars( $row[ 'name' ] ) ?></strong>
</div>
<div class = 'post-content'>
<p><?= nl2br( htmlspecialchars( $row[ 'content' ] ) ) ?></p>
<?php if ( !empty( $row[ 'image' ] ) && file_exists( 'uploads/' . $row[ 'image' ] ) ): ?>
<img src = "uploads/<?= htmlspecialchars($row['image']) ?>" alt = 'Imagem do post'><br>
<?php endif;
?>
</div>

<div class = 'post-footer'>
<small><?= $row[ 'created_at' ] ?></small>
<?php if ( $row[ 'user_id' ] == $user_id ): ?>
<form action = 'delete_post.php' method = 'GET' class = 'delete-post'>
<input type = 'hidden' name = 'id' value = "<?= $row['id'] ?>">
<button type = 'submit' onclick = "return confirm('Deseja mesmo excluir este post?')">
<i class = 'fa-solid fa-rectangle-xmark'></i>
</button>
</form>
<?php endif;
?>
</div>
</div>
<?php endwhile;
?>
</div>
</main>

</div>
</body>
<script>
function refreshPage() {
    location.reload();
}

document.getElementById('menuBtn').addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
});
</script>
</html>
