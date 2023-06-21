<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
    Aspek Keuangan
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    Dana Bersih
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th rowspan="2" width="30%">URAIAN</th>
      <th rowspan="2" width="10%">Tahun <?= $tahun; ?></th>
      <th rowspan="2" width="10%">Tahun <?= $tahun - 1; ?></th>
      <th rowspan="2" width="10%">RKA</th>
      <th rowspan="2" width="10%">Persentase Capaian Tahun <?= $tahun - 1; ?> terhadap RKA</th>
      <th colspan="2" width="10%">Kenaikan/Penurunan</th>
    </tr>
    <tr>
      <th>Nominal</th>
      <th>Persentase</th>
    </tr>

  </thead>
  <tbody>
    <?php if(isset($data_dana_bersih) && is_array($data_dana_bersih)):?>
    <?php foreach($data_dana_bersih as $dana_bersih):?>
      <?php if($dana_bersih['jenis_laporan'] == 'ASET'):?>
        <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
          <td style="text-align: left;color: #303a3f;" colspan="7"><?=$dana_bersih['jenis_laporan']?></td>
        </tr>
      <?php endif;?>
      <?php foreach($dana_bersih['child'] as $child):?>
        <tr>
          <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="7"><?=$child['judul_head']?></td>
        </tr>
        <?php foreach($child['subchild'] as $subchild):?>

          <?php if($subchild['type'] == 'PC'):?>
            <tr>
              <td style="text-align: left;" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
            </tr>
            <?php else:?>
              <tr>
                <td style="text-align: left;" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir_thn'] != 0 ) ? rupiah($subchild['saldo_akhir_thn']) : '-';?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_thn_lalu']) : '-';?></td>
                <td style="text-align: right;"><?=($subchild['rka_thn'] != 0 ) ? rupiah($subchild['rka_thn']) : '-';?></td>
                <td style="text-align: right;"><?=($subchild['perst_rka_thn'] != 0 ) ? persen($subchild['perst_rka_thn']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($subchild['nominal'] != 0 ) ? rupiah($subchild['nominal']) : '-';?></td>
                <td style="text-align: right;"><?=($subchild['persentase'] != 0 ) ? persen($subchild['persentase']).'%' : '-';?></td>
              </tr>
            <?php endif;?>

            <?php if($subchild['type'] == 'PC'):?>
              <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                <tr>
                  <td style="text-align: left;" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir_thn'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn_lalu']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['rka_thn'] != 0 ) ? rupiah($subchild3['rka_thn']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['perst_rka_thn'] != 0 ) ? persen($subchild3['perst_rka_thn']).'%' : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['nominal'] != 0 ) ? rupiah($subchild3['nominal']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['persentase'] != 0 ) ? persen($subchild3['persentase']).'%' : '-';?></td>
                </tr>
              <?php endforeach;?>
            <?php endif;?>
          <?php endforeach;?>
          <tr style="font-weight: bold;">
            <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['rka_thn_lvl2'] != 0 ) ? rupiah($child['rka_thn_lvl2']) : '-';?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_perst_rkasem2_lvl2'] != 0 ) ? persen($child['sum_perst_rkasem2_lvl2']).'%' : '-';?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['nominal_lvl2'] != 0 ) ? rupiah($child['nominal_lvl2']) : '-';?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['persentase_lvl2'] != 0 ) ? persen($child['persentase_lvl2']).'%' : '-';?></td>
          </tr>
        <?php endforeach;?>

        <?php if($dana_bersih['jenis_laporan'] == 'ASET'):?>
          <tr style="font-weight: bold; background-color:#c1e1f3;">
            <td style="text-align: left;"><?=$dana_bersih['total']?></td>
            <td style="text-align: right;"><?=($dana_bersih['sum_lvl1'] != 0 ) ? rupiah($dana_bersih['sum_lvl1']) : '-';?></td>
            <td style="text-align: right;"><?=($dana_bersih['sum_prev_lvl1'] != 0 ) ? rupiah($dana_bersih['sum_prev_lvl1']) : '-';?></td>
            <td style="text-align: right;"><?=($dana_bersih['rka_thn_lvl1'] != 0 ) ? rupiah($dana_bersih['rka_thn_lvl1']) : '-';?></td>
            <td style="text-align: right;"><?=($dana_bersih['sum_perst_rkasem2_lvl1'] != 0 ) ? persen($dana_bersih['sum_perst_rkasem2_lvl1']).'%' : '-';?></td>
            <td style="text-align: right;"><?=($dana_bersih['nominal_lvl1'] != 0 ) ? rupiah($dana_bersih['nominal_lvl1']) : '-';?></td>
            <td style="text-align: right;"><?=($dana_bersih['persentase_lvl1'] != 0 ) ? persen($dana_bersih['persentase_lvl1']).'%' : '-';?></td>
          </tr>

        <?php endif;?>
        
      <?php endforeach;?>
    <?php endif;?>

    <?php
    $saldo_akhir_thn_1 = (!empty($total_bersih[0]->saldo_akhir_thn) ? $total_bersih[0]->saldo_akhir_thn : '0');
    $saldo_akhir_thn_2 = (!empty($total_bersih[1]->saldo_akhir_thn) ? $total_bersih[1]->saldo_akhir_thn : '0');
    $saldo_akhir_thn_lalu_1 = (!empty($total_bersih[0]->saldo_akhir_thn_lalu) ? $total_bersih[0]->saldo_akhir_thn_lalu : '0');
    $saldo_akhir_thn_lalu_2 = (!empty($total_bersih[1]->saldo_akhir_thn_lalu) ? $total_bersih[1]->saldo_akhir_thn_lalu : '0');

    $tot = $saldo_akhir_thn_1 - $saldo_akhir_thn_2;
    $tot_prev = $saldo_akhir_thn_lalu_1 - $saldo_akhir_thn_lalu_2;
    $tot_nominal = $tot_prev - $tot;
    $tot_persen = ($tot!=0)?($tot_nominal/$tot)*100:0;

    $dbersih1 = (isset($data_dana_bersih[0]['sum_perst_rkasem2_lvl1']) ? $data_dana_bersih[0]['sum_perst_rkasem2_lvl1'] : 0) ;
    $dbersih2 = (isset($data_dana_bersih[1]['sum_perst_rkasem2_lvl1']) ? $data_dana_bersih[1]['sum_perst_rkasem2_lvl1'] : 0) ;
    $totpers_rka = $dbersih1 - $dbersih2;

    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
        <td style="text-align: left;">DANA BERSIH</td>
        <td style="text-align: right;"><?=rupiah($tot);?></td>
        <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
        <td style="text-align: right;"></td>
        <td style="text-align: right;"><?=persen($totpers_rka);?>%</td>
        <td style="text-align: right;"><?=rupiah($tot_nominal);?></td>
        <td style="text-align: right;"><?=persen($tot_persen);?>%</td>
    </tr>

    </tbody>
</table>




<!-- <br> -->
<!-- data keterangan  -->
<!-- <div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_hasil_investasi_ket[0]->keterangan_lap) ? $data_hasil_investasi_ket[0]->keterangan_lap : '');?></p>
</div> -->
<!-- end keterangan -->