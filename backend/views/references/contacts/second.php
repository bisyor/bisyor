<?php
use kartik\grid\GridView;
/* @var $dataProvider */
/* @var $panelBeforeTemplate */
?>
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
        'id'=>'crud-datatable-tab-2',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'pjax'=>true,
        // 'rowOptions' => ['class' => 'danger'],
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
        '<div class="clearfix"></div>',
        ]
        ])?>
    </div>
