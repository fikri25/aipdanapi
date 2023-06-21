<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}
	/*.odd*/
</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>aspek-operasional-simpan/nilai_tunai" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id" value="<?php echo !empty($data) ? $data['id'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<?php if($editstatus == "edit"){ ?>
		<input type="hidden" name="semester" value="<?php echo !empty($data) ? $data['semester'] : '';?>">
	<?php } ?>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Nilai Tunai</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Semester<font color="red">&nbsp;*</font></label>
										<select class="form-control select2nya combo" name="semester" id="semester">
											<option value="">
												-- Pilih --
											</option>
											<?php if(isset($opt_smt) && is_array($opt_smt)){?> 
												<?php foreach($opt_smt as $k=>$v){?>
													<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['semester']) echo 'selected="selected"';?>>
														<?php echo $v['txt'];?>
													</option>
												<?php }?>
											<?php }?>
										</select>
										<label class="validation_error_message" for="semester"></label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>RKA Penerima<font color="red">&nbsp;*</font></label>
										<input type="text" name="rka_penerima" class="form-control rka_penerima format_number" id="rka_penerima" value="<?= !empty($data) ? $data['rka_penerima'] : '';?>" placeholder="Penerima"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>RKA Pembayaran<font color="red">&nbsp;*</font></label>
										<input type="text" name="rka_pembayaran" class="form-control rka_pembayaran format_number" id="rka_pembayaran"  value="<?= !empty($data) ? $data['rka_pembayaran'] : '';?>" placeholder="Pembayaran"/>	
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="keterangan" class="lebel">Unggah Dokumen</label>
										<input type="hidden" name="filedata_lama" value="<?php echo (isset($data['filedata']) ? $data['filedata'] : '');?>">
										<input type="file" name="filedata" class="form-control">
										<p style="margin-top:15px;"></p>
										<p style="font-size: 11px; font-style: italic;" class="peringatan"> * Dokumen harus bertipe pdf, doc atau docx</p>
									</div>
								</div>
								<?php if($editstatus == "edit" && $data['filedata'] != ""){?>
								<div class="col-md-2">
									<div class="form-group">
										<label for="keterangan" class="lebel"></label>
										<a href="<?php echo site_url('semesteran/aspek_operasional/get_file_nilai_tunai/'.(isset($data['id']) ? $data['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:27px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
									</div>
								</div>
								<?php } ?>
							</div>
							<br>
							<div class="row">
								<div class='col-md-12'>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Nilai Tunai Cabang</legend>

										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-nilai-tunai" id="tbl-nilai-tunai" width="">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th>No Urut</th>
														<th>Kantor Cabang</th>
														<th>Jumlah Penerima</th>
														<th>Jumlah Pembayaran</th>
														<th class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_1" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
													</tr>
												</thead>
												<tbody class="nilai_tunai">
													<?php if($editstatus == "edit"):?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="tr_inv_" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select class="form-control select2nya" name="cabang[]" id="cabang_<?=$idx;?>" idx="<?=$idx;?>" id="cabang">
																			<option value="">
																				-- Pilih --
																			</option>
																			<?php if(isset($cabang) && is_array($cabang)){?> 
																				<?php foreach($cabang as $k=>$v){?>
																					<option value="<?php echo $v['id'];?>" <?php if(!empty($detail) && $v['id'] == $detail['id_cabang']) echo 'selected="selected"';?>>
																						<?php echo $v['txt'];?>
																					</option>
																				<?php }?>
																			<?php }?>
																		</select>	
																	</td>
																	<td>
																		<input type="text" name="jml_penerima[]" class="form-control jml_penerima_1 format_number" id="jml_penerima_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['jml_penerima'];?>" style="width:100%"/>		
																	</td>
																	<td>
																		<input type="text" name="jml_pembayaran[]" class="form-control jml_pembayaran_1 format_number" id="jml_pembayaran_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['jml_pembayaran'];?>" style="width:100%"/>		
																	</td>
																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
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
							<div class="row">
								<div class="col-md-12">
									<button href="javascript:void(0);" id="save" class="btn btn-primary btn-flat" type="submit">
										Simpan
									</button>	
									<a href="<?php echo site_url('semesteran/aspek_operasional/nilai_tunai');?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
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
	var sts ="<?= !empty($editstatus) ? $editstatus: ''?>";
	

	$(document).ready(function(){
		$('.format_number').number(true, 0, ',', '.');
		$('.rupiah').number(true,0);
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );
		
		new AutoNumeric.multiple('.negative', {
			allowDecimalPadding: false,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			decimalPlaces: 0,
			negativeSignCharacter: "-"
		});


		$('.tbl-nilai-tunai').DataTable({
			"paging":false,
			"searching": false,
			"ordering": false,
			"lengthChange": false,
			"info": false,
		});

		// add new row
		$('#semester').on('change', function(){
			var smt=$(this).val();
			$.post(host+'aspek-operasional-display/cabang', {[csrf_token]:csrf_hash }, function(resp1){
				if(resp1){
					data_cabang = resp1;
					// console.log(data_cabang);
				}
			});

			if(sts == "add"){
				$.post(host+'aspek-operasional-display/cek_nilai_tunai', { 'semester':smt, [csrf_token]:csrf_hash }, function(resp1){
					if(resp1){
						cek = JSON.parse(resp1)
						console.log(cek);
						if(cek.total > 0){
							$.messager.alert('SMART AIP','Anda sudah input data semester '+smt,'warning'); 
							return false;
						}
					}
				});
			}
		});


		$('.tambah_detail').on('click', function(){
			if($('#semester').val() == ""){
				$.messager.alert('SMART AIP','Pilih Semester Terlebih Dahulu!','warning'); 
				return false;
			}
			if(sts == "add"){
				if(cek.total > 0) {
					$.messager.alert('SMART AIP','Anda sudah input data semester '+$('#semester').val(),'warning'); 
					return false;
				}
			}
			$('.dataTables_empty').remove();
			tambah_row_semester('nilai_tunai');
			
		});


	});

	// edit
	if(sts == "edit"){
		$.post(host+'aspek-operasional-display/cabang', {[csrf_token]:csrf_hash }, function(resp1){
			if(resp1){
				data_cabang = resp1;
				// console.log(data_cabang);
			}
		});

		$(".combo").select2({'disabled': true,});
	}


	$(".hasil").on("keyup", function(){
		calculateHasilInvestasi();
	});

	function calculateHasilInvestasi(){
		var saldo_awal_head = 0;
		var mutasi_head = 0;
		var rka = 0;
		var saldoakhir_head = 0;

		saldoawal_head = parseFloat($("#saldo_awal_head").val().replace(/\./g,''));
		rka = parseFloat($("#rka").val().replace(/\./g,''));
		mutasi_head = parseFloat($("#mutasi_head").val().replace(/\./g,''));


		saldoakhir_head = (saldoawal_head + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;

		$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
		$("#realisasi_head").val(realisasi_head.toFixed(2));
	};






	// form action
	var rulesnya = {
		id_investasi : "required",
		rka : "required",
		
	};

	var messagesnya = {
		id_investasi : "<i style='color:red'>Harus Diisi</i>",
		rka : "<i style='color:red'>Harus Diisi</i>",
		
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
						window.location = host+'semesteran/aspek_operasional/nilai_tunai';
					}, 2000);
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