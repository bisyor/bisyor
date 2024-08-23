<?php
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use dosamigos\tinymce\TinyMce;
use backend\models\settings\SiteSettings;
?>
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=34f8b02c-7187-4562-bd09-1b207fddf96a"></script>
<div class="sitesettings-sitesettings-form" style="padding-right: 20px; padding-left: 20px; padding-top: 20px;">
    <?php
        $input = '<label for="avatar" title="Выберите" data-toggle="tooltip" id="image_label" onmousemove="style.cursor=\'pointer\'">'.$model->getImg('70px','70px').'</label>
        <input type="file" name="" id="avatar" style="display: none;" accept="image/*">';
        $template = '<div class="row"><div class="col-md-2">
                {label}</div><div class="col-md-9">{input}'.$input.'{error}</div></div>
                ';
    ?>
    <?= $form->field($model, 'img',['template' => $template])->hiddenInput(['id' => 'temp_address','value' => $model->logo]) ?>

    <?php
        $template = '<div class="row"><div class="col-md-2">
                    {label}{hint}</div><div class="col-md-8">{input}{error}</div></div>
                    ';
    ?>

    <?= $form->field($model, 'name',['template' => $template])->textInput(['placeholder' => 'Введите адрес']) ?>
    <?= $form->field($model, 'email',['template' => $template])->textInput(['placeholder' => 'Введите адрес']) ?>
	<?= $form->field($model, 'phone',['template' => $template])->widget(MultipleInput::className(), [
                'max'               => 4,
                'min'               => 1,
                'allowEmptyList'    => false,
                'columns' => [
                    [
                        'name' => 'phone',
                        'enableError' => true,
                        'type' => \yii\widgets\MaskedInput::className(),
                        'options' => [
                            'mask' => '+\9\9899-999-99-99',
                            'options' =>[
                                'class' => 'form-control'
                            ],
                        ],
                    ],
                ],
                'addButtonPosition' => MultipleInput::POS_ROW, // show add button in the header
            ])?>

    <?= $form->field($model, 'telegram_bot_token',['template' => $template])->textInput(['placeholder' => 'Токен телеграм бота']) ?>
    <?php
        $template = '<div class="row"><div class="col-md-3">
                    {label}{hint}</div><div class="col-md-9">{input}{error}</div></div>
                    ';
    ?>
	<div class="row">
        <div class="col-md-2">
            <label>Социальные сети</label>
        </div>
        <div class="col-md-8" style="padding-right: 0px;">
        	<div class="col-md-6">
            	<?= $form->field($model, 'facebook',['template' => $template])->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6" style="padding-right: 10px;">
	            <?= $form->field($model, 'twitter',['template' => $template])->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6">
	            <?= $form->field($model, 'instagram',['template' => $template])->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6" style="padding-right: 10px;">
	            <?= $form->field($model, 'youtube',['template' => $template])->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6">
	            <?= $form->field($model, 'telegram',['template' => $template])->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6" style="padding-right: 10px;">
	            <?= $form->field($model, 'odnoklassniki',['template' => $template])->textInput(['maxlength' => true]) ?>
			</div>
        </div>
	</div>
	<div class="row">
	    <div class="col-md-2">
	        <label for="sitesettings-address"><?=$model->getAttributeLabel('address')?></label>
	    </div>
	    <div class="col-md-8">
            <div style="display: none;">
                <input type="text" name="" id="suggest">
                <button type="button" class="btn btn-default btn-xs" id="button">найти на карте</button>
                - переместите маркер на карте чтобы указать точное местоположение
                <p id="notice">Адрес не найден</p>
            </div>
	        <?= $form->field($model, 'coordinate_x')->hiddenInput()->label(false) ?>
	        <?= $form->field($model, 'coordinate_y')->hiddenInput()->label(false) ?>

	        <div id="map" style="height: 350px;width: 100%;margin-top:10px;position: relative;"></div>
	        <div id="marker"></div>
	    </div>
	</div>
</div>
<?php
$dirname = SiteSettings::DIR_NAME;

