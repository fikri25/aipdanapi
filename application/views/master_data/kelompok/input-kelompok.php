<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}
	/*.odd*/
</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>master-simpan/master_kelompok_penerima" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" name="id_kelompok" value="<?php echo !empty($data) ? $data['id_kelompok'] : '';?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Master Kelompok Penerima</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<label>User<font color="red">&nbsp;*</font></label>
									<select class="form-control select2nya flag" id="flag" name="flag" required="required">
										<option value="">
											-- Pilih --
										</option>
										<?php if(isset($opt_kelompok) && is_array($opt_kelompok)){?> 
											<?php foreach($opt_kelompok as $k=>$v){?>
												<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['flag']) echo 'selected="selected"';?>>
													<?php echo $v['txt'];?>
												</option>
											<?php }?>
										<?php }?>
									</select>
									<label class="validation_error_message" for="flag"></label>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<label>Kelompok Penerima<font color="red">&nbsp;*</font></label>
										<input type="text" placeholder="Kelompok Penerima" class="form-control" id="kelompok_penerima" name="kelompok_penerima" value="<?php echo !empty($data) ? $data['kelompok_penerima'] : '';?>" required="required">
									</div>
								</div>
							</div>
							<br>
							
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
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );
	
	});

	
	// form action
	var rulesnya = {
		flag : "required",
		kode_pihak : "required",
		group : "required",
		nama_pihak : "required",
		
	};

	var messagesnya = {
		flag : "<i style='color:red'>Harus Diisi</i>",
		kode_pihak : "<i style='color:red'>Harus Diisi</i>",
		group : "<i style='color:red'>Harus Diisi</i>",
		nama_pihak : "<i style='color:red'>Harus Diisi</i>",
		
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
						window.location = host+'master/master_data/master_kelompok_penerima';
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