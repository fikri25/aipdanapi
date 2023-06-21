<div class="tab-content">
	<!-- Start Tab List Data Aset Temuan -->        
	<div class="tab-pane fade in active" id="tab_list_data_aset_temuan" style="margin-bottom: 100px;">
		<p style="margin-left:10px;margin-top:20px;"></p>
		<div class="table-responsive">
			<!-- ====================================================== SEMESTER 2 ================================ -->
			<?php if($semester == 2 || $semester == ""):?>
			<table id="tbl-jenis" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2" width="20">No</th>
						<th rowspan="2">Jenis Penerima</th>
						<th colspan="2">RKA/RIT</th>
						<th colspan="2">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
						<th colspan="2">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
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
							<td><?=($jenis['jml_penerima_smt1'] != 0 ) ? rupiah($jenis['jml_penerima_smt1']) : '-';?></td>
							<td><?=($jenis['jml_pembayaran_smt1'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt1']) : '-';?></td>
							<td><?=($jenis['jml_penerima_smt2'] != 0 ) ? rupiah($jenis['jml_penerima_smt2']) : '-';?></td>
							<td><?=($jenis['jml_pembayaran_smt2'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt2']) : '-';?></td>
							<td><?=($jenis['pers_penerimaan'] != 0 ) ? persen($jenis['pers_penerimaan']).'%' : '-';?></td>
							<td><?=($jenis['pers_pembayaran'] != 0 ) ? persen($jenis['pers_pembayaran']).'%' : '-';?></td>
							<td><?=($jenis['pers_kenaikan_penerima'] != 0 ) ? persen($jenis['pers_kenaikan_penerima']).'%' : '-';?></td>
							<td><?=($jenis['pers_kenaikan_pembayaran'] != 0 ) ? persen($jenis['pers_kenaikan_pembayaran']).'%' : '-';?></td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
			<?php endif;?>

			<!-- ====================================================== SEMESTER 1 ================================ -->
			<?php if($semester == 1 ):?>
				<table id="tbl-jenis" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2" width="20">No</th>
						<th rowspan="2">Jenis Penerima</th>
						<th colspan="2">RKA/RIT</th>
						<th colspan="2">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
						<th colspan="2">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
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
							<td><?=($jenis['jml_penerima_smt2'] != 0 ) ? rupiah($jenis['jml_penerima_smt2']) : '-';?></td>
							<td><?=($jenis['jml_pembayaran_smt2'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt2']) : '-';?></td>
							<td><?=($jenis['jml_penerima_smt1'] != 0 ) ? rupiah($jenis['jml_penerima_smt1']) : '-';?></td>
							<td><?=($jenis['jml_pembayaran_smt1'] != 0 ) ? rupiah($jenis['jml_pembayaran_smt1']) : '-';?></td>
							<td><?=($jenis['pers_penerimaan'] != 0 ) ? persen($jenis['pers_penerimaan']).'%' : '-';?></td>
							<td><?=($jenis['pers_pembayaran'] != 0 ) ? persen($jenis['pers_pembayaran']).'%' : '-';?></td>
							<td><?=($jenis['pers_kenaikan_penerima'] != 0 ) ? persen($jenis['pers_kenaikan_penerima']).'%' : '-';?></td>
							<td><?=($jenis['pers_kenaikan_pembayaran'] != 0 ) ? persen($jenis['pers_kenaikan_pembayaran']).'%' : '-';?></td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
			<?php endif;?>

			<!-- data keterangan  -->
			<div style="padding:4px;">
				<p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
				</p>
				<div style="padding:4px;border-style:groove;border-color:lightblue;">
					<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_aip_ket_smt1[0]->keterangan_lap) ? $data_pembayaran_pensiun_aip_ket_smt1[0]->keterangan_lap : '');?></p>

					<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester I : 
						<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_pembayaran_pensiun_aip_ket_smt1[0]->id) ? $data_pembayaran_pensiun_aip_ket_smt1[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_aip_ket_smt1[0]->file_lap) ? $data_pembayaran_pensiun_aip_ket_smt1[0]->file_lap : '');?></a>
					</p>
					<br>
					<?php if(isset($data_pembayaran_pensiun_aip_ket_smt2[0]->id) != "") :?>
						<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_aip_ket_smt2[0]->keterangan_lap) ? $data_pembayaran_pensiun_aip_ket_smt2[0]->keterangan_lap : '');?></p>

						<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester II : 
							<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_pembayaran_pensiun_aip_ket_smt2[0]->id) ? $data_pembayaran_pensiun_aip_ket_smt2[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_aip_ket_smt2[0]->file_lap) ? $data_pembayaran_pensiun_aip_ket_smt2[0]->file_lap : '');?></a>
						</p>
					<?php endif; ?>
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
	<!-- Modal input/edit -->
	<div id="modal_jenis" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );
    $('#tbl-jenis').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });

    var smt = $('#semester').val();
    if (smt != "") {
      if(smt == 1){
        $('.thn').text(tahun);
        $('.thn-filter').text(tahun-1);
        console.log(smt);
      }else{
        $('.thn').text(tahun);
        $('.thn-filter').text(tahun);
      }
    }else{
      $('.thn').text(tahun);
      $('.thn-filter').text(tahun);
    }

</script>
