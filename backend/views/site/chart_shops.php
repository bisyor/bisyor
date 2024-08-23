<?php
use dosamigos\chartjs\ChartJs;
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 14.04.2020
 * Time: 12:09
 * @var $label_shops_chart
 * @var $count_shops_chart
 */
?>

<div id="shops_line" class="col-md-12 hide">
    <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'id' => 'chart_shops_line',
            'height' => 250,
            'width' => 400
        ],
        'data' => [
            'labels' => $label_shops_chart,
            'datasets' => [
                [
                    'label' => "Новые магазины",
                    'backgroundColor' => "rgba(179,181,198,0.1)",
                    'borderColor' => "#0088c7",
                    'pointBackgroundColor' => '#0088c7',
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'lineTension' => 0,
                    'data' => $count_shops_chart
                ]
            ]
        ],
        'clientOptions' => [
            'scales' => [
                'yAxes' => [
                    [
                        'display' => true,
                        'ticks' => [
                            'suggestedMin' => 0,
                            'beginAtZero' => false
                        ]
                    ]
                ]
            ]
        ],
    ]);
    ?>
</div>
<div id="shops_bar" class="col-md-12 hide">
    <?= ChartJs::widget([
        'type' => 'bar',
        'options' => [
            'id' => 'chart_shops_bar',
            'height' => 250,
            'width' => 400
        ],
        'data' => [
            'labels' => $label_shops_chart,
            'datasets' => [
                [
                    'label' => "Новые магазины",
                    'backgroundColor' => "#0088c7",
                    'borderColor' => "rgba(179,181,198,1)",
                    'pointBackgroundColor' => "rgba(179,181,198,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'data' => $count_shops_chart
                ]
            ]
        ],
        'clientOptions' => [
            'scales' => [
                'yAxes' => [
                    [
                        'display' => true,
                        'ticks' => [
                            'suggestedMin' => 0,
                            'beginAtZero' => false
                        ]
                    ]
                ]
            ]
        ],
    ]);
    ?>
</div>
