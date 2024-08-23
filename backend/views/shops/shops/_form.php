<?php
use yii\helpers\Html;
use backend\models\shops\Shops;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use bajadev\dynamicform\DynamicFormWidget;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\Shops */
/* @var $form yii\widgets\ActiveForm */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops/shops/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=34f8b02c-7187-4562-bd09-1b207fddf96a"></script>
<div class="panel panel-inverse shops-form">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$this->title?></h4>
    </div>

    <div class="panel-body">
        <hr>
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'id' => 'create-shops-form',
            ],
            'enableAjaxValidation'      => true,
            'enableClientValidation'    => false,
            'validateOnChange'          => true,
            'validateOnSubmit'          => true,
            'validateOnBlur'            => false,
        ]); ?>

        <div class="shops-shops-form" style="padding-right: 20px; padding-left: 20px; padding-top: 20px;">
            <?php
                $templateInput = '<div class="row"><div class="col-md-2">
                            {label}</div><div class="col-md-8">{input}{error}</div></div>
                            ';
                $templateInput2 = '<div class="row"><div class="col-md-2">
                            {label}</div><div class="col-md-5">{input}{error}</div></div>
                            ';

            ?>
            <?= $form->field($model, 'name',['template' => $templateInput])->textInput(['maxlength' => true]) ?>

            <?php if (!$model->isNewRecord): ?>
                <div class="row">
                    <div class="col-md-2">
                        <label>Пользователь</label>
                    </div>
                    <div class="col-md-8">
                        <?= Html::a($model->user->getUserFio(), Url::to(['/items/items/user-info', 'id' => $model->id]), [
                            'role'=>'modal-remote','title'=> '',
                            'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-link'
                        ]);
                        ?>
                    </div>
                </div>
            <?php  endif;?>
            <br>
            <?= $form->field($model, 'sections',['template' => $templateInput])->widget(Select2::classname(), [
                'data' => $model->getCategoriesList(),
                'options' => ['placeholder' => 'Выберите разделы'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ]);?>

            <?= $form->field($model, 'description',['template' => $templateInput])->textarea(['rows' => 6]) ?>
            <hr>
            <?= $form->field($model, 'site',['template' => $templateInput])->textInput() ?>
            <?= $form->field($model, 'phones',['template' => $templateInput])->widget(MultipleInput::className(), [
                'max'               => 4,
                'min'               => 1,
                'allowEmptyList'    => false,
                'columns' => [
                    [
                        'name' => 'phones',
                        'enableError' => true,
                        'type' => \yii\widgets\MaskedInput::className(),
                        'options' => [
                            'mask' => '+(998)(99)-999-99-99',
                            'options' =>[
                                'class' => 'form-control'
                            ],
                        ],
                    ],
                ],
                'addButtonPosition' => MultipleInput::POS_ROW, // show add button in the header
            ])?>


            <div class="row" id="platno_items">
                <div class="col-md-2">
                    <label>Социальные сети</label>
                </div>
                <div class="col-md-8">
                    <div>
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 4, // the maximum times, an element can be cloned (default 999)
                            'min' => 0, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $modelNetworks[0],
                            'formId' => 'create-shops-form',
                            'formFields' => [
                                'name',
                                'address',
                            ],
                        ]); ?>

                        <button type="button" class="add-item btn btn-link btn-xs"><i class="glyphicon glyphicon-plus"></i> добавить ссылку</button>
                        <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($modelNetworks as $i => $modelNetwork): ?>
                            <br>

                            <div class="item row">
                                <?php
                                    // necessary for update action.
                                    if (! $modelNetwork->isNewRecord) {
                                        echo Html::activeHiddenInput($modelNetwork, "[{$i}]id");
                                    }
                                ?>
                                <div class="col-md-11">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?= $form->field($modelNetwork, "[{$i}]name")->widget(Select2::classname(), [
                                                'data' => $model->getSocialNetworksList(),
                                                'options' => ['placeholder' => 'Выберите'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])->label(false);?>
                                        </div>
                                        <div class="col-md-8">
                                            <?= $form->field($modelNetwork, "[{$i}]address")->textInput(['maxlength' => true,'placeholder' => 'ссылка','style' => 'width:98%;'])->label(false) ?>
                                        </div>
                                    </div><!-- .row -->
                                </div>

                                <div class="col-md-1">
                                        <button type="button" class="remove-item btn btn-danger btn-md"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>

                            </div>
                        <?php endforeach; ?>
                        </div>
                        <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'telegram_channel',['template' => $templateInput])->textInput(['placeholder'=>'@bisyor']) ?>
            <hr>
            <?= $form->field($model, 'district_id',['template' => $templateInput])->widget(Select2::classname(), [
                'data' => $model->getDistrictsList(),
                'options' => ['placeholder' => 'Выберите регионы'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
            <div class="row">
                <div class="col-md-2">
                    <label for="shops-address"><?=$model->getAttributeLabel('address')?></label>
                </div>
                <div class="col-md-8">
                    <?= $form->field($model, 'address')->textInput(['id' => 'suggest','placeholder' => 'Введите адрес'])->label(false) ?>
                    <?= $form->field($model, 'coordinate_x')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'coordinate_y')->hiddenInput()->label(false) ?>
                    <button type="button" class="btn btn-default btn-xs" id="button">найти на карте</button>
                    - переместите маркер на карте чтобы указать точное местоположение
                    <p id="notice">Адрес не найден</p>
                    <div id="map" style="height: 350px;width: 100%;margin-top:10px;position: relative;"></div>
                    <div id="marker"></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'img')->hiddenInput(['id' => 'temp_address']) ?>
                </div>
                <div class="col-md-10">
                    <label for="avatar" title="Выберите" data-toggle="tooltip" id="image_label" onmousemove="style.cursor='pointer'"><?=$model->getImg('50px','50px')?></label>
                    <input type="file" name="" id="avatar" style="display: none;">
                </div>
            </div>
            <br>
            <hr>

            <?php if (!$model->isNewRecord): ?>
            <div class="row">
                <div class="col-md-2">
                    <label>Статус магазина:</label>
                    <br>
                    <?='<i class="fa fa-pencil m-r-5"></i>  ' . $model->status_changed?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, "status")->widget(Select2::classname(), [
                        'data' => $model->getStatusType(true),
                        'options' => [
                            'placeholder' => 'Выберите',
                            'onchange' => '
                                if($(this).val() == 3){
                                    $("#reason").show(100);
                                }else{
                                    $("#reason").hide(100);
                                }
                            '
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(false);?>
                </div>
            </div>

            <div id="reason" <?= ($model->status != 3) ? 'style="display: none"' : '' ?>>
                <?= $form->field($model, 'blocked_reason',['template' => $templateInput])->textArea() ?>
                <hr>
            </div>
            <?php endif ?>
        </div>
        <div class="panel-footer row text-right">
            <div class="form-group col-md-10">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-inverse" type="button" onClick="history.back();">Отмена</button>
            </div>

        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
$dirname = Shops::DIR_NAME;
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

        cord_x = ($("#shops-coordinate_x").val()) ? $("#shops-coordinate_x").val() : 41.2995;
        cord_y = ($("#shops-coordinate_y").val()) ? $("#shops-coordinate_y").val() : 69.2401;
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
                    $("#shops-coordinate_x").val(coordinates[0]);
                    $("#shops-coordinate_y").val(coordinates[1]);
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
                $("#shops-coordinate_x").val(coordinates[0]);
                $("#shops-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#suggest").val(address);
                            $("#shops-coordinate_x").val(coordinates[0]);
                            $("#shops-coordinate_y").val(coordinates[1]);
                        }
                    );
                });
                // Если карта есть, то выставляем новый центр карты и меняем данные и позицию метки в соответствии с найденным адресом.
            } else {
                map.setCenter(state.center, state.zoom);
                placemark.geometry.setCoordinates(state.center);
                placemark.properties.set({iconCaption: caption, balloonContent: caption});

                var coordinates = placemark.geometry.getCoordinates();
                $("#shops-coordinate_x").val(coordinates[0]);
                $("#shops-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#suggest").val(address);
                            $("#shops-coordinate_x").val(coordinates[0]);
                            $("#shops-coordinate_y").val(coordinates[1]);
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

    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        if (! confirm("Вы уверены что хотите удалить этого элемента?")) {
            return false;
        }
        return true;
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $(".number_input").inputFilter(function(value) {
          return /^\d*$/.test(value);
        });
    });

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
                $("#image_label img").attr('style','width:50px;height:50px');
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