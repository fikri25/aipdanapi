<?php $tahun = $this->session->userdata("tahun");?>
<p style="font-weight: bold">
  <h5 align="center">SURAT PERNYATAAN DIREKSI</h5>
  <h5 align="center">TENTANG TANGGUNG JAWAB ATAS LAPORAN BULANAN</h5>
  <h5 align="center">PENGELOLAAN AKUMULASI IURAN PENSIUN DAN PEJABAT NEGARA</h5>
  <h5 align="center" style="text-transform: uppercase;">BULAN <?php echo $bulan[0]->nama_bulan; ?>&nbsp;<?php echo $tahun; ?></h5>
</p>
<hr style="height:3px;background-color:#a8a8a8;">
<table>
  <tbody>
      <tr>
        <td>Kami yang bertandatangan di bawah ini</td>
        <td>:</td>
        <td></td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?php echo (isset($data_pendahuluan[0]->nama_penandatangan) ? $data_pendahuluan[0]->nama_penandatangan : '');?></td>
      </tr>
      <tr>
        <td>Alamat Kantor</td>
        <td>:</td>
        <td>Jl. Letjen Suprapto No. 45 – Cempaka Putih Jakarta Pusat 10520 DKI Jakarta</td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?php echo (isset($data_pendahuluan[0]->jabatan) ? $data_pendahuluan[0]->jabatan : '');?></td>
      </tr>
      <tr>
        <td>Menyatakan bahwa</td>
        <td>:</td>
        <td></td>
      </tr>
  </tbody>
</table>
<p>1. Bertanggung jawab atas penyusunan dan penyajian laporan bulanan pengelolaan akumulasi iuran pensiun dan pejabat negara;</p>
<p>2. Laporan keuangan laporan bulanan pengelolaan akumulasi iuran pensiun dan pejabat negara telah disusun dan disajikan sesuai dengan ketentuan yang berlaku; </p>
<p>3. Semua informasi dalam laporan-laporan bulanan pengelolaan akumulasi iuran pensiun dan pejabat negara telah dimuat secara lengkap dan benar.</p>
<p>Demikian peryataan ini dibuat dengan sebenarnya.</p><br><br>
                      
<?php if ($data_pendahuluan[0]->status == "Approved"){ ?>
<p style="text-align: center;">Jakarta, <?php echo indo_tgl($data_pendahuluan[0]->status_tgl);?></p>
<?php } else { ?>
<p style="text-align: center;">Jakarta, <?php echo indo_tgl(date('Y-m-d'));?></p>
<?php } ?>

<?php if ($data_pendahuluan[0]->status == "Approved"){ ?>
<p style="text-align: center;"><?php echo (isset($data_pendahuluan[0]->jabatan) ? $data_pendahuluan[0]->jabatan : '');?></p>
<?php } else { ?>
<p style="text-align: center;">..................</p>
<?php } ?>

<p style="text-align: center;"> Ttd.</p>

<?php if ($data_pendahuluan[0]->status == "Approved"){ ?>
<p style="text-align: center; font-weight: bold"><?php echo (isset($data_pendahuluan[0]->nama_penandatangan) ? $data_pendahuluan[0]->nama_penandatangan : '');?></p>
<?php } else { ?>
<p style="text-align: center;">..................</p>
<?php } ?>