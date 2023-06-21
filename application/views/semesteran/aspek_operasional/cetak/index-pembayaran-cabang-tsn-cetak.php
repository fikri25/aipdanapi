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
            <th colspan="10">Semester I <?= $thn; ?></th>
            <th colspan="10">Semester II <?= $thn_filter;?></th>
        </tr>
        <tr>
            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
            <th>Jumlah</th>

            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
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
                    <td style="text-align: right;"><?=($child['pns_pusat_bayar_1'] != 0 ) ? rupiah($child['pns_pusat_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_bayar_1'] != 0 ) ? rupiah($child['pns_do_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_bayar_1'] != 0 ) ? rupiah($child['pejabat_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_bayar_1'] != 0 ) ? rupiah($child['hakim_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_bayar_1'] != 0 ) ? rupiah($child['pkri_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_bayar_1'] != 0 ) ? rupiah($child['veteran_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_bayar_1'] != 0 ) ? rupiah($child['tni_polri_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_bayar_1'] != 0 ) ? rupiah($child['pegadaian_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_bayar_1'] != 0 ) ? rupiah($child['dana_kehormatan_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_1_tsn'] != 0 ) ? rupiah($child['jumlah_smt_1_tsn']) : '-';?></td>
                    
                    <td style="text-align: right;"><?=($child['pns_pusat_bayar_2'] != 0 ) ? rupiah($child['pns_pusat_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_bayar_2'] != 0 ) ? rupiah($child['pns_do_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_bayar_2'] != 0 ) ? rupiah($child['pejabat_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_bayar_2'] != 0 ) ? rupiah($child['hakim_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_bayar_2'] != 0 ) ? rupiah($child['pkri_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_bayar_2'] != 0 ) ? rupiah($child['veteran_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_bayar_2'] != 0 ) ? rupiah($child['tni_polri_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_bayar_2'] != 0 ) ? rupiah($child['pegadaian_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_bayar_2'] != 0 ) ? rupiah($child['dana_kehormatan_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_2_tsn'] != 0 ) ? rupiah($child['jumlah_smt_2_tsn']) : '-';?></td>

                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$bayar['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($bayar['pns_pusat_bayar_1'] != 0 ) ? rupiah($bayar['pns_pusat_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pns_do_bayar_1'] != 0 ) ? rupiah($bayar['pns_do_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pejabat_bayar_1'] != 0 ) ? rupiah($bayar['pejabat_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['hakim_bayar_1'] != 0 ) ? rupiah($bayar['hakim_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pkri_bayar_1'] != 0 ) ? rupiah($bayar['pkri_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['veteran_bayar_1'] != 0 ) ? rupiah($bayar['veteran_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['tni_polri_bayar_1'] != 0 ) ? rupiah($bayar['tni_polri_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pegadaian_bayar_1'] != 0 ) ? rupiah($bayar['pegadaian_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['dana_kehormatan_bayar_1'] != 0 ) ? rupiah($bayar['dana_kehormatan_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['jumlah_smt_1_tsn'] != 0 ) ? rupiah($bayar['jumlah_smt_1_tsn']) : '-';?></td>

                <td style="text-align: right;"><?=($bayar['pns_pusat_bayar_2'] != 0 ) ? rupiah($bayar['pns_pusat_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pns_do_bayar_2'] != 0 ) ? rupiah($bayar['pns_do_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pejabat_bayar_2'] != 0 ) ? rupiah($bayar['pejabat_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['hakim_bayar_2'] != 0 ) ? rupiah($bayar['hakim_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pkri_bayar_2'] != 0 ) ? rupiah($bayar['pkri_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['veteran_bayar_2'] != 0 ) ? rupiah($bayar['veteran_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['tni_polri_bayar_2'] != 0 ) ? rupiah($bayar['tni_polri_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pegadaian_bayar_2'] != 0 ) ? rupiah($bayar['pegadaian_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['dana_kehormatan_bayar_2'] != 0 ) ? rupiah($bayar['dana_kehormatan_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['jumlah_smt_2_tsn'] != 0 ) ? rupiah($bayar['jumlah_smt_2_tsn']) : '-';?></td>
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
            <th colspan="10">Semester I <?= $thn; ?></th>
            <th colspan="10">Semester II <?= $thn_filter;?></th>
        </tr>
        <tr>
            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
            <th>Jumlah</th>

            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
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
                    <td style="text-align: right;"><?=($child['pns_pusat_terima_1'] != 0 ) ? rupiah($child['pns_pusat_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_terima_1'] != 0 ) ? rupiah($child['pns_do_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_terima_1'] != 0 ) ? rupiah($child['pejabat_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_terima_1'] != 0 ) ? rupiah($child['hakim_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_terima_1'] != 0 ) ? rupiah($child['pkri_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_terima_1'] != 0 ) ? rupiah($child['veteran_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_terima_1'] != 0 ) ? rupiah($child['tni_polri_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_terima_1'] != 0 ) ? rupiah($child['pegadaian_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_terima_1'] != 0 ) ? rupiah($child['dana_kehormatan_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_1_tsn'] != 0 ) ? rupiah($child['jumlah_smt_1_tsn']) : '-';?></td>

                    <td style="text-align: right;"><?=($child['pns_pusat_terima_2'] != 0 ) ? rupiah($child['pns_pusat_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_terima_2'] != 0 ) ? rupiah($child['pns_do_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_terima_2'] != 0 ) ? rupiah($child['pejabat_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_terima_2'] != 0 ) ? rupiah($child['hakim_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_terima_2'] != 0 ) ? rupiah($child['pkri_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_terima_2'] != 0 ) ? rupiah($child['veteran_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_terima_2'] != 0 ) ? rupiah($child['tni_polri_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_terima_2'] != 0 ) ? rupiah($child['pegadaian_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_terima_2'] != 0 ) ? rupiah($child['dana_kehormatan_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_2_tsn'] != 0 ) ? rupiah($child['jumlah_smt_2_tsn']) : '-';?></td>

                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($terima['pns_pusat_terima_1'] != 0 ) ? rupiah($terima['pns_pusat_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pns_do_terima_1'] != 0 ) ? rupiah($terima['pns_do_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pejabat_terima_1'] != 0 ) ? rupiah($terima['pejabat_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['hakim_terima_1'] != 0 ) ? rupiah($terima['hakim_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pkri_terima_1'] != 0 ) ? rupiah($terima['pkri_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['veteran_terima_1'] != 0 ) ? rupiah($terima['veteran_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['tni_polri_terima_1'] != 0 ) ? rupiah($terima['tni_polri_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pegadaian_terima_1'] != 0 ) ? rupiah($terima['pegadaian_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['dana_kehormatan_terima_1'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['jumlah_smt_1_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_1_tsn']) : '-';?></td>

                <td style="text-align: right;"><?=($terima['pns_pusat_terima_2'] != 0 ) ? rupiah($terima['pns_pusat_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pns_do_terima_2'] != 0 ) ? rupiah($terima['pns_do_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pejabat_terima_2'] != 0 ) ? rupiah($terima['pejabat_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['hakim_terima_2'] != 0 ) ? rupiah($terima['hakim_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pkri_terima_2'] != 0 ) ? rupiah($terima['pkri_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['veteran_terima_2'] != 0 ) ? rupiah($terima['veteran_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['tni_polri_terima_2'] != 0 ) ? rupiah($terima['tni_polri_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pegadaian_terima_2'] != 0 ) ? rupiah($terima['pegadaian_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['dana_kehormatan_terima_2'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['jumlah_smt_2_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_2_tsn']) : '-';?></td>

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
            <th colspan="10">Semester II <?= $thn_filter;?></th>
            <th colspan="10">Semester I <?= $thn; ?></th>
        </tr>
        <tr>
            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
            <th>Jumlah</th>

            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
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
                    <td style="text-align: right;"><?=($child['pns_pusat_bayar_2'] != 0 ) ? rupiah($child['pns_pusat_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_bayar_2'] != 0 ) ? rupiah($child['pns_do_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_bayar_2'] != 0 ) ? rupiah($child['pejabat_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_bayar_2'] != 0 ) ? rupiah($child['hakim_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_bayar_2'] != 0 ) ? rupiah($child['pkri_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_bayar_2'] != 0 ) ? rupiah($child['veteran_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_bayar_2'] != 0 ) ? rupiah($child['tni_polri_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_bayar_2'] != 0 ) ? rupiah($child['pegadaian_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_bayar_2'] != 0 ) ? rupiah($child['dana_kehormatan_bayar_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_2_tsn'] != 0 ) ? rupiah($child['jumlah_smt_2_tsn']) : '-';?></td>

                    <td style="text-align: right;"><?=($child['pns_pusat_bayar_1'] != 0 ) ? rupiah($child['pns_pusat_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_bayar_1'] != 0 ) ? rupiah($child['pns_do_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_bayar_1'] != 0 ) ? rupiah($child['pejabat_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_bayar_1'] != 0 ) ? rupiah($child['hakim_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_bayar_1'] != 0 ) ? rupiah($child['pkri_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_bayar_1'] != 0 ) ? rupiah($child['veteran_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_bayar_1'] != 0 ) ? rupiah($child['tni_polri_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_bayar_1'] != 0 ) ? rupiah($child['pegadaian_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_bayar_1'] != 0 ) ? rupiah($child['dana_kehormatan_bayar_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_1_tsn'] != 0 ) ? rupiah($child['jumlah_smt_1_tsn']) : '-';?></td>
                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$bayar['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($bayar['pns_pusat_bayar_2'] != 0 ) ? rupiah($bayar['pns_pusat_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pns_do_bayar_2'] != 0 ) ? rupiah($bayar['pns_do_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pejabat_bayar_2'] != 0 ) ? rupiah($bayar['pejabat_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['hakim_bayar_2'] != 0 ) ? rupiah($bayar['hakim_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pkri_bayar_2'] != 0 ) ? rupiah($bayar['pkri_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['veteran_bayar_2'] != 0 ) ? rupiah($bayar['veteran_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['tni_polri_bayar_2'] != 0 ) ? rupiah($bayar['tni_polri_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pegadaian_bayar_2'] != 0 ) ? rupiah($bayar['pegadaian_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['dana_kehormatan_bayar_2'] != 0 ) ? rupiah($bayar['dana_kehormatan_bayar_2']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['jumlah_smt_2_tsn'] != 0 ) ? rupiah($bayar['jumlah_smt_2_tsn']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pns_pusat_bayar_1'] != 0 ) ? rupiah($bayar['pns_pusat_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pns_do_bayar_1'] != 0 ) ? rupiah($bayar['pns_do_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pejabat_bayar_1'] != 0 ) ? rupiah($bayar['pejabat_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['hakim_bayar_1'] != 0 ) ? rupiah($bayar['hakim_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pkri_bayar_1'] != 0 ) ? rupiah($bayar['pkri_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['veteran_bayar_1'] != 0 ) ? rupiah($bayar['veteran_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['tni_polri_bayar_1'] != 0 ) ? rupiah($bayar['tni_polri_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['pegadaian_bayar_1'] != 0 ) ? rupiah($bayar['pegadaian_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['dana_kehormatan_bayar_1'] != 0 ) ? rupiah($bayar['dana_kehormatan_bayar_1']) : '-';?></td>
                <td style="text-align: right;"><?=($bayar['jumlah_smt_1_tsn'] != 0 ) ? rupiah($bayar['jumlah_smt_1_tsn']) : '-';?></td>
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
            <th colspan="10">Semester II <?= $thn_filter;?></th>
            <th colspan="10">Semester I <?= $thn; ?></th>
        </tr>
        <tr>
            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
            <th>Jumlah</th>

            <th>PNS Pusat</th>
            <th>PNS DO</th>
            <th>Pejabat Negara</th>
            <th>Hakim</th>
            <th>PKRI/KNIP</th>
            <th>Veteran</th>
            <th>TNI/Polri</th>
            <th>Pegadaian</th>
            <th>Dana Kehormatan</th>
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
                    <td style="text-align: right;"><?=($child['pns_pusat_terima_2'] != 0 ) ? rupiah($child['pns_pusat_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_terima_2'] != 0 ) ? rupiah($child['pns_do_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_terima_2'] != 0 ) ? rupiah($child['pejabat_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_terima_2'] != 0 ) ? rupiah($child['hakim_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_terima_2'] != 0 ) ? rupiah($child['pkri_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_terima_2'] != 0 ) ? rupiah($child['veteran_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_terima_2'] != 0 ) ? rupiah($child['tni_polri_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_terima_2'] != 0 ) ? rupiah($child['pegadaian_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_terima_2'] != 0 ) ? rupiah($child['dana_kehormatan_terima_2']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_2_tsn'] != 0 ) ? rupiah($child['jumlah_smt_2_tsn']) : '-';?></td>

                    <td style="text-align: right;"><?=($child['pns_pusat_terima_1'] != 0 ) ? rupiah($child['pns_pusat_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pns_do_terima_1'] != 0 ) ? rupiah($child['pns_do_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pejabat_terima_1'] != 0 ) ? rupiah($child['pejabat_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['hakim_terima_1'] != 0 ) ? rupiah($child['hakim_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pkri_terima_1'] != 0 ) ? rupiah($child['pkri_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['veteran_terima_1'] != 0 ) ? rupiah($child['veteran_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['tni_polri_terima_1'] != 0 ) ? rupiah($child['tni_polri_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['pegadaian_terima_1'] != 0 ) ? rupiah($child['pegadaian_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['dana_kehormatan_terima_1'] != 0 ) ? rupiah($child['dana_kehormatan_terima_1']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['jumlah_smt_1_tsn'] != 0 ) ? rupiah($child['jumlah_smt_1_tsn']) : '-';?></td>
                </tr>
            <?php endforeach;?>
            <tr style="background-color:#d2ebf9;font-weight: bold;">
                <td></td>
                <td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>
                <td style="text-align: right;"><?=($terima['pns_pusat_terima_2'] != 0 ) ? rupiah($terima['pns_pusat_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pns_do_terima_2'] != 0 ) ? rupiah($terima['pns_do_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pejabat_terima_2'] != 0 ) ? rupiah($terima['pejabat_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['hakim_terima_2'] != 0 ) ? rupiah($terima['hakim_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pkri_terima_2'] != 0 ) ? rupiah($terima['pkri_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['veteran_terima_2'] != 0 ) ? rupiah($terima['veteran_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['tni_polri_terima_2'] != 0 ) ? rupiah($terima['tni_polri_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pegadaian_terima_2'] != 0 ) ? rupiah($terima['pegadaian_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['dana_kehormatan_terima_2'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_2']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['jumlah_smt_2_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_2_tsn']) : '-';?></td>

                <td style="text-align: right;"><?=($terima['pns_pusat_terima_1'] != 0 ) ? rupiah($terima['pns_pusat_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pns_do_terima_1'] != 0 ) ? rupiah($terima['pns_do_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pejabat_terima_1'] != 0 ) ? rupiah($terima['pejabat_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['hakim_terima_1'] != 0 ) ? rupiah($terima['hakim_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pkri_terima_1'] != 0 ) ? rupiah($terima['pkri_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['veteran_terima_1'] != 0 ) ? rupiah($terima['veteran_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['tni_polri_terima_1'] != 0 ) ? rupiah($terima['tni_polri_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['pegadaian_terima_1'] != 0 ) ? rupiah($terima['pegadaian_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['dana_kehormatan_terima_1'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_1']) : '-';?></td>
                <td style="text-align: right;"><?=($terima['jumlah_smt_1_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_1_tsn']) : '-';?></td>
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