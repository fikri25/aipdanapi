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
                                <th colspan="7">Tahun&nbsp;<span class="tahun_lalu"></th>
                                <th colspan="7">Tahun&nbsp;<span class="tahun"></th>
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
                                $sum13 = 0;$sum14 = 0;$sum15 = 0;$sum16 = 0;
                            ?>
                            <?php if(isset($summary_periodik_tahunan) && is_array($summary_periodik_tahunan)):?>
                            <?php foreach($summary_periodik_tahunan as $sum):?>
                            <tr>
                                <td style="text-align: left;"><?=$sum['jenis_investasi']?></td>

                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_invest_thn_lalu'])?></td>
                                <td style="text-align: right;"><?=$sum['porsi_invest_thn_lalu'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_invest_thn_lalu'].'%'?></td>
                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_hasil_thn_lalu'])?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_hasil_thn_lalu'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['yoi_thn_lalu'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['roi_hasil_thn_lalu'].'%'?></td>

                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_invest_thn'])?></td>
                                <td style="text-align: right;"><?=$sum['porsi_invest_thn'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_invest_thn'].'%'?></td>
                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_hasil_thn'])?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_hasil_thn'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['yoi_thn'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['roi_hasil_thn'].'%'?></td>

                                <td style="text-align: right;">-</td>
                                <td style="text-align: right;">-</td>
                            </tr>
                            <?php 
                                $sum1 += $sum['saldo_akhir_invest_thn_lalu'];
                                $sum2 += (float)$sum['porsi_invest_thn_lalu'];
                                $sum3 += (float)$sum['capaian_rit_invest_thn_lalu'];
                                $sum4 += $sum['saldo_akhir_hasil_thn_lalu'];
                                $sum5 += (float)$sum['porsi_hasil_thn_lalu'];
                                $sum6 += (float)$sum['capaian_rit_hasil_thn_lalu'];

                                $sum7 += $sum['saldo_akhir_invest_thn'];
                                $sum8 += (float)$sum['porsi_invest_thn'];
                                $sum9 += (float)$sum['capaian_rit_invest_thn'];
                                $sum10 += $sum['saldo_akhir_hasil_thn'];
                                $sum11 += (float)$sum['porsi_hasil_thn'];
                                $sum12 += (float)$sum['capaian_rit_hasil_thn'];

                                $sum13 += (float)$sum['roi_hasil_thn_lalu'];
                                $sum14 += (float)$sum['roi_hasil_thn'];

                                $sum15 += (float)$sum['yoi_thn_lalu'];
                                $sum16 += (float)$sum['yoi_thn'];

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
                            <td style="text-align: right;"><?=$sum16.'%'?></td>
                            <td style="text-align: right;"><?=$sum13.'%'?></td>

                            <td style="text-align: right;"><?=rupiah($sum7)?></td>
                            <td style="text-align: right;"><?=$sum8.'%'?></td>
                            <td style="text-align: right;"><?=$sum9.'%'?></td>
                            <td style="text-align: right;"><?=rupiah($sum10)?></td>
                            <td style="text-align: right;"><?=$sum12.'%'?></td>
                            <td style="text-align: right;"><?=$sum15.'%'?></td>
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
	
    $.post(host+'dashboard-display/summary_periodik_tahunan', {[csrf_token]:csrf_hash,'iduser':iduser}, function(resp){
        if(resp){
            var param = {};
            parsing = JSON.parse(resp);
            var xChart = parsing.tahun;

            var yChart = [
            {
                name: 'Tahunan',
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
                name: 'Tahunan',
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
                name: 'Tahunan',
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
                name: 'Tahunan',
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


	

$(".select2nya").select2( { 'width':'100%' } );
$('.tahun').text(tahun);
$('.tahun_lalu').text(tahun-1);
</script>