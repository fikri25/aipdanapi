<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    Hasil Investasi - <?php echo (isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '');?>
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px">
    <thead>
        <tr>
            <th width="10">No</th>
            <th width="30%">Jenis Investasi</th>
            <th>RIT</th>
            <th>Saldo Awal</th>
            <th>Mutasi</th>
            <th>Saldo Akhir</th>
            <th width="8%">(%) Realisasi RIT</th>
            <th width="8%">(%) Target YOI</th>
        </tr>

    </thead>
    <tbody>
        <?php $no=1; ?>
        <?php if(isset($data_hasil_investasi) && is_array($data_hasil_investasi)):?>
        <?php foreach($data_hasil_investasi as $hasil):?>
            <?php if($hasil['type'] == 'P'):?>
                <tr class="cek">
                    <td><?= $no++;?></td>
                    <td style="text-align: left;"><?=$hasil['jenis_investasi']?></td>
                    <td style="text-align: right;"><?=($hasil['rka'] != 0 ) ? rupiah($hasil['rka']) : '-';?></td>
                    <td style="text-align: right;"><?=($hasil['saldo_awal'] != 0 ) ? rupiah($hasil['saldo_awal']) : '-';?></td>
                    <td style="text-align: right;"><?=($hasil['mutasi'] != 0 ) ? rupiah($hasil['mutasi']) : '-';?></td>
                    <td style="text-align: right;"><?=($hasil['saldo_akhir'] != 0 ) ? rupiah($hasil['saldo_akhir']) : '-';?></td>
                    <td style="text-align: right;"><?=($hasil['realisasi_rka'] != 0 ) ? persen($hasil['realisasi_rka']) : '-';?></td>
                    <td style="text-align: right;"><?=($hasil['target_yoi'] != 0 ) ? persen($hasil['target_yoi']) : '-';?></td>
                </tr>
            <?php endif;?>
            <?php foreach($hasil['child'] as $child):?>
                <?php if($child['type'] == 'PC'):?>
                    <tr>
                        <td><?= $no++;?></td>
                        <td style="text-align: left;"><?=$child['jenis_investasi']?></td>
                        <td style="text-align: right;"><?=($child['rka'] != 0 ) ? rupiah($child['rka']) : '-';?></td>
                        <td style="text-align: right;"><?=($child['saldo_awal'] != 0 ) ? rupiah($child['saldo_awal']) : '-';?></td>
                        <td style="text-align: right;"><?=($child['mutasi'] != 0 ) ? rupiah($child['mutasi']) : '-';?></td>
                        <td style="text-align: right;"><?=($child['saldo_akhir'] != 0 ) ? rupiah($child['saldo_akhir']) : '-';?></td>
                        <td style="text-align: right;"><?=($child['realisasi_rka'] != 0 ) ? persen($child['realisasi_rka']) : '-';?></td>
                        <td style="text-align: right;"><?=($child['target_yoi'] != 0 ) ? persen($child['target_yoi']) : '-';?></td>
                    </tr>
                <?php endif;?>
                <?php foreach($child['subchild'] as $subchild):?>
                    <tr>
                        <td><?= $no++;?></td>
                        <td style="text-align: left; padding-left:30px;color: #6c7275;"><?='- '.$subchild['jenis_investasi']?></td>
                        <td style="text-align: right;"><?=($subchild['rka'] != 0 ) ? rupiah($subchild['rka']) : '-';?></td>
                        <td style="text-align: right;"><?=($subchild['saldo_awal'] != 0 ) ? rupiah($subchild['saldo_awal']) : '-';?></td>
                        <td style="text-align: right;"><?=($subchild['mutasi'] != 0 ) ? rupiah($subchild['mutasi']) : '-';?></td>
                        <td style="text-align: right;"><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
                        <td style="text-align: right;"><?=($subchild['realisasi_rka'] != 0 ) ? persen($subchild['realisasi_rka']) : '-';?></td>
                        <td style="text-align: right;"><?=($subchild['target_yoi'] != 0 ) ? persen($subchild['target_yoi']) : '-';?></td>
                        
                    </tr>
                <?php endforeach;?>
            <?php endforeach;?>
        <?php endforeach;?>
    <?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
    <td></td>
    <td>Total</td>
    <td style="text-align: right;"><?=($sum['rka'] != 0 ) ? rupiah($sum['rka']) : '-';?></td>
    <td style="text-align: right;"><?=($sum['saldo_awal'] != 0 ) ? rupiah($sum['saldo_awal']) : '-';?></td>
    <td style="text-align: right;"><?=($sum['mutasi'] != 0 ) ? rupiah($sum['mutasi']) : '-';?></td>
    <td style="text-align: right;"><?=($sum['saldo_akhir'] != 0 ) ? rupiah($sum['saldo_akhir']) : '-';?></td>
    <td></td>
    <td></td>
</tr>    
</table>
<br>
<!-- data keterangan  -->
<div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_hasil_investasi_ket[0]->keterangan_lap) ? $data_hasil_investasi_ket[0]->keterangan_lap : '');?></p>
</div>
<!-- end keterangan -->