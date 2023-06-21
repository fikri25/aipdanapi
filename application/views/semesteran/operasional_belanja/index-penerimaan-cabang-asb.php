<div class="tab-content">
	<!-- Start Tab List Data Aset Temuan -->        
	<div class="tab-pane fade in active" id="tab_list_data_aset_temuan" style="margin-bottom: 100px;">
		<p style="margin-left:10px;margin-top:20px;"></p>
		<div class="table-responsive">

			<!-- ======================================== SEMESTER 2 ================================ -->
            <?php if($semester == 2 || $semester == ""):?>
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2">Kantor Cabang</th>
						<th rowspan="2">Jenis Penerima Manfaat</th>
						<th colspan="5">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
						<th colspan="5">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
					</tr>
					<tr>
						<th>Prajurit TNI</th>
						<th>Anggota POLR</th>
						<th>ASN KemHAN</th>
						<th>ASN POLRI</th>
						<th>Jumlah</th>

						<th>Prajurit TNI</th>
						<th>Anggota POLR</th>
						<th>ASN KemHAN</th>
						<th>ASN POLRI</th>
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
								<td><?=($child['prajurit_tni_terima_1'] != 0 ) ? rupiah($child['prajurit_tni_terima_1']) : '-';?></td>
								<td><?=($child['anggota_polri_terima_1'] != 0 ) ? rupiah($child['anggota_polri_terima_1']) : '-';?></td>
								<td><?=($child['asn_kemhan_terima_1'] != 0 ) ? rupiah($child['asn_kemhan_terima_1']) : '-';?></td>
								<td><?=($child['asn_polri_terima_1'] != 0 ) ? rupiah($child['asn_polri_terima_1']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_1_asb'] != 0 ) ? rupiah($child['jumlah_smt_1_asb']) : '-';?></td>
								
								<td><?=($child['prajurit_tni_terima_2'] != 0 ) ? rupiah($child['prajurit_tni_terima_2']) : '-';?></td>
								<td><?=($child['anggota_polri_terima_2'] != 0 ) ? rupiah($child['anggota_polri_terima_2']) : '-';?></td>
								<td><?=($child['asn_kemhan_terima_2'] != 0 ) ? rupiah($child['asn_kemhan_terima_2']) : '-';?></td>
								<td><?=($child['asn_polri_terima_2'] != 0 ) ? rupiah($child['asn_polri_terima_2']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_2_asb'] != 0 ) ? rupiah($child['jumlah_smt_2_asb']) : '-';?></td>

							</tr>
						<?php endforeach;?>
						<tr style="background-color:#d2ebf9;font-weight: bold;">
							<td></td>
							<td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>

							<td><?=($terima['prajurit_tni_terima_1'] != 0 ) ? rupiah($terima['prajurit_tni_terima_1']) : '-';?></td>
							<td><?=($terima['anggota_polri_terima_1'] != 0 ) ? rupiah($terima['anggota_polri_terima_1']) : '-';?></td>
							<td><?=($terima['asn_kemhan_terima_1'] != 0 ) ? rupiah($terima['asn_kemhan_terima_1']) : '-';?></td>
							<td><?=($terima['asn_polri_terima_1'] != 0 ) ? rupiah($terima['asn_polri_terima_1']) : '-';?></td>
							<td style="font-weight: bold;"><?=($terima['jumlah_smt_1_asb'] != 0 ) ? rupiah($terima['jumlah_smt_1_asb']) : '-';?></td>

							<td><?=($terima['prajurit_tni_terima_2'] != 0 ) ? rupiah($terima['prajurit_tni_terima_2']) : '-';?></td>
							<td><?=($terima['anggota_polri_terima_2'] != 0 ) ? rupiah($terima['anggota_polri_terima_2']) : '-';?></td>
							<td><?=($terima['asn_kemhan_terima_2'] != 0 ) ? rupiah($terima['asn_kemhan_terima_2']) : '-';?></td>
							<td><?=($terima['asn_polri_terima_2'] != 0 ) ? rupiah($terima['asn_polri_terima_2']) : '-';?></td>
							<td style="font-weight: bold;"><?=($terima['jumlah_smt_2_asb'] != 0 ) ? rupiah($terima['jumlah_smt_2_asb']) : '-';?></td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
			<?php endif;?>

			<!-- ========================================= SEMESTER 1 ================================ -->
			<?php if($semester == 1 ):?>
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2">Kantor Cabang</th>
						<th rowspan="2">Jenis Penerima Manfaat</th>
						<th colspan="5">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
						<th colspan="5">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
					</tr>
					<tr>
						<th>Prajurit TNI</th>
						<th>Anggota POLR</th>
						<th>ASN KemHAN</th>
						<th>ASN POLRI</th>
						<th>Jumlah</th>

						<th>Prajurit TNI</th>
						<th>Anggota POLR</th>
						<th>ASN KemHAN</th>
						<th>ASN POLRI</th>
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
								<td><?=($child['prajurit_tni_terima_2'] != 0 ) ? rupiah($child['prajurit_tni_terima_2']) : '-';?></td>
								<td><?=($child['anggota_polri_terima_2'] != 0 ) ? rupiah($child['anggota_polri_terima_2']) : '-';?></td>
								<td><?=($child['asn_kemhan_terima_2'] != 0 ) ? rupiah($child['asn_kemhan_terima_2']) : '-';?></td>
								<td><?=($child['asn_polri_terima_2'] != 0 ) ? rupiah($child['asn_polri_terima_2']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_2_asb'] != 0 ) ? rupiah($child['jumlah_smt_2_asb']) : '-';?></td>

								<td><?=($child['prajurit_tni_terima_1'] != 0 ) ? rupiah($child['prajurit_tni_terima_1']) : '-';?></td>
								<td><?=($child['anggota_polri_terima_1'] != 0 ) ? rupiah($child['anggota_polri_terima_1']) : '-';?></td>
								<td><?=($child['asn_kemhan_terima_1'] != 0 ) ? rupiah($child['asn_kemhan_terima_1']) : '-';?></td>
								<td><?=($child['asn_polri_terima_1'] != 0 ) ? rupiah($child['asn_polri_terima_1']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_1_asb'] != 0 ) ? rupiah($child['jumlah_smt_1_asb']) : '-';?></td>
							</tr>
						<?php endforeach;?>
						<tr style="background-color:#d2ebf9;font-weight: bold;">
							<td></td>
							<td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>
							<td><?=($terima['prajurit_tni_terima_2'] != 0 ) ? rupiah($terima['prajurit_tni_terima_2']) : '-';?></td>
							<td><?=($terima['anggota_polri_terima_2'] != 0 ) ? rupiah($terima['anggota_polri_terima_2']) : '-';?></td>
							<td><?=($terima['asn_kemhan_terima_2'] != 0 ) ? rupiah($terima['asn_kemhan_terima_2']) : '-';?></td>
							<td><?=($terima['asn_polri_terima_2'] != 0 ) ? rupiah($terima['asn_polri_terima_2']) : '-';?></td>
							<td style="font-weight: bold;"><?=($terima['jumlah_smt_2_asb'] != 0 ) ? rupiah($terima['jumlah_smt_2_asb']) : '-';?></td>

							<td><?=($terima['prajurit_tni_terima_1'] != 0 ) ? rupiah($terima['prajurit_tni_terima_1']) : '-';?></td>
							<td><?=($terima['anggota_polri_terima_1'] != 0 ) ? rupiah($terima['anggota_polri_terima_1']) : '-';?></td>
							<td><?=($terima['asn_kemhan_terima_1'] != 0 ) ? rupiah($terima['asn_kemhan_terima_1']) : '-';?></td>
							<td><?=($terima['asn_polri_terima_1'] != 0 ) ? rupiah($terima['asn_polri_terima_1']) : '-';?></td>
							<td style="font-weight: bold;"><?=($terima['jumlah_smt_1_asb'] != 0 ) ? rupiah($terima['jumlah_smt_1_asb']) : '-';?></td>
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
					<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_cbg_ket_smt1[0]->keterangan_lap) ? $data_pembayaran_pensiun_cbg_ket_smt1[0]->keterangan_lap : '');?></p>

					<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester I : 
						<a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_cbg_ket_smt1[0]->id) ? $data_pembayaran_pensiun_cbg_ket_smt1[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_cbg_ket_smt1[0]->file_lap) ? $data_pembayaran_pensiun_cbg_ket_smt1[0]->file_lap : '');?></a>
					</p>
					<br>
					<?php if(isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->id) != "") :?>
						<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->keterangan_lap) ? $data_pembayaran_pensiun_cbg_ket_smt2[0]->keterangan_lap : '');?></p>

						<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester II : 
							<a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->id) ? $data_pembayaran_pensiun_cbg_ket_smt2[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->file_lap) ? $data_pembayaran_pensiun_cbg_ket_smt2[0]->file_lap : '');?></a>
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
	
    $('#tbl-cabang').DataTable({
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

    $(document).ready(function() {
     var span = 1;
     var prevTD = "";
     var prevTDVal = "";
        $("#tbl-cabang tr td:first-child").each(function() { //for each first td in every tr
          var $this = $(this);
          if ($this.text() == prevTDVal) { // check value of previous td text
           span++;
           if (prevTD != "") {
                prevTD.attr("rowspan", span); // add attribute to previous td
                $this.remove(); // remove current td
            }
        } else {
             prevTD     = $this; // store current td 
             prevTDVal  = $this.text();
             span       = 1;
         }
     });
   });
</script>