
<?php 
    $tahun = $this->session->userdata('tahun');
?>
<br>
<div class="row" style="overflow-x:auto;">
  <div class="col-md-12">
    <table class="table table-responsive table-bordered">
      <thead>
        <tr>
          <th style="text-align:center;width:25%">Uraian</th>
          <th style="text-align:center;width:25%">RKA/RIT</th>
          <th style="text-align:center;width:25%">Realisasi (Bulan Terakhir)</th>
        </tr>
      </thead>
      <tbody>
        <tr style="background:#ffffff">
          <td style="text-align:left;"><b>Aset Investasi</b></td>
          <td><?php echo 'Rp. '.rupiah($data_tabel_pertama[0]) ?></td>
          <td><?php echo 'Rp. '.rupiah($data_tabel_pertama[1]) ?></td>
        </tr>
        <tr style="background:#ffffff">
          <td style="text-align:left;"><b>Hasil Investasi</b></td>
          <td><?php echo 'Rp. '.rupiah($data_tabel_pertama[2]) ?></td>
          <td><?php echo 'Rp. '.rupiah($data_tabel_pertama[3]) ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-widget">
      <div class="box-body">
        <center><div id="donutChart"></div></center>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-widget">
      <div class="box-body">
        <center><div id="doubleBarChart"></div></center>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-widget">
      <div class="box-body">
        <center><div id="barChart"></div></center>
      </div>
    </div>
  </div>
