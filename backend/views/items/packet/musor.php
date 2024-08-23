<?php foreach ($serviceModels as $i => $value): ?>
    <?php
        $label = $value->service->title;
        $checkbox = $form->field($value, "[{$i}]status")->widget(CheckboxX::classname(), [
            'autoLabel' => true,
            'pluginOptions'=>[
                'threeState'=>false
            ],
            'labelSettings' => [
                'label' => $label,
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'options' => [
                'id' => 'serviceModel' . $value->id
            ]
        ])->label(false);
        $hint = ($label == 'Поднятие') ? ' - количество поднятий' : ' - количество дней';
        $templateInput = '<div class="row" style="margin-bottom: -15px;"><div class="col-md-3">
            ' . $checkbox . '</div><div class="col-md-2">{input}{error}</div><div class="col-md-5">{hint}</div></div>';
    ?>
    
    <?= $form->field($value, "[{$i}]value",['template' => $templateInput])->textInput(['class' => 'number_input form-control','style' => 'height:25px !important;margin-bottom:2px;'])->hint($hint) ?>
<?php endforeach; ?>