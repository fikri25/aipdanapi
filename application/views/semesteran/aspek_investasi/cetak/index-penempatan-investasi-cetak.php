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
    Aspek Investasi
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    a) Penempatan Investasi
</p>
<!-- ======================================================SEMESTER 2 ================================ -->
<?php if($semester == 2 || $semester == ""):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th rowspan="2" width="30%">Jenis Investasi</th>
      <th rowspan="2">Saldo Akhir Semester I <?= $thn; ?></th>
      <th colspan="2">Mutasi</th>
      <th rowspan="2">Saldo Akhir Semester II <?= $thn_filter;?></th>
      <th rowspan="2">RKAP</th>
      <th rowspan="2">Capaian Semester II terhadap RKAP</th>
      <th colspan="2">Kenaikan/Penurunan</th>
    </tr>
    <tr>
      <th>Penambahan</th>
      <th>Pengurangan</th>
      <th>Nominal</th>
      <th>Persentase</th>
    </tr>

  </thead>
  <tbody>
    <?php if(isset($data_invest) && is_array($data_invest)):?>
    <?php foreach($data_invest as $invest):?>
      <?php if($invest['type'] == 'P'):?>
        <tr>
          <td style="text-align: left;"><?=$invest['jenis_investasi']?></td>
          <td style="text-align: right;"><?=($invest['saldo_akhir_smt1'] != 0 ) ? rupiah($invest['saldo_akhir_smt1']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['mutasi_penambahan'] != 0 ) ? rupiah($invest['mutasi_penambahan']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['mutasi_pengurangan'] != 0 ) ? rupiah($invest['mutasi_pengurangan']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['saldo_akhir_smt2'] != 0 ) ? rupiah($invest['saldo_akhir_smt2']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['rka'] != 0 ) ? rupiah($invest['rka']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['pers_rka'] != 0 ) ? persen($invest['pers_rka']).'%' : '-';?></td>
          <td style="text-align: right;"><?=($invest['nominal'] != 0 ) ? rupiah($invest['nominal']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['persentase'] != 0 ) ? persen($invest['persentase']).'%' : '-';?></td>

        </tr>
      <?php endif;?>
      <?php if($invest['type'] == 'PC'):?>
        <tr>
          <td style="text-align:left;"><?=$invest['jenis_investasi']?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      <?php endif;?>
      <?php foreach($invest['child'] as $child):?>
        <tr>
          <td style="text-align:left; padding-left: 30px; color: #6c7275;"><?='- '.$child['jenis_investasi']?></td>
          <td style="text-align: right;"><?=($child['saldo_akhir_smt1'] != 0 ) ? rupiah($child['saldo_akhir_smt1']) : '-';?></td>
          <td style="text-align: right;"><?=($child['mutasi_penambahan'] != 0 ) ? rupiah($child['mutasi_penambahan']) : '-';?></td>
          <td style="text-align: right;"><?=($child['mutasi_pengurangan'] != 0 ) ? rupiah($child['mutasi_pengurangan']) : '-';?></td>
          <td style="text-align: right;"><?=($child['saldo_akhir_smt2'] != 0 ) ? rupiah($child['saldo_akhir_smt2']) : '-';?></td>
          <td style="text-align: right;"><?=($child['rka'] != 0 ) ? rupiah($child['rka']) : '-';?></td>
          <td style="text-align: right;"><?=($child['pers_rka'] != 0 ) ? persen($child['pers_rka']).'%' : '-';?></td>
          <td style="text-align: right;"><?=($child['nominal'] != 0 ) ? rupiah($child['nominal']) : '-';?></td>
          <td style="text-align: right;"><?=($child['persentase'] != 0 ) ? persen($child['persentase']).'%' : '-';?></td>
        </tr>

      <?php endforeach;?>
    <?php endforeach;?>
  <?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
  <td>Total</td>
  <td style="text-align: right;"><?=($sum['saldo_akhir_smt1'] != 0 ) ? rupiah($sum['saldo_akhir_smt1']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['mutasi_penambahan'] != 0 ) ? rupiah($sum['mutasi_penambahan']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['mutasi_pengurangan'] != 0 ) ? rupiah($sum['mutasi_pengurangan']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['saldo_akhir_smt2'] != 0 ) ? rupiah($sum['saldo_akhir_smt2']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['rka'] != 0 ) ? rupiah($sum['rka']) : '-';?></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
