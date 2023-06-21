<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
    Aspek Keuangan
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    LKAK YOI
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
       <tr>
          <th width="30%">Uraian</th>
          <th>Tahun <?= $tahun; ?></th>
          <th>Tahun <?= $tahun - 1; ?></th>
          <th>RIT</th>
          <th>% Capaian Tahun <?= $tahun - 1; ?></th>
          <th>% Naik/Turun</th>
        </tr>

    </thead>
    <tbody>
        <tr>
          <td style="text-align: left;"><?= $yoi['uraian'];?></td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_saldo_akhir_thn']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_saldo_akhir_thn_lalu']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_rka_thn']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_pers_capaian']);?>%</td>
          <td style="text-align: right;"><?= persen($yoi['lkak_yoi_naik']);?>%</td>
      </tr>
    </tbody>
</table>