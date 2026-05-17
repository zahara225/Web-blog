<?php
require "config.php";
require "function.php";

logAction("Page d'accueil consultée");

// Récupérer tous les articles, du plus récent au plus ancien
$sql = "SELECT a.*, c.nom AS categorie_nom, u.nom AS auteur_nom
        FROM articles a
        LEFT JOIN categories c ON a.categorie_id = c.id
        LEFT JOIN utilisateurs u ON a.auteur_id = u.id
        ORDER BY a.date_publication DESC";
$articles = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WebBlog — Accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>WebBlog</h1>
            <a href="ajouter-article.php" class="btn btn-primary">+ Nouvel article</a>
        </div>
        <p class="text-muted"><?= count($articles) ?> articles publiés</p>

        <div class="row mt-4">
            <?php foreach ($articles as $a) : ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">
                                <?= htmlspecialchars($a["categorie_nom"]) ?>
                            </span>
                            <h5 class="card-title"><?= htmlspecialchars($a["titre"]) ?></h5>
                            <h6 class="text-muted small">
                                Par <?= htmlspecialchars($a["auteur_nom"]) ?> —
                                <?= formaterDate(substr($a["date_publication"], 0, 10)) ?>
                            </h6>
                            <p class="card-text mt-2">
                                <?= htmlspecialchars($a["extrait"]) ?>
                            </p>
                            <a href="article.php?id=<?= $a['id'] ?>"
                               class="btn btn-outline-primary btn-sm">Lire la suite</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
