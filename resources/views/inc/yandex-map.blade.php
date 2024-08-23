<script src="https://api-maps.yandex.ru/2.1/?apikey={{ config('settings.geo_maps_yandexKey') }}&lang={{ app()->getLocale() ==='oz'? 'uz' : app()->getLocale() }}"></script>

<script type="text/javascript">
    ymaps.ready(init);
    function init() {
        // Подключаем поисковые подсказки к полю ввода.
        var map, placemark;


        var cord_x = ($("#coordinate_x").val()) ? $("#coordinate_x").val() : 41.2995;
        var cord_y = ($("#coordinate_y").val()) ? $("#coordinate_y").val() : 69.2401;
        // Указывается идентификатор HTML-элемента.
        map = new ymaps.Map('map', {
            zoom: 10,
            center: [cord_x, cord_y],
            controls: []
        });

        placemark = new ymaps.Placemark(map.getCenter(), {
        },{
            preset: 'islands#redDotIconWithCaption',
            draggable: true
        });

        map.geoObjects.add(placemark);

        placemark.events.add('dragend', function (e) {
            var coordinates = placemark.geometry.getCoordinates();
            var myGeocoder = ymaps.geocode(coordinates,{results: 1});
            myGeocoder.then(
                function (res) {
                    var street = res.geoObjects.get(0);
                    address = street.properties.get('description') + ', ' +street.properties.get('name');
                    $("#address").val(address);
                    $("#coordinate_x").val(coordinates[0]);
                    $("#coordinate_y").val(coordinates[1]);
                }
            );
        });

        map.controls.add('zoomControl');
        map.controls.add('geolocationControl');
    }
</script>
