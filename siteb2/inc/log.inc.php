<?php
$dt = time();
$page = $_SERVER['REQUEST_URI'] ?? '/';
$ref = $_SERVER['HTTP_REFERER'] ?? '';
// Один переход занимает одну строку, символ-разделитель в адресах экранируем.
$page = str_replace(["\r", "\n", '|'], ['', '', '%7C'], $page);
$ref = str_replace(["\r", "\n", '|'], ['', '', '%7C'], $ref);
$path = "$dt|$page|$ref\n";
$logDirectory = dirname(__DIR__) . '/log';
if (!is_dir($logDirectory)) {
    mkdir($logDirectory, 0775, true);
}
if (file_put_contents($logDirectory . '/' . PATH_LOG, $path, FILE_APPEND | LOCK_EX) === false) {
    error_log('Не удалось записать журнал посещений');
}
