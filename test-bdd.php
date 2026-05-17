<?php
require "config.php";
echo "✅ Connexion réussie à la base " . DB_NAME;

$stmt = $pdo->query("SELECT nom FROM categories");
echo "<ul>";
foreach ($stmt as $ligne) {
    echo "<li>" . $ligne["nom"] . "</li>";
}
echo "</ul>";
?>
