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
    LKAK YOI
</p>
<!-- ======================================= SEMESTER 2 ================================ -->
<?php if($semester == 2 || $semester == ""):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
       <tr>
          <th width="30%">Uraian</th>
          <th>Semester I <?= $thn;?></th>
          <th>Semester II <?= $thn_filter;?></th>
          <th>RIT</th>
          <th>% Capaian Semester II</th>
          <th>% Naik/Turun</th>
        </tr>

    </thead>
    <tbody>
        <tr>
          <td style="text-align: left;"><?= $yoi['uraian'];?></td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_saldo_akhir_smt1']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_saldo_akhir_smt2']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_rka_smt1']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_pers_capaian']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_naik']);?>%</td>
      </tr>
    </tbody>
</table>
<?php endif;?>

<!-- ====================================== SEMESTER 1 ================================ -->
<?php if($semester == 1 ):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
       <tr>
          <th width="30%">Uraian</th>
          <th>Semester II <?= $thn_filter;?></th>
          <th>Semester I <?= $thn;?></th>
          <th>RIT</th>
          <th>% Capaian Semester II</th>
          <th>% Naik/Turun</th>
        </tr>

    </thead>
    <tbody>
        <tr>
          <td style="text-align: left;"><?= $yoi['uraian'];?></td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_saldo_akhir_smt2']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_saldo_akhir_smt1']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_rka_smt1']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_pers_capaian']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_naik']);?>%</td>
      </tr>
    </tbody>
</table>
<?php endif;?>