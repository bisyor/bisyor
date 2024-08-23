<?php
/**
 * Created by PhpStorm.
 * User: Abdulloh Olimov
 * Date: 18.11.2020
 * Time: 14:40
 */
use dosamigos\chartjs\ChartJs;
/* @var $post  */
?>

<div class=" row panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Статистика </h4>
    </div>
    <div class="panel-body" id="search_panel">
        <?= $this->render('bills/_search',['post' => $post]);?>
        <br>
        <?= ChartJs::widget([
            'type' => 'line',
            'options' => [
                'height' => 150,
                'width' => 400
            ],
            'data' => [
                'labels' =>$result['label'],
                'datasets' => [
                    [
                        'label' => $label_2,
                        'backgroundColor' => "rgba(51, 102, 255,0.2)",
                        'borderColor' => "rgba(52, 168, 235,1)",
                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#ff",
                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                        'data' => isset($result['old_sum']) ? $result['old_sum'] : [],
                    ],
                    [
                        'label' => $label_1,
                        'backgroundColor' => "rgba(255,99,132,0.2)",
                        'borderColor' => "rgba(255,99,132,1)",
                        'pointBackgroundColor' => "rgba(255,99,132,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'data' => isset($result['last_sum']) ? $result['last_sum'] : [],
                    ],
                ]
            ],
            'clientOptions' => [
               'tooltips'=> [
                    'callbacks'=> [
                        'label'=> new \yii\web\JsExpression("function(t, d) {
                                var label = d.labels[t.index];
                                var day_pay = label.split('|');
                                var data = d.datasets[t.datasetIndex].data[t.index];
                                if (t.datasetIndex === 0){
                                return day_pay[0] + ': ' + data;}
                                else if (t.datasetIndex === 1)
                                return  day_pay[1] + ': ' + data.toLocaleString();
                         }")
                             ]
                    ],
            ],
        ]);
        ?>
    </div>
</div>

