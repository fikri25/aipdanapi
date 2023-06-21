<div class="tab-content">
	<!-- Start Tab List Data Aset Temuan -->        
	<div class="tab-pane fade in active" id="tab_list_data_aset_temuan" style="margin-bottom: 100px;">
		<p style="margin-left:10px;margin-top:20px;"></p>
		<div class="table-responsive">
			<table id="" class="table table-responsive table-bordered table-hover">
				<thead>
					<tr>
						<th rowspan="2" width="20">No</th>
						<th rowspan="2">Jenis Penerima</th>
						<th colspan="2">RKA/RIT</th>
						<th colspan="2">Tahun&nbsp;&nbsp;<span class="tahun"></span></th>
						<th colspan="2">Tahun&nbsp;&nbsp;<span class="tahun_lalu"></span></th>
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
							<td><?=($jenis['rka_penerima'] != 0 ) ? rupiah($jenis['rka_penerima']) : '-';?></td>
							<td><?=($jenis['rka_pembayaran'] != 0 ) ? rupiah($jenis['rka_pembayaran']) : '-';?></td>
							<td><?=($jenis['jml_penerima_thn'] != 0 ) ? rupiah($jenis['jml_penerima_thn']) : '-';?></td>
							<td><?=($jenis['jml_pembayaran_thn'] != 0 ) ? rupiah($jenis['jml_pembayaran_thn']) : '-';?></td>
							<td><?=($jenis['jml_penerima_thn_lalu'] != 0 ) ? rupiah($jenis['jml_penerima_thn_lalu']) : '-';?></td>
							<td><?=($jenis['jml_pembayaran_thn_lalu'] != 0 ) ? rupiah($jenis['jml_pembayaran_thn_lalu']) : '-';?></td>
							<td><?=($jenis['pers_penerimaan'] != 0 ) ? persen($jenis['pers_penerimaan']).'%' : '-';?></td>
							<td><?=($jenis['pers_pembayaran'] != 0 ) ? persen($jenis['pers_pembayaran']).'%' : '-';?></td>
							<td><?=($jenis['pers_kenaikan_penerima'] != 0 ) ? persen($jenis['pers_kenaikan_penerima']).'%' : '-';?></td>
							<td><?=($jenis['pers_kenaikan_pembayaran'] != 0 ) ? persen($jenis['pers_kenaikan_pembayaran']).'%' : '-';?></td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
			<!-- data keterangan  -->
			<div style="padding:4px;">
				<p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
				</p>
				<div style="padding:4px;border-style:groove;border-color:lightblue;">
					<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->keterangan_lap) ? $data_pembayaran_pensiun_ket_thn[0]->keterangan_lap : '');?></p>

					<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen : 
						<a href="<?php echo site_url('tahunan/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_ket_thn[0]->id) ? $data_pembayaran_pensiun_ket_thn[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->file_lap) ? $data_pembayaran_pensiun_ket_thn[0]->file_lap : '');?></a>
					</p>

				</div>
			</div>
			<!-- end keterangan -->

			<div class="box-footer with-border">
				<div class="text-left">
					<!-- <?php echo $paggination;?> -->
				</div>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );
    
    $('.tahun').text(tahun);
    $('.tahun_lalu').text(tahun - 1);
</script>
