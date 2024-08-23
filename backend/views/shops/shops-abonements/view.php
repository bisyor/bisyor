<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsAbonements */
$i = 0;
$this->params['breadcrumbs'][] = ['label' => 'Абонемент', 'url' => ['/shops/shops-abonements/index']];
$titles = $model->translation_title;
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="panel panel-inverse shops-abonements-index">
    <div class="panel-heading">
        <h4 class="panel-title">Просмотр </h4>
    </div>
    <div class="panel-body">
        <div class="shop-categories-view">
            <ul class="nav nav-tabs" style="margin-top:2px;">
                <?php foreach($langs as $lang):?>
                <li class="<?=($i==0)?'active':''?>">
                    <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1])?explode('-',$lang->name)[1]:$lang->name)?></a>
                </li>
                <?php $i++; endforeach;?>
            </ul>
            <div class="tab-content">
                <?php $i=0; foreach($langs as $lang):?>
                    <div id="<?=$lang->url?>" class="tab-pane fade <?=($i==0)?'in active':''?>">
                    <?=DetailView::widget([
                        'model' => $model,
                        'attributes' => [ 
                            [
                                'attribute'=>'title',
                                'format'=>'html',
                                'value' => (($lang->url == 'ru') ? $model->title: (isset($titles[$lang->url]) ? $titles[$lang->url] : '' )),
                            ],
                        ],
                    ]) ?>
                    </div>
                <?php $i++; endforeach;?>
                <?=DetailView::widget([
                    'model' => $model,
                    'attributes' => [ 
                        [
                            'attribute'=>'icon_b',
                            'format'=>'raw',
                            'value' => function($data){
                                return $data->getImg(false,'50px','50px');
                            }
                        ],
                        [
                            'attribute'=>'icon_s',
                            'format'=>'raw',
                            'value' => function($data){
                                return $data->getImg(true,'50px','50px');
                            }
                        ],
                        [
                            'attribute' => 'price_free_period',
                            'format' => 'html',
                            'value' => function($data){
                                return $data->getFreePeriod();
                            }
                        ],
                        'ads_count',
                        [
                            'attribute'=>'one_time',
                            'format' => 'html',
                            'value' => function($data){
                                return $data->getYesNo($data->one_time);
                            }
                        ],
                        [
                            'attribute'=>'is_free',
                            'format' => 'html',
                            'value' => function($data){
                                return $data->getYesNo($data->is_free);
                            }
                        ],
                        [
                            'attribute'=>'enabled',
                            'format'=>'html',
                            'label' => 'Статус',
                            'value'=> function($data){
                                return $data->getStatusName($data->enabled);
                            },
                        ],
                        [
                            'attribute'=>'fix',
                            'format' => 'html',
                            'value' => function($data){
                                return $data->getYesNo($data->fix);
                            }
                        ],
                        [
                            'attribute'=>'mark',
                            'format' => 'html',
                            'value' => function($data){
                                return $data->getYesNo($data->mark);
                            }
                        ],
                        [
                            'attribute'=>'import',
                            'format' => 'html',
                            'value' => function($data){
                                return $data->getYesNo($data->import);
                            }
                        ],
                        [
                            'attribute'=>'is_default',
                            'format' => 'html',
                            'value' => function($data){
                                return $data->getYesNo($data->is_default);
                            }
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <p class="text-right m-b-0">
            <?=\yii\helpers\Html::a('Изменить', ['/shops/shops-abonements/update','id' => $model->id],['data-pjax' => 0,'class'=>'btn btn-primary'])?>
            <button class="btn btn-inverse" type="button" onClick="history.back();">Отмена</button>
        </p>
    </div>
</div>
