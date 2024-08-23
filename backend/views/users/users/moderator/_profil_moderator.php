<?php

use yii\helpers\Html;
use backend\components\StaticFunction;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use katzz0\yandexmaps\Map;
use katzz0\yandexmaps\JavaScript;
use katzz0\yandexmaps\objects\Placemark;
use katzz0\yandexmaps\Polyline;
use katzz0\yandexmaps\Point;
use katzz0\yandexmaps\Canvas as YandexMaps;

// User default kordinatalarni belgilash

if ($model->coordinate_x == null && $model->coordinate_y == null) {
    $model->coordinate_x = '41.2748753';
    $model->coordinate_y = '69.2071344';
}
$label = $model->attributeLabels();
?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']) ?> 
<table class="table table-bordered">
    <tbody>
        <tr>
            <td rowspan="8" width="300px">
                <?=Html::img($model->getAvatar(), [
                    'class' => '',
                    'style' => 'object-fit: cover; width:250px; height:250px;', 'alt' => 'Avatar'
                ])?>
            </td>
        </tr>
        <tr>
            <th width="250px"><?=$label['fio'];?></th>
            <td colspan="2"><?= Html::encode($model->fio);?></td>
        </tr>
        <tr>
            <th><?=$label['phone'];?></th>
            <td colspan="2"><?= Html::encode($model->phone);?></td>
        </tr>
        <tr>
            <th><?=$label['email'];?></th>
            <td colspan="2"><?= Html::encode($model->email);?></td>
        </tr>
        <tr>
            <th><?=$label['login'];?></th>
            <td colspan="2"><?= Html::encode($model->login);?></td>
        </tr>
        <tr>
            <th><?=$label['sex'];?></th>
            <td colspan="2"><?= Html::encode(StaticFunction::sex($model->sex));?></td>
        </tr>
        <tr>
            <th><?=$label['birthday'];?></th>
            <td colspan="2"><?= Html::encode(($model->birthday != null) ? date("d.m.Y", strtotime($model->birthday)) : 'Не выбрано');?></td>
        </tr>
        <tr>
            <th><?=$label['district_id'];?></th>
            <td colspan="2"><?= Html::encode(($model->district_id != null) ? $model->district->name : 'Не выбрано');?></td>
        </tr>
        <tr>
            <th><?=$label['balance'];?></th>
            <td><?= $model->balance;?> сум</td>
            <th><?=$label['status'];?></th>
            <td style="width: 16%;"><?=StaticFunction::status($model->status)?>
            <?=Html::a(' <i class="fa fa-edit"></i>', ['change-status', 'id' => $model->id], ['role'=>'modal-remote', 'class' => 'btn btn-xs btn-success pull-right', 'style' => ['margin' => '2px',]])?></td>
        </tr>
        <tr>
            <th><?=$label['referal_balance'];?></th>
            <td><?= $model->referal_balance;?> сум</td>
             <th><?=$label['sms_comment_alert'];?></th>
            <td><?=StaticFunction::status($model->sms_comment_alert)?></td>
        </tr>
        <tr>
            <th><?=$label['bonus_balance'];?></th>
            <td><?= Html::encode($model->bonus_balance);?> сум</td>
            <th><?=$label['email_fav_ads_price_alert'];?></th>
            <td><?=StaticFunction::status($model->email_fav_ads_price_alert)?></td>
        </tr>
        <tr>
            <th><?=$label['phones'];?></th>
            <td><?= StaticFunction::phoneExplode($model->phones);?></td>
            <th><?=$label['email_message_alert'];?></th>
            <td><?=StaticFunction::status($model->email_message_alert)?></td>
        </tr>
        <tr>
            <th><?=$label['address'];?></th>
            <td><?= Html::encode($model->address);?></td>
            <th><?=$label['sms_fav_ads_price_alert'];?></th>
            <td><?=StaticFunction::status($model->sms_fav_ads_price_alert)?></td>
        </tr>
        <tr>
            <th><?=$label['last_seen'];?></th>
            <td><?= Html::encode(date("H:m d.m.Y", strtotime($model->last_seen)));?></td>
            <th><?=$label['email_news_alert'];?></th>
            <td><?=StaticFunction::status($model->email_news_alert)?></td>
        </tr>
        <tr>
            <th><?=$label['registry_date'];?></th>
            <td><?= Html::encode(date("H:m d.m.Y", strtotime($model->registry_date)));?></td>
            <th><?=$label['email_comment_alert'];?></th>
            <td><?=StaticFunction::status($model->email_comment_alert)?></td>
        </tr>
        <tr>
            <th><?=$label['telegram'];?></th>
            <td><?= Html::encode($model->telegram);?></td>
            <th><?=$label['sms_news_alert'];?></th>
            <td><?=StaticFunction::status($model->sms_news_alert)?></td>
        </tr>
        <tr>
            <th><?=$label['site'];?></th>
            <td><a href="http://<?=$model->site?>"><?=$model->site?></a></td>
            <th><?=$label['phone_verified'];?></th>
            <td><?=StaticFunction::status($model->phone_verified)?></td>
        </tr>
        <tr>
            <th rowspan="2" style="vertical-align: middle;"><?=$label['admin_comment'];?></th>
            <td rowspan="2"><?= $model->admin_comment;?></td>
            <th><?=$label['email_verified'];?></th>
            <td><?=StaticFunction::status($model->email_verified)?></td>

        </tr>
        <tr>
            <th><?=$label['resume_file'];?></th>
            <td>
             <?php if($model->resume_file != null && file_exists('uploads/resume/' . $model->resume_file)){ 
                    echo Html::a($model->resume_file, ['/users/send-file', 'file' => $model->resume_file]);
                }else echo "Пустой"; ?>
            </td>
        </tr>
    </tbody>
