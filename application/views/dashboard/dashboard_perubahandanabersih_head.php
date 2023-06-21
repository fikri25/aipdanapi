<style type="text/css">
  td.left{
    text-align: left;
    margin-left: 35px;
  }
  td.right{
    text-align: right;
  }

</style>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Perubahan Dana Bersih</h3>
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
                    <!-- <table id="example" class="table table-responsive table-bordered table-hover">
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
                            ?>
                            <tr style="<?php if ($userData['uraian'] == 'KENAIKAN(PENURUNAN) KAS dan BANK'){echo 'font-weight: bold; background-color: #ddd;';}?>">
                                <td style="text-align: left;"><?= $userData['uraian']; ?></td>
                                <?php foreach($names as $name): ?>
                                    <td><?= rupiah($userData[$name])??'-'; ?></td>
                                <?php endforeach; ?>
                                <td><?= rupiah($nom)??'-';?></td>
                                <td><?= persen($pers).'%';?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table> -->
                    <table id="example" class="table table-responsive table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="40%">URAIAN</th>
                            <th width="27%">Data Akhir Periode &nbsp;<?=$bulan[0]->nama_bulan?></th>
                            <th width="27%">Data Akhir Periode Bulan Lalu</th>
                          </tr>

                        </thead>
                        <tbody>
                          <?php
                            $totkas = 0;
                            $totkasprev = 0;
                            $dbersih_awal1 = 0;
                            // $dbersih_awal2 = 0;
                            $dbersih_akhir1 = 0;
                            $dbersih_akhir2 = 0;
                          ?>
                          <?php if(isset($data_perubahan_danabersih) && is_array($data_perubahan_danabersih)):?>
                            <?php foreach($data_perubahan_danabersih as $perubahan_danabersih):?>
                              <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
                                <td style="text-align: left;color: #303a3f;" colspan="3"><?=$perubahan_danabersih['uraian']?></td>
                              </tr>
                                <?php foreach($perubahan_danabersih['child'] as $child):?>
                                  <?php if($child['group'] == 'HASIL INVESTASI'):?>
                                    <tr>
                                      <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="3"><?=$child['judul_head']?></td>
                                    </tr>
                                  <?php endif;?>
                                  <?php foreach($child['subchild'] as $subchild):?>

                                    <?php if($subchild['type'] == 'PC'):?>
                                    <tr>
                                      <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                                      <td class="right"></td>
                                      <td class="right"></td>
                                    </tr>
                                    <?php else:?>
                                    <tr>
                                      <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                                      <td class="right"><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
                                      <td class="right"><?=($subchild['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_bln_lalu']) : '-';?></td>
                                    </tr>
                                    <?php endif;?>

                                    <?php if($subchild['type'] == 'PC'):?>
                                      <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                                        <tr>
                                          <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                                          <td class="right"><?=($subchild3['saldo_akhir'] != 0 ) ? rupiah($subchild3['saldo_akhir']) : '-';?></td>
                                          <td class="right"><?=($subchild3['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_bln_lalu']) : '-';?></td>
                                        </tr>
                                      <?php endforeach;?>
                                    <?php endif;?>
                                  <?php endforeach;?>
                                  <?php if($child['group'] == 'HASIL INVESTASI' || $child['group'] == 'NILAI INVESTASI'):?>
                                  <tr style="font-weight: bold;">
                                    <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
                                    <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
                                    <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
                                  </tr>
                                  <?php endif;?>
                                <?php endforeach;?>
                                <tr style="font-weight: bold; background-color:#d2ebf9;">
                                  <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
                                  <td class="right"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
                                  <td class="right"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
                                </tr>
                            <?php endforeach;?>
                          <?php endif;?>
                          <?php
                            $saldo_akhir1 = (!empty($tot_perubahan[0]->saldo_akhir) ? $tot_perubahan[0]->saldo_akhir : '0');
                            $saldo_akhir2 = (!empty($tot_perubahan[1]->saldo_akhir) ? $tot_perubahan[1]->saldo_akhir : '0');
                            $saldo_akhir_bln_lalu1 = (!empty($tot_perubahan[0]->saldo_akhir_bln_lalu) ? $tot_perubahan[0]->saldo_akhir_bln_lalu : '0');
                            $saldo_akhir_bln_lalu2 = (!empty($tot_perubahan[1]->saldo_akhir_bln_lalu) ? $tot_perubahan[1]->saldo_akhir_bln_lalu : '0');

                            // $dbersih_awal1 = ((!empty($total_dbersih['saldo_akhir']) ? $total_dbersih['saldo_akhir']: '0');
                            // $dbersih_awal2 = (!empty($total_dbersih['saldo_akhir_bln_lalu']) ? $total_dbersih['saldo_akhir_bln_lalu']: '0');
                            $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_bln_lalu) ? $total_bersih[0]->saldo_akhir_bln_lalu : '0');
                            $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_bln_lalu) ? $total_bersih[1]->saldo_akhir_bln_lalu : '0');


                            // if ($bln == '1' && $tahun == '2020') {
                            //   $dbersih_awal2 = $total_bersih1 -  $total_bersih2;
                            // }else{
                            //   $dbersih_awal2 =  $total_bersih1 -  $total_bersih2 + 151428469320652;
                            // }
                            $dbersih_awal2 =  $total_bersih1 -  $total_bersih2;
                            $tot = $saldo_akhir1 - $saldo_akhir2;
                            $tot_prev = $saldo_akhir_bln_lalu1 - $saldo_akhir_bln_lalu2;
                            $dbersih_akhir2 =  $tot_prev + $dbersih_awal2;
                            $dbersih_akhir1 =  $tot + $dbersih_akhir2;

                          ?>
                          <tr style="font-weight: bold; background-color:#d2ebf9;">
                            <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
                            <td style="text-align: right;"><?=($tot != 0 ) ? rupiah($tot) : '-';?></td>
                            <td style="text-align: right;"><?=($tot_prev != 0 ) ? rupiah($tot_prev) : '-';?></td>
                          </tr>
                          <tr style="font-weight: bold; background-color:#d2ebf9;">
                            <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
                            <td style="text-align: right;"><?=($dbersih_akhir2 != 0 ) ? rupiah($dbersih_akhir2) : '-';?></td>
                            <td style="text-align: right;"><?=($dbersih_awal2 != 0 ) ? rupiah($dbersih_awal2) : '-';?></td>
                          </tr>
                           <tr style="font-weight: bold; background-color:#d2ebf9;">
                            <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
                            <td style="text-align: right;"><?=($dbersih_akhir1 != 0 ) ? rupiah($dbersih_akhir1) : '-';?></td>
                            <td style="text-align: right;"><?=($dbersih_akhir2 != 0 ) ? rupiah($dbersih_akhir2) : '-';?></td>
                          </tr>
                        </tbody>
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
    par[[csrf_token]] = csrf_hash;

    $.post(host+'dashboard-display/summary_dana_bersih', {[csrf_token]:csrf_hash, 'id_bulan':id_bulan, 'iduser':iduser,'bln_awal':bln_awal,'bln_akhir':bln_akhir,'tahun_awal':tahun_awal,'tahun_akhir':tahun_akhir}, function(resp){
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