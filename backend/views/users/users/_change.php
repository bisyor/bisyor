<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use katzz0\yandexmaps\Map;
use katzz0\yandexmaps\JavaScript;
use katzz0\yandexmaps\objects\Placemark;
use katzz0\yandexmaps\Polyline;
use katzz0\yandexmaps\Point;
use katzz0\yandexmaps\Canvas as YandexMaps;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->params['breadcrumbs'][] = ['label' => "Профиль", 'url' => ['/users/users/profile']];
$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="display: none;">
    <?= MaskedInput::widget(['mask' => '+\9\9899-999-99-99', 'name' => 'blaa']) ?>  
</div>
<div class="panel panel-inverse users-form">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=Html::encode($model->fio)?> </h4>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
        <div class="profile-section">
            <div class="row">
                <div class="col-md-4 ">
                    <div id="image" class="col-md-12">
                        <?=Html::img($model->getAvatar(), [
                            'style' => 'min-width:100%;object-fit: cover;',
                            'class'=>'img-circle img-responsive',
                        ])?>
                    </div>
                    <br>
                    <div class="col-md-12">
                       <?= $form->field($model, 'image')->fileInput(['class'=>"image_input", 'accept'=> 'image/*']); ?>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel-inverse">
                            <div class="panel-heading for-phones">
                                <h4 class="panel-title">Дополнительные телефонные номеры
                                    <?php
                                    $pcount = !empty($model->phones) ? count($model->phones) : 0;
                                    if($pcount != $limit):?>
                                        <button type="button" class="btn btn-warning btn-xs pull-right" id="add"><span class="fa fa-plus"></span></button>
                                    <?php endif;?>
                                </h4>
                            </div>
                            <div class="panel-body">
                                 <div class="row" >
                                    <div class="col-md-12">
                                        <div id="dynamic<?=$model->id?>">
                                            <div class="row">
                                            </div>
                                            <?php
                                                $individual = 0;
                                                if($model->phones != null){
                                                foreach ($model->phones as $value) {
                                                    $individual++;
                                                    ?>                                            
                                                    <div class="row" id="phones<?=$model->id . $individual?>" style="margin-top:10px;">
                                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                                            <?= MaskedInput::widget([
                                                                'mask' => '+\9\9899-999-99-99',
                                                                'name' => 'phones[]',
                                                                'value' => $value,
                                                                 'options' => [
                                                                    'id' => 'phones'.$model->id,
                                                                    'placeholder' => '+998-99-999-99-99',
                                                                    'class'=>'form-control',
                                                                 ]
                                                                ]) ?>
                                                        </div>
                                                        <div class="col-md-1 col-sm-1 col-xs-1" >
                                                            <button type="button" style="width: 30px;" name="remove<?=$model->id?>" id="<?=$individual?>" class="btn btn-danger btn_remove<?=$model->id?>"> 
                                                                <i style="margin-left: -6px;" class="glyphicon glyphicon-trash"></i> 
                                                            </button> 
                                                        </div>
                                                    </div>
                                            <?php } }?>
                                            <input type="hidden" class="form-control" id="individual_count" name="individual_count" value="<?=$individual?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>  
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=$form->field($model, 'sex')->dropDownList($model->getSex(), ['prompt'=>'Пожалуйста, выберите пол...']    ) ?>
                        </div>
                        <div class="col-md-6">
                           <?= $form->field($model, 'birthday')->widget(
                                DatePicker::className(), [
                                    'language' => 'ru',
                                    // 'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd.mm.yyyy',
                                    ]
                            ])
                         ?>
                        </div>            
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Область</label>
                                <?= Select2::widget([
                                    'data' => ArrayHelper::map(\backend\models\references\Regions::find()->asArray()->all(), 'id', 'name'),
                                    'value' => $model->getRegions(),
                                    'language' => 'ru',
                                    'options' => [
                                        'placeholder' => 'Выберите область ...',
                                        'onchange'=> '$.post( "/users/users/districts",{id:$(this).val()}, function( data ){
                                            $( "select#district_id" ).html(data);
                                        });',
                                    ],
                                    'name' => 'regions',
                                    'pluginOptions' => [
                                        'allowClear' => false,
                                    ],
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'district_id')->widget(Select2::classname(), [
                                'data' => $model->district_id != null ? $model->getDistricts($model->district_id) : '',
                                'language' => 'ru',
                                'options' => [
                                    'placeholder' => 'Выберите город ...',
                                    'id' => 'district_id',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=$form->field($model, 'address')->textInput(['id' => 'street']) ?>
                        </div>
                        <div class="col-md-6">
                            <?=$form->field($model, 'site')->textInput(['maxlength' => true, 'id' => 'site']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?=$form->field($model, 'telegram')->textInput(['maxlength' => true, 'id' => 'telegram']) ?>
                        </div>
                        <div class="col-md-4" style="padding-top: 25px">
                            <?php if($model->resume_file != null)
                                echo "<a href=".Yii::$app->params['image_site']."/site/send-file?file=".$model->resume_file .">".$model->resume_file."</a>";
                                ?>
                        </div>
                        <div class="col-md-4">
                            <?=$form->field($model, 'resume')->fileInput(['class' => 'form-control-file"']) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'coordinate_x')->hiddenInput(['id' => 'house-coordinate_x'])->label(false) ?>
                    <?= $form->field($model, 'coordinate_y')->hiddenInput(['id' => 'house-coordinate_y'])->label(false) ?>
                    <div class="row">
                        <div class="col-md-12">
                           <div id="map" style="height: 400px"></div> 
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <?= Html::a('<span class="fa fa-angle-double-left"></span> Назад', ['/users/users/profile'], ['class' => 'btn btn-inverse',]); ?>
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>   
</div>
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=34f8b02c-7187-4562-bd09-1b207fddf96a"></script>
<?php 
$this->registerJs(<<<JS
    
$(document).ready(function(){
    var fileCollection = new Array();
    $('#phones$model->id').inputmask({"mask":"+\\\9\\\9899-999-99-99"});
    $("#telegram").inputmask({ "mask": "@*{1,100}", "greedy": false});
    $("#site").inputmask({ "mask": "www.*{1,100}.*{1,10}", "greedy": false});
    $(document).on('change', '.image_input', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="min-width:100%; height:320px;object-fit: cover;" class="img-circle"  src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });

    var indiv_count = document.getElementById('individual_count').value;

    $(document).on('click', '#add', function(){
        indiv_count++;
        if($('input[name="phones[]"]').length+1 >= $limit){
            $('.for-phones').html('<h4 class="panel-title">Дополнительные телефонные номеры </h4>');
        }
        $('#dynamic$model->id').append('<div class="row" style="margin-top:10px;" id="phones$model->id'+indiv_count+'"><div class="col-md-10 col-sm-11 col-xs-11"> <input type="text" class="form-control" name="phones[]" id="phone'+indiv_count+'" placeholder="+998-99-999-99-99" /></div><div class="col-md-1 col-sm-1 col-xs-1" ><button type="button" style="width: 30px;" name="remove$model->id" id="'+indiv_count+'" class="btn btn-danger btn_remove$model->id"> <i style="margin-left: -6px;" class="glyphicon glyphicon-trash"></i> </button> </div></div>');
        $('#phone'+indiv_count).inputmask({"mask":"+\\\9\\\9899-999-99-99"});
    });

    $(document).on('click', '.btn_remove$model->id', function(){
        var button_id = $(this).attr("id");
        $('#phones$model->id'+button_id+'').remove();
        if($('input[name="phones[]"]').length < $limit){
            $('.for-phones').html('<h4 class="panel-title">Дополнительные телефонные номеры<button type="button" class="btn btn-warning btn-xs pull-right" id="add"><span class="fa fa-plus"></span></button></h4>');
        }
    });   
});
JS
);

$this->registerJs(<<<JS
    ymaps.ready(init);
    function init() {
        // Подключаем поисковые подсказки к полю ввода.
        var suggestView = new ymaps.SuggestView('street'),
            map,
            placemark;

        // При клике по кнопке запускаем верификацию введёных данных.
        $('#button').bind('click', function (e) {
            geocode();
        });

        cord_x = ($("#house-coordinate_x").val()) ? $("#house-coordinate_x").val() : 41.2995;
        cord_y = ($("#house-coordinate_y").val()) ? $("#house-coordinate_y").val() : 69.2401;
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
            var myGeocoder = ymaps.geocode(coordinates,{results: 1});
            myGeocoder.then(
                function (res) {
                    var street = res.geoObjects.get(0);
                    address = street.properties.get('description') + ', ' +street.properties.get('name');
                    $("#street").val(address);
                    $("#house-coordinate_x").val(coordinates[0]);
                    $("#house-coordinate_y").val(coordinates[1]);
                }
            );
        });

        map.controls.add('zoomControl');
        map.controls.add('geolocationControl');

        function geocode() {
            // Забираем запрос из поля ввода.
            var request = $('#street').val();
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
            $('#street').removeClass('input_error');
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
            $('#street').addClass('input_error');
            $('#notice').css('display', 'block');
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
                $("#house-coordinate_x").val(coordinates[0]);
                $("#house-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#street").val(address);
                            $("#house-coordinate_x").val(coordinates[0]);
                            $("#house-coordinate_y").val(coordinates[1]);
                        }
                    );
                });
                // Если карта есть, то выставляем новый центр карты и меняем данные и позицию метки в соответствии с найденным адресом.
            } else {
                map.setCenter(state.center, state.zoom);
                placemark.geometry.setCoordinates(state.center);
                placemark.properties.set({iconCaption: caption, balloonContent: caption});

                var coordinates = placemark.geometry.getCoordinates();
                $("#house-coordinate_x").val(coordinates[0]);
                $("#house-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#street").val(address);
                            $("#house-coordinate_x").val(coordinates[0]);
                            $("#house-coordinate_y").val(coordinates[1]);
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
JS
);
?>
