<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>aspek-investasi-simpan/karakteristik_investasi" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id" value="<?php echo !empty($data) ? $data['id'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Karakteristik & Resiko Investasi</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Semester<font color="red">&nbsp;*</font></label>
										<select class="form-control select2nya" name="semester" id="semester">
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
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis Investasi<font color="red">&nbsp;*</font></label>
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
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Karakteristik</label>
										<textarea name="karakteristik" placeholder="Karakteristik" id="karakteristik" class="form-control" style="height: 120px"><?php echo !empty($data) ? $data['karakteristik'] : '';?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Resiko</label>
										<textarea name="resiko" placeholder="Resiko" id="resiko" class="form-control" style="height: 120px"><?php echo !empty($data) ? $data['resiko'] : '';?></textarea>
									</div>
								</div>
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
	var data_pihak ='<?= !empty($data) ? $data['id_investasi'] : ''?>';
	
	

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
						window.location = host+'semesteran/aspek_investasi/karakteristik_invest';
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