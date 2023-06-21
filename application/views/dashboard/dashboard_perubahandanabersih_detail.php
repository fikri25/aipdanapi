<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Perubahan Dana Bersih - Detail</h3>
                </div>
                <div class="box-body" style="overflow-x:auto;">
                    <div id="container-d1"></div>
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
                    <table id="example" class="table table-responsive table-bordered table-hover">
                        <tr>
                            <th rowspan ="2">Uraian</th>
                            <th colspan="<?=$count;?>">Bulan</th>
                            <th colspan="2">Pertumbuhan</th>
                        </tr>
                        <tr>
                            <?php foreach($bln_thn as $bln): ?>
                                <th><?php echo $bln??'-'; ?></th>
                            <?php endforeach; ?>
                            <th>Nominal</th>
                            <th>Persentase</th>
                        </tr>
                        <?php foreach($data as $date => $userData): 
                            $nom =  $userData[$last] - $userData[$first];
                            $pers = $nom/$userData[$first];
                            $pers = (!is_nan($pers) && !is_infinite($pers) ? $pers : '0,00');
                            ?>
                            <tr style="<?php if ($userData['uraian'] == 'JUMLAH'){echo 'font-weight: bold; background-color: #ddd;';}?>">
                                <td style="text-align: left;"><?= $userData['uraian']; ?></td>
                                <?php foreach($names as $name): ?>
                                    <td><?= rupiah($userData[$name])??'-'; ?></td>
                                <?php endforeach; ?>
                                <td><?= rupiah($nom)??'-';?></td>
                                <td><?= persen($pers).'%';?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var par = {};
    var iduser = $('#iduser').val();

    var bln_awal= $('#bln_awal').val();
    var tahun_awal= $('#tahun_awal').val();
    var bln_akhir= $('#bln_akhir').val();
    var tahun_akhir= $('#tahun_akhir').val();
    var jns_lap= $('#jns_lap').val();
    par[[csrf_token]] = csrf_hash;

    $.post(host+'dashboard-display/summary_perubahan_dana_bersih', {[csrf_token]:csrf_hash, 'id_bulan':id_bulan, 'iduser':iduser,'bln_awal':bln_awal,'bln_akhir':bln_akhir,'jns_lap':jns_lap,'tahun_awal':tahun_awal,'tahun_akhir':tahun_akhir}, function(resp){
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
                data: parsing.nilai,
            }];
            genLineChart("container-d1", "", xChart, yChart1, "", "", "Nominal (Rp)", false);
        }
    });



$(".select2nya").select2( { 'width':'100%' } );
$('.tahun').text(tahun);
</script>