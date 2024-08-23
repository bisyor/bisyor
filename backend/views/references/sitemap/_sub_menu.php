<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 17.04.2020
 * Time: 20:41
 */


use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<?= GridView::widget([
    'id' => 'crud-datatable-'.$model->id,
    'dataProvider' => $model->getSubMenuList(),
    'columns' => [
        [
            'class'=>'kartik\grid\ExpandRowColumn',
            'width'=>'50px',
            'disabled' => function($model){
                if(!$model->allow_submenu) return true;
            },
            'value'=>function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                if($model->allow_submenu) return Yii::$app->controller->renderPartial('_sub_menu', ['model'=>$model]);
            },
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'expandOneOnly'=>true
        ],
        [
            'attribute' => 'name',
            'value' => function ($data) {
                return $data->name;
            }
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'width' => '120px',
            'template' => '{leadUpdate} {leadDelete} {leadCreate}',
            'buttons' => [
                'leadCreate' => function ($url, $model) {
                    $url = Url::to(['create', 'id' => $model->id]);
                    $link = Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['class' => 'btn btn-warning btn-xs', 'role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Добавить',]);
                    if($model->allow_submenu) return $link;
                    else return false;
                },
                'leadUpdate' => function ($url, $model) {
                    $url = Url::to(['update', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['class' => 'btn btn-info btn-xs', 'role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Изменить',]);
                },
                'leadDelete' => function ($url, $model) {
                    $url = Url::to(['delete', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'class' => 'btn btn-danger btn-xs',
                        'role' => 'modal-remote', 'title' => 'Удалить',
                        'data-confirm' => false, 'data-method' => false,// for overide yii data api
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => 'Подтвердите действие',
                        'data-confirm-message' => 'Вы уверены что хотите удалить этого элемента?',
                    ]);
                },
            ]
        ]
    ],
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => false,
    'pager' => [
        'firstPageLabel' => 'Первый',
        'lastPageLabel'  => 'Последный'
    ],
    'panelBeforeTemplate' => '',
    'panel' => [
        'headingOptions' => ['style' => 'display: none;'],
        'footer' => false,
    ]
]) ?>
