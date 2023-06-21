<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
  Aspek Investasi
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
  c) Beban Investasi
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th rowspan="2" width="30%">Uraian Beban Investasi</th>
      <th rowspan="2">Saldo Akhir Tahun <?= $tahun; ?></th>
      <th rowspan="2">Saldo Akhir Tahun <?= $tahun - 1; ?></th>
      <th colspan="2">Kenaikan/Penurunan</th>
      <th rowspan="2">RKA</th>
      <th rowspan="2">Capaian Tahun <?= $tahun - 1; ?> terhadap RKA</th>
    </tr>
    <tr>
      <th>Nominal</th>
      <th>Persentase</th>
    </tr>

  </thead>
  <tbody>
    <?php if(isset($data_beban) && is_array($data_beban)):?>
    <?php foreach($data_beban as $beban):?>
      <?php if($beban['type'] == 'P'):?>
        <tr>
          <td style="text-align: left;"><?=$beban['jenis_investasi']?></td>
          <td style="text-align:right;"><?=($beban['saldo_akhir_thn'] != 0 ) ? rupiah($beban['saldo_akhir_thn']) : '-';?></td>
          <td style="text-align:right;"><?=($beban['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($beban['saldo_akhir_thn_lalu']) : '-';?></td>
          <td style="text-align:right;"><?=($beban['nominal'] != 0 ) ? rupiah($beban['nominal']) : '-';?></td>
          <td style="text-align:right;"><?=($beban['persentase'] != 0 ) ? persen($beban['persentase']).'%' : '-';?></td>
          <td style="text-align:right;"><?=($beban['rka'] != 0 ) ? rupiah($beban['rka']) : '-';?></td>
          <td style="text-align:right;"><?=($beban['pers_rka'] != 0 ) ? persen($beban['pers_rka']).'%' : '-';?></td>

        </tr>
      <?php endif;?>
      <?php if($beban['type'] == 'PC'):?>
        <tr>
          <td style="text-align:left;"><?=$beban['jenis_investasi']?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      <?php endif;?>
      <?php foreach($beban['child'] as $child):?>
        <tr>
          <td style="text-align:left; padding-left: 30px; color: #6c7275;"><?='- '.$child['jenis_investasi']?></td>
          <td style="text-align:right;"><?=($child['saldo_akhir_thn'] != 0 ) ? rupiah($child['saldo_akhir_thn']) : '-';?></td>
          <td style="text-align:right;"><?=($child['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($child['saldo_akhir_thn_lalu']) : '-';?></td>
          <td style="text-align:right;"><?=($child['nominal'] != 0 ) ? rupiah($child['nominal']) : '-';?></td>
          <td style="text-align:right;"><?=($child['persentase'] != 0 ) ? persen($child['persentase']).'%' : '-';?></td>
          <td style="text-align:right;"><?=($child['rka'] != 0 ) ? rupiah($child['rka']) : '-';?></td>
          <td style="text-align:right;"><?=($child['pers_rka'] != 0 ) ? persen($child['pers_rka']).'%' : '-';?></td>
        </tr>

      <?php endforeach;?>
    <?php endforeach;?>
  <?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
  <td>Total</td>
  <td style="text-align:right;"><?=($sum['saldo_akhir_thn'] != 0 ) ? rupiah($sum['saldo_akhir_thn']) : '-';?></td>
  <td style="text-align:right;"><?=($sum['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($sum['saldo_akhir_thn_lalu']) : '-';?></td>
  <td style="text-align:right;"><?=($sum['rka'] != 0 ) ? rupiah($sum['rka']) : '-';?></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
</table>