<div class="row">
	<div class="col-md-6">
		<div class="nav-tabs-custom">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Hasil Investasi</h3>
				</div>
				<div class="box-body">
					<div id="container-d3"></div>
				</div>
			</div>
		</div>
	</div>
    <div class="col-md-6">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Nilai Investasi</h3>
                </div>
                <div class="box-body">
                    <div id="container-d4"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">ROI</h3>
                </div>
                <div class="box-body">
                    <div id="container-d6"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">YOI</h3>
                </div>
                <div class="box-body">
                    <div id="container-d7"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Data</h3>
                </div>
                <div class="box-body" style="overflow-x:auto;">
                    <table id="hasil-invest" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2">Jenis Investasi</th>
                                <th colspan="7">Semester I&nbsp;<span class="tahun"></th>
                                <th colspan="7">Semester II&nbsp;<span class="tahun"></th>
                                <th colspan="2">Pertumbuhan</th>
                            </tr>
                            <tr>
                                <th>Nilai Investasi</th>
                                <th>Porsi</th>
                                <th>Capaian Nilai Atas RIT</th>
                                <th>Hasil Investasi</th>
                                <th>Capaian Hasil Atas RIT</th>
                                <th>YOI</th>
                                <th>ROI</th>

                                <th>Nilai Investasi</th>
                                <th>Porsi</th>
                                <th>Capaian Nilai Atas RIT</th>
                                <th>Hasil Investasi</th>
                                <th>Capaian Hasil Atas RIT</th>
                                <th>YOI</th>
                                <th>ROI</th>

                                <th>Nilai (%)</th>
                                <th>Hasil (%)</th>
                            </tr>

                        </thead>
                         <tbody>
                            <?php 
                                $sum1 = 0;$sum2 = 0;$sum3 = 0;$sum4 = 0;$sum5 = 0;$sum6 = 0;  
                                $sum7 = 0;$sum8 = 0;$sum9 = 0;$sum10 = 0;$sum11 = 0;$sum12 = 0;  
                                $sum13 = 0;$sum14 = 0;
                            ?>
                            <?php if(isset($summary_periodik_semester) && is_array($summary_periodik_semester)):?>
                            <?php foreach($summary_periodik_semester as $sum):?>
                            <tr>
                                <td style="text-align: left;"><?=$sum['jenis_investasi']?></td>

                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_invest_smt1'])?></td>
                                <td style="text-align: right;"><?=$sum['porsi_invest_smt1'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_invest_smt1'].'%'?></td>
                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_hasil_smt1'])?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_hasil_smt1'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['yoi_smt1'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['roi_hasil_smt1'].'%'?></td>

                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_invest_smt2'])?></td>
                                <td style="text-align: right;"><?=$sum['porsi_invest_smt2'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_invest_smt2'].'%'?></td>
                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_hasil_smt2'])?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_hasil_smt2'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['yoi_smt2'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['roi_hasil_smt2'].'%'?></td>

                                <td style="text-align: right;">-</td>
                                <td style="text-align: right;">-</td>
                            </tr>
                            <?php 
                                $sum1 += $sum['saldo_akhir_invest_smt1'];
                                $sum2 += (float)$sum['porsi_invest_smt1'];
                                $sum3 += (float)$sum['capaian_rit_invest_smt1'];
                                $sum4 += $sum['saldo_akhir_hasil_smt1'];
                                $sum5 += (float)$sum['porsi_hasil_smt1'];
                                $sum6 += (float)$sum['capaian_rit_hasil_smt1'];

                                $sum7 += $sum['saldo_akhir_invest_smt2'];
                                $sum8 += (float)$sum['porsi_invest_smt2'];
                                $sum9 += (float)$sum['capaian_rit_invest_smt2'];
                                $sum10 += $sum['saldo_akhir_hasil_smt2'];
                                $sum11 += (float)$sum['porsi_hasil_smt2'];
                                $sum12 += (float)$sum['capaian_rit_hasil_smt2'];

                                $sum13 += (float)$sum['roi_hasil_smt1'];
                                $sum14 += (float)$sum['roi_hasil_smt2'];

                            endforeach;?>
                            <?php endif;?>
                        </tbody>
                        <tfoot style="background-color: #d8d8d8; font-weight: bold;">
                            <td>Total</td>
                            <td style="text-align: right;"><?=rupiah($sum1)?></td>
                            <td style="text-align: right;"><?=$sum2.'%'?></td>
                            <td style="text-align: right;"><?=$sum3.'%'?></td>
                            <td style="text-align: right;"><?=rupiah($sum4)?></td>
                            <td style="text-align: right;"><?=$sum6.'%'?></td>
                            <td style="text-align: right;">-</td>
                            <td style="text-align: right;"><?=$sum13.'%'?></td>

                            <td style="text-align: right;"><?=rupiah($sum7)?></td>
                            <td style="text-align: right;"><?=$sum8.'%'?></td>
                            <td style="text-align: right;"><?=$sum9.'%'?></td>
                            <td style="text-align: right;"><?=rupiah($sum10)?></td>
                            <td style="text-align: right;"><?=$sum12.'%'?></td>
                            <td style="text-align: right;">-</td>
                            <td style="text-align: right;"><?=$sum14.'%'?></td>

                            <td style="text-align: right;">-</td>
                            <td style="text-align: right;">-</td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var iduser = $('#iduser').val();
	$.post(host+'dashboard-display/testing_array', {[csrf_token]:csrf_hash}, function(resp){
		if(resp){
			parsing = JSON.parse(resp);
			var chartD1 = 
			[{
				name: 'Persentase',
				colorByPoint: true,
				data: 
				[{
					name: 'NILAI 1',
					y: parsing.nil1,
					color:'#8c3f6f'
				},{
					name: 'NILAI 2',
					y: parsing.nil2,
					color:'#ff7c8f'
				}]
			}];


			genPieChart("container-d1", "", "", chartD1, '', 250);
			genPieChart("container-d2", "", "", chartD1, '', 250);
		}
	});

    $.post(host+'dashboard-display/summary_periodik_semester', {[csrf_token]:csrf_hash,'iduser':iduser}, function(resp){
        if(resp){
            var param = {};
            parsing = JSON.parse(resp);
            var xChart = parsing.semester;

            var yChart = [
            {
                name: 'Semester',
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 1,
                        y2: 0
                    },
                    stops: [
                    [0, '#e93981'],
                    [1, '#3058ac']
                    ]
                },
                data: parsing.hasil,
            }];

            var yChart1 = [
            {
                name: 'Semester',
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 1,
                        y2: 0
                    },
                    stops: [
                    [0, '#e93981'],
                    [1, '#3058ac']
                    ]
                },
                data: parsing.invest,
            }];

            var yChart2 = [
            {
                name: 'Semester',
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 1,
                        y2: 0
                    },
                    stops: [
                    [0, '#e93981'],
                    [1, '#3058ac']
                    ]
                },
                data: parsing.roi,
            }];

            var yChart3 = [
            {
                name: 'Semester',
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 1,
                        y2: 0
                    },
                    stops: [
                    [0, '#e93981'],
                    [1, '#3058ac']
                    ]
                },
                data: parsing.yoi,
            }];

            genLineChart("container-d3", "", xChart, yChart, "", "", "Nominal (Rp)", false);
            genLineChart("container-d4", "", xChart, yChart1, "", "", "Nominal (Rp)", false);
            genLineChart("container-d6", "", xChart, yChart2, "", "", "Persentase", false);
            genLineChart("container-d7", "", xChart, yChart3, "", "", "Persentase", false);
        }
    });


	// $.post(host+'dashboard-display/testing_array_bar_smt2', {[csrf_token]:csrf_hash}, function(resp){
	// 	if(resp){
	// 		var param = {};
	// 		parsing = JSON.parse(resp);
	// 		var xChart = parsing.arr_bln;

	// 		var yChart = [
	// 		{
	// 			name: 'Semester',
	// 			color: {
	// 				linearGradient: {
	// 					x1: 0,
	// 					x2: 0,
	// 					y1: 1,
	// 					y2: 0
	// 				},
	// 				stops: [
	// 				[0, '#e93981'],
	// 				[1, '#3058ac']
	// 				]
	// 			},
	// 			data: parsing.arr_data,
	// 		}];

 //            var yChart1 = [
 //            {
 //                name: 'Semester',
 //                color: {
 //                    linearGradient: {
 //                        x1: 0,
 //                        x2: 0,
 //                        y1: 1,
 //                        y2: 0
 //                    },
 //                    stops: [
 //                    [0, '#e93981'],
 //                    [1, '#3058ac']
 //                    ]
 //                },
 //                data: parsing.arr_data1,
 //            }];

 //            var yChart2 = [
 //            {
 //                name: 'Semester',
 //                color: {
 //                    linearGradient: {
 //                        x1: 0,
 //                        x2: 0,
 //                        y1: 1,
 //                        y2: 0
 //                    },
 //                    stops: [
 //                    [0, '#e93981'],
 //                    [1, '#3058ac']
 //                    ]
 //                },
 //                data: parsing.arr_data2,
 //            }];

 //            var yChart3 = [
 //            {
 //                name: 'Semester',
 //                color: {
 //                    linearGradient: {
 //                        x1: 0,
 //                        x2: 0,
 //                        y1: 1,
 //                        y2: 0
 //                    },
 //                    stops: [
 //                    [0, '#e93981'],
 //                    [1, '#3058ac']
 //                    ]
 //                },
 //                data: parsing.arr_data3,
 //            }];

 //            var yChart4 = [
 //            {
 //                name: 'Semester',
 //                color: {
 //                    linearGradient: {
 //                        x1: 0,
 //                        x2: 0,
 //                        y1: 1,
 //                        y2: 0
 //                    },
 //                    stops: [
 //                    [0, '#e93981'],
 //                    [1, '#3058ac']
 //                    ]
 //                },
 //                data: parsing.arr_data4,
 //            }];
 //            genLineChart("container-d3", "", xChart, yChart, "", "", "", false);
 //            genLineChart("container-d4", "", xChart, yChart1, "", "", "", false);
 //            genLineChart("container-d6", "", xChart, yChart3, "", "", "", false);
	// 		genLineChart("container-d7", "", xChart, yChart4, "", "", "", false);
	// 	}
	// });