</table>
<div id="map" style="height: 400px; margin-bottom:5px"></div>
<div class="form-group">
     <?=Html::a('<i class="fa fa-angle-double-left"></i> Назад', ['moderator'], ['class' => 'btn btn-inverse', 'data-pjax' => '0', 'style' => ['margin' => '2px',]])?>
    <?=Html::a('<i class="fa fa-pencil"></i> Изменить', ['edit-moderator', 'id' => $model->id], ['class' => 'btn btn-info', 'data-pjax' => '0', 'style' => ['margin' => '2px',]])?>
    <?=Html::a('<i class="fa fa-edit"></i> Добавить комментарии', ['add-comment', 'id' => $model->id], ['role'=>'modal-remote', 'class' => 'btn btn-warning', 'style' => ['margin' => '2px',]])?>
</div>
<?php Pjax::end() ?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'options' => [
        'tabindex' => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru&load=package.full"></script>
<?php
$this->registerJs(<<<JS
ymaps.ready(init);
function init() {
    // Подключаем поисковые подсказки к полю ввода.
    var map,
        placemark;

    cord_x = $model->coordinate_x;
    cord_y = $model->coordinate_y;
    // Указывается идентификатор HTML-элемента.
    map = new ymaps.Map('map', {
        zoom: 15,
        center: [cord_x, cord_y],
        controls: []
    });

    placemark = new ymaps.Placemark(map.getCenter(), {
    },{
        preset: 'islands#redDotIconWithCaption',
        draggable: false
    });

    map.geoObjects.add(placemark);

    placemark.events.add('dragend', function (e) {
        var coordinates = placemark.geometry.getCoordinates();
        var myGeocoder = ymaps.geocode(coordinates,{results: 1});
        myGeocoder.then(
            function (res) {
                var street = res.geoObjects.get(0);
                address = street.properties.get('description') + ', ' +street.properties.get('name');
                $("#items-address").val(address);
                $("#items-coordinate_x").val(coordinates[0]);
                $("#items-coordinate_y").val(coordinates[1]);
            }
        );
    });

    map.controls.add('zoomControl');
    map.controls.add('geolocationControl');
}
JS
);

?>