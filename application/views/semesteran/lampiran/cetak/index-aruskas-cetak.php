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
  Lampiran Pendukung
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
  Arus Kas
</p>
<!-- ======================================================SEMESTER 2 ================================ -->
<?php if($semester == 2 || $semester == ""):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th width="40%">URAIAN</th>
      <th width="27%">Semester I <?= $thn; ?></th>
      <th width="27%">Semester II <?= $thn_filter;?></th>
    </tr>

  </thead>
  <tbody>
    <?php
      $totkas = 0;
      $totkasprev = 0;
    ?>
    <?php if(isset($arus_kas) && is_array($arus_kas)):?>
    <?php foreach($arus_kas as $kas):?>
      <tr style="font-weight: bold; background-color:#c1e1f3;">
        <td style="text-align: left;" colspan="3"><?=$kas['judul_kas']?></td>
      </tr>
      <?php foreach($kas['child'] as $child):?>
        <tr>
          <td style="text-align: left;padding-left: 35px"><?=$child['arus_kas']?></td>
          <?php foreach($child['subchild'] as $subchl):?>
            <td style="text-align: right;"><?=($subchl['saldo_smt1'] != 0 ) ? rupiah($subchl['saldo_smt1']) : '-';?></td>
            <td style="text-align: right;"><?=($subchl['saldo_smt2'] != 0 ) ? rupiah($subchl['saldo_smt2']) : '-';?></td>
          <?php endforeach;?>
        </tr>
      <?php endforeach;?>
      <tr style="font-weight: bold; background-color:#e6f5fe;">
        <td style="text-align: left;"><?=$kas['judul']?></td>
        <td style="text-align: right;"><?=($kas['sum'] != 0 ) ? rupiah($kas['sum']) : '-';?></td>
        <td style="text-align: right;"><?=($kas['sumprev'] != 0 ) ? rupiah($kas['sumprev']) : '-';?></td>
      </tr>
      <?php
      $totkas += $kas['sum'];
      $totkasprev += $kas['sumprev'];
      ?>

    <?php endforeach;?>
    <?php endif;?>

    <?php
      // $kas_akhir2 = $kas_bank['saldo_akhir']+$totkasprev;
      // $kas_akhir1 = $totkas+$kas_akhir2;
    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">KENAIKAN (PENURUNAN) KAS dan BANK</td>
      <td style="text-align: right;"><?=rupiah($totkas);?></td>
      <td style="text-align: right;"><?=rupiah($totkasprev);?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">KAS DAN BANK PADA AWAL BULAN</td>
      <td style="text-align: right;"><?=rupiah($kas_bank['saldo_awal_smt1']);?></td>
      <td style="text-align: right;"><?= rupiah($kas_bank['saldo_awal_smt2']);?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">KAS DAN BANK PADA AKHIR BULAN</td>
      <td style="text-align: right;"><?=rupiah($kas_bank['saldo_akhir_smt1']);?></td>
      <td style="text-align: right;"><?= rupiah($kas_bank['saldo_akhir_smt2']);?></td>
    </tr>
  </tbody>
</table>
<?php endif;?>
<!-- ======================================================SEMESTER 1 ================================ -->
<?php if($semester == 1 ):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th width="40%">URAIAN</th>
      <th width="27%">Semester II <?= $thn_filter;?></th>
      <th width="27%">Semester I <?= $thn; ?></th>
    </tr>

  </thead>
  <tbody>
    <?php
      $totkas = 0;
      $totkasprev = 0;
    ?>
    <?php if(isset($arus_kas) && is_array($arus_kas)):?>
    <?php foreach($arus_kas as $kas):?>
      <tr style="font-weight: bold; background-color:#c1e1f3;">
        <td style="text-align: left;" colspan="3"><?=$kas['judul_kas']?></td>
      </tr>
      <?php foreach($kas['child'] as $child):?>
        <tr>
          <td style="text-align: left;padding-left: 35px"><?=$child['arus_kas']?></td>
          <?php foreach($child['subchild'] as $subchl):?>
            <td style="text-align: right;"><?=($subchl['saldo_smt2'] != 0 ) ? rupiah($subchl['saldo_smt2']) : '-';?></td>
            <td style="text-align: right;"><?=($subchl['saldo_smt1'] != 0 ) ? rupiah($subchl['saldo_smt1']) : '-';?></td>
          <?php endforeach;?>
        </tr>
      <?php endforeach;?>
      <tr style="font-weight: bold; background-color:#e6f5fe;">
        <td style="text-align: left;"><?=$kas['judul']?></td>
        <td style="text-align: right;"><?=($kas['sumprev'] != 0 ) ? rupiah($kas['sumprev']) : '-';?></td>
        <td style="text-align: right;"><?=($kas['sum'] != 0 ) ? rupiah($kas['sum']) : '-';?></td>
      </tr>
      <?php
      $totkas += $kas['sum'];
      $totkasprev += $kas['sumprev'];
      ?>

    <?php endforeach;?>
    <?php endif;?>

    <?php
      // $kas_akhir2 = $kas_bank['saldo_akhir']+$totkasprev;
      // $kas_akhir1 = $totkas+$kas_akhir2;
    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">KENAIKAN (PENURUNAN) KAS dan BANK</td>
      <td style="text-align: right;"><?=rupiah($totkasprev);?></td>
      <td style="text-align: right;"><?=rupiah($totkas);?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">KAS DAN BANK PADA AWAL BULAN</td>
      <td style="text-align: right;"><?=rupiah($kas_bank['saldo_awal_smt2_lalu']);?></td>
      <td style="text-align: right;"><?= rupiah($kas_bank['saldo_awal_smt1']);?></td>
    </tr>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">KAS DAN BANK PADA AKHIR BULAN</td>
      <td style="text-align: right;"><?=rupiah($kas_bank['saldo_awal_smt2_lalu']);?></td>
      <td style="text-align: right;"><?= rupiah($kas_bank['saldo_akhir_smt1']);?></td>
    </tr>
  </tbody>
</table>
<?php endif;?>

