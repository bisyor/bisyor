<h3>Слайдеры</h3>
<?= $this->render('../../shop-slider/index',[
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'shopModel' => $model
]) ?>
