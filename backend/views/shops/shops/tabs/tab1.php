<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        
        [
            'attribute'=>'logo',
            'format' => 'raw',
            'value' => function($data){
                return $data->getImg('150px','150px');
            }
        ],
        [
            'format' => 'raw',
            'attribute'=>'name',
            'value' => function($data){
                return '<i class="fa fa-building fa-lg m-r-5"></i>  ' . $data->name;
            }
        ],
        [
            'format' => 'raw',
            'attribute'=>'user_id',
            'value' => function($data){
                return '<i class="fa fa-user fa-lg m-r-5"></i>  ' . $data->getShopUser();
            }
        ],
        [
            'attribute'=>'status',
            'format' => 'raw',
            'value' => function($data){
                return $data->getStatusName($data->status);
            },
        ],
        [
            'format' => 'raw',
            'attribute'=>'description',
            'value' => function($data){
                return '<i class="fa fa-flash fa-lg m-r-5"></i>  ' . $data->description;
            },
        ],
        [
            'format' => 'raw',
            'attribute'=>'district_id',
            'value' => function($data){
                $name = null;
                $name = $data->district_id != null ? $data->district->region->name . " , " . $data->district->name : null;
                return '<i class="fa fa-compass fa-lg m-r-5"></i>  '.$name;
            },
        ],
        [
            'format' => 'raw',
            'attribute' => 'address',
            'value' => function($data){
                return '<i class="fa fa-map-marker fa-lg m-r-5"></i>  ' . $data->address;
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'phones',
            'value' => function($data){
                return '<i class="fa fa-mobile fa-lg m-r-5"></i>  ' . implode(",  ",$data->getPhoneNumbers());
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'telegram_channel',
        ],
        [
            'format' => 'raw',
            'attribute' => 'site',
            'value' => function($data){
                return '<i class="fa fa-globe fa-lg m-r-5"></i>  ' . $data->site;
            }
        ],
        [
            'format' => 'raw',
            'attribute'=>'blocked_reason',
            'value' => function($data){
                return '<i class="fa fa-ban fa-lg m-r-5"></i>  ' . $data->blocked_reason;
            },
        ],
        [
            'format' => 'raw',
            'attribute'=>'admin_comment',
            'value' => function($data){
                return '<i class="fa fa-comment fa-lg m-r-5"></i>  ' . $data->admin_comment;
            },
        ],
        [
            'format' => 'raw',
            'attribute'=>'social_networks',
            'value' => function($data){
                return $data->getSotSetiTemplate();
            },
        ],
        [
            'format' => 'raw',
            'attribute'=>'date_cr',
            'value' => function($data){
                return '<i class="fa fa-plus-circle fa-lg m-r-5"></i>  ' . $data->date_cr;
            },
        ],
        
        [
            'format' => 'raw',
            'attribute'=>'date_up',
            'value' => function($data){
                return '<i class="fa fa-pencil fa-lg m-r-5"></i>  ' . $data->date_up;
            },
        ],
    ],
]) ?>

<p class="text-right m-b-0">
    <?=\yii\helpers\Html::a('Изменить', ['/shops/shops/update','id' => $model->id],['data-pjax' => 0,'class'=>'btn btn-primary'])?>
    <button class="btn btn-inverse" onClick="history.back();">Назад</button>
</p>