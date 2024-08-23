<?php
use dosamigos\chartjs\ChartJs;
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 14.04.2020
 * Time: 12:09
 * @var $label_percent_chart
 * @var $count_percent_chart
 */
?>

<div id="percent_line" class="col-md-12 hide">
    <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'id' => 'click_percent_line_bisyor',
            'height' => 250,
            'width' => 400
        ],
        'data' => [
            'labels' => $label_percent_chart,
            'datasets' => [
                [
                    'label' => "Статистика",
                    'backgroundColor' => "rgba(179,181,198,0.1)",
                    'borderColor' => "#0088c7",
                    'pointBackgroundColor' => '#0088c7',
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'lineTension' => 0,
                    'data' => $count_percent_chart
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
<div id="percent_bar" class="col-md-12 hide">
    <?= ChartJs::widget([
        'type' => 'bar',
        'options' => [
            'id' => 'click_percent_bar_bisyor',
            'height' => 250,
            'width' => 400
        ],
        'data' => [
            'labels' => $label_percent_chart,
            'datasets' => [
                [
                    'label' => "Статистика",
                    'backgroundColor' => "#0088c7",
                    'borderColor' => "rgba(179,181,198,1)",
                    'pointBackgroundColor' => "rgba(179,181,198,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'data' => $count_percent_chart
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
