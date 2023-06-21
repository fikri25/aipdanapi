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
    Aspek Operasional
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    a) Pembayaran Pensiun AIP (Kelompok Penerima)
</p>

<!-- ======================================= SEMESTER 2 ================================ -->
<?php if($semester == 2 || $semester == ""):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Kelompok Penerima</th>
            <th colspan="2">RKA/RIT</th>
            <th colspan="2">Semester I <?= $thn; ?></th>
            <th colspan="2">Semester II <?= $thn_filter;?></th>
            <th colspan="2">% Capaian Semester II</th>
            <th colspan="2">% Kenaikan/Penurunan Semester I</th>
        </tr>
        <tr>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
        <?php if(isset($data_kelompok) && is_array($data_kelompok)):?>
        <?php foreach($data_kelompok as $kelompok):?>
            <tr>
                <td><?= $no++;?></td>
                <td style="text-align: left;"><?=$kelompok['kelompok_penerima']?></td>
                <td style="text-align: right;"><?=($kelompok['rka_penerima'] != 0 ) ? rupiah($kelompok['rka_penerima']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['rka_pembayaran'] != 0 ) ? rupiah($kelompok['rka_pembayaran']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_penerima_smt1'] != 0 ) ? rupiah($kelompok['jml_penerima_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_pembayaran_smt1'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_penerima_smt2'] != 0 ) ? rupiah($kelompok['jml_penerima_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_pembayaran_smt2'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_penerimaan'] != 0 ) ? persen($kelompok['pers_penerimaan']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_pembayaran'] != 0 ) ? persen($kelompok['pers_pembayaran']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_kenaikan_penerima'] != 0 ) ? persen($kelompok['pers_kenaikan_penerima']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_kenaikan_pembayaran'] != 0 ) ? persen($kelompok['pers_kenaikan_pembayaran']).'%' : '-';?></td>

            </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<pagebreak></pagebreak>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Pembayaran Pensiun AIP (Jenis Penerima)
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2" width="20">No</th>
            <th rowspan="2">Jenis Penerima</th>
            <th colspan="2">RKA/RIT</th>
            <th colspan="2">Semester I <?= $thn; ?></th>
            <th colspan="2">Semester II <?= $thn_filter;?></th>
            <th colspan="2">% Capaian Semester II</th>
            <th colspan="2">% Kenaikan/Penurunan Semester I</th>
        </tr>
        <tr>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
        <?php if(isset($data_jenis) && is_array($data_jenis)):?>
        <?php foreach($data_jenis as $jenis):?>
            <tr>
                <td><?= $no++;?></td>
                <td style="text-align: left;"><?=$jenis['jenis_penerima']?></td>
                <td style="text-align: right;"><?=($jenis['rka_penerima'] != 0 ) ? rupiah($jenis['rka_penerima']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['rka_pembayaran'] != 0 ) ? rupiah($jenis['rka_pembayaran']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_penerima_smt1'] != 0 ) ? rupiah($jenis['jml_penerima_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_pembayaran_smt1'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_penerima_smt2'] != 0 ) ? rupiah($jenis['jml_penerima_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_pembayaran_smt2'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_penerimaan'] != 0 ) ? persen($jenis['pers_penerimaan']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_pembayaran'] != 0 ) ? persen($jenis['pers_pembayaran']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_kenaikan_penerima'] != 0 ) ? persen($jenis['pers_kenaikan_penerima']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_kenaikan_pembayaran'] != 0 ) ? persen($jenis['pers_kenaikan_pembayaran']).'%' : '-';?></td>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<?php endif;?>

<!-- ====================================== SEMESTER 1 ================================ -->
<?php if($semester == 1 ):?>
    <table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Kelompok Penerima</th>
            <th colspan="2">RKA/RIT</th>
            <th colspan="2">Semester II <?= $thn_filter;?></th>
            <th colspan="2">Semester I <?= $thn; ?></th>
            <th colspan="2">% Capaian Semester II</th>
            <th colspan="2">% Kenaikan/Penurunan Semester I</th>
        </tr>
        <tr>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
        <?php if(isset($data_kelompok) && is_array($data_kelompok)):?>
        <?php foreach($data_kelompok as $kelompok):?>
            <tr>
                <td><?= $no++;?></td>
                <td style="text-align: left;"><?=$kelompok['kelompok_penerima']?></td>
                <td style="text-align: right;"><?=($kelompok['rka_penerima'] != 0 ) ? rupiah($kelompok['rka_penerima']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['rka_pembayaran'] != 0 ) ? rupiah($kelompok['rka_pembayaran']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_penerima_smt2'] != 0 ) ? rupiah($kelompok['jml_penerima_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_pembayaran_smt2'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_penerima_smt1'] != 0 ) ? rupiah($kelompok['jml_penerima_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['jml_pembayaran_smt1'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_penerimaan'] != 0 ) ? persen($kelompok['pers_penerimaan']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_pembayaran'] != 0 ) ? persen($kelompok['pers_pembayaran']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_kenaikan_penerima'] != 0 ) ? persen($kelompok['pers_kenaikan_penerima']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($kelompok['pers_kenaikan_pembayaran'] != 0 ) ? persen($kelompok['pers_kenaikan_pembayaran']).'%' : '-';?></td>

            </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<pagebreak></pagebreak>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Pembayaran Pensiun AIP (Jenis Penerima)
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2" width="20">No</th>
            <th rowspan="2">Jenis Penerima</th>
            <th colspan="2">RKA/RIT</th>
            <th colspan="2">Semester II <?= $thn_filter;?></th>
            <th colspan="2">Semester I <?= $thn; ?></th>
            <th colspan="2">% Capaian Semester II</th>
            <th colspan="2">% Kenaikan/Penurunan Semester I</th>
        </tr>
        <tr>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
            <th>Jumlah Penerima</th>
            <th>Jumlah Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; ?>
        <?php if(isset($data_jenis) && is_array($data_jenis)):?>
        <?php foreach($data_jenis as $jenis):?>
            <tr>
                <td><?= $no++;?></td>
                <td style="text-align: left;"><?=$jenis['jenis_penerima']?></td>
                <td style="text-align: right;"><?=($jenis['rka_penerima'] != 0 ) ? rupiah($jenis['rka_penerima']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['rka_pembayaran'] != 0 ) ? rupiah($jenis['rka_pembayaran']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_penerima_smt2'] != 0 ) ? rupiah($jenis['jml_penerima_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_pembayaran_smt2'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt2']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_penerima_smt1'] != 0 ) ? rupiah($jenis['jml_penerima_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['jml_pembayaran_smt1'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt1']) : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_penerimaan'] != 0 ) ? persen($jenis['pers_penerimaan']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_pembayaran'] != 0 ) ? persen($jenis['pers_pembayaran']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_kenaikan_penerima'] != 0 ) ? persen($jenis['pers_kenaikan_penerima']).'%' : '-';?></td>
                <td style="text-align: right;"><?=($jenis['pers_kenaikan_pembayaran'] != 0 ) ? persen($jenis['pers_kenaikan_pembayaran']).'%' : '-';?></td>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<?php endif;?>


<!-- <br> -->
<!-- data keterangan  -->
<!-- <div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_hasil_investasi_ket[0]->keterangan_lap) ? $data_hasil_investasi_ket[0]->keterangan_lap : '');?></p>
</div> -->
<!-- end keterangan -->