<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}

</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>arus-kas-simpan/arus_kas" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($id_bulan) ? $id_bulan['id_bulan'] : $this->session->userdata('id_bulan');?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Arus Kas</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Jenis Aktivitas</label>
										<select class="form-control combo-invest" id="jenis_kas" name="jenis_kas" required="required">
											<option value="">
												-- Pilih --
											</option>
											<?php if(isset($data_aktivitas) && is_array($data_aktivitas)){?>
												<?php foreach($data_aktivitas as $aktivitas){?>
													<option value="<?php echo $aktivitas->jenis_kas;?>" <?php if(!empty($data) && $aktivitas->jenis_kas == $data['jenis_kas']) echo 'selected="selected"';?>>
														<?php echo $aktivitas->jenis_kas;?>
													</option>
												<?php }?>
											<?php }?>
										</select>
										<label class="validation_error_message" for="jenis_kas"></label>
									</div>
								</div>
							</div>
							
							<div class="aruskas_div_" id="aruskas_div" idx="" style="border:1px solid #F0F0F0;padding:10px;background-color:#F6F6F6;">
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Arus Kas </label> 
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Saldo Akhir Periode</label> 

										</div>
									</div> 
									<div class="col-md-3">
										<div class="form-group">
											<label>Unggah Dokumen</label> 

										</div>
									</div>
									<div class="col-md-1 text-right" style="padding-top:23px;">
										&nbsp;
									</div>
								</div>
								<?php if($editstatus == "edit") :?>
								 	<?php if(isset($data_detail) && is_array($data_detail)):?>
								  		<?php foreach($data_detail as $detail):?>
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="id_aruskas[]" value="<?php echo !empty($detail) ? $detail['id_aruskas'] : '';?>">
													<select id="id_aruskas"  name="id_aruskas[]" class="form-control id_aruskas select2nya combo">
														<option value="">-- Pilih --</option>
														<?php if(isset($combo) && is_array($combo)):?>
														<?php foreach($combo as $combo_kas):?>
															<option value="<?= $combo_kas['id'];?>" 
																<?php if(!empty($detail) && $combo_kas['id'] == $detail['id_aruskas']) echo 'selected="selected"';?> >
																<?= $combo_kas['txt'];?>
															</option>
														<?php endforeach;?>
													<?php endif;?>

												</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" name="saldo_bulan_berjalan[]" id="saldo_bulan_berjalan_" class="form-control negative saldo_bulan_berjalan" placeholder="Saldo Akhir Periode" value="<?= $detail['saldo_bulan_berjalan'];?>"/>
												</div>
											</div> 
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="filedata_lama[]" value="<?php echo (isset($detail['filedata']) ? $detail['filedata'] : '');?>">
													<input type="file" name="filedata[]">
													<p style="margin-top:15px;"></p>
												</div>
											</div>
											<?php if($editstatus == "edit" && $detail['filedata'] != ""){?>
												<div class="col-md-1">
													<div class="form-group">
														<label>&nbsp;</label>
														<a href="<?php echo site_url('bulanan/arus_kas/get_file_kas/'.(isset($detail['id']) ? $detail['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:25px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
													</div>
												</div>
											<?php } ?>
										</div>
										<div class="row">
											<div class="col-md-5">
												&nbsp;
											</div>
											<div class="col-md-6">
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
									<a href="<?php echo site_url('bulanan/arus_kas').get_uri();?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
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
	var data_aruskas ='<?= !empty($data) ? $data['jenis_kas'] : ''?>';

	$(document).ready(function(){
		$('.format_number').number(true, 0, ',', '.');
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );
		
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

		// $('.tanggalnya').datepicker({ 
		// 	format: 'yyyy-mm-dd'
		// });
	
	});

	// get combo nama pihak
	if(sts == "add" || sts == "edit"){
		$('#jenis_kas').on('change', function(){
			$('.aruskas_div').remove();
			var jenis_kas = $('#jenis_kas').val()
			$.post(host+'arus-kas-form/arus_kas/'+jenis_kas+uri, { 'editstatus':'edit','id':jenis_kas, [csrf_token]:csrf_hash }, function(resp){
				if(resp){
					$('.content').html(resp);
				}
			});
		});


		$(".combo").select2({'disabled': true,});
	}



	// if(sts == "add"){
	// 	$('#jenis_kas').on('change', function(){

	// 		$('.aruskas_div').remove();
	// 		$.post(host+'arus-kas-display/get_arus_kas'+uri, { 'jenis_kas':$('#jenis_kas').val(), [csrf_token]:csrf_hash }, function(resp){
	// 			if(resp){
	// 				$('.id_aruskas').empty();
	// 				data_aruskas = resp;

	// 				$('.id_aruskas').append(data_aruskas);
	// 			}
	// 		});
	// 		$.post(host+'arus-kas-display/get_all_kas'+uri, { 'jenis_kas':$('#jenis_kas').val(), [csrf_token]:csrf_hash }, function(resp1){
	// 			if(resp1){
	// 			// console.log(resp1);
	// 			tambah_row_div('aruskas_div', resp1);
	// 		}
	// 	});
	// 	});
	// }



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
						window.location = host+'bulanan/arus_kas'+uri;
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