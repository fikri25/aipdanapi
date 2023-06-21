<?php
  $tahun = $this->session->userdata('tahun');
  if ($semester != "") {
    if($semester == 1){
      $thn = $tahun;
      $thn_filter = $tahun - 1;
    }else{
      $thn = $tahun;
      $thn_filter = $tahun;
    }
  }else{
    $thn = $tahun;
    $thn_filter = $tahun;
  }
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
    Aspek Keuangan
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    Perubahan Dana Bersih
</p>
<!-- ======================================= SEMESTER 2 ================================ -->
<?php if($semester == 2 || $semester == ""):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2" width="30%">URAIAN</th>
            <th rowspan="2" width="10%">Semester I <?= $thn;?></th>
            <th rowspan="2" width="10%">Semester II <?= $thn_filter;?></th>
            <th rowspan="2" width="10%">RKA</th>
            <th rowspan="2" width="10%">Persentase Capaian Semester II terhadap RKA</th>
            <th colspan="2" width="10%">Kenaikan/Penurunan</th>
        </tr>
        <tr>
            <th>Nominal</th>
            <th>Persentase</th>
        </tr>

    </thead>
    <tbody>
      <?php if(isset($data_perubahan_danabersih) && is_array($data_perubahan_danabersih)):?>
      <?php foreach($data_perubahan_danabersih as $perubahan_danabersih):?>
          <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
            <td style="text-align: left;color: #303a3f;" colspan="7"><?=$perubahan_danabersih['uraian']?></td>
        </tr>
        <?php foreach($perubahan_danabersih['child'] as $child):?>
          <?php if($child['group'] == 'HASIL INVESTASI'):?>
            <tr>
              <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="7"><?=$child['judul_head']?></td>
          </tr>
      <?php endif;?>
      <?php foreach($child['subchild'] as $subchild):?>

        <?php if($subchild['type'] == 'PC'):?>
            <tr>
              <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
          </tr>
          <?php else:?>
            <tr>
              <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
              <td style="text-align: right;"><?=($subchild['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild['saldo_akhir_smt1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild['saldo_akhir_smt2']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['rka_sem1'] != 0 ) ? rupiah($subchild['rka_sem1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['perst_rka_sem1'] != 0 ) ? persen($subchild['perst_rka_sem1']).'%' : '-';?></td>
              <td style="text-align: right;"><?=($subchild['nominal'] != 0 ) ? rupiah($subchild['nominal']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['persentase'] != 0 ) ? persen($subchild['persentase']).'%' : '-';?></td>
          </tr>
      <?php endif;?>

      <?php if($subchild['type'] == 'PC'):?>
          <?php foreach($subchild['subchild_sub'] as $subchild3):?>
            <tr>
              <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
              <td style="text-align: right;"><?=($subchild3['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt2']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['rka_sem1'] != 0 ) ? rupiah($subchild3['rka_sem1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['perst_rka_sem1'] != 0 ) ? persen($subchild3['perst_rka_sem1']).'%' : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['nominal'] != 0 ) ? rupiah($subchild3['nominal']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['persentase'] != 0 ) ? persen($subchild3['persentase']).'%' : '-';?></td>
          </tr>
      <?php endforeach;?>
    <?php endif;?>
    <?php endforeach;?>
    <?php if($child['group'] == 'HASIL INVESTASI' || $child['group'] == 'NILAI INVESTASI'):?>
      <tr style="font-weight: bold;">
        <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['rka_sem1_lvl2'] != 0 ) ? rupiah($child['rka_sem1_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_perst_rkasem2_lvl2'] != 0 ) ? persen($child['sum_perst_rkasem2_lvl2']).'%' : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['nominal_lvl2'] != 0 ) ? rupiah($child['nominal_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['persentase_lvl2'] != 0 ) ? persen($child['persentase_lvl2']).'%' : '-';?></td>
    </tr>
    <?php endif;?>
    <?php endforeach;?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['rka_sem1_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['rka_sem1_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['sum_perst_rkasem2_lvl1'] != 0 ) ? persen($perubahan_danabersih['sum_perst_rkasem2_lvl1']).'%' : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['nominal_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['nominal_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['persentase_lvl1'] != 0 ) ? persen($perubahan_danabersih['persentase_lvl1']).'%' : '-';?></td>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
    <?php
        $saldo_akhir_smt1_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt1) ? $tot_perubahan[0]->saldo_akhir_smt1 : '0');
        $saldo_akhir_smt1_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt1) ? $tot_perubahan[1]->saldo_akhir_smt1 : '0');
        $saldo_akhir_smt2_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt2) ? $tot_perubahan[0]->saldo_akhir_smt2 : '0');
        $saldo_akhir_smt2_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt2) ? $tot_perubahan[1]->saldo_akhir_smt2 : '0');

        $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_smt1) ? $total_bersih[0]->saldo_akhir_smt1 : '0');
        $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_smt1) ? $total_bersih[1]->saldo_akhir_smt1 : '0');
        $dbersih1 = (isset($data_perubahan_danabersih[0]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[0]['rka_sem1_lvl1'] : 0) ;
        $dbersih2 = (isset($data_perubahan_danabersih[1]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[1]['rka_sem1_lvl1'] : 0) ;
                        // penngkatan (penurunan)
        $tot = $saldo_akhir_smt1_1 - $saldo_akhir_smt1_2;
        $tot_prev = $saldo_akhir_smt2_1 - $saldo_akhir_smt2_2;
        $tot_rka = $dbersih1 - $dbersih2;
        $tot_pers_rka = ($tot_rka!=0)?($tot_prev/$tot_rka):0;
        $tot_nominal =  $tot_prev - $tot;
        $tot_persentase = ($tot!=0)?($tot_nominal/$tot)*100:0;

                        // dana bersih awal & akhir
        $dbersih_awal1 =  $total_bersih1 - $total_bersih2;
        $dbersih_akhir1 = $tot + $dbersih_awal1;
        $dbersih_awal2 =  $dbersih_akhir1;
        $dbersih_akhir2 = $tot_prev + $dbersih_awal2;
        $dbersih_rka_awal = $dbersih_akhir2;
        $dbersih_rka_akhir = $tot_rka + $dbersih_rka_awal;
        $dbersih_prsn_rka_awal = ($dbersih_rka_awal!=0)?($dbersih_awal2/$dbersih_rka_awal)*100:0;
        $dbersih_prsn_rka_akhir = ($dbersih_rka_akhir!=0)?($dbersih_akhir2/$dbersih_rka_akhir)*100:0;
        $dbersih_nominal_awal = $dbersih_awal2 - $dbersih_awal1;
        $dbersih_nominal_akhir = $dbersih_akhir2 - $dbersih_akhir1;
        $dbersih_persentase_awal = ($dbersih_awal1!=0)?($dbersih_nominal_awal/$dbersih_awal1)*100:0;
        $dbersih_persentase_akhir = ($dbersih_akhir1!=0)?($dbersih_nominal_akhir/$dbersih_akhir1)*100:0;

    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
        <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
        <td style="text-align: right;"><?=rupiah($tot);?></td>
        <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
        <td style="text-align: right;"><?=rupiah($tot_rka);?></td>
        <td style="text-align: right;"><?=persen($tot_pers_rka);?>%</td>
        <td style="text-align: right;"><?=rupiah($tot_nominal);?></td>
        <td style="text-align: right;"><?=persen($tot_persentase);?>%</td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
        <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
        <td style="text-align: right;"><?=rupiah($dbersih_awal1);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_awal2);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_rka_awal);?></td>
        <td style="text-align: right;"><?=persen($dbersih_prsn_rka_awal);?>%</td>
        <td style="text-align: right;"><?=rupiah($dbersih_nominal_awal);?></td>
        <td style="text-align: right;"><?=persen($dbersih_persentase_awal);?>%</td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
        <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
        <td style="text-align: right;"><?=rupiah($dbersih_akhir1);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_rka_akhir);?></td>
        <td style="text-align: right;"><?=persen($dbersih_prsn_rka_akhir);?>%</td>
        <td style="text-align: right;"><?=rupiah($dbersih_nominal_akhir);?></td>
        <td style="text-align: right;"><?=persen($dbersih_persentase_akhir);?>%</td>
    </tr>
    </tbody>
