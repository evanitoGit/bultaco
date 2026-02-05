<?php
require_once '../../config.php';

$stmt = $pdo->prepare("SELECT contenu FROM textes WHERE section = 'emblemes'");
$stmt->execute();
$texte = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtPilotes = $pdo->prepare("SELECT * FROM pilotes_emblematiques ORDER BY ordre ASC");
$stmtPilotes->execute();
$pilotes = $stmtPilotes->fetchAll(PDO::FETCH_ASSOC);

$stmtModeles = $pdo->prepare("SELECT * FROM modeles_emblematiques ORDER BY ordre ASC");
$stmtModeles->execute();
$modeles = $stmtModeles->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emblèmes - Club Bultaco</title>
    <link rel="stylesheet" href="../../css/style_emblemes.css">
</head>
<body>
<header class="nav">
    <img src="../../img/logo.png" alt="logo">
    <ul>
        <li><a href="../accueil/index.php">ACCUEIL</a></li>
        <li><a href="../restauration/restauration.php">RESTAURATION</a></li>
        <li><a href="../pieces/pieces.php">PIÈCES DÉTACHÉES</a></li>
        <li><a href="">EMBLÈMES</a></li>
    </ul>
    <a href="../../login.php?redirect=admin_emblemes" class="button_co">CONNEXION ADMIN</a>
</header>

<div class="head">
    <h1>EMBLÈMES</h1>
</div>

<div class="container">
    <section class="hero">
        <p><?php echo htmlspecialchars($texte['contenu']); ?></p>
    </section>

    <section class="emblemes-section">
        <div class="emblemes-container">
            <div class="liste-pilotes">
                <h2>PILOTES LÉGENDAIRES</h2>
                <div class="liste-items">
                    <?php if (empty($pilotes)): ?>
                        <p class="no-items">Aucun pilote pour le moment</p>
                    <?php else: ?>
                        <?php foreach ($pilotes as $pilote): ?>
                            <div class="item-card" onclick="openPiloteModal(<?php echo $pilote['id']; ?>)">
                                <?php if ($pilote['image_path']): ?>
                                    <div class="item-photo" style="background-image: url('<?php echo htmlspecialchars($pilote['image_path']); ?>')"></div>
                                <?php else: ?>
                                    <div class="item-photo no-photo"></div>
                                <?php endif; ?>
                                <div class="item-info">
                                    <h3><?php echo htmlspecialchars($pilote['prenom'] . ' ' . $pilote['nom']); ?></h3>
                                    <p class="item-meta"><?php echo htmlspecialchars(' (' . $pilote['date_naissance'] . ' - ' . $pilote['date_deces'] . ')'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="liste-modeles">
                <h2>MODÈLES MYTHIQUES</h2>
                <div class="liste-items">
                    <?php if (empty($modeles)): ?>
                        <p class="no-items">Aucun modèle pour le moment</p>
                    <?php else: ?>
                        <?php foreach ($modeles as $modele): ?>
                            <div class="item-card" onclick="openModeleModal(<?php echo $modele['id']; ?>)">
                                <?php if ($modele['image_path']): ?>
                                    <div class="item-photo" style="background-image: url('<?php echo htmlspecialchars($modele['image_path']); ?>')"></div>
                                <?php else: ?>
                                    <div class="item-photo no-photo"></div>
                                <?php endif; ?>
                                <div class="item-info">
                                    <h3><?php echo htmlspecialchars($modele['nom']); ?></h3>
                                    <p class="item-meta"><?php echo htmlspecialchars($modele['type_moto']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="modalOverlay" class="modal-overlay" onclick="closeModal()"></div>

<div id="piloteModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div class="modal-body" id="piloteModalContent"></div>
    </div>
</div>

<div id="modeleModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div class="modal-body" id="modeleModalContent"></div>
    </div>
</div>

<script>
    const pilotes = <?php echo json_encode($pilotes); ?>;
    const modeles = <?php echo json_encode($modeles); ?>;

    function openPiloteModal(id) {
        const pilote = pilotes.find(p => p.id == id);
        if (!pilote) return;

        const content = `
                <div class="carte-identite">
                    <div class="carte-header">
                        <h2>${pilote.prenom} ${pilote.nom}</h2>
                        <span class="badge-pilote">PILOTE</span>
                    </div>

                    ${pilote.image_path ?
            `<img src="${pilote.image_path}" alt="${pilote.prenom} ${pilote.nom}" class="carte-photo">` :
            '<div class="carte-photo-placeholder"></div>'
        }

                    <div class="carte-section">
                        <h3>Informations</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Naissance :</span>
                                <span class="info-value">${pilote.date_naissance || 'N/A'}</span>
                            </div>
                            ${pilote.date_deces ?
            `<div class="info-item">
                                    <span class="info-label">Décès :</span>
                                    <span class="info-value">${pilote.date_deces}</span>
                                </div>` : ''
        }
                            <div class="info-item">
                                <span class="info-label">Nationalité :</span>
                                <span class="info-value">${pilote.nationalite || 'N/A'}</span>
                            </div>
                        </div>
                    </div>

                    ${pilote.description ?
            `<div class="carte-section">
                            <h3>Description</h3>
                            <p class="description-text">${pilote.description}</p>
                        </div>` : ''
        }

                    ${pilote.palmares ?
            `<div class="carte-section">
                            <h3>Palmarès</h3>
                            <div class="palmares-text">${pilote.palmares.replace(/\n/g, '<br>')}</div>
                        </div>` : ''
        }
                </div>
            `;

        document.getElementById('piloteModalContent').innerHTML = content;
        document.getElementById('piloteModal').classList.add('active');
        document.getElementById('modalOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function openModeleModal(id) {
        const modele = modeles.find(m => m.id == id);
        if (!modele) return;

        const content = `
                <div class="carte-identite">
                    <div class="carte-header">
                        <h2>${modele.nom}</h2>
                        <span class="badge-modele">MODÈLE</span>
                    </div>

                    ${modele.image_path ?
            `<img src="${modele.image_path}" alt="${modele.nom}" class="carte-photo">` :
            '<div class="carte-photo-placeholder">️</div>'
        }

                    <div class="carte-section">
                        <h3>Informations</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Période :</span>
                                <span class="info-value">${modele.annee_debut || '?'} - ${modele.annee_fin || '?'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Cylindrée :</span>
                                <span class="info-value">${modele.cylindree || 'N/A'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Type :</span>
                                <span class="info-value">${modele.type_moto || 'N/A'}</span>
                            </div>
                        </div>
                    </div>

                    ${modele.description ?
            `<div class="carte-section">
                            <h3>Description</h3>
                            <p class="description-text">${modele.description}</p>
                        </div>` : ''
        }

                    ${modele.caracteristiques ?
            `<div class="carte-section">
                            <h3>Caractéristiques techniques</h3>
                            <div class="caracteristiques-text">${modele.caracteristiques.replace(/\n/g, '<br>')}</div>
                        </div>` : ''
        }
                </div>
            `;

        document.getElementById('modeleModalContent').innerHTML = content;
        document.getElementById('modeleModal').classList.add('active');
        document.getElementById('modalOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('piloteModal').classList.remove('active');
        document.getElementById('modeleModal').classList.remove('active');
        document.getElementById('modalOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
</body>
</html>