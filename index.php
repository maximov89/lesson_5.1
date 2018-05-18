<?php
require __DIR__ . '/vendor/autoload.php';
$api = new \Yandex\Geo\Api();
if (!empty($_GET['address'])) {
    $api->setQuery($_GET['address']);
}
// Настройка фильтров
@$api
    ->setLimit(INF) // кол-во результатов
    ->setLang(\Yandex\Geo\Api::LANG_RU) // локаль ответа
    ->load();
$response = $api->getResponse();
$response->getFoundCount(); // кол-во найденных адресов
$response->getQuery(); // исходный запрос
$response->getLatitude(); // широта для исходного запроса
$response->getLongitude(); // долгота для исходного запроса
// Список найденных точек
$collection = $response->getList();
// Создаем переменные для js
if (!empty($_GET['only_address'])) {
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
    $address = $_GET['only_address'];
    $only_address = $_GET['only_address'];
} elseif (!empty($collection)) {
    $latitude = $collection[0]->getLatitude();
    $longitude = $collection[0]->getLongitude();
    $address = $collection[0]->getAddress();
}
if (!empty($_GET['address']) && $response->getFoundCount() == 0) {
    echo "По Вашему запросу ничего не найдено";
    exit();
}
require_once('v/v_index.php');
