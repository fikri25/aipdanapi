<div class="tab-content">
	<!-- Start Tab List Data Aset Temuan -->        
	<div class="tab-pane fade in active" id="tab_list_data_aset_temuan" style="margin-bottom: 100px;">
		<p style="margin-left:10px;margin-top:20px;"></p>
		<div class="table-responsive">
			<!-- ======================================== SEMESTER 2 ================================ -->
			<?php if($semester == 2 || $semester == ""):?>
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover">
				<thead>
					<tr>
						<th rowspan="2">Kantor Cabang</th>
						<th rowspan="2">Jenis Penerima Manfaat</th>
						<th colspan="10">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
						<th colspan="10">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
					</tr>
					<tr>
						<th>PNS Pusat</th>
						<th>PNS DO</th>
						<th>Pejabat Negara</th>
						<th>Hakim</th>
						<th>PKRI/KNIP</th>
						<th>Veteran</th>
						<th>TNI/Polri</th>
						<th>Pegadaian</th>
						<th>Dana Kehormatan</th>
						<th>Jumlah</th>

						<th>PNS Pusat</th>
						<th>PNS DO</th>
						<th>Pejabat Negara</th>
						<th>Hakim</th>
						<th>PKRI/KNIP</th>
						<th>Veteran</th>
						<th>TNI/Polri</th>
						<th>Pegadaian</th>
						<th>Dana Kehormatan</th>
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
								<td><?=($child['pns_pusat_terima_1'] != 0 ) ? rupiah($child['pns_pusat_terima_1']) : '-';?></td>
								<td><?=($child['pns_do_terima_1'] != 0 ) ? rupiah($child['pns_do_terima_1']) : '-';?></td>
								<td><?=($child['pejabat_terima_1'] != 0 ) ? rupiah($child['pejabat_terima_1']) : '-';?></td>
								<td><?=($child['hakim_terima_1'] != 0 ) ? rupiah($child['hakim_terima_1']) : '-';?></td>
								<td><?=($child['pkri_terima_1'] != 0 ) ? rupiah($child['pkri_terima_1']) : '-';?></td>
								<td><?=($child['veteran_terima_1'] != 0 ) ? rupiah($child['veteran_terima_1']) : '-';?></td>
								<td><?=($child['tni_polri_terima_1'] != 0 ) ? rupiah($child['tni_polri_terima_1']) : '-';?></td>
								<td><?=($child['pegadaian_terima_1'] != 0 ) ? rupiah($child['pegadaian_terima_1']) : '-';?></td>
								<td><?=($child['dana_kehormatan_terima_1'] != 0 ) ? rupiah($child['dana_kehormatan_terima_1']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_1_tsn'] != 0 ) ? rupiah($child['jumlah_smt_1_tsn']) : '-';?></td>

								<td><?=($child['pns_pusat_terima_2'] != 0 ) ? rupiah($child['pns_pusat_terima_2']) : '-';?></td>
								<td><?=($child['pns_do_terima_2'] != 0 ) ? rupiah($child['pns_do_terima_2']) : '-';?></td>
								<td><?=($child['pejabat_terima_2'] != 0 ) ? rupiah($child['pejabat_terima_2']) : '-';?></td>
								<td><?=($child['hakim_terima_2'] != 0 ) ? rupiah($child['hakim_terima_2']) : '-';?></td>
								<td><?=($child['pkri_terima_2'] != 0 ) ? rupiah($child['pkri_terima_2']) : '-';?></td>
								<td><?=($child['veteran_terima_2'] != 0 ) ? rupiah($child['veteran_terima_2']) : '-';?></td>
								<td><?=($child['tni_polri_terima_2'] != 0 ) ? rupiah($child['tni_polri_terima_2']) : '-';?></td>
								<td><?=($child['pegadaian_terima_2'] != 0 ) ? rupiah($child['pegadaian_terima_2']) : '-';?></td>
								<td><?=($child['dana_kehormatan_terima_2'] != 0 ) ? rupiah($child['dana_kehormatan_terima_2']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_2_tsn'] != 0 ) ? rupiah($child['jumlah_smt_2_tsn']) : '-';?></td>
							</tr>
						<?php endforeach;?>
						<tr style="background-color:#d2ebf9;font-weight: bold;">
							<td></td>
							<td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>
							<td><?=($terima['pns_pusat_terima_1'] != 0 ) ? rupiah($terima['pns_pusat_terima_1']) : '-';?></td>
							<td><?=($terima['pns_do_terima_1'] != 0 ) ? rupiah($terima['pns_do_terima_1']) : '-';?></td>
							<td><?=($terima['pejabat_terima_1'] != 0 ) ? rupiah($terima['pejabat_terima_1']) : '-';?></td>
							<td><?=($terima['hakim_terima_1'] != 0 ) ? rupiah($terima['hakim_terima_1']) : '-';?></td>
							<td><?=($terima['pkri_terima_1'] != 0 ) ? rupiah($terima['pkri_terima_1']) : '-';?></td>
							<td><?=($terima['veteran_terima_1'] != 0 ) ? rupiah($terima['veteran_terima_1']) : '-';?></td>
							<td><?=($terima['tni_polri_terima_1'] != 0 ) ? rupiah($terima['tni_polri_terima_1']) : '-';?></td>
							<td><?=($terima['pegadaian_terima_1'] != 0 ) ? rupiah($terima['pegadaian_terima_1']) : '-';?></td>
							<td><?=($terima['dana_kehormatan_terima_1'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_1']) : '-';?></td>
							<td><?=($terima['jumlah_smt_1_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_1_tsn']) : '-';?></td>

							<td><?=($terima['pns_pusat_terima_2'] != 0 ) ? rupiah($terima['pns_pusat_terima_2']) : '-';?></td>
							<td><?=($terima['pns_do_terima_2'] != 0 ) ? rupiah($terima['pns_do_terima_2']) : '-';?></td>
							<td><?=($terima['pejabat_terima_2'] != 0 ) ? rupiah($terima['pejabat_terima_2']) : '-';?></td>
							<td><?=($terima['hakim_terima_2'] != 0 ) ? rupiah($terima['hakim_terima_2']) : '-';?></td>
							<td><?=($terima['pkri_terima_2'] != 0 ) ? rupiah($terima['pkri_terima_2']) : '-';?></td>
							<td><?=($terima['veteran_terima_2'] != 0 ) ? rupiah($terima['veteran_terima_2']) : '-';?></td>
							<td><?=($terima['tni_polri_terima_2'] != 0 ) ? rupiah($terima['tni_polri_terima_2']) : '-';?></td>
							<td><?=($terima['pegadaian_terima_2'] != 0 ) ? rupiah($terima['pegadaian_terima_2']) : '-';?></td>
							<td><?=($terima['dana_kehormatan_terima_2'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_2']) : '-';?></td>
							<td><?=($terima['jumlah_smt_2_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_2_tsn']) : '-';?></td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
				</tbody>
			</table>
			<?php endif;?>

			<!-- ========================================= SEMESTER 1 ================================ -->
			<?php if($semester == 1 ):?>
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover">
				<thead>
					<tr>
						<th rowspan="2">Kantor Cabang</th>
						<th rowspan="2">Jenis Penerima Manfaat</th>
						<th colspan="10">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
						<th colspan="10">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
					</tr>
					<tr>
						<th>PNS Pusat</th>
						<th>PNS DO</th>
						<th>Pejabat Negara</th>
						<th>Hakim</th>
						<th>PKRI/KNIP</th>
						<th>Veteran</th>
						<th>TNI/Polri</th>
						<th>Pegadaian</th>
						<th>Dana Kehormatan</th>
						<th>Jumlah</th>

						<th>PNS Pusat</th>
						<th>PNS DO</th>
						<th>Pejabat Negara</th>
						<th>Hakim</th>
						<th>PKRI/KNIP</th>
						<th>Veteran</th>
						<th>TNI/Polri</th>
						<th>Pegadaian</th>
						<th>Dana Kehormatan</th>
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
								<td><?=($child['pns_pusat_terima_2'] != 0 ) ? rupiah($child['pns_pusat_terima_2']) : '-';?></td>
								<td><?=($child['pns_do_terima_2'] != 0 ) ? rupiah($child['pns_do_terima_2']) : '-';?></td>
								<td><?=($child['pejabat_terima_2'] != 0 ) ? rupiah($child['pejabat_terima_2']) : '-';?></td>
								<td><?=($child['hakim_terima_2'] != 0 ) ? rupiah($child['hakim_terima_2']) : '-';?></td>
								<td><?=($child['pkri_terima_2'] != 0 ) ? rupiah($child['pkri_terima_2']) : '-';?></td>
								<td><?=($child['veteran_terima_2'] != 0 ) ? rupiah($child['veteran_terima_2']) : '-';?></td>
								<td><?=($child['tni_polri_terima_2'] != 0 ) ? rupiah($child['tni_polri_terima_2']) : '-';?></td>
								<td><?=($child['pegadaian_terima_2'] != 0 ) ? rupiah($child['pegadaian_terima_2']) : '-';?></td>
								<td><?=($child['dana_kehormatan_terima_2'] != 0 ) ? rupiah($child['dana_kehormatan_terima_2']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_2_tsn'] != 0 ) ? rupiah($child['jumlah_smt_2_tsn']) : '-';?></td>

								<td><?=($child['pns_pusat_terima_1'] != 0 ) ? rupiah($child['pns_pusat_terima_1']) : '-';?></td>
								<td><?=($child['pns_do_terima_1'] != 0 ) ? rupiah($child['pns_do_terima_1']) : '-';?></td>
								<td><?=($child['pejabat_terima_1'] != 0 ) ? rupiah($child['pejabat_terima_1']) : '-';?></td>
								<td><?=($child['hakim_terima_1'] != 0 ) ? rupiah($child['hakim_terima_1']) : '-';?></td>
								<td><?=($child['pkri_terima_1'] != 0 ) ? rupiah($child['pkri_terima_1']) : '-';?></td>
								<td><?=($child['veteran_terima_1'] != 0 ) ? rupiah($child['veteran_terima_1']) : '-';?></td>
								<td><?=($child['tni_polri_terima_1'] != 0 ) ? rupiah($child['tni_polri_terima_1']) : '-';?></td>
								<td><?=($child['pegadaian_terima_1'] != 0 ) ? rupiah($child['pegadaian_terima_1']) : '-';?></td>
								<td><?=($child['dana_kehormatan_terima_1'] != 0 ) ? rupiah($child['dana_kehormatan_terima_1']) : '-';?></td>
								<td style="font-weight: bold;"><?=($child['jumlah_smt_1_tsn'] != 0 ) ? rupiah($child['jumlah_smt_1_tsn']) : '-';?></td>
							</tr>
						<?php endforeach;?>
						<tr style="background-color:#d2ebf9;font-weight: bold;">
							<td></td>
							<td style="text-align: center;"><?=$terima['judul_sum_bawah'];?></td>
							<td><?=($terima['pns_pusat_terima_2'] != 0 ) ? rupiah($terima['pns_pusat_terima_2']) : '-';?></td>
							<td><?=($terima['pns_do_terima_2'] != 0 ) ? rupiah($terima['pns_do_terima_2']) : '-';?></td>
							<td><?=($terima['pejabat_terima_2'] != 0 ) ? rupiah($terima['pejabat_terima_2']) : '-';?></td>
							<td><?=($terima['hakim_terima_2'] != 0 ) ? rupiah($terima['hakim_terima_2']) : '-';?></td>
							<td><?=($terima['pkri_terima_2'] != 0 ) ? rupiah($terima['pkri_terima_2']) : '-';?></td>
							<td><?=($terima['veteran_terima_2'] != 0 ) ? rupiah($terima['veteran_terima_2']) : '-';?></td>
							<td><?=($terima['tni_polri_terima_2'] != 0 ) ? rupiah($terima['tni_polri_terima_2']) : '-';?></td>
							<td><?=($terima['pegadaian_terima_2'] != 0 ) ? rupiah($terima['pegadaian_terima_2']) : '-';?></td>
							<td><?=($terima['dana_kehormatan_terima_2'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_2']) : '-';?></td>
							<td><?=($terima['jumlah_smt_2_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_2_tsn']) : '-';?></td>

							<td><?=($terima['pns_pusat_terima_1'] != 0 ) ? rupiah($terima['pns_pusat_terima_1']) : '-';?></td>
							<td><?=($terima['pns_do_terima_1'] != 0 ) ? rupiah($terima['pns_do_terima_1']) : '-';?></td>
							<td><?=($terima['pejabat_terima_1'] != 0 ) ? rupiah($terima['pejabat_terima_1']) : '-';?></td>
							<td><?=($terima['hakim_terima_1'] != 0 ) ? rupiah($terima['hakim_terima_1']) : '-';?></td>
							<td><?=($terima['pkri_terima_1'] != 0 ) ? rupiah($terima['pkri_terima_1']) : '-';?></td>
							<td><?=($terima['veteran_terima_1'] != 0 ) ? rupiah($terima['veteran_terima_1']) : '-';?></td>
							<td><?=($terima['tni_polri_terima_1'] != 0 ) ? rupiah($terima['tni_polri_terima_1']) : '-';?></td>
							<td><?=($terima['pegadaian_terima_1'] != 0 ) ? rupiah($terima['pegadaian_terima_1']) : '-';?></td>
							<td><?=($terima['dana_kehormatan_terima_1'] != 0 ) ? rupiah($terima['dana_kehormatan_terima_1']) : '-';?></td>
							<td><?=($terima['jumlah_smt_1_tsn'] != 0 ) ? rupiah($terima['jumlah_smt_1_tsn']) : '-';?></td>
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
						<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_pembayaran_pensiun_cbg_ket_smt1[0]->id) ? $data_pembayaran_pensiun_cbg_ket_smt1[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_cbg_ket_smt1[0]->file_lap) ? $data_pembayaran_pensiun_cbg_ket_smt1[0]->file_lap : '');?></a>
					</p>
					<br>
					<?php if(isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->id) != "") :?>
						<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->keterangan_lap) ? $data_pembayaran_pensiun_cbg_ket_smt2[0]->keterangan_lap : '');?></p>

						<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester II : 
							<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->id) ? $data_pembayaran_pensiun_cbg_ket_smt2[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_cbg_ket_smt2[0]->file_lap) ? $data_pembayaran_pensiun_cbg_ket_smt2[0]->file_lap : '');?></a>
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