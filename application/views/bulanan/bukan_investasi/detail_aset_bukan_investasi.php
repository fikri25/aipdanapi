<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}
	/*.odd*/
</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>investasi-simpan/aset_bukan_investasi" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id" value="<?php echo !empty($data) ? $data['id'] : '';?>">
	<input type="hidden" name="jns_form" id="jns_form" value="<?php echo !empty($data) ? $data['jns_form'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($id_bulan) ? $id_bulan['id_bulan'] : $this->session->userdata('id_bulan');?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Detail Aset Bukan Investasi</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis Aset Bukan Investasi</label>
										<select class="form-control combo-invest" id="id_investasi" name="id_investasi" required="required">
											<option value="">
												-- Pilih Jenis Investasi --
											</option>
											<?php if(isset($data_jenis) && is_array($data_jenis)){?>
												<?php foreach($data_jenis as $jenis){?>
													<option value="<?php echo $jenis->id_investasi;?>" <?php if(!empty($data) && $jenis->id_investasi == $data['id_investasi']) echo 'selected="selected"';?>>
														<?php echo $jenis->jenis_investasi;?>
													</option>
												<?php }?>
											<?php }?>
										</select>
										<label class="validation_error_message" for="id_investasi"></label>
									</div>
								</div>
								<?php if($editstatus == "edit" && $data['filedata'] != ""){?>
								<div class="col-md-2">
									<div class="form-group">
										<label for="keterangan" class="lebel"></label>
										<a href="<?php echo site_url('bulanan/aset_investasi/get_file_jenis/'.(isset($data['id']) ? $data['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:25px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
									</div>
								</div>
								<?php } ?>
							</div>
							<!-- FORM - 1 -->
							<div class="row form-10" id="form-10">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Aset Bukan Investasi (Form - 1)</legend>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2" width="5%">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Uraian</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="2">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_bkn_investasi_1 form_bkn_investasi_bln_lalu_1">
													<?php if($editstatus == "edit" && $data['jns_form'] == "10") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_bkn_1" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td style="text-align: center"><?= $detail['no_urut'];?></td>
																	<td style="text-align: left"><?= $detail['nama_pihak'];?></td>
																	<td style="text-align: left"><?= $detail['jenis_investasi'];?></td>
																	<td><?= rupiah($detail['saldo_awal']);?></td>
																	<td><?= rupiah($detail['mutasi_pembelian']);?></td>
																	<td><?= rupiah($detail['mutasi_penjualan']);?></td>
																	<td><?= rupiah($detail['saldo_akhir']);?></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</fieldset>
								</div>
							</div>

							<!-- FORM - 2 -->
							<div class="row form-11" id="form-11">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Aset Bukan Investasi (Form - 2)</legend>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2" width="5%">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Uraian</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="3">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan</th>
															<th>Amortisasi</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_bkn_investasi_2 form_bkn_investasi_bln_lalu_2">
													<?php if($editstatus == "edit" && $data['jns_form'] == "11") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_bkn_2" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td style="text-align: center"><?= $detail['no_urut'];?></td>
																	<td style="text-align: left"><?= $detail['nama_pihak'];?></td>
																	<td style="text-align: left"><?= $detail['jenis_investasi'];?></td>
																	<td><?= rupiah($detail['saldo_awal']);?></td>
																	<td><?= rupiah($detail['mutasi_pembelian']);?></td>
																	<td><?= rupiah($detail['mutasi_penjualan']);?></td>
																	<td><?= rupiah($detail['mutasi_amortisasi']);?></td>
																	<td><?= rupiah($detail['saldo_akhir']);?></td>
																	
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</fieldset>
								</div>
							</div>

			
							<hr />
							<div class="row">
								<div class="col-md-12">	
									<a href="<?php echo site_url('bulanan/bukan_investasi').get_uri();?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
								</div>
							</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</form>

