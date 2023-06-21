<?php
	$tahun=$this->session->userdata("tahun");		
	$nama_lengkap=$this->session->userdata("nama_lengkap");		
?>
<table style="background-color: #e6f5fe">
	<tr style="background-color: #c1e1f3">
		<td colspan="3" style="text-align: center;">
			<p style="margin-left:0px;margin-top:5px;margin-bottom:5px;font-weight: bold;text-align: center">     
				Penyampaian Laporan Berkala Pengelolaan Akumulasi Iuran Pensiun
			</p>
			<p style="margin-left:0px;margin-top:15px;margin-bottom:5px;font-weight: bold;text-align: center">     
				Direktorat Jenderal Anggaran
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center;">
			<p style="margin-left:0px;margin-top:20px;margin-bottom:5px;text-align: center">     
				Berikut ini adalah Bukti Penerimaan Laporan Berkala Pengelolaan Akumulasi Iuran Pensiun
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td><p>Nama</p></td>
		<td><p>:</p></td>
		<td><p>Laporan Tahunan Pengelolaan Akumulasi Iuran Pensiun&nbsp;<?=$nama_lengkap;?></p></td>
	</tr>
	<tr>
		<td><p>Periode Pelaporan</p></td>
		<td><p>:</p></td>
		<td><p>Tahun&nbsp;<?=$tahun;?></p></td>
	</tr>
	<tr>
		<td><p>Tanggal Penyampaian</p></td>
		<td><p>:</p></td>
		<td><p><?=indo_tgl($data_pendahuluan[0]->status_tgl);?></p></td>
	</tr>
	<tr>
		<td><p>Nomor Tanda Terima Elektronik</p></td>
		<td><p>:</p></td>
		<td><p>-------------</p></td>
		<!-- <td><p><?=str_replace('=','',base64_encode($data_pendahuluan[0]->id_ref));?></p></td> -->
	</tr>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center;">
			<p style="margin-left:0px;margin-top:20px;margin-bottom:5px;text-align: center">     
				Terima kasih telah menyampaikan Laporan Berkala Pengelolaan AIP PNS dan Pejabat Negara
			</p>
		</td>
	</tr>		
</table>					
										
									
