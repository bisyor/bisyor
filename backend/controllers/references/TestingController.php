<?php

namespace backend\controllers\references;

use Yii;
use yii\web\Controller;

class TestingController extends Controller
{
	public function actionRedirect()
	{
		/*$redirects = Redirects::find()->all();
		foreach ($redirects as $redirect) {
			$data = $redirect->attributes;
			$model = new Redirects();
			$model->setAttributes($data);
			print_r($model);
			die();
		}*/
	}
}