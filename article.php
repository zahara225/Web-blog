<?php
require "config.php";
require "function.php";

// Vérifier que l'id est présent et valide
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit;
}
$id = (int) $_GET["id"];

// Récupérer l'article
$sql = "SELECT a.*, c.nom AS categorie_nom, u.nom AS auteur_nom
        FROM articles a
        LEFT JOIN categories c ON a.categorie_id = c.id
        LEFT JOIN utilisateurs u ON a.auteur_id = u.id
        WHERE a.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$article = $stmt->fetch();

// Si l'article n'existe pas, retour à l'accueil
if (!$article) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article["titre"]) ?> — WebBlog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <a href="index.php">← Retour à l'accueil</a>

        <span class="badge bg-secondary mt-3">
            <?= htmlspecialchars($article["categorie_nom"]) ?>
        </span>
        <h1 class="mt-2"><?= htmlspecialchars($article["titre"]) ?></h1>
        <p class="text-muted">
            Par <?= htmlspecialchars($article["auteur_nom"]) ?> —
            <?= formaterDate(substr($article["date_publication"], 0, 10)) ?> —
            <?= compterMots($article["contenu"]) ?> mots
        </p>
        <hr>
        <p class="lead"><?= nl2br(htmlspecialchars($article["contenu"])) ?></p>
    </div>
</body>
</html>
