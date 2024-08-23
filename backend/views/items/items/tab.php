<?php 
use backend\models\items\Items;
use backend\widgets\BulkButtonWidget;
?>
<?php \yii\widgets\Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-items-' . $tab . '-pjax']) ?> 
    <?= $this->render('search',['model' => $searchModel,'tab' => $tab])?>
    <?php 

            $panelBeforeTemplate = "";
        if($status == Items::STATUS_PUBLICATIOM){
//            $panelBeforeTemplate = BulkButtonWidget::widget([
//                'buttons'=>\yii\helpers\Html::a('На модерации',
//                    ["bulk-change-status",'status' => Items::STATUS_MODERATING] ,
//                    [
//                        "class"=>"btn btn-primary btn-xs",
//                        'role'=>'modal-remote-bulk',
//                        'data-confirm'=>false, 'data-method'=>false,
//                        'data-request-method'=>'post',
//                        'data-confirm-title'=>'Подтвердите действие',
//                        'data-confirm-message'=>'Вы уверены что хотите на модерации этого элемента?'
//                    ]),
//            ]);

            $panelBeforeTemplate = BulkButtonWidget::widget([
                'buttons'=>\yii\helpers\Html::a('Заблокировать',
                    ["bulk-block-item",'status' => Items::STATUS_BLOCKED] ,
                    [
                        "class"=>"btn btn-warning btn-xs",
                        'role'=>'modal-remote-bulk',
                        'data-confirm'=>false, 'data-method'=>false,
                        'data-request-method'=>'post',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите заблокировать этого элемента?'
                    ]),
            ]);
        }
        if($status == Items::STATUS_INPUBLICATION){
            $panelBeforeTemplate =  BulkButtonWidget::widget([
                                    'buttons'=>\yii\helpers\Html::a('Опубликовать',
                                        ["bulk-change-status",'status' => Items::STATUS_PUBLICATIOM] ,
                                        [
                                            "class"=>"btn btn-success btn-xs",
                                            'role'=>'modal-remote-bulk',
                                            'data-confirm'=>false, 'data-method'=>false,
                                            'data-request-method'=>'post',
                                            'data-confirm-title'=>'Подтвердите действие',
                                            'data-confirm-message'=>'Вы уверены что хотите Опубликовать этого элемента?'
                                        ]),
                                ]);
        }
        if($status == Items::STATUS_MODERATING){
            $panelBeforeTemplate =  BulkButtonWidget::widget([
                                    'buttons'=>\yii\helpers\Html::a('Одобрить',
                                        ["bulk-change-status",'status' => Items::STATUS_PUBLICATIOM] ,
                                        [
                                            "class"=>"btn btn-success btn-xs",
                                            'role'=>'modal-remote-bulk',
                                            'data-confirm'=>false, 'data-method'=>false,
                                            'data-request-method'=>'post',
                                            'data-confirm-title'=>'Подтвердите действие',
                                            'data-confirm-message'=>'Вы уверены что хотите Одобрить этого элемента?'
                                        ]),
                                ]). BulkButtonWidget::widget([
                                    'buttons'=>\yii\helpers\Html::a('Заблокировать',
                                        ["bulk-block-item",'status' => Items::STATUS_BLOCKED] ,
                                        [
                                            "class"=>"btn btn-warning btn-xs",
                                            'role'=>'modal-remote-bulk',
                                            'data-confirm'=>false, 'data-method'=>false,
                                            'data-request-method'=>'post',
                                            'data-confirm-title'=>'Подтвердите действие',
                                            'data-confirm-message'=>'Вы уверены что хотите заблокировать этого элемента?'
                                        ]),
                                ]);
        }
        $panelBeforeTemplate .= BulkButtonWidget::widget([
                                    'buttons'=>\yii\helpers\Html::a('Удалить',
                                        ["bulk-change-status",'status' => Items::STATUS_DELETED] ,
                                        [
                                            "class"=>"btn btn-danger btn-xs",
                                            'role'=>'modal-remote-bulk',
                                            'data-confirm'=>false, 'data-method'=>false,
                                            'data-request-method'=>'post',
                                            'data-confirm-title'=>'Подтвердите действие',
                                            'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                                        ]),
                                ]);
        $panelBeforeTemplate .= BulkButtonWidget::widget([
                'buttons'=>\yii\helpers\Html::a('На модерации',
                    ["bulk-change-status",'status' => Items::STATUS_MODERATING] ,
                    [
                        "class"=>"btn btn-primary btn-xs",
                        'role'=>'modal-remote-bulk',
                        'data-confirm'=>false, 'data-method'=>false,
                        'data-request-method'=>'post',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите на модерации этого элемента?'
                    ]),
        ]);

        $panelBeforeTemplate .= '<div class="clearfix"></div>';

        if($status == Items::STATUS_DELETED && $status != -1){
            $panelBeforeTemplate =  /*BulkButtonWidget::widget([
                    'buttons'=>\yii\helpers\Html::a('Одобрить',
                        ["bulk-change-status",'status' => Items::STATUS_PUBLICATIOM] ,
                        [
                            "class"=>"btn btn-success btn-xs",
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'Подтвердите действие',
                            'data-confirm-message'=>'Вы уверены что хотите Одобрить этого элемента?'
                        ]),
                ]).*/ BulkButtonWidget::widget([
                    'buttons'=>\yii\helpers\Html::a('Заблокировать',
                        ["bulk-block-item",'status' => Items::STATUS_BLOCKED] ,
                        [
                            "class"=>"btn btn-warning btn-xs",
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'Подтвердите действие',
                            'data-confirm-message'=>'Вы уверены что хотите заблокировать этого элемента?'
                        ]),
                ]);
            if($status == Items::STATUS_DELETED){
                $panelBeforeTemplate .= BulkButtonWidget::widget([
                    'buttons'=>\yii\helpers\Html::a('Удалить',
                        ["bulk-change-delete"] ,
                        [
                            "class"=>"btn btn-danger btn-xs",
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'Подтвердите действие',
                            'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                        ]),
                ]);
            }

            $panelBeforeTemplate .= BulkButtonWidget::widget([
                'buttons'=>\yii\helpers\Html::a('На модерации',
                    ["bulk-change-status",'status' => Items::STATUS_MODERATING] ,
                    [
                        "class"=>"btn btn-primary btn-xs",
                        'role'=>'modal-remote-bulk',
                        'data-confirm'=>false, 'data-method'=>false,
                        'data-request-method'=>'post',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите на модерации этого элемента?'
                    ]),
            ]);
            $panelBeforeTemplate .= '<div class="clearfix"></div>';
        }
    ?>
    <?=\kartik\grid\GridView::widget([
        'id'=>'crud-datatable-items-'.$tab,
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        // 'pjax'=>true,
        'columns' => require(__DIR__.'/_columns.php'),
        'panelBeforeTemplate' => $panelBeforeTemplate,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'responsiveWrap' => false,
        'pager' => [
            'firstPageLabel' => 'Первый',
            'lastPageLabel'  => 'Последный'
        ],
        'panel' => [
        'headingOptions' => ['style' => 'display: none;'],
        'after'=>'<div class="clearfix"></div>',
        ]
    ])?>
<?php \yii\widgets\Pjax::end(); ?>
