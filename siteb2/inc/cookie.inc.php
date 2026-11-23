<?php
$visitCounter = 0;
if (isset($_COOKIE['visitCounter'])) {
    $visitCounter = max(0, (int) $_COOKIE['visitCounter']);
}

$lastVisit = '';
$lastVisitTimestamp = 0;
if (isset($_COOKIE['lastVisit'])) {
    $lastVisitTimestamp = max(0, (int) $_COOKIE['lastVisit']);
    if ($lastVisitTimestamp > 0) {
        $lastVisit = date('d-m-Y H:i:s', $lastVisitTimestamp);
    }
}

// Считаем только первый визит за календарный день, обновление F5 не учитываем.
if ($lastVisitTimestamp === 0 || date('d-m-Y', $lastVisitTimestamp) !== date('d-m-Y')) {
    ++$visitCounter;
    $options = [
        'expires' => time() + 365 * 24 * 60 * 60,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ];
    setcookie('visitCounter', (string) $visitCounter, $options);
    setcookie('lastVisit', (string) time(), $options);
}
