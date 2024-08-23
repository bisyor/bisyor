<h3>Абонементы</h3>
<?= $this->render('../../shops-tariff/index',[
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'shopModel' => $model
]) ?>