</table>
<?php endif;?>

<!-- ====================================== SEMESTER 1 ================================ -->
<?php if($semester == 1 ):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2" width="30%">URAIAN</th>
            <th rowspan="2" width="10%">Semester II <?= $thn_filter;?></th>
            <th rowspan="2" width="10%">Semester I <?= $thn;?></th>
            <th rowspan="2" width="10%">RKA</th>
            <th rowspan="2" width="10%">Persentase Capaian Semester II terhadap RKA</th>
            <th colspan="2" width="10%">Kenaikan/Penurunan</th>
        </tr>
        <tr>
            <th>Nominal</th>
            <th>Persentase</th>
        </tr>

    </thead>
    <tbody>
      <?php if(isset($data_perubahan_danabersih) && is_array($data_perubahan_danabersih)):?>
      <?php foreach($data_perubahan_danabersih as $perubahan_danabersih):?>
          <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
            <td style="text-align: left;color: #303a3f;" colspan="7"><?=$perubahan_danabersih['uraian']?></td>
        </tr>
        <?php foreach($perubahan_danabersih['child'] as $child):?>
          <?php if($child['group'] == 'HASIL INVESTASI'):?>
            <tr>
              <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="7"><?=$child['judul_head']?></td>
          </tr>
      <?php endif;?>
      <?php foreach($child['subchild'] as $subchild):?>

        <?php if($subchild['type'] == 'PC'):?>
            <tr>
              <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
          </tr>
          <?php else:?>
            <tr>
              <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
              <td style="text-align: right;"><?=($subchild['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild['saldo_akhir_smt2']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild['saldo_akhir_smt1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['rka_sem1'] != 0 ) ? rupiah($subchild['rka_sem1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['perst_rka_sem1'] != 0 ) ? persen($subchild['perst_rka_sem1']).'%' : '-';?></td>
              <td style="text-align: right;"><?=($subchild['nominal'] != 0 ) ? rupiah($subchild['nominal']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild['persentase'] != 0 ) ? persen($subchild['persentase']).'%' : '-';?></td>
          </tr>
      <?php endif;?>

      <?php if($subchild['type'] == 'PC'):?>
          <?php foreach($subchild['subchild_sub'] as $subchild3):?>
            <tr>
              <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
              <td style="text-align: right;"><?=($subchild3['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt2']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['rka_sem1'] != 0 ) ? rupiah($subchild3['rka_sem1']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['perst_rka_sem1'] != 0 ) ? persen($subchild3['perst_rka_sem1']).'%' : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['nominal'] != 0 ) ? rupiah($subchild3['nominal']) : '-';?></td>
              <td style="text-align: right;"><?=($subchild3['persentase'] != 0 ) ? persen($subchild3['persentase']).'%' : '-';?></td>
          </tr>
      <?php endforeach;?>
    <?php endif;?>
    <?php endforeach;?>
    <?php if($child['group'] == 'HASIL INVESTASI'):?>
      <tr style="font-weight: bold;">
        <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['rka_sem1_lvl2'] != 0 ) ? rupiah($child['rka_sem1_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_perst_rkasem2_lvl2'] != 0 ) ? persen($child['sum_perst_rkasem2_lvl2']).'%' : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['nominal_lvl2'] != 0 ) ? rupiah($child['nominal_lvl2']) : '-';?></td>
        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['persentase_lvl2'] != 0 ) ? persen($child['persentase_lvl2']).'%' : '-';?></td>
    </tr>
    <?php endif;?>
    <?php endforeach;?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['rka_sem1_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['rka_sem1_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['sum_perst_rkasem2_lvl1'] != 0 ) ? persen($perubahan_danabersih['sum_perst_rkasem2_lvl1']).'%' : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['nominal_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['nominal_lvl1']) : '-';?></td>
      <td style="text-align: right;"><?=($perubahan_danabersih['persentase_lvl1'] != 0 ) ? persen($perubahan_danabersih['persentase_lvl1']).'%' : '-';?></td>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
    <?php
        $saldo_akhir_smt1_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt1) ? $tot_perubahan[0]->saldo_akhir_smt1 : '0');
        $saldo_akhir_smt1_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt1) ? $tot_perubahan[1]->saldo_akhir_smt1 : '0');
        $saldo_akhir_smt2_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt2) ? $tot_perubahan[0]->saldo_akhir_smt2 : '0');
        $saldo_akhir_smt2_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt2) ? $tot_perubahan[1]->saldo_akhir_smt2 : '0');

        $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_smt1) ? $total_bersih[0]->saldo_akhir_smt1 : '0');
        $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_smt1) ? $total_bersih[1]->saldo_akhir_smt1 : '0');
        $dbersih1 = (isset($data_perubahan_danabersih[0]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[0]['rka_sem1_lvl1'] : 0) ;
        $dbersih2 = (isset($data_perubahan_danabersih[1]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[1]['rka_sem1_lvl1'] : 0) ;
                        // penngkatan (penurunan)
        $tot = $saldo_akhir_smt1_1 - $saldo_akhir_smt1_2;
        $tot_prev = $saldo_akhir_smt2_1 - $saldo_akhir_smt2_2;
        $tot_rka = $dbersih1 - $dbersih2;
        $tot_pers_rka = ($tot_rka!=0)?($tot_prev/$tot_rka):0;
        $tot_nominal =  $tot_prev - $tot;
        $tot_persentase = ($tot!=0)?($tot_nominal/$tot)*100:0;

                        // dana bersih awal & akhir
        $dbersih_awal1 =  $total_bersih1 - $total_bersih2;
        $dbersih_akhir1 = $tot + $dbersih_awal1;
        $dbersih_awal2 =  $dbersih_akhir1;
        $dbersih_akhir2 = $tot_prev + $dbersih_awal2;
        $dbersih_rka_awal = $dbersih_akhir2;
        $dbersih_rka_akhir = $tot_rka + $dbersih_rka_awal;
        $dbersih_prsn_rka_awal = ($dbersih_rka_awal!=0)?($dbersih_awal2/$dbersih_rka_awal)*100:0;
        $dbersih_prsn_rka_akhir = ($dbersih_rka_akhir!=0)?($dbersih_akhir2/$dbersih_rka_akhir)*100:0;
        $dbersih_nominal_awal = $dbersih_awal2 - $dbersih_awal1;
        $dbersih_nominal_akhir = $dbersih_akhir2 - $dbersih_akhir1;
        $dbersih_persentase_awal = ($dbersih_awal1!=0)?($dbersih_nominal_awal/$dbersih_awal1)*100:0;
        $dbersih_persentase_akhir = ($dbersih_akhir1!=0)?($dbersih_nominal_akhir/$dbersih_akhir1)*100:0;

    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
        <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
        <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
        <td style="text-align: right;"><?=rupiah($tot);?></td>
        <td style="text-align: right;"><?=rupiah($tot_rka);?></td>
        <td style="text-align: right;"><?=persen($tot_pers_rka);?>%</td>
        <td style="text-align: right;"><?=rupiah($tot_nominal);?></td>
        <td style="text-align: right;"><?=persen($tot_persentase);?>%</td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
        <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
        <td style="text-align: right;"><?=rupiah($dbersih_awal2);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_awal1);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_rka_awal);?></td>
        <td style="text-align: right;"><?=persen($dbersih_prsn_rka_awal);?>%</td>
        <td style="text-align: right;"><?=rupiah($dbersih_nominal_awal);?></td>
        <td style="text-align: right;"><?=persen($dbersih_persentase_awal);?>%</td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
        <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
        <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_akhir1);?></td>
        <td style="text-align: right;"><?=rupiah($dbersih_rka_akhir);?></td>
        <td style="text-align: right;"><?=persen($dbersih_prsn_rka_akhir);?>%</td>
        <td style="text-align: right;"><?=rupiah($dbersih_nominal_akhir);?></td>
        <td style="text-align: right;"><?=persen($dbersih_persentase_akhir);?>%</td>
    </tr>
    </tbody>
</table>
<?php endif;?>

