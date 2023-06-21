<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
  Lampiran Pendukung
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
  Perubahan Dana Bersih
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th width="40%">URAIAN</th>
      <th width="27%">Tahun <?= $tahun; ?></th>
      <th width="27%">Tahun <?= $tahun - 1; ?></th>
    </tr>

  </thead>
  <tbody>
    <?php
      $totkas = 0;
      $totkasprev = 0;
      $dbersih_awal1 = 0;
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
              <td></td>
              <td></td>
            </tr>
            <?php else:?>
              <tr>
                <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir_thn'] != 0 ) ? rupiah($subchild['saldo_akhir_thn']) : '-';?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_thn_lalu']) : '-';?></td>
              </tr>
            <?php endif;?>

            <?php if($subchild['type'] == 'PC'):?>
              <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                <tr>
                  <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir_thn'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn_lalu']) : '-';?></td>
                </tr>
              <?php endforeach;?>
            <?php endif;?>
          <?php endforeach;?>
          <?php if($child['group'] == 'HASIL INVESTASI'):?>
            <tr style="font-weight: bold;">
              <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
              <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
              <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
            </tr>
          <?php endif;?>
        <?php endforeach;?>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
          <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
          <td style="text-align: right;"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
          <td style="text-align: right;"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
        </tr>
      <?php endforeach;?>
    <?php endif;?>
    <?php
      $saldo_akhir1 = (!empty($tot_perubahan[0]->saldo_akhir_thn) ? $tot_perubahan[0]->saldo_akhir_thn : '0');
      $saldo_akhir2 = (!empty($tot_perubahan[1]->saldo_akhir_thn) ? $tot_perubahan[1]->saldo_akhir_thn : '0');
      $saldo_akhir_thn_lalu1 = (!empty($tot_perubahan[0]->saldo_akhir_thn_lalu) ? $tot_perubahan[0]->saldo_akhir_thn_lalu : '0');
      $saldo_akhir_thn_lalu2 = (!empty($tot_perubahan[1]->saldo_akhir_thn_lalu) ? $tot_perubahan[1]->saldo_akhir_thn_lalu : '0');

      // $dbersih_awal1 = ((!empty($total_dbersih['saldo_akhir']) ? $total_dbersih['saldo_akhir']: '0');
      // $dbersih_awal2 = (!empty($total_dbersih['saldo_akhir_thn_lalu']) ? $total_dbersih['saldo_akhir_thn_lalu']: '0');
      $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_thn_lalu) ? $total_bersih[0]->saldo_akhir_thn_lalu : '0');
      $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_thn_lalu) ? $total_bersih[1]->saldo_akhir_thn_lalu : '0');

      $dbersih_awal2 =  $total_bersih1 -  $total_bersih2;
      $tot = $saldo_akhir1 - $saldo_akhir2;
      $tot_prev = $saldo_akhir_thn_lalu1 - $saldo_akhir_thn_lalu2;
      $dbersih_akhir2 =  $tot_prev + $dbersih_awal2;
      $dbersih_akhir1 =  $tot + $dbersih_akhir2;

    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
      <td style="text-align: right;"><?=rupiah($tot);?></td>
      <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
      <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
      <td style="text-align: right;"><?=rupiah($dbersih_awal2);?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
      <td style="text-align: right;"><?=rupiah($dbersih_akhir1);?></td>
      <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
    </tr>
  </tbody>
</table>