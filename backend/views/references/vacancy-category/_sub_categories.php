<?php
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<?=GridView::widget([ 
    'id'=>'crud-datatable',
    'dataProvider' => $model->getChildList(),
    'responsiveWrap' => false,
    'columns' => [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => '30px',
        ],
        [
            'attribute' => 'name',
            'value' => function($data){
                return $data->name;
            }
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($data){
                return \backend\models\references\VacancyCategory::getStatusName($data->status);
            }
        ],
        /*[
            'contentOptions'=>['class'=>'text-center'],
            'headerOptions'=>['class'=>'text-center'],
            'attribute'=>'metro',
            'width'=>'150px',
            'format'=>'raw',
            'value'=>function($data){
                return '<label class="switch switch-small">
                        <input type="checkbox"'. (($data->metro == 1)?' checked=""':'""').'value="'.$data->id.'" onchange="$.post(\'/references/regions/change-metro\',{id:'.$data->id.'},function(data){ });">
                        <span></span>
                        </a>
                    </label>';
                },
        ],*/
        [
            'class'    => 'kartik\grid\ActionColumn',
            'template' => '{leadUpdate}',
            'buttons'  => [
                'leadUpdate' => function ($url, $model) {
                    $url = Url::to(['update-child', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['class' => 'btn btn-info btn-xs', 'role'=>'modal-remote', 'data-toggle'=>'tooltip','title'=>'Изменить',]);
                },
                'leadDelete' => function ($url, $model) {
                    $url = Url::to(['delete-sub', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>'Удалить', 
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                    ]);
                },
            ]
        ]
    ],
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
])?>