</div>
<div class="row" style="overflow-x:auto;">
  <div class="col-md-12">
    <table class="table table-responsive table-bordered">
      <thead>
        <tr>
          <th style="text-align:center;width:25%">Uraian</th>
          <th style="text-align:center;width:25%">RKA/RIT</th>
          <th style="text-align:center;width:25%">Realisasi<br><small>(Bulan Terakhir)</small></th>
          <th style="text-align:center;width:25%">% Realisasi</th>
        </tr>
      </thead>
      <tbody>
        <tr style="background:#ffffff">
          <td style="text-align:left;"><b>Hasil Investasi</b></td>
          <td><?php echo "Rp. ".rupiah($hasil_investasi[0]) ?></td>
          <td><?php echo "Rp. ".rupiah($hasil_investasi[1]) ?></td>
          <td><?php echo number_format($hasil_investasi[2], 2, '.', '')." %" ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-widget">
      <div class="box-body">
        <center><div id="gaugeChart"></div></center>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-widget">
      <div class="box-body">
        <center><div id="lineBarChart"></div></center>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-widget">
      <div class="box-body">
        <center><div id="doubleBarLine"></div></center>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  //================================ Fungsi Load Charts ================================
  window.onload = function(){
    //************* Color gradation function *************
    Highcharts.setOptions({
      colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
          radialGradient: {
            cx: 0.5,
            cy: 0.3,
            r: 0.7
          },
          stops: [
            [0, color],
            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
          ]
        };
      }),
      lang:{
        thousandsSep:','
      }
    });

    //================================ Gauge Chart ================================
    Highcharts.chart('gaugeChart', {
      chart: {
        type: 'gauge',
        plotBackgroundColor: null,
        plotBackgroundImage: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      title: {
        text: 'Data Pencapaian Aset Investasi'+'<br>'+'Tahun '+<?php echo $tahun?>,
      },
      subtitle: {
        text: '(dalam persentase)'
      },
      pane: {
        startAngle: -150,
        endAngle: 150,
        background: [{
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
              [0, '#FFF'],
              [1, '#333']
            ]
          },
          borderWidth: 0,
          outerRadius: '109%'
        }, {
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
              [0, '#333'],
              [1, '#FFF']
            ]
          },
          borderWidth: 1,
          outerRadius: '107%'
        }, {
          // default background
        }, {
          backgroundColor: '#DDD',
          borderWidth: 0,
          outerRadius: '105%',
          innerRadius: '103%'
        }]
      },

      // the value axis
      yAxis: {
        min: -25,
        max: 150,

        minorTickInterval: 'auto',
        minorTickWidth: 1,
        minorTickLength: 10,
        minorTickPosition: 'inside',
        minorTickColor: '#666',
        tickPixelInterval: 30,
        tickWidth: 2,
        tickPosition: 'inside',
        tickLength: 10,
        tickColor: '#666',
        labels: {
          step: 2,
          rotation: 'auto'
        },
        title: {
          text: '( % )'
        },
        plotBands: [{
          from: -25,
          to: 0,
          color: 'rgb(115, 0, 10)' // Merah Tua
        },{
          from: 1,
          to: 25,
          color: 'rgb(211, 60, 66)' // Merah
        },{
          from: 26,
          to: 50,
          color: 'rgb(205, 211, 16)' // Kuning
        },{
          from: 51,
          to: 75,
          color: 'rgb(144, 238, 144)' // Hijau Muda
        },{
          from: 76,
          to: 150,
          color: 'rgb(120, 134, 107)' // Hijau
        }]
      },
      responsive: {
        rules: [{
          condition: {
            maxWidth: 500
          },
          chartOptions: {
            legend: {
              layout: 'horizontal',
              align: 'center',
              verticalAlign: 'bottom'
            }
          }
        }]
      },
      series: [{
        name: 'Pencapaian Aset Investasi',
        data: [<?php echo number_format($hasil_investasi[2], 2, '.', ''); ?>],
        tooltip: {
          valueSuffix: ' Triliun'
        }
      }],
      credits: false,
      exporting: {
        enabled: false
      }
    });

    

    //================================ Bar Chart ================================

    var deposito = <?php echo json_encode($komposisi_deposito); ?>;
    var a = [];
    var dataDepo = [];
    for(var i=0; i < deposito.length; i++) {
      a.push(parseFloat(deposito[i]/1000000000000).toFixed(2));
      dataDepo.push(parseFloat(a[i]));
    }

    var sbn = <?php echo json_encode($komposisi_sbn); ?>;
    var b = [];
    var dataSbn = [];
    for(var i=0; i < sbn.length; i++) {
      b.push(parseFloat(sbn[i]/1000000000000).toFixed(2));
      dataSbn.push(parseFloat(b[i]));
    }

    var obKorp = <?php echo json_encode($komposisi_korporasi); ?>;
    var c = [];
    var dataKorp = [];
    for(var i=0; i < obKorp.length; i++) {
      c.push(parseFloat(obKorp[i]/1000000000000).toFixed(2));
      dataKorp.push(parseFloat(c[i]));
    }

    var saham = <?php echo json_encode($komposisi_saham); ?>;
    var d = [];
    var dataSaham = [];
    for(var i=0; i < saham.length; i++) {
      d.push(parseFloat(saham[i]/1000000000000).toFixed(2));
      dataSaham.push(parseFloat(d[i]));
    }

    var reksa = <?php echo json_encode($komposisi_reksa); ?>;
    var e = [];
    var dataReksa = [];
    for(var i=0; i < reksa.length; i++) {
      e.push(parseFloat(reksa[i]/1000000000000).toFixed(2));
      dataReksa.push(parseFloat(e[i]));
    }

    var penyel = <?php echo json_encode($komposisi_penyel); ?>;
    var f = [];
    var dataPenyel = [];
    for(var i=0; i < penyel.length; i++) {
      f.push(parseFloat(penyel[i]/1000000000000).toFixed(2));
      dataPenyel.push(parseFloat(f[i]));
    }

    var sumLine = sumArray(dataDepo, dataSbn, dataKorp, dataSaham, dataReksa, dataPenyel);
    sumLine = sumLine.map(function(each_element){
      return Number(each_element.toFixed(2));
    });


    Highcharts.chart('barChart', {
      chart: {
        zoomType: 'xy',
      },
      title: {
        text: 'Komposisi Portofolio Investasi'+'<br>'+'Tahun '+<?php echo $tahun?>,
      },
      subtitle: {
        text: '(dalam triliun rupiah)'
      },
      xAxis: {
        categories: <?php echo json_encode($radius_bulan); ?>,
        croosHair: true
      },
      yAxis: {
        min: 0,
        max: 150,
        title: {
          text: ''
        }
      },
      legend: {
        align: 'center',
        verticalAlign: 'bottom',
        x: 0,
        y: 0
      },
      tooltip: {
        headerFormat: '<span style="font-size:12px;font-weight:bold">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y}</b> ({point.percentage:.0f}%)</td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true

      },
      plotOptions: {
        column: {
          stacking: 'normal',
          dataLabels: {
            enabled: true,
            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
          }
        }
      },
      series: [{
        name: 'Line',
        type: 'spline',
        data: sumLine
      },{
        name: 'Penyertaan Langsung',
        type: 'column',
        data: dataPenyel
      },{
        name: 'Reksadana',
        type: 'column',
        data: dataReksa
      },{
        name: 'Saham',
        type: 'column',
        data: dataSaham
      },{
        name: 'Obligasi Korporasi',
        type: 'column',
        data: dataKorp
      },{
        name: 'SBN',
        type: 'column',
        data: dataSbn
      },{
        name: 'Deposito',
        type: 'column',
        data: dataDepo
      }],
      credits: {
        enabled : false
      },
      exporting: {
        enabled: false
      }
    });

    //================================ Pie Chart ================================
    //************* Pie Chart Implementation *************
    Highcharts.chart({
      chart: {
        renderTo: 'donutChart',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
      },
      title: {
        text: 'Proporsi Aset Bulan Terakhir'+'<br>'+'Tahun '+<?php echo $tahun?>,
      },
      subtitle: {
        text: '(dalam persentase & triliun rupiah)'
      },
      tooltip: {
        enabled: true,
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
          },
          showInLegend: false,
          connectorColor: 'silver',
          innerSize: '40%'
        }
      },
      series: [{
        type: 'pie',
        name: 'Aset',
        colorByPoint: true,
        data: [{
          name: "SBN<br><?php echo number_format($proporsi_aset[0]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[0], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[0];?>
        },{
          name: "Deposito<br><?php echo number_format($proporsi_aset[1]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[1], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[1];?>
        },{
          name: "Saham<br><?php echo number_format($proporsi_aset[2]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[2], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[2];?>
        },{
          name: "Obligasi Korporasi<br><?php echo number_format($proporsi_aset[3]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[3], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[3];?>
        },{
          name: "Sukuk Korporasi<br><?php echo number_format($proporsi_aset[4]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[4], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[4];?>
        },{
          name: "MTN<br><?php echo number_format($proporsi_aset[5]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[5], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[5];?>
        },{
          name: "Reksadana<br><?php echo number_format($proporsi_aset[6]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[6], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[6];?>
        },{
          name: "Penyertaan Langsung<br><?php echo number_format($proporsi_aset[7]/1000000000000, 2, '.', '').' T; '?><?php echo number_format($persen_proporsi_aset[7], 2, '.', '').'%';?>",
          y: <?php echo $proporsi_aset[7];?>
        }]
      }],
      credits: {
        enabled : false
      },
      exporting: {
        enabled: false
      }
    });

    //============================ Double Bar Chart ==============================
    Highcharts.chart('doubleBarChart', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Perbandingan Komposisi Portofolio Investasi (bulan terakhir) dengan RKA'+'<br>'+'Tahun '+<?php echo $tahun?>,
      },
      subtitle: {
        text: '(dalam triliun rupiah)'
      },
      xAxis: {
        categories: [
        <?php foreach ($double_bar as $key => $value) {
          echo "'".$value->jenis_investasi."',";
        }?>
        ],
        crosshair: true
      },
      yAxis: {
        min: 0,
        title: {
          text: ''
        }
      },
      tooltip: {
        headerFormat: '<span style="font-size:12px;font-weight:bold">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>Rp {point.y:,.0f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true

      },
      plotOptions: {
        column: {
          pointPadding: 0.2,
          borderWidth: 0
        }
      },
      series:[{
        name: '30 Okt',
        data: [<?php foreach ($double_bar as $key => $value1) {
          echo $value1->saldo_akhir.",";
        }?>]
      },{
        name: 'RKA '+<?php echo $tahun?>,
        // color: '#f02a62',
        data: [<?php foreach ($double_bar as $key => $value2) {
          echo $value2->rka.",";
        }?>]
      }],
      credits: {
        enabled : false
      },
      exporting: {
        enabled: false
      }
    });

    //============================ Line & Bar Chart ==============================
    var dtInvest = <?php echo json_encode($hasil_invest); ?>;
    var dataInvest = [];
    for(var i=0; i < dtInvest.length; i++) {
      // c.push(parseFloat(obKorp[i]/1000000000000).toFixed(2));
      // dataKorp.push(parseFloat(c[i]));
      dataInvest.push(parseInt(dtInvest[i]));
    }
    var spl = [];
    var ttl = dataInvest.reduce(getSum);
    for(var j=0; j < dataInvest.length; j++) {
      spl.push(parseFloat(parseFloat(dataInvest[j]/ttl).toFixed(2)));
    }
    // console.log(spl);

    Highcharts.chart('lineBarChart', {
      chart: {
        zoomType: 'xy'
      },
      title: {
        text: 'Perkembangan Hasil Investasi dan ROI'+'<br>'+'Tahun '+<?php echo $tahun?>,
      },
      subtitle: {
        text: '(dalam persentase & triliun rupiah)'
      },
      xAxis: [{
        categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'],
        crosshair: true
      }],
      yAxis: [{
        min: 0,
        title: {
          text: '( % )'
        }
      },{
        min: 0,
        title: {
          text: '(Rp)'
        },
        labels: {
          //format: '{value} %'
          format: '{value}'
        },
        opposite: true
      }],
      tooltip: {
        headerFormat: '<span style="font-size:12px;font-weight:bold">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y:,.1f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true

      },
      legend: {
        align: 'center',
        verticalAlign: 'bottom',
        x: 0,
        y: 0
      },
      series: [{
        name: 'Hasil Investasi',
        type: 'column',
        yAxis: 1,
        data: dataInvest,
        tooltip: {
          valueSuffix: ' '
        }
      },{
        name: 'ROI',
        type: 'spline',
        data: spl,
        color: '#FF0000',
        tooltip: {
          valuesuffix: ' %'
        }
      }],
      credits: {
        enabled : false
      },
      exporting: {
        enabled: false
      }
    });

    //============================ Double Column & Line Chart ==============================

    <?php 
      // data tahun berjalan
      $bi1=0;$bi2=0; 
      foreach($beban_investasi as $bi) { 
      $bi1 += $bi->saldo_akhir_smt1;
      $bi2 += $bi->saldo_akhir_smt2;
      }

      $bo1=0;$bo2=0; 
      foreach($beban_operasional as $bo) {
      $bo1 += $bo->saldo_akhir_smt1;
      $bo2 += $bo->saldo_akhir_smt2;
      }
      //=========================================================================
      // data tahun sebelumnya (tahun-1)

      $bi1_prev=0;$bi2_prev=0; 
      foreach($bebanPrev_investasi as $bi) { 
      $bi1_prev += $bi->saldo_akhir_smt1;
      $bi2_prev += $bi->saldo_akhir_smt2;
      }

      $bo1_prev=0;$bo2_prev=0; 
      foreach($bebanPrev_operasional as $bo) {
      $bo1_prev += $bo->saldo_akhir_smt1;
      $bo2_prev += $bo->saldo_akhir_smt2;
      }

      ?>


    <?php 
      // semester 1 dan 2 tahun berjalan
      $smt_1=$sum_hasil_invest[0]->smt_1;
      $smt_2=$sum_hasil_invest[0]->smt_2;
      $bbn1=$bi1+$bo1;
      $bbn2=$bi2+$bo2;
      $jml1=(0.67*($smt_1-$bbn1));
      $jml2=(0.67*($smt_2-$bbn2));

      $beban2=number_format($bbn2/1000000000000, 2, '.', '');
      $beban1=number_format($bbn1/1000000000000, 2, '.', '');
      $fee1=number_format($jml1/1000000000000, 2, '.', '');
      $fee2=number_format($jml2/1000000000000, 2, '.', '');

      $tot1=$beban1+$fee1;
      $tot2=$beban2+$fee2;

      //=========================================================================
      // semester 1 dan 2 tahun sebelumnya (tahun-1)

      $smt_1_prev=$sum_hasilPrev_invest[0]->smt_1;
      $smt_2_prev=$sum_hasilPrev_invest[0]->smt_2;
      $bbn1_prev=$bi1_prev+$bo1_prev;
      $bbn2_prev=$bi2_prev+$bo2_prev;
      $jml1_prev=(0.67*($smt_1_prev-$bbn1_prev));
      $jml2_prev=(0.67*($smt_2_prev-$bbn2_prev));

      $beban2_prev=number_format($bbn2_prev/1000000000000, 2, '.', '');
      $beban1_prev=number_format($bbn1_prev/1000000000000, 2, '.', '');
      $fee1_prev=number_format($jml1_prev/1000000000000, 2, '.', '');
      $fee2_prev=number_format($jml2_prev/1000000000000, 2, '.', '');

      $tot1_prev=$beban1_prev+$fee1_prev;
      $tot2_prev=$beban2_prev+$fee2_prev;
    ?>

    Highcharts.chart('doubleBarLine', {
      title: {
        text: 'BOP & Fee Time Series'
      },
      subtitle: {
        text: '(dalam triliun rupiah)'
      },
      xAxis: {
        categories: [
          "Semester II <?php echo $this->session->userdata('tahun') ?>",
          "Semester I <?php echo $this->session->userdata('tahun') ?>",
          "Semester II <?php echo $this->session->userdata('tahun')-1 ?>",
          "Semester I <?php echo $this->session->userdata('tahun')-1 ?>",
        ]
      },
      yAxis: [{
        min: 0,
        title: {
          text: '( Triliun )'
        }
      }],
      tooltip: {
        headerFormat: '<span style="font-size:12px;font-weight:bold">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y:,.1f} T </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true

      },
      series: [{
        type: 'column',
        name: 'BOP',
        data: [<?=$beban2;?>, <?=$beban1;?>, <?=$beban2_prev;?>, <?=$beban1_prev;?>]
      },{
        type: 'column',
        name: 'Fee',
        color: (Highcharts.theme && Highcharts.theme.radialGradient) || '#f02a62',
        data: [<?=$fee2;?>, <?=$fee1;?>, <?=$fee2_prev;?>, <?=$fee1_prev;?>]
      },{
        type: 'spline',
        name: 'Total',
        data: [<?=$tot2;?>, <?=$tot1;?>, <?=$tot2_prev;?>, <?=$tot1_prev;?>],
        marker: {
          lineWidth: 2,
          lineColor: Highcharts.getOptions().colors[3],
          fillColor: 'white'
        }
      }],
      center: [100, 80],
      size: 100,
      showInLegend: false,
      dataLabels: {
        enabled: false
      },
      credits: {
        enabled : false
      },
      exporting: {
        enabled: false
      }
    });
  }

  function sumArray(dataDepo, dataSbn, dataKorp, dataSaham, dataReksa, dataPenyel) {
    var c = [];
    for (var i = 0; i < Math.max(dataDepo.length); i++) {
      c.push(
        (dataDepo[i] || 0) + 
        (dataSbn[i] || 0) + 
        (dataKorp[i] || 0) + 
        (dataSaham[i] || 0) + 
        (dataReksa[i] || 0) + 
        (dataPenyel[i] || 0)
      );
    }
    return c;
  }

  function getSum(total, num) {
    return total + num;
  }
</script>