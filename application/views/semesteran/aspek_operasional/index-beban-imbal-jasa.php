<div class="tab-content">
	<!-- Start Tab List Data Aset Temuan -->        
	<div class="tab-pane fade in active" id="beban_2" style="margin-bottom: 100px;">
		<p style="margin-left:10px;margin-top:20px;"></p>
		<div class="table-responsive">
			<!-- ======================================== SEMESTER 2 ================================ -->
			<?php if($semester == 2 || $semester == ""):?>
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2" width="30%">Uraian</th>
						<th rowspan="2">Saldo Akhir Semester I&nbsp;&nbsp;<span class="thn"></span></th>
						<th rowspan="2">Saldo Akhir Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
						<th colspan="2">Kenaikan/Penurunan</th>
					</tr>
					<tr>
						<th>Nominal</th>
						<th>Persentase</th>
					</tr>

				</thead>
				<tbody>
					<?php
						$netto_smt1 = 0;
						$netto_smt2 = 0;
						$fee_nom = 0;
						$fee_pers = 0;
					?>
					<?php if(isset($imbal_jasa) && is_array($imbal_jasa)):?>
					<?php foreach($imbal_jasa as $imbal):?>
						<tr>
							<td style="text-align: left;"><?=$imbal['group']?></td>
							<td><?=rupiah($imbal['saldo_akhir_smt1']);?></td>
							<td><?=rupiah($imbal['saldo_akhir_smt2']);?></td>
							<td><?=rupiah($imbal['nominal']);?></td>
							<td><?=persen($imbal['persentase']);?>%</td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
					<?php
						$imbal_jasa_smt2a = (isset($imbal_jasa[0]['saldo_akhir_smt2']) ? $imbal_jasa[0]['saldo_akhir_smt2'] : 0) ;
						$imbal_jasa_smt2b = (isset($imbal_jasa[1]['saldo_akhir_smt2']) ? $imbal_jasa[1]['saldo_akhir_smt2'] : 0) ;

						$imbal_jasa_smt1a = (isset($imbal_jasa[0]['saldo_akhir_smt1']) ? $imbal_jasa[0]['saldo_akhir_smt1'] : 0) ;
						$imbal_jasa_smt1b = (isset($imbal_jasa[1]['saldo_akhir_smt1']) ? $imbal_jasa[1]['saldo_akhir_smt1'] : 0) ;

						$netto_smt2= (($imbal_jasa_smt2a - $imbal_jasa_smt2b)*0.067);
						$netto_smt1= (($imbal_jasa_smt1a - $imbal_jasa_smt1b)*0.067);
						$fee_nom = $netto_smt2 - $netto_smt1;
						$fee_pers = ($netto_smt1!=0)?($fee_nom/$netto_smt1)*100:0;
					?>
					<tr style="font-weight: bold;">
						<td style="text-align: left;">Fee 6,7%</td>
						<td style="text-align: right;"><?= rupiah($netto_smt1);?></td>
						<td style="text-align: right;"><?= rupiah($netto_smt2);?></td>
						<td style="text-align: right;"><?= rupiah($fee_nom);?></td>
						<td style="text-align: right;"><?= persen($fee_pers);?>%</td>
					</tr>
				</tbody>
			</table>
			<?php endif;?>

			<!-- ========================================= SEMESTER 1 ================================ -->
			<?php if($semester == 1 ):?>
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2" width="30%">Uraian</th>
						<th rowspan="2">Saldo Akhir Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
						<th rowspan="2">Saldo Akhir Semester I&nbsp;&nbsp;<span class="thn"></span></th>
						<th colspan="2">Kenaikan/Penurunan</th>
					</tr>
					<tr>
						<th>Nominal</th>
						<th>Persentase</th>
					</tr>

				</thead>
				<tbody>
					<?php
						$netto_smt1 = 0;
						$netto_smt2 = 0;
						$fee_nom = 0;
						$fee_pers = 0;
					?>
					<?php if(isset($imbal_jasa) && is_array($imbal_jasa)):?>
					<?php foreach($imbal_jasa as $imbal):?>
						<tr>
							<td style="text-align: left;"><?=$imbal['group']?></td>
							<td><?=rupiah($imbal['saldo_akhir_smt2']);?></td>
							<td><?=rupiah($imbal['saldo_akhir_smt1']);?></td>
							<td><?=rupiah($imbal['nominal']);?></td>
							<td><?=persen($imbal['persentase']);?>%</td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
					<?php
						$imbal_jasa_smt2a = (isset($imbal_jasa[0]['saldo_akhir_smt2']) ? $imbal_jasa[0]['saldo_akhir_smt2'] : 0) ;
						$imbal_jasa_smt2b = (isset($imbal_jasa[1]['saldo_akhir_smt2']) ? $imbal_jasa[1]['saldo_akhir_smt2'] : 0) ;

						$imbal_jasa_smt1a = (isset($imbal_jasa[0]['saldo_akhir_smt1']) ? $imbal_jasa[0]['saldo_akhir_smt1'] : 0) ;
						$imbal_jasa_smt1b = (isset($imbal_jasa[1]['saldo_akhir_smt1']) ? $imbal_jasa[1]['saldo_akhir_smt1'] : 0) ;

						$netto_smt2= (($imbal_jasa_smt2a - $imbal_jasa_smt2b)*0.067);
						$netto_smt1= (($imbal_jasa_smt1a - $imbal_jasa_smt1b)*0.067);
						$fee_nom = $netto_smt2 - $netto_smt1;
						$fee_pers = ($netto_smt1!=0)?($fee_nom/$netto_smt1)*100:0;
					?>
					<tr style="font-weight: bold;">
						<td style="text-align: left;">Fee 6,7%</td>
						<td style="text-align: right;"><?= rupiah($netto_smt2);?></td>
						<td style="text-align: right;"><?= rupiah($netto_smt1);?></td>
						<td style="text-align: right;"><?= rupiah($fee_nom);?></td>
						<td style="text-align: right;"><?= persen($fee_pers);?>%</td>
					</tr>
				</tbody>
			</table>
			<?php endif;?>

			<!-- data keterangan  -->
			<div style="padding:4px;">
				<p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
				</p>
				<div style="padding:4px;border-style:groove;border-color:lightblue;">
					<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_beban_ket_smt1[0]->keterangan_lap) ? $data_beban_ket_smt1[0]->keterangan_lap : '');?></p>

					<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester I : 
						<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_beban_ket_smt1[0]->id) ? $data_beban_ket_smt1[0]->id : ''));?>"><?php echo (isset($data_beban_ket_smt1[0]->file_lap) ? $data_beban_ket_smt1[0]->file_lap : '');?></a>
					</p>
					<br>
					<?php if(isset($data_beban_ket_smt2[0]->id) != "") :?>
						<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_beban_ket_smt2[0]->keterangan_lap) ? $data_beban_ket_smt2[0]->keterangan_lap : '');?></p>

						<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester II : 
							<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_beban_ket_smt2[0]->id) ? $data_beban_ket_smt2[0]->id : ''));?>"><?php echo (isset($data_beban_ket_smt2[0]->file_lap) ? $data_beban_ket_smt2[0]->file_lap : '');?></a>
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
</script>