</table>
<?php endif;?>


<!-- ======================================================SEMESTER 1 ================================ -->
<?php if($semester == 1 ):?>

<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th rowspan="2" width="30%">Jenis Investasi</th>
      <th rowspan="2">Saldo Akhir Semester II <?= $thn_filter; ?></th>
      <th colspan="2">Mutasi</th>
      <th rowspan="2">Saldo Akhir Semester I <?= $thn;?></th>
      <th rowspan="2">RKAP</th>
      <th rowspan="2">Capaian Semester II terhadap RKAP</th>
      <th colspan="2">Kenaikan/Penurunan</th>
    </tr>
    <tr>
      <th>Penambahan</th>
      <th>Pengurangan</th>
      <th>Nominal</th>
      <th>Persentase</th>
    </tr>

  </thead>
  <tbody>
    <?php if(isset($data_invest) && is_array($data_invest)):?>
    <?php foreach($data_invest as $invest):?>
      <?php if($invest['type'] == 'P'):?>
        <tr>
          <td style="text-align: left;"><?=$invest['jenis_investasi']?></td>
          <td style="text-align: right;"><?=($invest['saldo_akhir_smt2'] != 0 ) ? rupiah($invest['saldo_akhir_smt2']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['mutasi_penambahan'] != 0 ) ? rupiah($invest['mutasi_penambahan']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['mutasi_pengurangan'] != 0 ) ? rupiah($invest['mutasi_pengurangan']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['saldo_akhir_smt1'] != 0 ) ? rupiah($invest['saldo_akhir_smt1']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['rka'] != 0 ) ? rupiah($invest['rka']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['pers_rka'] != 0 ) ? persen($invest['pers_rka']).'%' : '-';?></td>
          <td style="text-align: right;"><?=($invest['nominal'] != 0 ) ? rupiah($invest['nominal']) : '-';?></td>
          <td style="text-align: right;"><?=($invest['persentase'] != 0 ) ? persen($invest['persentase']).'%' : '-';?></td>

        </tr>
      <?php endif;?>
      <?php if($invest['type'] == 'PC'):?>
        <tr>
          <td style="text-align:left;"><?=$invest['jenis_investasi']?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      <?php endif;?>
      <?php foreach($invest['child'] as $child):?>
        <tr>
          <td style="text-align:left; padding-left: 30px; color: #6c7275;"><?='- '.$child['jenis_investasi']?></td>
          <td style="text-align: right;"><?=($child['saldo_akhir_smt2'] != 0 ) ? rupiah($child['saldo_akhir_smt2']) : '-';?></td>
          <td style="text-align: right;"><?=($child['mutasi_penambahan'] != 0 ) ? rupiah($child['mutasi_penambahan']) : '-';?></td>
          <td style="text-align: right;"><?=($child['mutasi_pengurangan'] != 0 ) ? rupiah($child['mutasi_pengurangan']) : '-';?></td>
          <td style="text-align: right;"><?=($child['saldo_akhir_smt1'] != 0 ) ? rupiah($child['saldo_akhir_smt1']) : '-';?></td>
          <td style="text-align: right;"><?=($child['rka'] != 0 ) ? rupiah($child['rka']) : '-';?></td>
          <td style="text-align: right;"><?=($child['pers_rka'] != 0 ) ? persen($child['pers_rka']).'%' : '-';?></td>
          <td style="text-align: right;"><?=($child['nominal'] != 0 ) ? rupiah($child['nominal']) : '-';?></td>
          <td style="text-align: right;"><?=($child['persentase'] != 0 ) ? persen($child['persentase']).'%' : '-';?></td>
        </tr>

      <?php endforeach;?>
    <?php endforeach;?>
  <?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
  <td>Total</td>
  <td style="text-align: right;"><?=($sum['saldo_akhir_smt2'] != 0 ) ? rupiah($sum['saldo_akhir_smt2']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['mutasi_penambahan'] != 0 ) ? rupiah($sum['mutasi_penambahan']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['mutasi_pengurangan'] != 0 ) ? rupiah($sum['mutasi_pengurangan']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['saldo_akhir_smt1'] != 0 ) ? rupiah($sum['saldo_akhir_smt1']) : '-';?></td>
  <td style="text-align: right;"><?=($sum['rka'] != 0 ) ? rupiah($sum['rka']) : '-';?></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
</table>
<?php endif;?>