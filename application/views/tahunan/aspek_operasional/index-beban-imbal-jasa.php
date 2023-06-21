<div class="tab-content">
	<!-- Start Tab List Data Aset Temuan -->        
	<div class="tab-pane fade in active" id="beban_2" style="margin-bottom: 100px;">
		<p style="margin-left:10px;margin-top:20px;"></p>
		<div class="table-responsive">
			<table id="tbl-cabang" class="table table-responsive table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th rowspan="2" width="30%">Uraian</th>
						<th rowspan="2">Tahun&nbsp;&nbsp;<span class="tahun"></span></th>
						<th rowspan="2">Tahun&nbsp;&nbsp;<span class="tahun_lalu"></span></th>
						<th colspan="2">Kenaikan/Penurunan</th>
					</tr>
					<tr>
						<th>Nominal</th>
						<th>Persentase</th>
					</tr>

				</thead>
				<tbody>
					<?php
						$netto_thn = 0;
						$netto_thn_lalu = 0;
						$fee_nom = 0;
						$fee_pers = 0;
					?>
					<?php if(isset($imbal_jasa) && is_array($imbal_jasa)):?>
					<?php foreach($imbal_jasa as $imbal):?>
						<tr>
							<td style="text-align: left;"><?=$imbal['group']?></td>
							<td><?=rupiah($imbal['saldo_akhir_thn']);?></td>
							<td><?=rupiah($imbal['saldo_akhir_thn_lalu']);?></td>
							<td><?=rupiah($imbal['nominal']);?></td>
							<td><?=persen($imbal['persentase']);?>%</td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
					<?php
						$imbal_jasa_thn_lalua = (isset($imbal_jasa[0]['saldo_akhir_thn_lalu']) ? $imbal_jasa[0]['saldo_akhir_thn_lalu'] : 0) ;
						$imbal_jasa_thn_lalub = (isset($imbal_jasa[1]['saldo_akhir_thn_lalu']) ? $imbal_jasa[1]['saldo_akhir_thn_lalu'] : 0) ;

						$imbal_jasa_thna = (isset($imbal_jasa[0]['saldo_akhir_thn']) ? $imbal_jasa[0]['saldo_akhir_thn'] : 0) ;
						$imbal_jasa_thnb = (isset($imbal_jasa[1]['saldo_akhir_thn']) ? $imbal_jasa[1]['saldo_akhir_thn'] : 0) ;

						$netto_thn_lalu= (($imbal_jasa_thn_lalua - $imbal_jasa_thn_lalub)*0.067);
						$netto_thn= (($imbal_jasa_thna - $imbal_jasa_thnb)*0.067);
						$fee_nom = $netto_thn_lalu - $netto_thn;
						$fee_pers = ($netto_thn!=0)?($fee_nom/$netto_thn)*100:0;
					?>
					<tr style="font-weight: bold;">
						<td style="text-align: left;">Fee 6,7%</td>
						<td style="text-align: right;"><?= rupiah($netto_thn);?></td>
						<td style="text-align: right;"><?= rupiah($netto_thn_lalu);?></td>
						<td style="text-align: right;"><?= rupiah($fee_nom);?></td>
						<td style="text-align: right;"><?= persen($fee_pers);?>%</td>
					</tr>
				</tbody>
			</table>
			<!-- data keterangan  -->
			<div style="padding:4px;">
				<p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
				</p>
				<div style="padding:4px;border-style:groove;border-color:lightblue;">
					<p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_beban_ket_thn[0]->keterangan_lap) ? $data_beban_ket_thn[0]->keterangan_lap : '');?></p>

					<p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen : 
						<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_beban_ket_thn[0]->id) ? $data_beban_ket_thn[0]->id : ''));?>"><?php echo (isset($data_beban_ket_thn[0]->file_lap) ? $data_beban_ket_thn[0]->file_lap : '');?></a>
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
	$('.tahun').text(tahun);
	$('.tahun_lalu').text(tahun - 1);
    $('#tbl-cabang').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
</script>