var gaugeOptions = {
    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '70%'],
        size: '90%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: true
    },

    credits: {
        enabled: false
    },

    tooltip: {
        enabled: true
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The speed gauge
var chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 200,
        title: {
            text: 'Hasil Investasi'
        }
    },

    series: [{
        name: 'Hasil Investasi',
        data: [63.22],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y}</span>%<br/>' +
                '<span style="font-size:12px;opacity:0.4">Persentase</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' %'
        }
    }]

}));

// The RPM gauge
var chartRpm = Highcharts.chart('container-rpm', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 200,
        title: {
            text: 'Aset Investasi'
        }
    },

    series: [{
        name: 'Aset Investasi',
        data: [103.14],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y:.2f}</span>%<br/>' +
                '<span style="font-size:12px;opacity:0.4">' +
                'Persentase' +
                '</span>' +
                '</div>'
        },
        tooltip: {
            valueSuffix: ' %'
        }
    }]

}));

// // Bring life to the dials
// setInterval(function () {
//     // Speed
//     var point,
//         newVal,
//         inc;

//     if (chartSpeed) {
//         point = chartSpeed.series[0].points[0];
//         inc = Math.round((Math.random() - 0.5) * 100);
//         newVal = point.y + inc;

//         if (newVal < 0 || newVal > 200) {
//             newVal = point.y - inc;
//         }

//         point.update(newVal);
//     }

//     // RPM
//     if (chartRpm) {
//         point = chartRpm.series[0].points[0];
//         inc = Math.random() - 0.5;
//         newVal = point.y + inc;

//         if (newVal < 0 || newVal > 5) {
//             newVal = point.y - inc;
//         }

//         point.update(newVal);
//     }
// }, 2000);

$(".select2nya").select2( { 'width':'100%' } );
$('.tahun').text(tahun);
</script>