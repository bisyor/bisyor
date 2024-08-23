<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\items\Items;
/* @var $this yii\web\View */
/* @var $model backend\models\items\Items */
?>

<div class="items-view">

      <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                  'attribute' => 'user_id',
                  'value' => function($data){
                        return $data->name;
                  }
            ],
            [
              'attribute' => 'title',
                'format' => 'raw',
              'value' => function($data){
                    if($data->old_title){
                        return $data->title.' <br><button class="label label-inverse"  onclick="oldTitle()">Старое значения</button> <p id="old_title_view" style="display: none">'.$data->old_title.'</p>';
                    }
                    return $data->title;
              }
            ],
            //'price',
            [
                  'attribute' => 'price',
                  'format' => 'raw',
                  'value' => function($data){
                      return $data->getPriceForApi();
                  }
            ],
            [
                  'attribute' => 'from_device',
                  'format' => 'raw',
                  'value' => function($data){
                        return $data->getFromDevice();
                  }
            ],
            [
                'attribute' => 'phones',
                'format' => 'raw',
                'value' => function($data){
                    return $data->phones != null ? $data->phones[0] : 'Не задано';
                }
            ],
            [
                  'attribute' => 'description',
                    'format' => 'raw',
                    'width' => '500px',
                    'value' => function($data){
                      if($data->old_description){
                           if(mb_strlen($data->description) > 250) {
                               return  mb_substr($data->description, 0, 250) . "...";
                           }
                           return $data->description.' <br><button class="label label-inverse"  onclick="oldDescription()">Старое значения</button> <p id="old_description_view" style="display: none">'.$data->old_description.'</p>';
                      }
                        if(mb_strlen($data->description) > 250) {
                            return '<span id="view_shoert_desc">'.mb_substr($data->description, 0, 250) . "...".'</span><br><button class="label label-inverse" id="text_click"  onclick="firstDescription()">просмотреть</button> <p id="description_view" style="display: none">'.$data->description.'</p>';
                        }
                        return $data->description;
                    }
            ],
            [
                  'attribute' => 'images',
                  'format' => 'raw',
                  'value' => function($data){
                        return $data->getItemsImageView();
                  }
            ],
            [
                  'format' => 'raw',
                  'attribute' => 'cat_id',
                  'value' => function($data){
                        $template = $data->getCategoryName();
                        return implode(" > ", $template);
                  }
            ],
            [
                  'format' => 'html',
                  'attribute' => 'status',
                  'value' => function($data){
                        return $data->getStatusName();
                  }
            ],
            [
                  'format' => 'html',
                  'label' => 'Период',
                  'attribute' => 'publicated_period',
                  'value' => function($data){
                        return date("H:i d.m.Y", strtotime($data->publicated)) . " - " . date("H:i d.m.Y", strtotime($data->publicated_to));

                  }
            ],
            [
                'attribute' => 'verified',
                'format' => 'raw',
                'value'=>function($data){
                    return \dosamigos\switchery\Switchery::widget([
                        'name' => 'status',
                        'value' => $data->verified,
                        'checked' => $data->verified,
                        'clientOptions' => [
                            'size' => 'mini',
                            'color' => '#5FBEAA',
                            'secondaryColor' => '#CCCCCC',
                            'jackColor' => '#FFFFFF',
                        ],
                        'clientEvents' => [
                            'change' => new \yii\web\JsExpression('function() {
                        $.post(\'/items/items/change-verified\', {id: '.$data->id.'}, function(data){$.pjax.reload({container: "#crud-datatable"});});
                    }')
                        ]
                    ]);
                },
            ],
            [
                'attribute' => 'id',
                'label' => 'Услуги',
                'value' => function($data){
                    $service = "";
                    if($data->serviceUp()) $service.=" Поднятие";
                    if($data->serviceFixed()) $service.=" , Закрепление";
                    if($data->servicePremimum()) $service.=" , Премиум";
                    if($data->serviceMarked()) $service.=" , Выделение";
                    if($data->serviceQuick()) $service.=" , Срочно";

                    $service = trim($service ,' , ');
                    return $service;
                },
            ],
            [
                'format' => 'html',
                'label' => 'Olx_link',
                'attribute' => 'id',
                'value' => function($data){
                    return $data->user->olx_link;
                }
            ],
            [
                'format' => 'html',
                'label' => 'Модератор',
                'attribute' => 'moderated_id',
                'value' => function($data){
                    return $data->moderated_id ? $data->moderator->getUserFio() : '';
                }
            ],
        ],
      ]) ?>

    <div class="row" id="status">
        <div class="col-md-12 pull-right" >
            <?php if ($model->getStatus() == Items::STATUS_PUBLICATIOM): ?>
                    <?=Html::a('на модерации', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_MODERATING ]),
                    [
                        'role'=>'modal-remote',
                        'class'=>'btn btn-sm btn-primary'
                    ])?>
                  <?=Html::a('снят c публикации', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_INPUBLICATION ]),
                        [
                            'role'=>'modal-remote',
                            'class'=>'btn btn-sm btn-success'
                        ])?>
                 <button id="current-content" type="button" onclick="$('#change-content').show();$('#current-content').hide()" class="btn btn-sm btn-warning">заблокировать</button>

                <?=Html::a('удалить', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_DELETED ]),
                    [
                        'role'=>'modal-remote',
                        'class'=>'btn btn-sm btn-danger'
                    ])?>
                <a href="/chats/index?item_id=<?= $model->id?>&type=6" class="btn btn-default btn-sm">сообщения(<?=$chats_count?>)</a>
                <div id="change-content" style="display: none;">
                    <br>
                    <select style="width: 50%" class="form-control input-sm" data-id="<?=$model->id?>" id="blocked_reason" onchange="$.post('/items/items/change-blocked-reason?value='+$('#blocked_reason').val() + '&id=' +$(this).attr('data-id'),function(success){
                        if(success == 'Другая причина'){
                            $('#reason-text').show(100);
                        }else{
                            $('#reason-text').hide(100);
                        }
                    })">
                        <?php foreach (Items::BLOCKED_REASONS as $key => $value): ?>
                            <option value="<?=$value?>" <?=($model->blocked_reason == $value) ? 'selected' : '' ?>>
                                <?=$value?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <br>
                    <textarea name=""  id="reason-text" cols="60" class="form-control" data-id="<?=$model->id?>" rows="3" style="display: none" onchange="$.post('/items/items/change-blocked-reason?value='+$(this).val() + '&id=' +$(this).attr('data-id'),function(success){})"><?=$model->blocked_reason?></textarea>
                    <br>
                    <?=Html::a('заблокировать', ['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_BLOCKED ],
                        [
                            'role'=>'modal-remote',
                            'class'=>'btn btn-sm btn-warning'
                        ])?>
                    <button type="button" id="cancel-button" onclick="$('#change-content').hide();$('#current-content').show()" class="btn btn-sm btn-default">отмена</button>
                </div>
            <?php endif ?>
              <?php if ($model->getStatus() == Items::STATUS_INPUBLICATION): ?>
                  <?=Html::a('опубликовать', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_PUBLICATIOM ]),
                        [
                            'role'=>'modal-remote',
                            'class'=>'btn btn-sm btn-info'
                        ])?>
                  <button id="current-content" type="button" onclick="$('#change-content').show();$('#current-content').hide()" class="btn btn-sm btn-warning">заблокировать</button>
                  <?=Html::a('удалить', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_DELETED ]),
                    [
                      'role'=>'modal-remote',
                      'class'=>'btn btn-sm btn-danger'
                  ])?>
                  <div id="change-content" style="display: none;">
                      <br>
                      <select style="width: 50%" class="form-control input-sm" data-id="<?=$model->id?>" id="blocked_reason" onchange="$.post('/items/items/change-blocked-reason?value='+$('#blocked_reason').val() + '&id=' +$(this).attr('data-id'),function(success){
                        if(success == 'Другая причина'){
                            $('#reason-text').show(100);
                        }else{
                            $('#reason-text').hide(100);
                        }
                    })">
                          <?php foreach (Items::BLOCKED_REASONS as $key => $value): ?>
                              <option value="<?=$value?>" <?=($model->blocked_reason == $value) ? 'selected' : '' ?>>
                                  <?=$value?>
                              </option>
                          <?php endforeach ?>
                      </select>
                      <br>
                      <textarea name="" id="reason-text" cols="60" class="form-control" data-id="<?=$model->id?>" rows="3" style="display: none" onchange="$.post('/items/items/change-blocked-reason?value='+$(this).val() + '&id=' +$(this).attr('data-id'),function(success){})"><?=$model->blocked_reason?></textarea>
                      <br>
                    <!-- <button type="button" value="<?=$model->id?>" onclick="$.post('/items/items/change-blocked-reason?value='+$('#blocked_reason').val() + '&id=' +$(this).val(),function(success){$('#cancel-button').trigger('click'); /*location.reload(true);*/})" class="btn btn-sm btn-info">изменить причину</button> -->
                    <?=Html::a('заблокировать', ['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_BLOCKED ],
                      [
                          'role'=>'modal-remote',
                          'class'=>'btn btn-sm btn-warning'
                      ])?>
                    <button type="button" id="cancel-button" onclick="$('#change-content').hide();$('#current-content').show()" class="btn btn-sm btn-default">отмена</button>
                  </div>
              <?php endif ?>
              <?php if ($model->getStatus() == Items::STATUS_MODERATING): ?>
                  <?=Html::a('проверено', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_PUBLICATIOM ]),
                        [
                            'role'=>'modal-remote',
                            'class'=>'btn btn-sm btn-success'
                        ])?>
                  <button id="current-content" type="button" onclick="$('#change-content').show();$('#current-content').hide()" class="btn btn-sm btn-warning">заблокировать</button>
                  <?=Html::a('удалить', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_DELETED ]),
                  [
                      'role'=>'modal-remote',
                      'class'=>'btn btn-sm btn-danger'
                  ])?>
                  <div id="change-content" style="display: none;">
                      <br>
                      <select style="width: 50%" class="form-control input-sm" data-id="<?=$model->id?>" id="blocked_reason" onchange="$.post('/items/items/change-blocked-reason?value='+$('#blocked_reason').val() + '&id=' +$(this).attr('data-id'),function(success){
                        if(success == 'Другая причина'){
                            $('#reason-text').show(100);
                        }else{
                            $('#reason-text').hide(100);
                        }
                    })">
                          <?php foreach (Items::BLOCKED_REASONS as $key => $value): ?>
                              <option value="<?=$value?>" <?=($model->blocked_reason == $value) ? 'selected' : '' ?>>
                                  <?=$value?>
                              </option>
                          <?php endforeach ?>
                      </select>
                      <br>
                      <textarea name="" id="reason-text" cols="60" class="form-control" data-id="<?=$model->id?>" rows="3" style="display: none" onchange="$.post('/items/items/change-blocked-reason?value='+$(this).val() + '&id=' +$(this).attr('data-id'),function(success){})"><?=$model->blocked_reason?></textarea>
                      <br>
                    <!-- <button type="button" value="<?=$model->id?>" onclick="$.post('/items/items/change-blocked-reason?value='+$('#blocked_reason').val() + '&id=' +$(this).val(),function(success){$('#cancel-button').trigger('click'); /*location.reload(true);*/})" class="btn btn-sm btn-info">изменить причину</button> -->
                    <?=Html::a('заблокировать', ['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_BLOCKED ],
                      [
                          'role'=>'modal-remote',
                          'class'=>'btn btn-sm btn-warning'
                      ])?>
                    <button type="button" id="cancel-button" onclick="$('#change-content').hide();$('#current-content').show()" class="btn btn-sm btn-default">отмена</button>
                  </div>
              <?php endif ?>
                <?php if ($model->getStatus() == Items::STATUS_INACTIVE): ?>
                    <?=Html::a('удалить', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_DELETED ]),
                        [
                            'role'=>'modal-remote',
                            'class'=>'btn btn-sm btn-danger'
                        ])?>
                <?php endif;?>
              <?php if ($model->getStatus() == Items::STATUS_BLOCKED): ?>

                <div class="alert alert-danger">
                  <strong>Причина блокировки</strong>
                  <div id="current-content">
                    <p><span id="result"><?=$model->blocked_reason?></span>
                    - <button type="button" onclick="$('#change-content').show();$('#current-content').hide()" class="btn btn-xs btn-link">изменить</button></p>
                  </div>
                  <div id="change-content" style="display: none;">
                    <br>
                    <select style="width: 50%" class="form-control input-sm" id="blocked_reason">
                      <?php foreach (Items::BLOCKED_REASONS as $key => $value): ?>
                        <option value="<?=$value?>" <?=($model->blocked_reason == $value) ? 'selected' : '' ?>>
                          <?=$value?>
                        </option>
                      <?php endforeach ?>
                    </select>
                    <br>
                    <button type="button" value="<?=$model->id?>" onclick="$.post('/items/items/change-blocked-reason?value='+$('#blocked_reason').val() + '&id=' +$(this).val(),function(success){$('#result').html(success);$('#cancel-button').trigger('click');})" class="btn btn-sm btn-info">изменить причину</button>
                    <?=Html::a('разблокировать', ['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_PUBLICATIOM],
                      [
                          'role'=>'modal-remote',
                          'class'=>'btn btn-sm btn-success'
                      ])?>
                    <button type="button" id="cancel-button" onclick="$('#change-content').hide();$('#current-content').show()" class="btn btn-sm btn-default">отмена</button>
                  </div>
                </div>
                  <?=Html::a('удалить', Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_DELETED ]),
                      [
                          'role'=>'modal-remote',
                          'class'=>'btn btn-sm btn-danger'
                      ])?>
              <?php endif ?>
              <?php if ($model->getStatus() == Items::STATUS_DELETED): ?>
              <?php endif ?>
            </div>

      </div>

</div>
<!-- <pre>
  <?php
    $this->registerJs(<<<JS
    function oldTitle() {
        var x = document.getElementById("old_title_view");
        if (x.style.display === "none") {
             $('#old_title_view').show(300);
        } else {
            $('#old_title_view').hide(300);
        }
    }
    
    function oldDescription() {
        var x = document.getElementById("old_description_view");
        if (x.style.display === "none") {
             $('#old_description_view').show(300);
        } else {
            $('#old_description_view').hide(300);
        }
    }
    function firstDescription() {
        var x = document.getElementById("description_view");
        if (x.style.display === "none") {
             document.getElementById("text_click").textContent="Закрыть";
             $('#description_view').show(300);
             $('#view_shoert_desc').hide(300);
        } else {
            document.getElementById("text_click").textContent="просмотреть";
            $('#view_shoert_desc').show(300);
            $('#description_view').hide(300);
        }
    }
    
JS
)
?>
</pre> -->
