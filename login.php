<?php
session_start();
require_once 'config.php';

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Récupérer l'admin depuis la base
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier le mot de passe avec password_verify
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = true;
        header('Location: public/accueil/index_admin.php');
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin - Club Bultaco</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url("img/accueil.png");
            background-attachment: fixed;
            background-size: cover;
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            border: 3px solid var(--carbone);
        }

        .login-title {
            color: var(--carbone);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            font-family: "Playfair Display", serif;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: var(--carbone);
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--carbone);
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--sepia);
            box-shadow: 0 0 5px rgba(204, 175, 146, 0.5);
        }

        .btn-login {
            width: 100%;
            background-color: var(--carbone);
            color: var(--beige);
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: var(--beige);
            color: var(--carbone);
            border: 2px solid var(--carbone);
            transform: translateY(-2px);
        }

        .error-message {
            background-color: #ff4444;
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--carbone);
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <h2 class="login-title">Connexion Admin</h2>

        <?php if ($error): ?>
            <div class="error-message">
                ❌ Identifiants incorrects
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Se connecter</button>
        </form>

        <a href="public/accueil/index.php" class="back-link">← Retour au site</a>
    </div>
</div>
</body>
</html>