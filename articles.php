<?php

require "function.php";
logAction("Page articles consultée");



$articles = [
    [
        "id"      => 1,
        "titre"   => "Pourquoi PHP en 2025 ?",
        "contenu" => "PHP a beaucoup évolué depuis ses débuts. Aujourd'hui, c'est un langage moderne, rapide, et toujours largement utilisé par Facebook, Wikipedia et WordPress. PHP 8.x apporte de vraies améliorations de performance.",
        "auteur"  => "Marie Dupont",
        "date"    => "2025-12-06"
    ],
    [
        "id"      => 2,
        "titre"   => "Découvrir Bootstrap en 30 minutes",
        "contenu" => "Bootstrap est un framework CSS qui permet de créer des interfaces propres rapidement, sans écrire de CSS à la main. Il propose une grille, des composants, et un design responsive prêt à l'emploi.",
        "auteur"  => "Pierre Martin",
        "date"    => "2025-12-04"
    ],
    [
        "id"      => 3,
        "titre"   => "Mes 5 outils dev favoris",
        "contenu" => "Aujourd'hui je partage les 5 outils qui ont changé mon quotidien de développeur : VS Code, Git, Postman, Docker, et Insomnia. Chacun résout un problème bien précis.",
        "auteur"  => "Lucas Bernard",
        "date"    => "2025-12-02"
    ],
    [
        "id"      => 4,
        "titre"   => "VS Code : les extensions essentielles",
        "contenu" => "Prettier, ESLint, GitLens, Live Server, et PHP Intelephense. Avec ces 5 extensions, votre éditeur devient une vraie IDE.",
        "auteur"  => "Sophie Lemoine",
        "date"    => "2025-11-30"
    ],
    [
        "id"      => 5,
        "titre"   => "Git pour les nuls",
        "contenu" => "add, commit, push, pull : voilà les 4 commandes qui couvrent 90% des cas d'usage. On voit comment les enchaîner pour partager son code en équipe.",
        "auteur"  => "Lucas Bernard",
        "date"    => "2025-11-28"
    ]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WebBlog — Articles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>WebBlog — Tous les articles</h1>
        <p><?= count($articles) ?> articles publiés.</p>
        <div class="row mt-4">
    <?php foreach ($articles as $article) : ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= $article["titre"] ?>
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Par <?= $article["auteur"] ?>
                        — <?= formaterDate($article["date"]) ?>
                    </h6>
                    <p class="card-text">
                        <?= genererExtrait($article["contenu"], 120) ?>
                    </p>
                    <p class="text-muted small">
                        <?= compterMots($article["contenu"]) ?> mots
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    </div>
</body>
</html>