<script type="text/javascript">
	var idx_row = 1;
	var sts ='<?= !empty($editstatus) ? $editstatus: ''?>';
	var data_pihak ='<?= !empty($data) ? $data['id_investasi'] : ''?>';
	

	$(document).ready(function(){
		$('.format_number').number(true, 0, ',', '.');
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );
		
		new AutoNumeric.multiple('.negative', {
			allowDecimalPadding: false,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			decimalPlaces: 0,
			negativeSignCharacter: "-"
		});

		$('.tbl-form').DataTable({
			"paging":false,
			"searching": false,
			"ordering": false,
			"lengthChange": false,
			"info": false,
		});

		$('.form-11').css('display','none');

		// get data bulan lalu
		$('.bulan_lalu_form').on('click', function(){
			var form = $('#jns_form').val();
			if($('#id_investasi').val() == ""){
				$.messager.alert('SMART AIP','Pilih Jenis Investasi Terlebih Dahulu!','warning'); 
				return false;
			}
			if($('#bulan').val() == 1){
				$.messager.alert('SMART AIP','Tidak bisa generate data bulan Januari !','warning'); 
				return false;
			}

			$.LoadingOverlay("show");
			$.post(host+'investasi-display/data_bulan_lalu_form'+uri, { 'jns_form':form, 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp){

				parsing_bln_lalu = JSON.parse(resp)
				if(parsing_bln_lalu.length == '0'){
					$.messager.alert('SMART AIP','Data bulan lalu tidak ditemukan !','warning'); 
					$.LoadingOverlay("hide", true);
					return false;

				}

				$('.dataTables_empty').remove();
				if(form == '10'){
					tambah_row('form_bkn_investasi_bln_lalu_1', resp);
				}
				if(form == '11'){
					tambah_row('form_bkn_investasi_bln_lalu_2', resp);
				}
				$.LoadingOverlay("hide", true);
			});

		});


	});

	// edit
	if(sts == "edit"){
		$( document ).ready(function() {
			$('#id_investasi').val(data_pihak).trigger('change');
			$(".combo-invest").select2({'disabled': true,});
			// fungsi calculate
			// $(".form_bkn_1").on("keyup", function(){
			// 	calculateInvestasiFormBkn1();
			// });
			// $(".form_bkn_2").on("keyup", function(){
			// 	calculateInvestasiFormBkn2();
			// });
			

			var form = $('#jns_form').val();
			
			// if(form == '10'){
			// 	calculateInvestasiFormBkn1();
			// }
			// if(form == '11'){
			// 	calculateInvestasiFormBkn2();
			// }
			
		});
	}


	// add new row
	$('.tambah_detail').on('click', function(){
		if($('#id_investasi').val() == ""){
			$.messager.alert('SMART AIP','Pilih Jenis Investasi Terlebih Dahulu!','warning'); 
			return false;
		}else{
			parsing = parsing_form;

			if(parsing.jns_form == 10) {
				var form = "form_bkn_investasi_1";
			}
			if(parsing.jns_form == 11){
				var form = "form_bkn_investasi_2";
			}

			$('.dataTables_empty').remove();
			tambah_row(form);
		}
		
	});

	// get combo nama pihak
	$('#id_investasi').on('change', function(){
		$('.tr_inv').remove();
		$.post(host+'investasi-display/cek_aset_investasi'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp){
			if(resp){
				parsing = JSON.parse(resp);
				if(parsing.total == '0'){
					$.post(host+'investasi-display/data_pihak'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp1){
						if(resp1){
							data_pihak = resp1;
							console.log(data_pihak);
						}
					});
				}else{
					if(sts == "edit"){
						$.post(host+'investasi-display/data_pihak'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp1){
							if(resp1){
								data_pihak = resp1;
								console.log(data_pihak);
							}
						});
					}else{
						$.messager.alert('SMART AIP','Anda sudah input data '+parsing.jenis_investasi+' !','warning');
						return false;
					}
				}
			}
		});

		$.post(host+'investasi-display/form_invest'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp){
			if(resp){
				parsing_form = JSON.parse(resp);
				$('#jns_form').val(parsing_form.jns_form);
				if(parsing_form.jns_form == 10) {
					$('.form-10').css('display','block');
					$('.form-11').css('display','none');
				}else if(parsing_form.jns_form == 11){
					$('.form-10').css('display','none');
					$('.form-11').css('display','block');
				}
			}
		});
	});



	// form action
	var rulesnya = {
		id_investasi : "required",
		
	};

	var messagesnya = {
		id_investasi : "<i style='color:red'>Harus Diisi</i>",
		
	}

	$( "#form_<?=$acak;?>" ).validate( {
		rules: rulesnya,
		messages: messagesnya,
		submitHandler: function(form) {
			$.LoadingOverlay("show");
			submit_form('form_<?=$acak;?>',function(r){
				if(r==1){ 
					$.messager.alert('SMART AIP','Data Tersimpan','info'); 
					$('#cancel').trigger('click');
					setTimeout(function(){
						window.location = host+'bulanan/bukan_investasi'+uri;
					}, 2500);
				}else{ 
					$.messager.alert('SMART AIP','Proses Simpan Data Gagal '+r,'warning'); 
				}
				$.LoadingOverlay("hide", true);
			});
		
		},
		errorPlacement: function(error, element) {
	        var name = element.attr('name');
	        var errorSelector = '.validation_error_message[for="' + name + '"]';
	        var $element = $(errorSelector);
	        if ($element.length) { 
	            $(errorSelector).html(error.html());
	        } else {
	            error.insertAfter(element);
	        }
	    }
	} );


</script>