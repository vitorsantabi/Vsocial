<?php
include 'db.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $bio = substr(trim($_POST['bio']), 0, 30);
    $profile_pic = 'default.png';

    // Upload da imagem de perfil
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $profile_pic = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/" . $profile_pic);
    }

    // Inserir no banco
    $stmt = $conn->prepare("INSERT INTO users (name, username, password, bio, profile_pic) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $password, $bio, $profile_pic);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Erro ao cadastrar: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="./css/cadastro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer" />
</head>

<body>


    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST" enctype="multipart/form-data">
        <h2>Cadastro</h2>
        <div class="cad"> <label>Nome completo:</label>
            <input type="text" name="name" required>
        </div>

        <div class="cad"><label>Email:</label>
            <input type="email" name="username" required>
        </div>

        <div class="cad"><label>Senha:</label>
            <input type="password" name="password" required>
        </div>

        <div class="cad"><label>Bio (até 30 caracteres):</label>
            <input type="text" name="bio" maxlength="30" class="bio">
        </div>
        <br>
        <div class="cad">
            <label for="profile_pic">Foto de Perfil</label>
            <br>
            <label for="profile_pic" style="cursor:pointer;">
            <i class="fa-solid fa-image"></i> Clique aqui!
            </label>
            <input type="file" id="profile_pic" name="profile_pic" accept="image/*" style="display:none;">
        </div>
        <br>

        <button type="submit" id="btnCadastrar">Cadastrar</button>
    </form>

    <script>
    // Exibe alerta após cadastro bem-sucedido
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)): ?>
        alert('Conta criada com sucesso!');
        window.location.href = 'login.php';
    <?php endif; ?>
    </script>
    </form>
        <br><br>
        <div class="back">
          <p>Já tem conta? <a href="login.php" class="back_login">Login</a></p>    
        </div>
  
</body>

</html>