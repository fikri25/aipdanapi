<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}

</style>

<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>investasi-simpan/iuran_beban" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($id_bulan) ? $id_bulan['id_bulan'] : $this->session->userdata('id_bulan');?>">
	
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Input Iuran dan Beban</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Jenis Perubahan Dana Bersih</label>
										<select class="form-control select2nya" id="group" name="group" required="required">
											<option value="">
												-- Pilih --
											</option>
											<?php if(isset($data_perubahan) && is_array($data_perubahan)){?>
												<?php foreach($data_perubahan as $perubahan){?>
													<option value="<?php echo $perubahan->group;?>" <?php if(!empty($data) && $perubahan->group == $data['group']) echo 'selected="selected"';?>>
														<?php echo $perubahan->group;?>
													</option>
												<?php }?>
											<?php }?>
										</select>
										<label class="validation_error_message" for="group"></label>
									</div>
								</div>
							</div>
							<div class="aruskas_div_" id="perubahan_div_iuran" idx="" style="border:1px solid #F0F0F0;padding:10px;background-color:#F6F6F6;">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Uraian (Iuran)</label> 
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>RKA/RIT</label> 

										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Saldo Akhir Periode</label> 
										</div>
									</div> 
									<div class="col-md-2">
										<div class="form-group">
											<label>Unggah Dokumen</label> 

										</div>
									</div>
								</div>
								<?php if($data_perubahan[1]->group == "IURAN") :?>
								 	<?php if(isset($data_iuran) && is_array($data_iuran)):?>
								  		<?php foreach($data_iuran as $dt):?>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="id_investasi_iuran[]" value="<?php echo !empty($dt) ? $dt['id_investasi'] : '';?>">
													<select class="form-control combo-invest" id="id_investasi" name="id_investasi_iuran[]" required="required">
														<?php if(isset($data_jenis_iuran) && is_array($data_jenis_iuran)){?>
															<?php foreach($data_jenis_iuran as $jenis){?>
																<option value="<?php echo $jenis->id_investasi;?>" <?php if(!empty($dt) && $jenis->id_investasi == $dt['id_investasi']) echo 'selected="selected"';?>>
																	<?php echo $jenis->jenis_investasi;?>
																</option>
															<?php }?>
														<?php }?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" placeholder="RKA/RIT" name="rka_iuran[]" id="rka_" class="form-control format_number rka" value="<?= (isset($dt['rka']) ? $dt['rka'] :  $dt['rka_bln_lalu'])?>"/>
												</div>
											</div> 
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" placeholder="Saldo Akhir Periode" name="saldo_akhir_invest_iuran[]" id="saldo_akhir_invest_" class="form-control format_number saldo_akhir_invest" value="<?= !empty($dt) ? $dt['saldo_akhir'] : '';?>"/>
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="filedata_lama_iuran[]" value="<?php echo (isset($dt['filedata']) ? $dt['filedata'] : '');?>">
													<input type="file" name="filedata_iuran[]">
													<p style="margin-top:15px;"></p>
												</div>
											</div>
											<?php if($editstatus == "edit" && $dt['filedata'] != ""){?>
												<div class="col-md-1">
													<div class="form-group">
														<label>&nbsp;</label>
														<a href="<?php echo site_url('bulanan/aset_investasi/get_file_iuran/'.(isset($dt['id']) ? $dt['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:25px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
													</div>
												</div>
											<?php } ?> 
										</div>
										<div class="row">
											<div class="col-md-3">
												&nbsp;
											</div>
											<div class="col-md-8">
												<div class="form-group">
													<label>Keterangan</label>
													<textarea name="keterangan_iuran[]" placeholder="Keterangan" class="form-control"><?php echo (isset($dt['keterangan']) ? $dt['keterangan'] : '');?></textarea>
												</div>
											</div>
										</div>
										<?php endforeach;?>
									<?php endif;?>
								<?php endif;?>
							</div>
							<div class="aruskas_div_" id="perubahan_div_beban" idx="" style="border:1px solid #F0F0F0;padding:10px;background-color:#F6F6F6;">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Uraian (Beban)</label> 
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>RKA/RIT</label> 

										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Saldo Akhir Periode</label> 

										</div>
									</div> 
									<div class="col-md-2">
										<div class="form-group">
											<label>Unggah Dokumen</label> 

										</div>
									</div>
								</div>
								<?php if($data_perubahan[0]->group == "BEBAN") :?>
								 	<?php if(isset($data_beban) && is_array($data_beban)):?>
								 		<?php $idx=1;?>
								  		<?php foreach($data_beban as $dt):?>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" id="id_investasi_beban_<?=$idx;?>" name="id_investasi_beban[]" value="<?php echo !empty($dt) ? $dt['id_investasi'] : '';?>">
													<select class="form-control combo-invest" id="id_investasi_beban_<?=$idx;?>" name="id_investasi_beban[]" required="required">
														<?php if(isset($data_jenis_beban) && is_array($data_jenis_beban)){?>
															<?php foreach($data_jenis_beban as $jenis){?>
																<option value="<?php echo $jenis->id_investasi;?>" <?php if(!empty($dt) && $jenis->id_investasi == $dt['id_investasi']) echo 'selected="selected"';?>>
																	<?php echo $jenis->jenis_investasi;?>
																</option>
															<?php }?>
														<?php }?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" placeholder="RKA/RIT" name="rka_beban[]" id="rka_beban_<?=$idx;?>" class="form-control format_number rka" value="<?= (isset($dt['rka']) ? $dt['rka'] :  $dt['rka_bln_lalu'])?>"/>

												</div>
											</div> 
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" placeholder="Saldo Akhir Periode" name="saldo_akhir_invest_beban[]" id="saldo_akhir_beban_<?=$idx;?>" class="form-control format_number saldo_akhir_invest" value="<?= !empty($dt) ? $dt['saldo_akhir'] : '';?>"/>
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="filedata_lama_beban[]" value="<?php echo (isset($dt['filedata']) ? $dt['filedata'] : '');?>">
													<input type="file" name="filedata_beban[]">
													<p style="margin-top:15px;"></p>
												</div>
											</div>
											<?php if($editstatus == "edit" && $dt['filedata'] != ""){?>
												<div class="col-md-1">
													<div class="form-group">
														<label>&nbsp;</label>
														<a href="<?php echo site_url('bulanan/aset_investasi/get_file_iuran/'.(isset($dt['id']) ? $dt['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:25px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
													</div>
												</div>
											<?php } ?> 
										</div>
										<div class="row">
											<div class="col-md-3">
												&nbsp;
											</div>
											<div class="col-md-8">
												<div class="form-group">
													<label>Keterangan</label>
													<textarea name="keterangan_beban[]" placeholder="Keterangan" class="form-control"><?php echo (isset($dt['keterangan']) ? $dt['keterangan'] : '');?></textarea>
												</div>
											</div>
										</div>
										<?php $idx++;?>
										<?php endforeach;?>
									<?php endif;?>
								<?php endif;?>
							</div>
						
							<hr />
							<div class="row">
								<div class="col-md-12">
									<button href="javascript:void(0);" id="save" class="btn btn-primary btn-flat" type="submit">
										Simpan
									</button>	
									<a href="<?php echo site_url('bulanan/perubahan_dana_bersih').get_uri();?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
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
	var idx_row_div = 1;
	var sts ='<?= !empty($editstatus) ? $editstatus: ''?>';

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


		$('#perubahan_div_beban').hide();
		$('#perubahan_div_iuran').hide();
	});

	$('#group').on('change', function(){
		var group = $('#group').val();
		if(group == 'IURAN'){
			$('#perubahan_div_beban').hide();
			$('#perubahan_div_iuran').show();
		}else if (group == 'BEBAN'){
			$('#perubahan_div_beban').show();
			$('#perubahan_div_iuran').hide();

			// get sum beban investasi
			$.post(host+'investasi-display/sum_beban_investasi'+uri, {[csrf_token]:csrf_hash }, function(resp){
				if(resp){
					sum_beban = JSON.parse(resp);
					$('#rka_beban_1').val(sum_beban.rka);
					$('#saldo_akhir_beban_1').val(sum_beban.saldo_akhir);
					console.log(sum_beban);
				}
			});

		}else{
			$('#perubahan_div_beban').hide();
			$('#perubahan_div_iuran').hide();
		}
	});

	// edit
	if(sts == "add" || sts == "edit"){
		$(".combo-invest").select2({'disabled': true,});
	}


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
						window.location = host+'bulanan/perubahan_dana_bersih'+uri;
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