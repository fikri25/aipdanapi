<div class="tab-content">
	<!-- Start Tab List Data Aset Temuan -->        
	<div class="tab-pane fade in active" id="tab_list_data_aset_temuan" style="margin-bottom: 100px;">
		<p style="margin-left:10px;margin-top:20px;"></p>
		<div class="table-responsive">
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2">Kantor Cabang</th>
						<th colspan="2">Tahun&nbsp;&nbsp;<span class="tahun"></span></th>
						<th colspan="2">Tahun&nbsp;&nbsp;<span class="tahun_lalu"></span></th>
						<th colspan="2">% Kenaikan/Penurunan </th>
					</tr>
					<tr>
						<th>Jumlah Penerima</th>
						<th>Jumlah Pembayaran</th>
						<th>Jumlah Penerima</th>
						<th>Jumlah Pembayaran</th>
						<th>Jumlah Penerima</th>
						<th>Jumlah Pembayaran</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($nilai_tunai_detail) && is_array($nilai_tunai_detail)):?>
					<?php foreach($nilai_tunai_detail as $detail):?>
						<tr>
							<td style="text-align: left;"><?=$detail['nama_cabang']?></td>
							<td><?=($detail['jml_penerima_thn'] != 0 ) ? rupiah($detail['jml_penerima_thn']) : '-';?></td>
							<td><?=($detail['jml_pembayaran_thn'] != 0 ) ? rupiah($detail['jml_pembayaran_thn']) : '-';?></td>
							<td><?=($detail['jml_penerima_thn_lalu'] != 0 ) ? rupiah($detail['jml_penerima_thn_lalu']) : '-';?></td>
							<td><?=($detail['jml_pembayaran_thn_lalu'] != 0 ) ? rupiah($detail['jml_pembayaran_thn_lalu']) : '-';?></td>
							<td><?=persen($detail['pers_kenaikan_penerima']).'%';?></td>
							<td><?=persen($detail['pers_kenaikan_pembayaran']).'%';?></td>
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
					<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_nilai_tunai_ket_thn[0]->keterangan_lap) ? $data_nilai_tunai_ket_thn[0]->keterangan_lap : '');?></p>

					<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen : 
						<a href="<?php echo site_url('tahunan/aspek_operasional/get_file/'.(isset($data_nilai_tunai_ket_thn[0]->id) ? $data_nilai_tunai_ket_thn[0]->id : ''));?>"><?php echo (isset($data_nilai_tunai_ket_thn[0]->file_lap) ? $data_nilai_tunai_ket_thn[0]->file_lap : '');?></a>
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

	<!-- /.box-body -->
</div>


<script type="text/javascript">
	
    $('#tbl-cabang').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
    
    $('.tahun').text(tahun);
    $('.tahun_lalu').text(tahun - 1);
</script>