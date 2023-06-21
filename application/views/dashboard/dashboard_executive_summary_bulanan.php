<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Nilai Investasi <?= konversi_bln($bln,'fullbulan')?>&nbsp;<span class="tahun"></h3>
                </div>
                <div class="box-body">
                    <div id="container-d3"></div>
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
                    <h3 class="box-title">Hasil Investasi <?= konversi_bln($bln,'fullbulan')?>&nbsp;<span class="tahun"></h3>
                </div>
                <div class="box-body">
                    <div id="container-d4"></div>
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
                    <h3 class="box-title">YOI <?= konversi_bln($bln,'fullbulan')?>&nbsp;<span class="tahun"></h3>
                </div>
                <div class="box-body">
                    <div id="container-d6"></div>
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
                                <th rowspan="2" width="30%">Jenis Investasi</th>
                                <th colspan="7"><?= konversi_bln($bln,'fullbulan')?>&nbsp;<span class="tahun"></th>
                            </tr>
                            <tr>
                                <th>Nilai Investasi</th>
                                <th>Porsi</th>
                                <th>Capaian Nilai Atas RIT</th>
                                <th>Hasil Investasi</th>
                                <th>Porsi</th>
                                <th>Capaian Hasil Atas RIT</th>
                                <th>YOI</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $sum1 = 0;$sum2 = 0;$sum3 = 0;$sum4 = 0;$sum5 = 0;$sum6 = 0;$sum7 = 0;  ?>
                            <?php if(isset($summary_periodik) && is_array($summary_periodik)):?>
                            <?php foreach($summary_periodik as $sum):?>
                            <?php if($sum['bulan'] == $bln):?>
                            <tr>
                                <td style="text-align: left;"><?=$sum['jenis_investasi']?></td>
                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_invest'])?></td>
                                <td style="text-align: right;"><?=$sum['porsi_invest'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_invest'].'%'?></td>
                                <td style="text-align: right;"><?=rupiah($sum['saldo_akhir_hasil'])?></td>
                                <td style="text-align: right;"><?=$sum['porsi_hasil'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['capaian_rit_hasil'].'%'?></td>
                                <td style="text-align: right;"><?=$sum['yoi'].'%'?></td>
                            </tr>
                            <?php endif;?>
                            <?php 
                                $sum1 += $sum['saldo_akhir_invest'];
                                $sum2 += (float)$sum['porsi_invest'];
                                $sum3 += (float)$sum['capaian_rit_invest'];
                                $sum4 += $sum['saldo_akhir_hasil'];
                                $sum5 += (float)$sum['porsi_hasil'];
                                $sum6 += (float)$sum['capaian_rit_hasil'];
                                $sum7 += (float)$sum['yoi'];

                            endforeach;?>
                            <?php endif;?>
                        </tbody>
                        <tfoot style="background-color: #d8d8d8; font-weight: bold;">
                            <td>Total</td>
                            <td style="text-align: right;"><?=rupiah($sum1)?></td>
                            <td style="text-align: right;"><?=$sum2.'%'?></td>
                            <td style="text-align: right;"><?=$sum3.'%'?></td>
                            <td style="text-align: right;"><?=rupiah($sum4)?></td>
                            <td style="text-align: right;"><?=$sum5.'%'?></td>
                            <td style="text-align: right;"><?=$sum6.'%'?></td>
                            <td style="text-align: right;">-</td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var par = {};
    var id_bulan = $('#id_bulan').val();
    var iduser = $('#iduser').val();
    par[[csrf_token]] = csrf_hash;

    $.post(host+'dashboard-display/summary_periodik_bulanan', {[csrf_token]:csrf_hash, 'id_bulan':id_bulan, 'iduser':iduser}, function(resp){
        if(resp){
            parsing = JSON.parse(resp);
            var xChart = parsing.arr_bln;

            var yChart1 = [
            {
                name: '(Jumlah Dalam Rupiah)',
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
                name: '(Jumlah Dalam Rupiah)',
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

            var yChart3 = [
            {
                name: 'Persentase (%)',
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
            genLineChart("container-d3", "", xChart, yChart1, "", "", "Nominal (Rp)", false);
            genLineChart("container-d4", "", xChart, yChart2, "", "", "Nominal (Rp)", false);
            genLineChart("container-d6", "", xChart, yChart3, "", "", "Persentase (%)", false);
        }
    });



$(".select2nya").select2( { 'width':'100%' } );
$('.tahun').text(tahun);
</script>