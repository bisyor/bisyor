<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\mail\SendmailTemplate */
/* @var $translation_title backend\models\mail\SendmailTemplate */
/* @var $translation_content backend\models\mail\SendmailTemplate */

?>
<div class="sendmail-template-create">
    <?= $this->render('_form', [
        'model' => $model,
        'translation_title' => $translation_title,
        'translation_content' => $translation_content,
        'langs' => $langs,
    ]) ?>
</div>
