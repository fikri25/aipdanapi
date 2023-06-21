<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    Bukan Investasi - <?php echo (isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '');?>
</p>
<table cellpadding="4px" cellspacing="0px" border="1" style="color:#000;background:#fff;font-size: 12px;" width="100%">
    <thead>
		<tr style="background-color: #e5e5e5;">
            <th width="9">No</th>
            <th>Jenis Investasi</th>
            <th>Saldo Awal</th>
            <th>Mutasi</th>
            <th>Saldo Akhir</th>
		</tr>
	</thead>
    <tbody>
       <?php $no=1; ?>
       <?php if(isset($data_bukan_investasi) && is_array($data_bukan_investasi)):?>
       <?php foreach($data_bukan_investasi as $invest):?>
        <?php if($invest['type'] == 'P'):?>
            <tr>
                <td><?= $no++;?></td>
                <td style="text-align: left;"><?=$invest['jenis_investasi']?></td>
                <td style="text-align: right;"><?=($invest['saldo_awal'] != 0 ) ? rupiah($invest['saldo_awal']) : '-';?></td>
                <td style="text-align: right;"><?=($invest['mutasi'] != 0 ) ? rupiah($invest['mutasi']) : '-';?></td>
                <td style="text-align: right;"><?=($invest['saldo_akhir'] != 0 ) ? rupiah($invest['saldo_akhir']) : '-';?></td>
                
            </tr>
        <?php endif;?>
        <?php foreach($invest['child'] as $child):?>
            <?php if($child['type'] == 'PC'):?>
                <tr>
                    <td><?= $no++;?></td>
                    <td style="text-align: left;"><?=$child['jenis_investasi']?></td>
                    <td style="text-align: right;"><?=($child['saldo_awal'] != 0 ) ? rupiah($child['saldo_awal']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['mutasi'] != 0 ) ? rupiah($child['mutasi']) : '-';?></td>
                    <td style="text-align: right;"><?=($child['saldo_akhir'] != 0 ) ? rupiah($child['saldo_akhir']) : '-';?></td>
                </tr>
            <?php endif;?>
            <?php foreach($child['subchild'] as $subchild):?>
                <tr>
                    <td><?= $no++;?></td>
                    <td style="text-align: left; padding-left:30px;color: #6c7275;"><?='- '.$subchild['jenis_investasi']?></td>
                    <td style="text-align: right;"><?=($subchild['saldo_awal'] != 0 ) ? rupiah($subchild['saldo_awal']) : '-';?></td>
                    <td style="text-align: right;"><?=($subchild['mutasi'] != 0 ) ? rupiah($subchild['mutasi']) : '-';?></td>
                    <td style="text-align: right;"><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
                </tr>

            <?php endforeach;?>
        <?php endforeach;?>
    <?php endforeach;?>
<?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
    <td></td>
    <td>Total</td>
    <td style="text-align: right;"><?=($sum['saldo_awal'] != 0 ) ? rupiah($sum['saldo_awal']) : '-';?></td>
    <td style="text-align: right;"><?=($sum['mutasi'] != 0 ) ? rupiah($sum['mutasi']) : '-';?></td>
    <td style="text-align: right;"><?=($sum['saldo_akhir'] != 0 ) ? rupiah($sum['saldo_akhir']) : '-';?></td>
</tr>
</table>
<br>
<!-- data keterangan  -->
<div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_bukan_investasi_ket[0]->keterangan_lap) ? $data_bukan_investasi_ket[0]->keterangan_lap : '');?></p>
</div>
<!-- end keterangan -->