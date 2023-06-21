<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
    Aspek Operasional
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    a) Nilai Beban
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;" width="100%">
    <thead>
        <tr>
            <th rowspan="2" width="30%">Beban Investasi</th>
            <th rowspan="2">Tahun <?= $tahun; ?></th>
            <th rowspan="2">Tahun <?= $tahun - 1; ?></th>
            <th colspan="2">Kenaikan/Penurunan</th>
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
                    <td style="text-align: right;"><?=($beban['saldo_akhir_thn'] != 0 ) ? rupiah($beban['saldo_akhir_thn']) : '-';?></td>
                    <td style="text-align: right;"><?=($beban['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($beban['saldo_akhir_thn_lalu']) : '-';?></td>
                    <td style="text-align: right;"><?=($beban['nominal'] != 0 ) ? rupiah($beban['nominal']) : '-';?></td>
                    <td style="text-align: right;"><?=($beban['persentase'] != 0 ) ? persen($beban['persentase']).'%' : '-';?></td>

                </tr>
            <?php endif;?>
            <?php if($beban['type'] == 'PC'):?>
                <tr>
                    <td style="text-align:left;"><?=$beban['jenis_investasi']?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif;?>
            <?php foreach($beban['child'] as $child):?>
                <tr>
                    <td style="text-align:left; padding-left: 30px; color: #6c7275;"><?='- '.$child['jenis_investasi']?></td>
                    <td style="text-align: right;"><?=($child['saldo_akhir_thn'] != 0 ) ? rupiah($child['saldo_akhir_thn']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($child['saldo_akhir_thn_lalu']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['nominal'] != 0 ) ? rupiah($child['nominal']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['persentase'] != 0 ) ? persen($child['persentase']).'%' : '-';?></td>
                </tr>

            <?php endforeach;?>
        <?php endforeach;?>
    <?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
    <td>Total</td>
    <td style="text-align: right;"><?=($sum['saldo_akhir_thn'] != 0 ) ? rupiah($sum['saldo_akhir_thn']) : '-';?></td>
    <td style="text-align: right;"><?=($sum['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($sum['saldo_akhir_thn_lalu']) : '-';?></td>
    <td></td>
    <td></td>
</tr>
</table>
<br>
<br>
<!-- <pagebreak></pagebreak> -->
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Imbal Jasa
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;" width="100%">
    <thead>
        <tr>
            <th rowspan="2" width="30%">Uraian</th>
            <th rowspan="2">Tahun <?= $tahun; ?></th>
            <th rowspan="2">Tahun <?= $tahun - 1; ?></th>
            <th colspan="2">Kenaikan/Penurunan</th>
        </tr>
        <tr>
            <th>Nominal</th>
            <th>Persentase</th>
        </tr>

    </thead>
    <tbody>
        <?php
        $netto_smt1 = 0;
        $netto_smt2 = 0;
        $fee_nom = 0;
        $fee_pers = 0;
        ?>
        <?php if(isset($imbal_jasa) && is_array($imbal_jasa)):?>
        <?php foreach($imbal_jasa as $imbal):?>
            <tr>
                <td style="text-align: left;"><?=$imbal['group']?></td>
                <td style="text-align: right;"><?=rupiah($imbal['saldo_akhir_thn']);?></td>
                <td style="text-align: right;"><?=rupiah($imbal['saldo_akhir_thn_lalu']);?></td>
                <td style="text-align: right;"><?=rupiah($imbal['nominal']);?></td>
                <td style="text-align: right;"><?=persen($imbal['persentase']);?>%</td>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
        <?php
        $imbal_jasa_smt2a = (isset($imbal_jasa[0]['saldo_akhir_thn_lalu']) ? $imbal_jasa[0]['saldo_akhir_thn_lalu'] : 0) ;
        $imbal_jasa_smt2b = (isset($imbal_jasa[1]['saldo_akhir_thn_lalu']) ? $imbal_jasa[1]['saldo_akhir_thn_lalu'] : 0) ;

        $imbal_jasa_smt1a = (isset($imbal_jasa[0]['saldo_akhir_thn']) ? $imbal_jasa[0]['saldo_akhir_thn'] : 0) ;
        $imbal_jasa_smt1b = (isset($imbal_jasa[1]['saldo_akhir_thn']) ? $imbal_jasa[1]['saldo_akhir_thn'] : 0) ;

        $netto_smt2= (($imbal_jasa_smt2a - $imbal_jasa_smt2b)*0.067);
        $netto_smt1= (($imbal_jasa_smt1a - $imbal_jasa_smt1b)*0.067);
        $fee_nom = $netto_smt2 - $netto_smt1;
        $fee_pers = ($netto_smt1!=0)?($fee_nom/$netto_smt1)*100:0;
        ?>
        <tr style="font-weight: bold;">
            <td style="text-align: left;">Fee 6,7%</td>
            <td style="text-align: right;"><?= rupiah($netto_smt1);?></td>
            <td style="text-align: right;"><?= rupiah($netto_smt2);?></td>
            <td style="text-align: right;"><?= rupiah($fee_nom);?></td>
            <td style="text-align: right;"><?= persen($fee_pers);?>%</td>
        </tr>
    </tbody>
</table>

<pagebreak></pagebreak>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    c) Kebijakan Alokasi
</p>
<br>
<p><?php echo (isset($data_kebijakan_ket_smt1[0]->keterangan_lap) ? $data_kebijakan_ket_smt1[0]->keterangan_lap : '');?></p>

<br>
<br>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    d) Jumlah Tenaga Kerja
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;" width="100%">
    <thead>
        <tr>
            <th rowspan="2" width="30%">Kantor Cabang</th>
            <th colspan="2">Penyelenggara Pensiun</th>
            <th colspan="2">Lainnya</th>
        </tr>
        <tr>
            <th>Jumlah</th>
            <th>% Persentase</th>
            <th>Jumlah</th>
            <th>% Persentase</th>
        </tr>

    </thead>
    <tbody>
        <?php if(isset($tenaga_kerja) && is_array($tenaga_kerja)):?>
        <?php foreach($tenaga_kerja as $data):?>
            <tr>
                <td style="text-align: left;"><?=$data['nama_cabang']?></td>
                <td style="text-align: right;"><?=rupiah($data['jml_penyelenggaraan']);?></td>
                <td style="text-align: right;"><?=rupiah($data['persen_penyelenggaraan']);?></td>
                <td style="text-align: right;"><?=rupiah($data['jml_lain']);?></td>
                <td style="text-align: right;"><?=rupiah($data['persen_lain']);?></td>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>


<!-- <br> -->
<!-- data keterangan  -->
<!-- <div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_hasil_investasi_ket[0]->keterangan_lap) ? $data_hasil_investasi_ket[0]->keterangan_lap : '');?></p>
</div> -->
<!-- end keterangan -->