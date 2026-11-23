<?php
$logFile = dirname(__DIR__) . '/log/' . PATH_LOG;
if (!is_file($logFile)) {
    echo '<p>Журнал посещений пока пуст.</p>';
    return;
}
$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($lines === false || $lines === []) {
    echo '<p>Нет записей для отображения.</p>';
    return;
}
echo '<ul>';
foreach ($lines as $line) {
    $entry = explode('|', $line, 3);
    if (count($entry) !== 3 || !ctype_digit($entry[0])) {
        continue;
    }
    [$timestamp, $page, $ref] = $entry;
    echo '<li>' . date('d-m-Y H:i:s', (int) $timestamp) . ' — '
        . htmlspecialchars($page, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . ' → '
        . htmlspecialchars($ref !== '' ? $ref : 'Прямой переход', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</li>';
}
echo '</ul>';
