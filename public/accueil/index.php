<?php
require_once '../../config.php';

$stmt = $pdo->prepare("SELECT contenu FROM textes WHERE section = 'presentation'");
$stmt->execute();
$texte = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Club Bultaco - Escuyer</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header class="nav">
        <img src="../../img/logo.png" alt="logo">
        <ul>
            <li>Accueil</li>
            <li>Restauration</li>
            <li>Pièces détachées</li>
            <li>Emblèmes</li>
        </ul>
        <a href="../../login.php">Connexion Admin</a>
    </header>
    <section class="hero">
        <h1>Club Bultaco</h1>
        <img src="../../img/logo_rond.png" alt="logo">
    </section>
    <section class="presentation">
        <p class="txt_pres"><?php echo htmlspecialchars($texte['contenu']); ?></p
        <div class="buttons">
            <p class="txt_decouvrir">Allez on vous invite, venez découvrir :</p>
            <ul>
                <li><a href="../restauration/restauration.php">Nos restaurations de bécanes</a></li>
                <li><a href="">Notre liste de pièces détachées</a></li>
                <li><a href="">Les modèles emblématiques</a></li>
                <li><a href="">Les pilotes emblématiques</a></li>
            </ul>
        </div>
    </section>
    <script src="../../js/script.js"></script>
</body>
</html>