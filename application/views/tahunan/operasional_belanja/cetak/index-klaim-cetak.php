<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
    Operasional Belanja
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    a) Klaim
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
   <tr>
    <th rowspan="2" width="15%">Jenis Klaim</th>
    <th colspan="2">Tahun <?= $tahun; ?></th>
    <th colspan="2">Tahun <?= $tahun - 1; ?></th>
    <th colspan ="2">% Kenaikan/Penurunan </th>
    <th colspan ="2">RKA</th>
    <th colspan="2">%Capaian Semester terhadap RKA</th>
  </tr>
  <tr>
    <th>Jumlah Klaim</th>
    <th>Jumlah Pembayaran</th>
    <th>Jumlah Klaim</th>
    <th>Jumlah Pembayaran</th>
    <th>Jumlah Klaim</th>
    <th>Jumlah Pembayaran</th>
    <th>Jumlah Klaim</th>
    <th>Jumlah Pembayaran</th>
    <th>Jumlah Klaim</th>
    <th>Jumlah Pembayaran</th>
  </tr>
</thead>
<tbody>
 <?php if(isset($klaim_header) && is_array($klaim_header)):?>
 <?php foreach($klaim_header as $header):?>
  <tr>
    <td style="text-align: left;"><?=$header['jenis_klaim']?></td>
    <td style="text-align: right;"><?=($header['jml_klaim_thn'] != 0 ) ? rupiah($header['jml_klaim_thn']) : '-';?></td>
    <td style="text-align: right;"><?=($header['jml_pembayaran_thn'] != 0 ) ? rupiah($header['jml_pembayaran_thn']) : '-';?></td>
    <td style="text-align: right;"><?=($header['jml_klaim_thn_lalu'] != 0 ) ? rupiah($header['jml_klaim_thn_lalu']) : '-';?></td>
    <td style="text-align: right;"><?=($header['jml_pembayaran_thn_lalu'] != 0 ) ? rupiah($header['jml_pembayaran_thn_lalu']) : '-';?></td>
    <td style="text-align: right;"><?=persen($header['pers_penerimaan']);?>%</td>
    <td style="text-align: right;"><?=persen($header['pers_pembayaran']);?>%</td>
    <td style="text-align: right;"><?=rupiah($header['rka_jml_klaim']);?></td>
    <td style="text-align: right;"><?=rupiah($header['rka_jml_pembayaran']);?></td>
    <td style="text-align: right;"><?=persen($header['pers_kenaikan_penerima']);?>%</td>
    <td style="text-align: right;"><?=persen($header['pers_kenaikan_pembayaran']);?>%</td>
  <?php endforeach;?>
<?php endif;?>
</tbody>
</table>
<pagebreak></pagebreak>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Klaim (Detail)
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th rowspan="2">Kantor Cabang</th>
      <th rowspan="2">Jenis Klaim</th>
      <th colspan="2">Tahun <?= $tahun; ?></th>
      <th colspan="2">Tahun <?= $tahun - 1; ?></th>
      <th colspan="2">% Kenaikan/Penurunan </th>
    </tr>
    <tr>
      <th>Jumlah Klaim</th>
      <th>Jumlah Pembayaran</th>
      <th>Jumlah Klaim</th>
      <th>Jumlah Pembayaran</th>
      <th>Jumlah Klaim</th>
      <th>Jumlah Pembayaran</th>

    </tr>
  </thead>
  <tbody>
    <?php if(isset($klaim_detail) && is_array($klaim_detail)):?>
    <?php foreach($klaim_detail as $detail):?>
      <tr>
          <td style="text-align: left;"><?=$detail['nama_cabang']?></td>
          <td style="text-align: left;"><?=$detail['jenis_klaim']?></td>
          <td style="text-align: right;"><?=($detail['jml_klaim_thn'] != 0 ) ? rupiah($detail['jml_klaim_thn']) : '-';?></td>
          <td style="text-align: right;"><?=($detail['jml_pembayaran_thn'] != 0 ) ? rupiah($detail['jml_pembayaran_thn']) : '-';?></td>
          <td style="text-align: right;"><?=($detail['jml_klaim_thn_lalu'] != 0 ) ? rupiah($detail['jml_klaim_thn_lalu']) : '-';?></td>
          <td style="text-align: right;"><?=($detail['jml_pembayaran_thn_lalu'] != 0 ) ? rupiah($detail['jml_pembayaran_thn_lalu']) : '-';?></td>
          <td style="text-align: right;"><?=persen($detail['pers_kenaikan_penerima']);?>%</td>
          <td style="text-align: right;"><?=persen($detail['pers_kenaikan_pembayaran']);?>%</td>
      </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>