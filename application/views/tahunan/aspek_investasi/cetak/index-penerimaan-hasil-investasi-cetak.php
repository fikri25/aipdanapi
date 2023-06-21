<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
    Aspek Investasi
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Penerimaan Hasil Investasi
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th rowspan="2" width="30%">Jenis Investasi</th>
      <th rowspan="2">Saldo Akhir Tahun <?= $tahun; ?></th>
      <!-- <th colspan="2">Mutasi</th> -->
      <th rowspan="2">Saldo Akhir Tahun <?= $tahun - 1; ?></th>
      <th rowspan="2">RKA/RIT</th>
      <th rowspan="2">Capaian Tahun  <?= $tahun - 1; ?> terhadap RKA</th>
      <th colspan="2">Kenaikan/Penurunan</th>
    </tr>
    <tr>
      <!-- <th>Penambahan</th>
      <th>Pengurangan</th> -->
      <th>Nominal</th>
      <th>Persentase</th>
    </tr>

  </thead>
  <tbody>
    <?php if(isset($data_hasil) && is_array($data_hasil)):?>
    <?php foreach($data_hasil as $hasil):?>
      <?php if($hasil['type'] == 'P'):?>
        <tr>
          <td style="text-align: left;"><?=$hasil['jenis_investasi']?></td>
          <td style="text-align:right;"><?=($hasil['saldo_akhir_thn'] != 0 ) ? rupiah($hasil['saldo_akhir_thn']) : '-';?></td>
         <!--  <td style="text-align:right;"><?=($hasil['mutasi_penambahan'] != 0 ) ? rupiah($hasil['mutasi_penambahan']) : '-';?></td>
          <td style="text-align:right;"><?=($hasil['mutasi_pengurangan'] != 0 ) ? rupiah($hasil['mutasi_pengurangan']) : '-';?></td> -->
          <td style="text-align:right;"><?=($hasil['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($hasil['saldo_akhir_thn_lalu']) : '-';?></td>
          <td style="text-align:right;"><?=($hasil['rka'] != 0 ) ? rupiah($hasil['rka']) : '-';?></td>
          <td style="text-align:right;"><?=($hasil['pers_rka'] != 0 ) ? persen($hasil['pers_rka']).'%' : '-';?></td>
          <td style="text-align:right;"><?=($hasil['nominal'] != 0 ) ? rupiah($hasil['nominal']) : '-';?></td>
          <td style="text-align:right;"><?=($hasil['persentase'] != 0 ) ? persen($hasil['persentase']).'%' : '-';?></td>

        </tr>
      <?php endif;?>
      <?php if($hasil['type'] == 'PC'):?>
        <tr>
          <td style="text-align:left;"><?=$hasil['jenis_investasi']?></td>
          <td></td>
         <!--  <td></td>
          <td></td> -->
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      <?php endif;?>
      <?php foreach($hasil['child'] as $child):?>
        <tr>
          <td style="text-align:left; padding-left: 30px; color: #6c7275;"><?='- '.$child['jenis_investasi']?></td>
          <td style="text-align:right;"><?=($child['saldo_akhir_thn'] != 0 ) ? rupiah($child['saldo_akhir_thn']) : '-';?></td>
         <!--  <td style="text-align:right;"><?=($child['mutasi_penambahan'] != 0 ) ? rupiah($child['mutasi_penambahan']) : '-';?></td>
          <td style="text-align:right;"><?=($child['mutasi_pengurangan'] != 0 ) ? rupiah($child['mutasi_pengurangan']) : '-';?></td> -->
          <td style="text-align:right;"><?=($child['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($child['saldo_akhir_thn_lalu']) : '-';?></td>
          <td style="text-align:right;"><?=($child['rka'] != 0 ) ? rupiah($child['rka']) : '-';?></td>
          <td style="text-align:right;"><?=($child['pers_rka'] != 0 ) ? persen($child['pers_rka']).'%' : '-';?></td>
          <td style="text-align:right;"><?=($child['nominal'] != 0 ) ? rupiah($child['nominal']) : '-';?></td>
          <td style="text-align:right;"><?=($child['persentase'] != 0 ) ? persen($child['persentase']).'%' : '-';?></td>
        </tr>

      <?php endforeach;?>
    <?php endforeach;?>
  <?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
  <td>Total</td>
  <td style="text-align:right;"><?=($sum['saldo_akhir_thn'] != 0 ) ? rupiah($sum['saldo_akhir_thn']) : '-';?></td>
  <!-- <td style="text-align:right;"><?=($sum['mutasi_penambahan'] != 0 ) ? rupiah($sum['mutasi_penambahan']) : '-';?></td>
  <td style="text-align:right;"><?=($sum['mutasi_pengurangan'] != 0 ) ? rupiah($sum['mutasi_pengurangan']) : '-';?></td> -->
  <td style="text-align:right;"><?=($sum['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($sum['saldo_akhir_thn_lalu']) : '-';?></td>
  <td style="text-align:right;"><?=($sum['rka'] != 0 ) ? rupiah($sum['rka']) : '-';?></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
</table>