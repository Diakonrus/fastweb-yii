<?php
$sc=Yii::app()->clientScript;
$sc->registerScriptFile('https://clck.yandex.ru/jclck/dtype=stred/pid=443/cid=71834/path=map/rnd=0.7599599848035723/*https://maps.yandex.ru/');
$sc->registerScriptFile('http://api-maps.yandex.ru/2.0/?load=package.full&amp;lang=ru-RU&coordorder=longlat');
?>

<script type="text/javascript">
    ymaps.ready(init);
    function init () {
        var myMap = new ymaps.Map('map', {
            center: [<?=$startCoords;?>],
            zoom: 13
        });

        myMap.controls.add('zoomControl');

        var myPointsCollection = new ymaps.GeoObjectCollection(),
            arrId = '',
            i = 0;

        <?php foreach ( $coordsData as $key=>$value ){ ?>
           ++i;
           arrId += 1 + ',';
           myPointsCollection.add(new ymaps.Placemark([<?=$value['coords'];?>], {iconContent: '<?=$value['description'];?>'}, {preset: "twirl#blueStretchyIcon"}));
        <?php }  ?>

        myMap.geoObjects.add(myPointsCollection);


        // Обработка события, возникающего при щелчке
        // левой кнопкой мыши в любой точке карты.
        // При возникновении такого события откроем балун.
        myMap.events.add('click', function (e) {
            if (!myMap.balloon.isOpen()) {
                var coords = e.get('coordPosition');
                myMap.balloon.open(coords, {
                    contentHeader:'Координаты:',
                    contentBody:'<p>Введите следующие координаты в соответствующие поля для установки координат точки.</p>' +
                    '<p>Координаты щелчка: ' + [
                        coords[0].toPrecision(6),
                        coords[1].toPrecision(6)
                    ].join(', ') + '</p>',
                    contentFooter:'<sup></sup>'
                });
            }
            else {
                myMap.balloon.close();
            }
        });


    }
</script>

<div id="map" style="width:<?=$mapX;?>px; height:<?=$mapY;?>px" class="<?=$class;?>"></div>