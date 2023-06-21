<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}

</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>investasi-simpan/kewajiban" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($id_bulan) ? $id_bulan['id_bulan'] : $this->session->userdata('id_bulan');?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Input</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="aruskas_div_" id="aruskas_div" idx="" style="border:1px solid #F0F0F0;padding:10px;background-color:#F6F6F6;">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Uraian</label> 
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
								<?php if($editstatus == "add" || $editstatus == "edit") :?>
								 	<?php if(isset($kewajiban) && is_array($kewajiban)):?>
								  		<?php foreach($kewajiban as $dt):?>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="id_investasi[]" value="<?php echo !empty($dt) ? $dt['id_investasi'] : '';?>">
													<select class="form-control combo-invest" id="id_investasi" name="id_investasi[]" required="required">
														<option value="">
															-- Pilih Jenis Kewajiban --
														</option>
														<?php if(isset($data_jenis) && is_array($data_jenis)){?>
															<?php foreach($data_jenis as $jenis){?>
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
													<input type="text" placeholder="RKA/RIT" name="rka[]" id="rka_" class="form-control format_number rka" value="<?= (isset($dt['rka']) ? $dt['rka'] :  $dt['rka_bln_lalu']);?>"/>
												</div>
											</div> 
											<div class="col-md-3">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" placeholder="Saldo Akhir Periode" name="saldo_akhir_invest[]" id="saldo_akhir_invest_" class="form-control negative saldo_akhir_invest" value="<?= !empty($dt) ? $dt['saldo_akhir'] : '';?>"/>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="hidden" name="filedata_lama[]" value="<?php echo (isset($dt['filedata']) ? $dt['filedata'] : '');?>">
													<input type="file" name="filedata[]">
													<p style="margin-top:15px;"></p>
                      								<p style="font-size: 11px; font-style: italic;" class="peringatan"> * Dokumen harus bertipe pdf, doc atau docx</p>
												</div>
											</div>
											<?php if($dt['filedata'] != ""){?>
												<div class="col-md-1">
													<div class="form-group">
														<label>&nbsp;</label>
														<a href="<?php echo site_url('bulanan/aset_investasi/get_file_kewajiban/'.(isset($dt['id']) ? $dt['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:25px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
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
													<textarea name="keterangan[]" placeholder="Keterangan" class="form-control"><?php echo (isset($dt['keterangan']) ? $dt['keterangan'] : '');?></textarea>
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
									<a href="<?php echo site_url('bulanan/dana_bersih').get_uri();?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
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


	
	});

	// get combo nama pihak
	if(sts == "add"){
		$('#jenis_kas').on('change', function(){

			$('.aruskas_div').remove();
			$.post(host+'arus-kas-display/get_arus_kas'+uri, { 'jenis_kas':$('#jenis_kas').val(), [csrf_token]:csrf_hash }, function(resp){
				if(resp){
					$('.id_aruskas').empty();
					data_aruskas = resp;

					$('.id_aruskas').append(data_aruskas);
				}
			});
			$.post(host+'arus-kas-display/get_all_kas'+uri, { 'jenis_kas':$('#jenis_kas').val(), [csrf_token]:csrf_hash }, function(resp1){
				if(resp1){
				// console.log(resp1);
				tambah_row_div('aruskas_div', resp1);
			}
		});
		});
	}

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
						window.location = host+'bulanan/dana_bersih'+uri;
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