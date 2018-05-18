<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>yandex/geo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>
<body>
    <div class="container">
    <div class="alert alert-success" role="alert">
    <?php if (empty($only_address)) : ?>
            <h2 class="alert-heading">Яндекс координаты (долгота, широта)</h2>
                <form action="">
                    <div class="form-group">
                         <input type="text" placeholder="Введите адрес" name="address" id="lg">
                    </div>
                    <input class="btn btn-primary" type="submit" id="btn-login" value="Найти">
                </form>
    <?php endif ?>
      <?php  if (!empty($address) && empty($only_address)) : ?>
        <h2 class="alert-heading">Результаты поиска координат</h2>
       <table class="table table-bordered table-inverse">
                <tr>
                    <th>По запросу <?=$response->getQuery(); ?> найдено адресов: <?=$response->getFoundCount(); ?></th>
                    <th>Координаты</th>
                </tr>
                <?php $collection = $response->getList();
                foreach ($collection as $item) : ?>
                <tr>
                    <td><a class="badge badge-dark" href="index.php?latitude=<?= $item->getLatitude(); ?>&longitude=<?= $item->getLongitude(); ?>&only_address=<?= $item->getAddress(); ?>"><?= $item->getAddress(); ?></a></td>
                    <td>Широта: <?=$item->getLatitude()." Долгота: ".$item->getLongitude(); ?></td>
                </tr>
                <?php endforeach ?>
            </table>
    <?php endif ?>
            <h2 class="alert-heading">Результаты поиска на карте</h2>
    <?php if (!empty($only_address)) : ?>
        <p>"<?= $only_address ?>" - широта: "<?= $latitude ?>", долгота "<?= $longitude ?>".</p>
        <?php endif ?>
    <?php if (!empty($latitude) && !empty($longitude)) : ?>
        <div class="form-group" id="map" style="width: 900px; height: 600px"></div>
    <?php endif ?>
</div>
</div>
<script type="text/javascript">
    ymaps.ready(init);
    var myMap,
        myPlacemark;
    function init(){
        myMap = new ymaps.Map("map", {
            center: [<?= $latitude; ?>, <?= $longitude; ?>],
            zoom: 10
        });
        myPlacemark = new ymaps.Placemark([<?= $latitude; ?>, <?= $longitude; ?>], {
            hintContent: '<?= $address; ?>',
            balloonContent: '<?= $address; ?>'
        });
        myMap.geoObjects.add(myPlacemark);
    }
</script>

</body>
</html>
