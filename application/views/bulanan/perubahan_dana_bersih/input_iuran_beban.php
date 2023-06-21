<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}

</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>investasi-simpan/iuran_beban" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<!-- <input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($data) ? $data['id_bulan'] : $this->session->userdata('id_bulan');?>"> -->
	<input type="hidden" id="bulan" name="id_bulan" value="<?php echo (isset($data['id_bulan']) ? $data['id_bulan'] : $this->session->userdata('id_bulan'));?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Input</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-4">
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
							
							<div class="beban_div_" id="beban_div" idx="" style="border:1px solid #F0F0F0;padding:10px;background-color:#F6F6F6;">
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label><span class="lebel"></span></label> 
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label>Saldo Akhir</label> 
										</div>
									</div> 
									<div class="col-md-2">
										<div class="form-group">
											<label>RIT/RKA</label> 
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label>Unggah Dokumen</label> 
										</div>
									</div>
								</div>
								<?php if($editstatus == "edit") :?>
								 	<?php if(isset($data_detail) && is_array($data_detail)):?>
								  		<?php foreach($data_detail as $detail):?>
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="id_investasi[]" value="<?php echo !empty($detail) ? $detail['id_investasi'] : '';?>">
													<select id="id_investasi"  name="id_investasi[]" class="form-control id_investasi select2nya combo">
														<option value="">-- Pilih --</option>
														<?php if(isset($combo_detail_beban) && is_array($combo_detail_beban)):?>
														<?php foreach($combo_detail_beban as $detail_beban):?>
															<option value="<?= $detail_beban['id'];?>" 
																<?php if(!empty($detail) && $detail_beban['id'] == $detail['id_investasi']) echo 'selected="selected"';?> >
																<?= $detail_beban['txt'];?>
															</option>
														<?php endforeach;?>
													<?php endif;?>

												</select>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" name="saldo_akhir[]" id="saldo_akhir_" class="form-control negative saldo_akhir" placeholder="Saldo Akhir" value="<?= $detail['saldo_akhir'];?>"/>
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" name="rka[]" id="rka_" class="form-control negative rka" placeholder="RKA" value="<?= $detail['rka'];?>"/>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="filedata_lama[]" value="<?php echo (isset($detail['filedata']) ? $detail['filedata'] : '');?>">
													<input type="file" name="filedata[]">
													<p style="margin-top:15px;"></p>
													<p style="font-size: 11px; font-style: italic;" class="peringatan"> * Dokumen harus bertipe pdf, doc atau docx</p>
												</div>
											</div>
											<?php if($editstatus == "edit" && $detail['filedata'] != ""){?>
												<div class="col-md-1">
													<div class="form-group">
														<label>&nbsp;</label>
														<a href="<?php echo site_url('bulanan/aset_investasi/get_file_iuran_beban/'.(isset($detail['id']) ? $detail['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:25px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="row">
											<div class="col-md-5">
												&nbsp;
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<label>Keterangan</label>
													<textarea name="keterangan[]" placeholder="Keterangan" class="form-control"><?php echo (isset($detail['keterangan']) ? $detail['keterangan'] : '');?></textarea>
												</div>
											</div>
										</div>
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
	var data_aruskas ='<?= !empty($data) ? $data['id'] : ''?>';

	$(document).ready(function(){
		$('.format_number').number(true, 0, ',', '.');
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );
		var investasi_txt = $('#group option:selected').text()
		
		new AutoNumeric.multiple('.negative', {
			allowDecimalPadding: false,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			decimalPlaces: 0,
			negativeSignCharacter: "-",
			maximumValue:99999999999999999999,
			minimumValue:-99999999999999999999
		});

		$('.tbl-form').DataTable({
			"paging":false,
			"searching": false,
			"ordering": false,
			"lengthChange": false,
			"info": false,
		});

		if(sts == "add"){
			$('.lebel').html('Uraian');
		}else{
			if($('#group').val() != "") {
				$('.lebel').html(investasi_txt);
			}else{
				$('.lebel').html('Uraian');
			}	
		}

	
	});

	if(sts == "add" || sts == "edit"){
		$('#group').on('change', function(){
			$('.beban_div').remove();
			var group = $('#group').val()
			$.post(host+'perubahan-danabersih-form/perubahan_dana_bersih/'+group, { 'editstatus':'edit','id':group, [csrf_token]:csrf_hash }, function(resp){
				if(resp){
					$('.content').html(resp);
				}
			});
		});
	}

	// edit
	if(sts == "edit"){
		$(".combo").select2({'disabled': true,});
	}



	// form action
	var rulesnya = {
		id_investasi : "required",
		saldo_awal : "required",
		rka : "required",
		saldo_akhir : "required",
		
	};

	var messagesnya = {
		id_investasi : "<i style='color:red'>Harus Diisi</i>",
		saldo_awal : "<i style='color:red'>Harus Diisi</i>",
		rka : "<i style='color:red'>Harus Diisi</i>",
		saldo_akhir : "<i style='color:red'>Harus Diisi</i>",
		
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
	        var name = element.attr('class');
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