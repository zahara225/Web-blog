<?php
require "config.php";
require "function.php";

// On prépare des variables pour conserver les valeurs et les erreurs
$erreurs    = [];
$titre      = "";
$categorie  = "";
$contenu    = "";
$tags       = "";
$succes     = false;

// On ne valide que si le formulaire a été soumis (en POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // On récupère et on nettoie chaque champ
    $titre     = trim($_POST["titre"]);
    $categorie = trim($_POST["categorie"]);
    $contenu   = trim($_POST["contenu"]);
    $tags      = trim($_POST["tags"]);

    // Validation du titre
    if (strlen($titre) < 5) {
        $erreurs["titre"] = "Le titre doit faire au moins 5 caractères.";
    } elseif (strlen($titre) > 200) {
        $erreurs["titre"] = "Le titre ne doit pas dépasser 200 caractères.";
    }

    // Validation de la catégorie (on vérifie qu'elle fait partie des choix valides)
    $categoriesValides = ["Technologie", "Voyage", "Cuisine", "Lifestyle"];
    if (!in_array($categorie, $categoriesValides)) {
        $erreurs["categorie"] = "Veuillez choisir une catégorie valide.";
    }

    // Validation du contenu
    if (strlen($contenu) < 50) {
        $erreurs["contenu"] = "Le contenu doit faire au moins 50 caractères.";
    }

    // Si aucune erreur, c'est validé !
    if (count($erreurs) === 0) {
        // Récupérer l'id de la catégorie à partir de son nom
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE nom = ?");
    $stmt->execute([$categorie]);
    $categorieId = $stmt->fetchColumn();

    // Générer un extrait automatiquement
    $extrait = genererExtrait($contenu, 200);

    // INSERT préparé (sécurisé contre les injections SQL)
    $sql = "INSERT INTO articles (titre, contenu, extrait, auteur_id, categorie_id, tags)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $titre,
        $contenu,
        $extrait,
        1,             // auteur_id (Lucas, créé en étape 3.3)
        $categorieId,
        $tags
    ]);

    // Redirection vers la page d'accueil
    header("Location: index.php");
    exit;

    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WebBlog — Ajouter un article</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Ajouter un article</h1>
        <?php if ($succes) : ?>
    <div class="alert alert-success mt-4">
        <h4>✅ Article validé !</h4>
        <p><strong>Titre :</strong> <?= htmlspecialchars($titre) ?></p>
        <p><strong>Catégorie :</strong> <?= htmlspecialchars($categorie) ?></p>
        <p><strong>Extrait :</strong> <?= genererExtrait($contenu, 120) ?></p>
        <p><?= compterMots($contenu) ?> mots.</p>
    </div>
<?php endif; ?>
<form method="POST" action="ajouter-article.php" class="mt-4">

    <div class="mb-3">
        <label class="form-label">Titre</label>
        <input type="text" name="titre" class="form-control"
               value="<?= htmlspecialchars($titre) ?>">
        <?php if (isset($erreurs["titre"])) : ?>
            <div class="text-danger mt-1"><?= $erreurs["titre"] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <select name="categorie" class="form-select">
            <option value="">-- Choisir --</option>
            <option value="Technologie">Technologie</option>
            <option value="Voyage">Voyage</option>
            <option value="Cuisine">Cuisine</option>
            <option value="Lifestyle">Lifestyle</option>
        </select>
        <?php if (isset($erreurs["categorie"])) : ?>
            <div class="text-danger mt-1"><?= $erreurs["categorie"] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Contenu</label>
        <textarea name="contenu" class="form-control" rows="6"><?= htmlspecialchars($contenu) ?></textarea>
        <?php if (isset($erreurs["contenu"])) : ?>
            <div class="text-danger mt-1"><?= $erreurs["contenu"] ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Tags (séparés par des virgules)</label>
        <input type="text" name="tags" class="form-control"
               value="<?= htmlspecialchars($tags) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Publier</button>
</form>
    </div>
</body>
</html>
