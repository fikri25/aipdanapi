<?php 
    $tahun = $this->session->userdata("tahun");
    $semester = $this->session->userdata("semester");
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;text-align: center">     
    PENDAHULUAN
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;text-align: center">     
   LAPORAN SEMESTER&nbsp;<?php if($semester == '1'){echo "I";}else{echo "II";} ?>
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;text-align: center">     
   TAHUN ANGGARAN&nbsp;<?php echo $tahun;?>
</p>
<br>
<!-- <p style="font-weight: bold">Latar Belakang Pelaporan</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->latar_belakang))?></p>
<p style="font-weight: bold">Pihak yang Menjadi Tujuan Laporan</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->tujuan_laporan))?></p>
<p style="font-weight: bold">Kejadian Penting</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->kejadian_penting))?></p>
<p style="font-weight: bold">Periode Pelaporan</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->periode))?></p>
<p style="font-weight: bold">Keterangan</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->keterangan))?></p>
<p style="font-weight: bold">Dewan Direksi</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->direksi))?></p>
<p style="font-weight: bold">Komisaris</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->komisaris))?></p>
<p style="font-weight: bold">Alamat Kantor Pusat</p>
<p style="text-align: justify;"><?php echo strip_tags(html_entity_decode($data_pendahuluan[0]->alamat))?></p> -->


<!-- Format sesuai yang si ketik/copy-->

<?php echo $data_pendahuluan[0]->latar_belakang; ?>
<?php echo $data_pendahuluan[0]->tujuan_laporan; ?>
<?php echo $data_pendahuluan[0]->kejadian_penting; ?>
<?php echo $data_pendahuluan[0]->periode; ?>
<?php echo $data_pendahuluan[0]->keterangan; ?>
<?php echo $data_pendahuluan[0]->direksi; ?>
<?php echo $data_pendahuluan[0]->komisaris; ?>
<?php echo $data_pendahuluan[0]->alamat; ?>