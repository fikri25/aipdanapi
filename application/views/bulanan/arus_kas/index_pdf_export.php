<?php
    $level = $this->session->userdata('level');
    $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:5px;margin-bottom:5px;font-weight: bold; text-align: center">     
  <?php
    if ($level == "DJA") {
        if ($iduser == 'TSN002') {
            $judul= "PT TASPEN (PERSERO)";
        }else{
            $judul= "PT ASABRI (PERSERO)";
        }
    }else if ($level == "TASPEN") {
        $judul= "PT TASPEN (PERSERO)";
    }else if ($level == "ASABRI") {
        $judul= "PT ASABRI (PERSERO)";
    }

    echo $judul;
  ?>
</p>
<p style="margin-left:0px;margin-top:5px;margin-bottom:5px;font-weight: bold; text-align: center">     
   LAPORAN ARUS KAS
</p>
<p style="margin-left:0px;margin-top:5px;margin-bottom:5px;font-weight: bold; text-align: center">     
   AKUMULASI IURAN PENSIUN
</p>
<p style="margin-left:0px;margin-top:5px;margin-bottom:15px;font-weight: bold; text-align: center"> 
    PER <?php echo strtoupper(isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '');?>&nbsp;<?= $tahun;?>
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px">
    <thead>
        <tr>
            <th width="40%">URAIAN</th>
            <th width="27%">Data Akhir Periode Bulan Lalu</th>
            <th width="27%">Data Akhir Periode &nbsp;<?=$bulan[0]->nama_bulan?></th>
            <!-- <th width="6%">Action</th> -->
        </tr>

    </thead>
    <tbody>
        <?php
        $totkas = 0;
        $totkasprev = 0;
        ?>
        <?php if(isset($arus_kas) && is_array($arus_kas)):?>
        <?php foreach($arus_kas as $kas):?>
            <tr style="font-weight: bold; background-color:#c1e1f3;">
                <td style="text-align: left;" colspan="3"><?=$kas['judul_kas']?></td>
            </tr>
            <?php foreach($kas['child'] as $child):?>
                <tr>
                    <td style="text-align: left;padding-left: 35px"><?=$child['arus_kas']?></td>
                    <?php foreach($child['subchild'] as $subchl):?>
                        <td style="text-align: right;"><?=($subchl['saldo_bulan_lalu'] != 0 ) ? rupiah($subchl['saldo_bulan_lalu']) : '-';?></td>
                        <td style="text-align: right;"><?=($subchl['saldo_bulan_berjalan'] != 0 ) ? rupiah($subchl['saldo_bulan_berjalan']) : '-';?></td>
                        <!-- <td style="text-align: right;"></td> -->
                    <?php endforeach;?>
                </tr>
            <?php endforeach;?>
            <tr style="font-weight: bold; background-color:#e6f5fe;">
                <td style="text-align: left;"><?=$kas['judul']?></td>
                <td style="text-align: right;"><?=($kas['sumprev'] != 0 ) ? rupiah($kas['sumprev']) : '-';?></td>
                <td style="text-align: right;"><?=($kas['sum'] != 0 ) ? rupiah($kas['sum']) : '-';?></td>
            </tr>
            <?php
            $totkas += $kas['sum'];
            $totkasprev += $kas['sumprev'];
            ?>

        <?php endforeach;?>
        <?php endif;?>
        <?php
        // $kas_bank = (isset($kas_bank['saldo_akhir']) ? $kas_bank['saldo_akhir'] : 0) ;
        // $kas_akhir2 = $kas_bank+$totkasprev;
        // $kas_akhir1 = $totkas+$kas_akhir2;

        ?>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
            <td style="text-align: left;">KENAIKAN (PENURUNAN) KAS dan BANK</td>
            <td style="text-align: right;"><?=($totkasprev != 0 ) ? rupiah($totkasprev) : '-';?></td>
            <td style="text-align: right;"><?=($totkas != 0 ) ? rupiah($totkas) : '-';?></td>
            <!-- <td style="text-align: left;"></td> -->
        </tr>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
            <td style="text-align: left;">KAS DAN BANK PADA AWAL BULAN</td>
            <td style="text-align: right;"><?= (isset($kas_bank['saldo_awal_bln_lalu']) ?  rupiah($kas_bank['saldo_awal_bln_lalu']) : '-');?></td>
            <td style="text-align: right;"><?= (isset($kas_bank['saldo_awal']) ?  rupiah($kas_bank['saldo_awal']) : '-');?></td>
            <!-- <td style="text-align: left;"></td> -->
        </tr>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
            <td style="text-align: left;">KAS DAN BANK PADA AKHIR BULAN</td>
            <td style="text-align: right;"><?= (isset($kas_bank['saldo_akhir_bln_lalu']) ?  rupiah($kas_bank['saldo_akhir_bln_lalu']) : '-');?></td>
            <td style="text-align: right;"><?= (isset($kas_bank['saldo_akhir']) ?  rupiah($kas_bank['saldo_akhir']) : '-');?></td>
            <!-- <td style="text-align: left;"></td> -->
        </tr>

    </tbody>
</table>
<br>
<!-- data keterangan  -->
<div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_arus_kas_ket[0]->keterangan_lap) ? $data_arus_kas_ket[0]->keterangan_lap : '');?></p>
</div>
<!-- end keterangan -->