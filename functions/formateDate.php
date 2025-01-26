<?php
// Tableaux pour les mois et les jours
$months = [
    'Janvier',
    'Février',
    'Mars',
    'Avril',
    'Mai',
    'Juin',
    'Juillet',
    'Août',
    'Septembre',
    'Octobre',
    'Novembre',
    'Décembre'
];

$days = [
    'Dimanche',
    'Lundi',
    'Mardi',
    'Mercredi',
    'Jeudi',
    'Vendredi',
    'Samedi'
];

// Fonction pour formater la date
function formatDate($date, $months, $days) {
    $selectedDate = strtotime($date); // Convertir en timestamp
    $day = date('j', $selectedDate); // Numéro du jour
    $month = date('n', $selectedDate) - 1; // Index du mois (commence à 0)
    $year = date('Y', $selectedDate); // Année
    $dayOfWeek = date('w', $selectedDate); // Jour de la semaine (0 = Dimanche)

    return "{$days[$dayOfWeek]}, le {$day} {$months[$month]} {$year}.";
}
