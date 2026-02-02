<?php

session_start();
require_once '../../config.php';

// Vérification simple (à améliorer avec une vraie authentification)
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

// Récupérer le texte actuel
$stmt = $pdo->prepare("SELECT contenu FROM textes WHERE section = 'presentation'");
$stmt->execute();
$texte = $stmt->fetch(PDO::FETCH_ASSOC);

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
    $nouveauTexte = $_POST['contenu'];

    $stmt = $pdo->prepare("UPDATE textes SET contenu = :contenu WHERE section = 'presentation'");
    $stmt->execute(['contenu' => $nouveauTexte]);

    $message = "Texte mis à jour avec succès !";

    // Récupérer le nouveau texte
    $stmt = $pdo->prepare("SELECT contenu FROM textes WHERE section = 'presentation'");
    $stmt->execute();
    $texte = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Club Bultaco</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }

        .admin-title {
            color: var(--carbone);
            text-align: center;
            margin-bottom: 30px;
        }

        textarea {
            width: 100%;
            min-height: 200px;
            padding: 15px;
            font-size: 1.1em;
            border: 2px solid var(--carbone);
            border-radius: 10px;
            font-family: Arial, sans-serif;
            resize: vertical;
        }

        .btn-update {
            background-color: var(--carbone);
            color: var(--beige);
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            background-color: var(--beige);
            color: var(--carbone);
            border: 2px solid var(--carbone);
        }

        .message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .preview-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--carbone);
            text-decoration: none;
            font-weight: bold;
        }

        .preview-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php if (!$isAdmin): ?>
    <div class="admin-container">
        <h2 class="admin-title">Connexion Admin</h2>
        <form method="POST" action="../../login.php">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" class="btn-update">Se connecter</button>
        </form>
    </div>
<?php else: ?>
    <div class="admin-container">
        <h2 class="admin-title">Administration - Modifier le texte de présentation</h2>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="contenu" style="color: var(--carbone); font-weight: bold; display: block; margin-bottom: 10px;">
                Texte de présentation :
            </label>
            <textarea name="contenu" id="contenu" required><?php echo htmlspecialchars($texte['contenu']); ?></textarea>

            <div style="text-align: center;">
                <button type="submit" class="btn-update">Valider les modifications</button>
            </div>
        </form>

        <div style="text-align: center;">
            <a href="index.php" class="preview-link" target="_blank">→ Voir la page visiteur</a>
            <br>
            <a href="../../logout.php" class="preview-link">Déconnexion</a>
        </div>
    </div>
<?php endif; ?>
</body>
</html>