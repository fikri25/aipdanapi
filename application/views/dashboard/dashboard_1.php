<div class="row">
	<div class="col-md-6">
		<div class="nav-tabs-custom">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Dashboard - 1</h3>
				</div>
				<div class="box-body">
					<div id="container-d1"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="nav-tabs-custom">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Dashboard - 2</h3>
				</div>
				<div class="box-body">
					<div id="container-d2"></div>
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
					<h3 class="box-title">Dashboard - 3</h3>
				</div>
				<div class="box-body">
					<div id="container-d3"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="nav-tabs-custom">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title" style="font-size: 11pt">Capaian Nilai Aset Investasi Terhadap RIT</h3>
				</div>
				<div class="box-body">
					<div id="container-rpm"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="nav-tabs-custom">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title" style="font-size: 11pt">Capaian Nilai Hasil Investasi Terhadap RIT</h3>
				</div>
				<div class="box-body">
					<div id="container-speed"></div>
				</div>
			</div>
		</div>
	</div>
    <div class="col-md-4">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Dashboard - 6</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="small-box bg-aqua">
                                <div class="inner">
                                  <h3>65,98%</h3>

                                  <p>YOI</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="small-box bg-yellow">
                                <div class="inner">
                                  <h3>78,90%</h3>

                                  <p>ROA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <h3 class="box-title">Dashboard - 7</h3>
                </div>
                <div class="box-body">
                    <table id="hasil-invest" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2" width="5%">No</th>
                                <th rowspan="2" width="30%">Jenis Investasi</th>
                                <th colspan="4">S.d. Maret 2020</th>
                                <th colspan="4">Target Sesuai RIT 2020</th>
                                <th colspan="2">Capaian Hasil</th>
                            </tr>
                            <tr>
                                <th>Nilai Investasi</th>
                                <th>Porsi</th>
                                <th>Hasil Investasi</th>
                                <th>YOI</th>
                                <th>Nilai Investasi</th>
                                <th>Porsi</th>
                                <th>Hasil Investasi</th>
                                <th>YOI</th>
                                <th>Nilai</th>
                                <th>Hasil</th>
                            </tr>

                        </thead>
                            <tr>
                                <td colspan="12" style="text-align: center">Tidak Ada Data</td>
                            </tr>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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

	$.post(host+'dashboard-display/testing_array_bar', {[csrf_token]:csrf_hash}, function(resp){
		if(resp){
			var param = {};
			parsing = JSON.parse(resp);
			var xChart = parsing.arr_bln;

			var yChart = [
			{
				name: 'NILAI',
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
				data: parsing.arr_data,
			}

			];
			genColumnChart("container-d3", "", xChart, yChart, "", "", "", false);
		}
	});


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
</script>

