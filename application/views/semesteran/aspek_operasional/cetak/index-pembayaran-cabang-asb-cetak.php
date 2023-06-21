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
    a) Pembayaran Pensiun AIP (Cabang)
</p>

<!-- ======================================= SEMESTER 2 ================================ -->
<?php if($semester == 2 || $semester == ""):?>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2">Kantor Cabang</th>
            <th rowspan="2">Jenis Penerima Manfaat</th>
            <th colspan="5">Semester I <?= $thn; ?></th>
            <th colspan="5">Semester II <?= $thn_filter;?></th>
        </tr>
        <tr>
            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>

            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($data_cabang_bayar) && is_array($data_cabang_bayar)):?>
        <?php foreach($data_cabang_bayar as $bayar):?>
            <?php foreach($bayar['child'] as $child):?>
                <tr>
                    <td style="text-align: left;"><?=$bayar['nama_cabang']?></td>
                    <td style="text-align: left;"><?=$child['jenis_penerima']?></td>
                    <td style="text-align: right;"><?=($child['prajurit_tni_bayar_1'] != 0 ) ? rupiah($child['prajurit_tni_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_bayar_1'] != 0 ) ? rupiah($child['anggota_polri_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_bayar_1'] != 0 ) ? rupiah($child['asn_kemhan_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_bayar_1'] != 0 ) ? rupiah($child['asn_polri_bayar_1']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_1_asb'] != 0 ) ? rupiah($child['jumlah_smt_1_asb']) : '-';?></td>

                    <td style="text-align: right;"><?=($child['prajurit_tni_bayar_2'] != 0 ) ? rupiah($child['prajurit_tni_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_bayar_2'] != 0 ) ? rupiah($child['anggota_polri_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_bayar_2'] != 0 ) ? rupiah($child['asn_kemhan_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_bayar_2'] != 0 ) ? rupiah($child['asn_polri_bayar_2']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_2_asb'] != 0 ) ? rupiah($child['jumlah_smt_2_asb']) : '-';?></td>

                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$bayar['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($bayar['prajurit_tni_bayar_1'] != 0 ) ? rupiah($bayar['prajurit_tni_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['anggota_polri_bayar_1'] != 0 ) ? rupiah($bayar['anggota_polri_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_kemhan_bayar_1'] != 0 ) ? rupiah($bayar['asn_kemhan_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_polri_bayar_1'] != 0 ) ? rupiah($bayar['asn_polri_bayar_1']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($bayar['jumlah_smt_1_asb'] != 0 ) ? rupiah($bayar['jumlah_smt_1_asb']) : '-';?></td>

                <td style="text-align: right;"><?=($bayar['prajurit_tni_bayar_2'] != 0 ) ? rupiah($bayar['prajurit_tni_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['anggota_polri_bayar_2'] != 0 ) ? rupiah($bayar['anggota_polri_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_kemhan_bayar_2'] != 0 ) ? rupiah($bayar['asn_kemhan_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_polri_bayar_2'] != 0 ) ? rupiah($bayar['asn_polri_bayar_2']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($bayar['jumlah_smt_2_asb'] != 0 ) ? rupiah($bayar['jumlah_smt_2_asb']) : '-';?></td>

            </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<pagebreak></pagebreak>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Penerimaan Pensiun AIP (Cabang)
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2">Kantor Cabang</th>
            <th rowspan="2">Jenis Penerima Manfaat</th>
            <th colspan="5">Semester I <?= $thn; ?></th>
            <th colspan="5">Semester II <?= $thn_filter;?></th>
        </tr>
        <tr>
            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>

            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($data_cabang_terima) && is_array($data_cabang_terima)):?>
        <?php foreach($data_cabang_terima as $terima):?>
            <?php foreach($terima['child'] as $child):?>
                <tr>
                    <td style="text-align: left;"><?=$terima['nama_cabang']?></td>
                    <td style="text-align: left;"><?=$child['jenis_penerima']?></td>
                    <td style="text-align: right;"><?=($child['prajurit_tni_terima_1'] != 0 ) ? rupiah($child['prajurit_tni_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_terima_1'] != 0 ) ? rupiah($child['anggota_polri_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_terima_1'] != 0 ) ? rupiah($child['asn_kemhan_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_terima_1'] != 0 ) ? rupiah($child['asn_polri_terima_1']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_1_asb'] != 0 ) ? rupiah($child['jumlah_smt_1_asb']) : '-';?></td>

                    <td style="text-align: right;"><?=($child['prajurit_tni_terima_2'] != 0 ) ? rupiah($child['prajurit_tni_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_terima_2'] != 0 ) ? rupiah($child['anggota_polri_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_terima_2'] != 0 ) ? rupiah($child['asn_kemhan_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_terima_2'] != 0 ) ? rupiah($child['asn_polri_terima_2']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_2_asb'] != 0 ) ? rupiah($child['jumlah_smt_2_asb']) : '-';?></td>

                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($terima['prajurit_tni_terima_1'] != 0 ) ? rupiah($terima['prajurit_tni_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['anggota_polri_terima_1'] != 0 ) ? rupiah($terima['anggota_polri_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_kemhan_terima_1'] != 0 ) ? rupiah($terima['asn_kemhan_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_polri_terima_1'] != 0 ) ? rupiah($terima['asn_polri_terima_1']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($terima['jumlah_smt_1_asb'] != 0 ) ? rupiah($terima['jumlah_smt_1_asb']) : '-';?></td>

                <td style="text-align: right;"><?=($terima['prajurit_tni_terima_2'] != 0 ) ? rupiah($terima['prajurit_tni_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['anggota_polri_terima_2'] != 0 ) ? rupiah($terima['anggota_polri_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_kemhan_terima_2'] != 0 ) ? rupiah($terima['asn_kemhan_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_polri_terima_2'] != 0 ) ? rupiah($terima['asn_polri_terima_2']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($terima['jumlah_smt_2_asb'] != 0 ) ? rupiah($terima['jumlah_smt_2_asb']) : '-';?></td>

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
            <th rowspan="2">Kantor Cabang</th>
            <th rowspan="2">Jenis Penerima Manfaat</th>
            <th colspan="5">Semester II <?= $thn_filter;?></th>
            <th colspan="5">Semester I <?= $thn; ?></th>
        </tr>
        <tr>
            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>

            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($data_cabang_bayar) && is_array($data_cabang_bayar)):?>
        <?php foreach($data_cabang_bayar as $bayar):?>
            <?php foreach($bayar['child'] as $child):?>
                <tr>
                    <td style="text-align: left;"><?=$bayar['nama_cabang']?></td>
                    <td style="text-align: left;"><?=$child['jenis_penerima']?></td>
                    <td style="text-align: right;"><?=($child['prajurit_tni_bayar_2'] != 0 ) ? rupiah($child['prajurit_tni_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_bayar_2'] != 0 ) ? rupiah($child['anggota_polri_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_bayar_2'] != 0 ) ? rupiah($child['asn_kemhan_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_bayar_2'] != 0 ) ? rupiah($child['asn_polri_bayar_2']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_2_asb'] != 0 ) ? rupiah($child['jumlah_smt_2_asb']) : '-';?></td>

                    <td style="text-align: right;"><?=($child['prajurit_tni_bayar_1'] != 0 ) ? rupiah($child['prajurit_tni_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_bayar_1'] != 0 ) ? rupiah($child['anggota_polri_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_bayar_1'] != 0 ) ? rupiah($child['asn_kemhan_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_bayar_1'] != 0 ) ? rupiah($child['asn_polri_bayar_1']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_1_asb'] != 0 ) ? rupiah($child['jumlah_smt_1_asb']) : '-';?></td>
                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$bayar['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($bayar['prajurit_tni_bayar_2'] != 0 ) ? rupiah($bayar['prajurit_tni_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['anggota_polri_bayar_2'] != 0 ) ? rupiah($bayar['anggota_polri_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_kemhan_bayar_2'] != 0 ) ? rupiah($bayar['asn_kemhan_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_polri_bayar_2'] != 0 ) ? rupiah($bayar['asn_polri_bayar_2']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($bayar['jumlah_smt_2_asb'] != 0 ) ? rupiah($bayar['jumlah_smt_2_asb']) : '-';?></td>

                <td style="text-align: right;"><?=($bayar['prajurit_tni_bayar_1'] != 0 ) ? rupiah($bayar['prajurit_tni_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['anggota_polri_bayar_1'] != 0 ) ? rupiah($bayar['anggota_polri_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_kemhan_bayar_1'] != 0 ) ? rupiah($bayar['asn_kemhan_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['asn_polri_bayar_1'] != 0 ) ? rupiah($bayar['asn_polri_bayar_1']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($bayar['jumlah_smt_1_asb'] != 0 ) ? rupiah($bayar['jumlah_smt_1_asb']) : '-';?></td>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<pagebreak></pagebreak>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Penerimaan Pensiun AIP (Cabang)
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2">Kantor Cabang</th>
            <th rowspan="2">Jenis Penerima Manfaat</th>
            <th colspan="5">Semester II <?= $thn_filter;?></th>
            <th colspan="5">Semester I <?= $thn; ?></th>
        </tr>
        <tr>
            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>

            <th>Prajurit TNI</th>
            <th>Anggota POLR</th>
            <th>ASN KemHAN</th>
            <th>ASN POLRI</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($data_cabang_terima) && is_array($data_cabang_terima)):?>
        <?php foreach($data_cabang_terima as $terima):?>
            <?php foreach($terima['child'] as $child):?>
                <tr>
                    <td style="text-align: left;"><?=$terima['nama_cabang']?></td>
                    <td style="text-align: left;"><?=$child['jenis_penerima']?></td>
                    <td style="text-align: right;"><?=($child['prajurit_tni_terima_2'] != 0 ) ? rupiah($child['prajurit_tni_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_terima_2'] != 0 ) ? rupiah($child['anggota_polri_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_terima_2'] != 0 ) ? rupiah($child['asn_kemhan_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_terima_2'] != 0 ) ? rupiah($child['asn_polri_terima_2']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_2_asb'] != 0 ) ? rupiah($child['jumlah_smt_2_asb']) : '-';?></td>

                    <td style="text-align: right;"><?=($child['prajurit_tni_terima_1'] != 0 ) ? rupiah($child['prajurit_tni_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['anggota_polri_terima_1'] != 0 ) ? rupiah($child['anggota_polri_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_kemhan_terima_1'] != 0 ) ? rupiah($child['asn_kemhan_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['asn_polri_terima_1'] != 0 ) ? rupiah($child['asn_polri_terima_1']) : '-';?></td>
                    <td style="font-weight: bold; text-align: right;"><?=($child['jumlah_smt_1_asb'] != 0 ) ? rupiah($child['jumlah_smt_1_asb']) : '-';?></td>
                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($terima['prajurit_tni_terima_2'] != 0 ) ? rupiah($terima['prajurit_tni_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['anggota_polri_terima_2'] != 0 ) ? rupiah($terima['anggota_polri_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_kemhan_terima_2'] != 0 ) ? rupiah($terima['asn_kemhan_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_polri_terima_2'] != 0 ) ? rupiah($terima['asn_polri_terima_2']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($terima['jumlah_smt_2_asb'] != 0 ) ? rupiah($terima['jumlah_smt_2_asb']) : '-';?></td>

                <td style="text-align: right;"><?=($terima['prajurit_tni_terima_1'] != 0 ) ? rupiah($terima['prajurit_tni_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['anggota_polri_terima_1'] != 0 ) ? rupiah($terima['anggota_polri_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_kemhan_terima_1'] != 0 ) ? rupiah($terima['asn_kemhan_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['asn_polri_terima_1'] != 0 ) ? rupiah($terima['asn_polri_terima_1']) : '-';?></td>
                <td style="font-weight: bold; text-align: right;"><?=($terima['jumlah_smt_1_asb'] != 0 ) ? rupiah($terima['jumlah_smt_1_asb']) : '-';?></td>
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