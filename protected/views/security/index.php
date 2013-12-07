<?php

$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=> array(
        'title' => array(
            'text' => 'Password Security'
        ),
        'tooltip' => array(
            'pointFormat' => '{series.name}: <b>{point.percentage}%</b>',
            'percentageDecimals' => 1
        ),
        'plotOptions' => array(
            'pie' => array(
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => array(
                    'color' => '#000',
                    'connectorColor' => '#000',
                    'enabled' => true
                )
            )
        ),
        'series' => array(
            array(
                'type' => 'pie',
                'name' => 'Passwords',
                'data' => $data
            )
        )
    )
/*
   '{
      "title": { "text": "Password Security" },
      tooltip: {
                pointFormat: "{series.name}: <b>{point.percentage}%</b>",
                percentageDecimals: 1
      },
      plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: "pointer",
                    dataLabels: {
                        enabled: true,
                        color: "#000000",
                        connectorColor: "#000000",
                        formatter: function() {
                            return "<b>"+ this.point.name +"</b>: "+ this.percentage +" %";
                        }
                    }
                }
            },
            series: [{
                type: "pie",
                name: "Length of Passwords",
                data: ' . json_encode($data) . ''
            }]
   }'*/
));

?>