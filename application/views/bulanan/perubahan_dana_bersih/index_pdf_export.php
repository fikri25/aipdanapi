<?php
    $level = $this->session->userdata('level');
    $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:5px;margin-bottom:5px;font-weight: bold; text-align: center">     
  <?php
    if ($level == "DJA") {
        if ($iduser == 'TSN002') {
            $judul= "PT TASPEN (PERSERO)";
        }else{
            $judul= "PT ASABRI (PERSERO)";
        }
    }else if ($level == "TASPEN") {
        $judul= "PT TASPEN (PERSERO)";
    }else if ($level == "ASABRI") {
        $judul= "PT ASABRI (PERSERO)";
    }

    echo $judul;
  ?>
</p>
<p style="margin-left:0px;margin-top:5px;margin-bottom:5px;font-weight: bold; text-align: center">     
   LAPORAN PERUBAHAN DANA BERSIH
</p>
<p style="margin-left:0px;margin-top:5px;margin-bottom:5px;font-weight: bold; text-align: center">     
   AKUMULASI IURAN PENSIUN
</p>
<p style="margin-left:0px;margin-top:5px;margin-bottom:15px;font-weight: bold; text-align: center"> 
    PER <?php echo strtoupper(isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '');?>&nbsp;<?= $tahun;?>
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px">
  <thead>
    <tr>
      <th width="40%">URAIAN</th>
      <th width="27%">Data Akhir Periode Bulan Lalu</th>
      <th width="27%">Data Akhir Periode &nbsp;<?=$bulan[0]->nama_bulan?></th>
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
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
            </tr>
            <?php else:?>
              <tr>
                <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_bln_lalu']) : '-';?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
              </tr>
            <?php endif;?>

            <?php if($subchild['type'] == 'PC'):?>
              <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                <tr>
                  <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_bln_lalu']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir'] != 0 ) ? rupiah($subchild3['saldo_akhir']) : '-';?></td>
                </tr>
              <?php endforeach;?>
            <?php endif;?>
          <?php endforeach;?>
          <?php if($child['group'] == 'HASIL INVESTASI'):?>
            <tr style="font-weight: bold;">
              <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
              <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
              <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
            </tr>
          <?php endif;?>
        <?php endforeach;?>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
          <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
          <td style="text-align: right;"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
          <td style="text-align: right;"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
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

    $dbersih_awal2 =  $total_bersih1 -  $total_bersih2;
    $tot = $saldo_akhir1 - $saldo_akhir2;
    $tot_prev = $saldo_akhir_bln_lalu1 - $saldo_akhir_bln_lalu2;
    $dbersih_akhir2 =  $tot_prev + $dbersih_awal2;
    $dbersih_akhir1 =  $tot + $dbersih_akhir2;

    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
      <td style="text-align: right;"><?=($tot_prev != 0 ) ? rupiah($tot_prev) : '-';?></td>
      <td style="text-align: right;"><?=($tot != 0 ) ? rupiah($tot) : '-';?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
      <td style="text-align: right;"><?=($dbersih_awal2 != 0 ) ? rupiah($dbersih_awal2) : '-';?></td>
      <td style="text-align: right;"><?=($dbersih_akhir2 != 0 ) ? rupiah($dbersih_akhir2) : '-';?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
      <td style="text-align: right;"><?=($dbersih_akhir2 != 0 ) ? rupiah($dbersih_akhir2) : '-';?></td>
      <td style="text-align: right;"><?=($dbersih_akhir1 != 0 ) ? rupiah($dbersih_akhir1) : '-';?></td>
    </tr>
  </tbody>
</table>
<br>
<!-- data keterangan  -->
<div>
  <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
  <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_perubahan_dana_bersih_ket[0]->keterangan_lap) ? $data_perubahan_dana_bersih_ket[0]->keterangan_lap : '');?></p>
</div>
<!-- end keterangan -->