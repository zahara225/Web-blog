<?php
// =====================================================
// Bibliothèque de fonctions utilitaires de WebBlog
// =====================================================

// Formater une date du format "2025-12-06" vers "6 décembre 2025"
function formaterDate($date) {
    $mois = ["", "janvier", "février", "mars", "avril", "mai", "juin",
             "juillet", "août", "septembre", "octobre", "novembre", "décembre"];

    $annee    = substr($date, 0, 4);   // "2025"
    $numMois  = (int) substr($date, 5, 2);  // 12
    $jour     = (int) substr($date, 8, 2);  // 6

    return $jour . " " . $mois[$numMois] . " " . $annee;
}

// Couper un texte trop long et ajouter "..."
function genererExtrait($texte, $longueur = 150) {
    if (strlen($texte) <= $longueur) {
        return $texte;
    }
    return substr($texte, 0, $longueur) . "...";
}

// Compter le nombre de mots d'un texte
function compterMots($texte) {
    $mots = explode(" ", trim($texte));
    return count($mots);
}

// Écrire une ligne dans le fichier de logs
function logAction($action) {
    // On crée le dossier logs/ s'il n'existe pas
    if (!is_dir("logs")) {
        mkdir("logs");
    }
    $date = date("Y-m-d H:i:s");
    $ligne = "[$date] $action\n";
    file_put_contents("logs/actions.log", $ligne, FILE_APPEND);
}

?>
