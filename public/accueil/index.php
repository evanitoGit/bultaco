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
    <link rel="stylesheet" href="../../css/style_index.css">
</head>
<body>
    <header class="nav">
        <img src="../../img/logo.png" alt="logo">
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="../restauration/restauration.php">Restauration</a></li>
            <li><a href="../pieces/pieces.php">Pièces détachées</a></li>
            <li>Emblèmes</li>
        </ul>
        <a href="../../login.php?redirect=admin" class="button_co">CONNEXION ADMIN</a>
    </header>
    <div class="container">

    </div>
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
                <li><a href="../pieces/pieces.php">Notre liste de pièces détachées</a></li>
                <li><a href="">Les modèles emblématiques</a></li>
                <li><a href="">Les pilotes emblématiques</a></li>
            </ul>
        </div>
    </section>
    <script src="../../js/script.js"></script>
</body>
</html>