$x = isset($model->coordinate_x) ? $model->coordinate_x : 41.2995;
$y = isset($model->coordinate_y) ? $model->coordinate_y : 69.2401;
$this->registerJs(<<<JS

    ymaps.ready(init);

    function init() {

        // Подключаем поисковые подсказки к полю ввода.
        var suggestView = new ymaps.SuggestView('suggest'),
            map,
            placemark;

        // При клике по кнопке запускаем верификацию введёных данных.
        $('#button').bind('click', function (e) {
            geocode();
        });

        cord_x = ($("#sitesettings-coordinate_x").val()) ? $("#sitesettings-coordinate_x").val() : 41.2995;
        cord_y = ($("#sitesettings-coordinate_y").val()) ? $("#sitesettings-coordinate_y").val() : 69.2401;
        // Указывается идентификатор HTML-элемента.
        map = new ymaps.Map('map', {
            zoom: 15,
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
            console.log(coordinates);
            var myGeocoder = ymaps.geocode(coordinates,{results: 1});
            myGeocoder.then(
                function (res) {
                    var street = res.geoObjects.get(0);
                    address = street.properties.get('description') + ', ' +street.properties.get('name');
                    $("#suggest").val(address);

                    $("#sitesettings-coordinate_x").val(coordinates[0]);
                    $("#sitesettings-coordinate_y").val(coordinates[1]);
                }
            );
        });

        map.controls.add('zoomControl');
        map.controls.add('geolocationControl');

        function geocode() {
            // Забираем запрос из поля ввода.
            var request = $('#suggest').val();
            // Геокодируем введённые данные.
            ymaps.geocode(request).then(function (res) {
                var obj = res.geoObjects.get(0),
                    error, hint;

                if (obj) {
                    // Об оценке точности ответа геокодера можно прочитать тут: https://tech.yandex.ru/maps/doc/geocoder/desc/reference/precision-docpage/
                    switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                        case 'exact':
                            break;
                        case 'number':
                        case 'near':
                        case 'range':
                            error = 'Неточный адрес, требуется уточнение';
                            hint = 'Уточните номер дома';
                            break;
                        case 'street':
                            error = 'Неполный адрес, требуется уточнение';
                            hint = 'Уточните номер дома';
                            break;
                        case 'other':
                        default:
                            error = 'Неточный адрес, требуется уточнение';
                            hint = 'Уточните адрес';
                    }
                } else {
                    error = 'Адрес не найден';
                    hint = 'Уточните адрес';
                }

                // Если геокодер возвращает пустой массив или неточный результат, то показываем ошибку.
                if (error) {
                    showError(error);
                    // showMessage(hint);
                } else {
                    showResult(obj);
                }
            }, function (e) {
                console.log(e)
            })
        }

        function showResult(obj) {
            // Удаляем сообщение об ошибке, если найденный адрес совпадает с поисковым запросом.
            $('#suggest').removeClass('input_error');
            $('#notice').css('display', 'none');

            var mapContainer = $('#map'),
                bounds = obj.properties.get('boundedBy'),
            // Рассчитываем видимую область для текущего положения пользователя.
                mapState = ymaps.util.bounds.getCenterAndZoom(
                    bounds,
                    [mapContainer.width(), mapContainer.height()]
                ),
            // Сохраняем полный адрес для сообщения под картой.
                address = [obj.getCountry(), obj.getAddressLine()].join(', '),
            // Сохраняем укороченный адрес для подписи метки.
                shortAddress = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
            // Убираем контролы с карты.
            mapState.controls = [];
            // Создаём карту.
            createMap(mapState, shortAddress);
            // Выводим сообщение под картой.
            showMessage(address);
        }

        function showError(message) {
            $('#notice').text(message);
            $('#suggest').addClass('input_error');
            $('#notice').css('display', 'block');
            // Удаляем карту.
            // if (map) {
            //     map.destroy();
            //     map = null;
            // }
        }

        function createMap(state, caption) {
            // Если карта еще не была создана, то создадим ее и добавим метку с адресом.
            if (!map) {
                map = new ymaps.Map('map', state);
                placemark = new ymaps.Placemark(
                    map.getCenter(), {
                        iconCaption: caption,
                        balloonContent: caption
                    }, {
                        draggable: true,
                        preset: 'islands#redDotIconWithCaption'
                    });
                map.geoObjects.add(placemark);

                var coordinates = placemark.geometry.getCoordinates();
                $("#sitesettings-coordinate_x").val(coordinates[0]);
                $("#sitesettings-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#suggest").val(address);

                            $("#sitesettings-coordinate_x").val(coordinates[0]);
                            $("#sitesettings-coordinate_y").val(coordinates[1]);
                        }
                    );
                });
                // Если карта есть, то выставляем новый центр карты и меняем данные и позицию метки в соответствии с найденным адресом.
            } else {
                map.setCenter(state.center, state.zoom);
                placemark.geometry.setCoordinates(state.center);
                placemark.properties.set({iconCaption: caption, balloonContent: caption});

                var coordinates = placemark.geometry.getCoordinates();
                $("#sitesettings-coordinate_x").val(coordinates[0]);
                $("#sitesettings-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#suggest").val(address);

                            $("#sitesettings-coordinate_x").val(coordinates[0]);
                            $("#sitesettings-coordinate_y").val(coordinates[1]);
                        }
                    );
                });
            }
        }

        function showMessage(message) {
            $('#messageHeader').text('Данные получены:');
            $('#message').text(message);
        }
    }

    $("#avatar").on('change',function(e){
        var file = $( '#avatar' )[0].files[0];
        var data = new FormData();

        var d = new Date();
        var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();
        var filename = file.name;
        name = filename.split('.').shift();
        var ext = filename.split('.').pop();
        new_name = name + '(' + new_name + ")." + ext;
        data.append('file[]', file) ;
        data.append('dir_name', '$dirname') ;
        data.append('names[]', new_name);
        data.append('old_image', $("#temp_address").val());
        $("#temp_address").val(new_name);

        $.ajax({
            url: '/shops/shop-categories/upload-image',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(success){
                $("#count_files").val(1);
                $("#image_label img").attr('style','width:70px;height:70px');
                $("#image_label img").attr('src',success);
            },
            error: function(success){
                alert("Error occur uploading image. Try again )");
                $("#image_label img").attr('src','/uploads/noimg.jpg');
            },
            //Do not cache the page
            cache: false,

            //@TODO start here
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    $("#image_label img").attr('src','/uploads/zz.gif');
                    return myXhr;
                }
            }
        });
    });
JS
);
?>