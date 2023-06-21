<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    Aset Investasi - <?php echo (isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '');?>
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px">
    <thead>
		<tr style="background-color: #e5e5e5;">
            <th width="10">No</th>
            <th width="30%">Jenis Investasi</th>
            <th>RIT</th>
            <th>Saldo Awal</th>
            <th>Mutasi</th>
            <th>Saldo Akhir</th>
            <th width="8%">(%) Realisasi RIT</th>
		</tr>
	</thead>
    <tbody>
							
        <tbody>
            <?php $no=1; ?>
            <?php if(isset($data_invest) && is_array($data_invest)):?>
            <?php foreach($data_invest as $invest):?>
                <?php if($invest['type'] == 'P'):?>
                    <tr>
                        <td><?= $no++;?></td>
                        <td style="text-align: left;"><?=$invest['jenis_investasi']?></td>
                        <td style="text-align: right;"><?=($invest['rka'] != 0 ) ? rupiah($invest['rka']) : '-';?></td>
                        <td style="text-align: right;"><?=($invest['saldo_awal'] != 0 ) ? rupiah($invest['saldo_awal']) : '-';?></td>
                        <td style="text-align: right;"><?=($invest['mutasi'] != 0 ) ? rupiah($invest['mutasi']) : '-';?></td>
                        <td style="text-align: right;"><?=($invest['saldo_akhir'] != 0 ) ? rupiah($invest['saldo_akhir']) : '-';?></td>
                        <td style="text-align: right;"><?=($invest['realisasi_rka'] != 0 ) ? persen($invest['realisasi_rka']) : '-';?></td>
                    </tr>
                <?php endif;?>
                <?php foreach($invest['child'] as $child):?>
                    <?php if($child['type'] == 'PC'):?>
                        <tr>
                            <td><?= $no++;?></td>
                            <td style="text-align: left;"><?=$child['jenis_investasi']?></td>
                            <td style="text-align: right;"><?=($child['rka'] != 0 ) ? rupiah($child['rka']) : '-';?></td>
                            <td style="text-align: right;"><?=($child['saldo_awal'] != 0 ) ? rupiah($child['saldo_awal']) : '-';?></td>
                            <td style="text-align: right;"><?=($child['mutasi'] != 0 ) ? rupiah($child['mutasi']) : '-';?></td>
                            <td style="text-align: right;"><?=($child['saldo_akhir'] != 0 ) ? rupiah($child['saldo_akhir']) : '-';?></td>
                            <td style="text-align: right;"><?=($child['realisasi_rka'] != 0 ) ? persen($child['realisasi_rka']) : '-';?></td>
                        </tr>
                    <?php endif;?>
                    <?php foreach($child['subchild'] as $subchild):?>
                        <!-- <?php if($child['type'] == 'PC'):?> -->
                        <tr>
                            <td><?= $no++;?></td>
                            <td style="text-align: left; padding-left:30px;color: #6c7275;"><?='- '.$subchild['jenis_investasi']?></td>
                            <td style="text-align: right;"><?=($subchild['rka'] != 0 ) ? rupiah($subchild['rka']) : '-';?></td>
                            <td style="text-align: right;"><?=($subchild['saldo_awal'] != 0 ) ? rupiah($subchild['saldo_awal']) : '-';?></td>
                            <td style="text-align: right;"><?=($subchild['mutasi'] != 0 ) ? rupiah($subchild['mutasi']) : '-';?></td>
                            <td style="text-align: right;"><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
                            <td style="text-align: right;"><?=($subchild['realisasi_rka'] != 0 ) ? persen($subchild['realisasi_rka']) : '-';?></td>
                        </tr>
                        <!-- <?php endif;?> -->

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
    </tr>  
</table>
<br>
<!-- data keterangan  -->
<div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_posisi_investasi_ket[0]->keterangan_lap) ? $data_posisi_investasi_ket[0]->keterangan_lap : '');?></p>
</div>
<!-- end keterangan -->