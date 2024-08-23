

<canvas id="myChart" height="200"></canvas>

<script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $price_statistic_labels !!},
            datasets: [{
                label: '{{ trans('messages.Minimal price') }}',
                data: {!! $min_price_statistics !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.1)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            },
                {
                    label: '{{ trans('messages.Maximal price') }}',
                    data: {!! $max_price_statistics !!},
                    backgroundColor: [
                        'rgba(73, 140, 255, 0.1)',
                    ],
                    borderColor: [
                        'rgba(73, 140, 255, 1)',
                    ],
                    borderWidth: 1
                },
                {
                    label: '{{ trans('messages.This price') }}',
                    data: {!! $current_price !!},
                    backgroundColor: [
                        'rgba(0, 255, 0, 0.1'
                    ],
                    borderColor: [
                        'rgba(0, 255, 0, 1)'
                    ],
                    pointBackgroundColor: ['rgba(0, 255, 0, 1)'],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ').replace('.00', '') + ' ' + '{{ trans('messages.sum') }}';
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }
                        label += tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ').replace('.00', '') + ' ' + '{{ trans('messages.sum') }}';
                        return label;
                    }
                }
            }
        }
    });
</script>
