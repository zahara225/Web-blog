<?php
$cheminLog = "logs/actions.log";

if (file_exists($cheminLog)) {
    $contenu = file_get_contents($cheminLog);
} else {
    $contenu = "Aucun log pour le moment.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WebBlog — Logs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Logs des actions</h1>
        <pre class="bg-dark text-light p-3 rounded"><?= $contenu ?></pre>
    </div>
</body>
</html>
