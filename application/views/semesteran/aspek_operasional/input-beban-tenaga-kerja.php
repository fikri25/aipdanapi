<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>aspek-operasional-simpan/beban_tenaga_kerja" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id" value="<?php echo !empty($data) ? $data['id'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<?php if($editstatus == "edit"){ ?>
		<input type="hidden" name="id_cabang" value="<?php echo !empty($data) ? $data['id_cabang'] : '';?>">
	<?php } ?>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Jumlah Tenaga Kerja</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Cabang<font color="red">&nbsp;*</font></label>
										<select class="form-control select2nya combo" name="id_cabang" id="cabang">
											<option value="">
												-- Pilih --
											</option>
											<?php if(isset($cabang) && is_array($cabang)){?> 
												<?php foreach($cabang as $k=>$v){?>
													<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['id_cabang']) echo 'selected="selected"';?>>
														<?php echo $v['txt'];?>
													</option>
												<?php }?>
											<?php }?>
										</select>	
										<label class="validation_error_message" for="cabang"></label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Jumlah Penyelenggaraan</label>
										<input type="text" name="jml_penyelenggaraan" class="form-control jml_penyelenggaraan format_number" id="jml_penyelenggaraan"  value="<?php echo !empty($data) ? $data['jml_penyelenggaraan'] : '';?>" placeholder="jumlah penyelenggaraan"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Persentase Penyelenggaraan</label>
										<input type="text" name="persen_penyelenggaraan" class="form-control persen_penyelenggaraan percent" id="persen_penyelenggaraan"  value="<?php echo !empty($data) ? $data['persen_penyelenggaraan'] : '';?>" placeholder="Persen penyelenggaraan"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Jumlah Lainnya</label>
										<input type="text" name="jml_lain" class="form-control jml_lain format_number" id="jml_lain"  value="<?php echo !empty($data) ? $data['jml_lain'] : '';?>" placeholder="jumlah lainnya"/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Persentase Lainnya</label>
										<input type="text" name="persen_lain" class="form-control persen_lain percent" id="persen_lain"  value="<?php echo !empty($data) ? $data['persen_lain'] : '';?>" placeholder="Persentase Lainnya"/>
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
										<a href="<?php echo site_url('semesteran/aspek_operasional/get_file_tenaga_kerja/'.(isset($data['id']) ? $data['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:27px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
									</div>
								</div>
								<?php } ?>
							</div>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<button href="javascript:void(0);" id="save" class="btn btn-primary btn-flat" type="submit">
										Simpan
									</button>	
									<button type="reset" class="btn btn-danger btn-flat"  data-dismiss="modal" aria-hidden="true">
										Kembali
									</button>
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
	
	

	$(document).ready(function(){
		$('.format_number').number(true, 0, ',', '.');
		$('.rupiah').number(true,0);
		// $('.format_number').number(true, 0);
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );

		
		
		new AutoNumeric.multiple('.negative', {
			allowDecimalPadding: false,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			decimalPlaces: 0,
			negativeSignCharacter: "-"
		});

		new AutoNumeric.multiple('.percent', {
			alwaysAllowDecimalCharacter: true,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			suffixText: "%",
			decimalPlacesShownOnFocus: 2,
			unformatOnSubmit: true
		});

		

	});

	// edit
	if(sts == "edit"){
		$(".combo").select2({'disabled': true,});
	}

	// form action
	var rulesnya = {
		id_cabang : "required",
		rka : "required",
		
	};

	var messagesnya = {
		id_cabang : "<i style='color:red'>Harus Diisi</i>",
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
						window.location = host+'semesteran/aspek_operasional/beban';
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