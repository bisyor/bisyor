<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use backend\models\users\Users;
use backend\components\StaticFunction;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
$label = $model->attributeLabels();
?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <h4 class="panel-title">Профиль                     
        </h4>
    </div>
    <div class="panel-body">
            <div class="row">
                <div class="profile-container">
                    <!-- begin profile-section -->
                    <div class="profile-section">
                        <!-- begin profile-left -->
                        <div class="profile-left">
                            <!-- begin profile-image -->
                            <?=Html::img($model->getAvatar(), [
                                'class' => 'img-circle img-responsive',
                                'style' => 'width:100%; object-fit: cover;', 'alt' => 'Avatar'
                            ])?>
                            <!-- end profile-image -->
                            <!-- begin profile-highlight -->
                            <div class="profile-highlight m-t-5">
                                <h4><i class="fa fa-bell-o"></i> Настроить уведомления</h4>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" <?= ($model->email_news_alert == true) ? 'checked=""' : '';?> onchange="$.post('/users/users/change-values',{id: <?=$model->id?>, name : 'email_news_alert'},function(data){ });" /> <?=$label['email_news_alert']?></label>
                                </div>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" <?= ($model->email_message_alert == true) ? 'checked=""' : '';?> onchange="$.post('/users/users/change-values',{id: <?=$model->id?>, name : 'email_message_alert'},function(data){ });"/> <?=$label['email_message_alert']?></label>
                                </div>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" <?= ($model->email_comment_alert == true) ? 'checked=""' : '';?> onchange="$.post('/users/users/change-values',{id: <?=$model->id?>, name : 'email_comment_alert'},function(data){ });"/> <?=$label['email_comment_alert']?></label>
                                </div>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" <?= ($model->email_fav_ads_price_alert == true) ? 'checked=""' : '';?> onchange="$.post('/users/users/change-values',{id: <?=$model->id?>, name :'email_fav_ads_price_alert'},function(data){ });"/> <?=$label['email_fav_ads_price_alert']?></label>
                                </div>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" <?= ($model->sms_news_alert == true) ? 'checked=""' : '';?> onchange="$.post('/users/users/change-values',{id: <?=$model->id?>, name : 'sms_news_alert'},function(data){ });"/> <?=$label['sms_news_alert']?></label>
                                </div>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" <?= ($model->sms_comment_alert == true) ? 'checked' : '';?> onchange="$.post('/users/users/change-values',{id: <?=$model->id;?>, name : 'sms_comment_alert'},function(data){ });"/> <?=$label['sms_comment_alert']?></label>
                                </div>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" <?= ($model->sms_fav_ads_price_alert == true) ? 'checked=""' : '';?> onchange="$.post('/users/users/change-values',{id: <?=$model->id;?>, name : 'sms_fav_ads_price_alert'},function(data){ });"/> <?=$label['sms_fav_ads_price_alert']?></label>
                                </div>
                            </div>
                            <!-- end profile-highlight -->
                        </div>
                        <!-- end profile-left -->
                        <!-- begin profile-right -->
                        <div class="profile-right">
                            <!-- begin profile-info -->
                            <div class="profile-info">
                                <!-- begin table -->
                                <div class="table-responsive">
                                    <table class="table table-profile">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">
                                                    <h4><?=$model->fio?><small><?=$model->getTypeDescription()?></small></h4>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['email']?></td>
                                                <td><?=$model->email?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['phone']?></td>
                                                <td><i class="fa fa-mobile fa-lg m-r-5"></i> <?=$model->phone?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['status']?></td>
                                                <td> <?=StaticFunction::status($model->status)?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['sex']?></td>
                                                <td> <?=StaticFunction::sex($model->sex)?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['birthday']?></td>
                                                <td> <?= date("d.m.Y", strtotime($model->birthday))?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['district_id']?></td>
                                                <td><?= Html::encode(($model->district_id != null) ? $model->district->name : 'Не выбрано');?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['address']?></td>
                                                <td> <?= $model->address?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['phones']?></td>
                                                <td> <?= StaticFunction::phoneExplode($model->phones);?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['balance']?></td>
                                                <td> <?= $model->balance?> сум</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['referal_balance']?></td>
                                                <td> <?= $model->referal_balance?> сум</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['bonus_balance']?></td>
                                                <td> <?= $model->bonus_balance?> сум</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['last_seen']?></td>
                                                <td> <?= Html::encode(date("H:m d.m.Y", strtotime($model->last_seen)));?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['registry_date']?></td>
                                                <td> <?= Html::encode(date("H:m d.m.Y", strtotime($model->registry_date)));?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;"><?=$label['resume_file']?></td>
                                                <td >
                                                    <?php if($model->resume_file != null)
                                                       echo "<a href=".Yii::$app->params['image_site']."/site/send-file?file=".$model->resume_file .">".$model->resume_file."</a>";                                                            
                                                        else echo "Пустой"; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                            <!-- end profile-info -->
                        </div>
                        <!-- end profile-right -->
                    </div>
                    <!-- end profile-section -->
                    <div class="m-b-10">
                        <?=Html::a('<i class="fa fa-pencil"></i> Изменить', ['change'], ['class' => 'btn btn-warning btn-sm pull-right', ])?>
                    </div>
                </div>
            </div>
    </div>                           
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>