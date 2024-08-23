<?= \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'floatHeader' => true,
    // 'filterModel' => $searchModel,
    'summary' => false,
    'pager' => [
        'firstPageLabel' => 'Первый',
        'lastPageLabel'  => 'Последный'
    ],
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        // 'email:boolean',
        // 'sms:boolean',
        [
            'format' => 'html',
            'width' => '90%',
            'attribute' => 'key_title',
            'value' => function($data){
                return "<b>" . $data->key_title . "</b><br>" . "" . $data->key_text . (
                ($data->subscription) ? "<br><p class='text-muted'>Подписка: " . $data->subscription ."</p>" : "");
            }
        ],

        [
            'format' => 'html',
            'attribute' => 'status',
            'format'=>'raw',
            'value'=>function($data){
                return '<label class="switch switch-small">
                    <input type="checkbox"'. (($data->status == 1)?' checked=""':'""').'value="'.$data->id.'" onchange="$.post(\'/alerts/change-status\',{id:'.$data->id.'},function(data){ });">
                    <span></span>
                    </a>
                </label>';
            },
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'vAlign'=>'middle',
            'headerOptions'=>['class'=>'text-center'],
            'template' => '{leadUpdate}',
            'buttons'  => [
                'leadUpdate' => function ($url, $model) {
                    $url = \yii\helpers\Url::to(['/alerts/update','id' => $model->id]);
                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, 
                        [
                            'data-pjax'=>0,'title'=>'Изменить', 'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                        ]);
                },
            ]
        ],
    ],
]); ?>