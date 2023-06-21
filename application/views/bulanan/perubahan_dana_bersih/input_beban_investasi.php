<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}

</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>investasi-simpan/beban_investasi" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($id_bulan) ? $id_bulan['id_bulan'] : $this->session->userdata('id_bulan');?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Beban Investasi</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis Beban Investasi</label>
										<select class="form-control combo-invest" id="id_investasi" name="id_investasi" required="required">
											<option value="">
												-- Pilih --
											</option>
											<?php if(isset($combo) && is_array($combo)):?>
												<?php foreach($combo as $combo_beban):?>
													<option value="<?= $combo_beban['id'];?>" 
														<?php if(!empty($data) && $combo_beban['id'] == $data['id']) echo 'selected="selected"';?> >
														<?= $combo_beban['txt'];?>
													</option>
												<?php endforeach;?>
											<?php endif;?>
										</select>
										<label class="validation_error_message" for="id_investasi"></label>
									</div>
								</div>
							</div>
							
							<div class="beban_div_" id="beban_div" idx="" style="border:1px solid #F0F0F0;padding:10px;background-color:#F6F6F6;">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label><span class="lebel"></span></label> 
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label>Saldo Awal</label> 

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
											<div class="col-md-3">
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
													<input type="text" name="saldo_awal[]" id="saldo_awal_" class="form-control format_number saldo_awal" placeholder="Saldo Awal" value="<?= $detail['saldo_awal'];?>"/>
												</div>
											</div>  
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" name="saldo_akhir[]" id="saldo_akhir_" class="form-control format_number saldo_akhir" placeholder="Saldo Akhir" value="<?= $detail['saldo_akhir'];?>"/>
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label> 
													<input type="text" name="rka[]" id="rka_" class="form-control format_number rka" placeholder="RKA" value="<?= $detail['rka'];?>"/>
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
														<a href="<?php echo site_url('bulanan/aset_investasi/get_file_beban_investasi/'.(isset($detail['id']) ? $detail['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:25px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
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
									<a href="<?php echo site_url('beban-investasi').get_uri();?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
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
		var investasi_txt = $('#id_investasi option:selected').text()
		
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
			$('.lebel').html('Beban Investasi');
		}else{
			if($('#id_investasi').val() != "") {
				$('.lebel').html(investasi_txt);
			}else{
				$('.lebel').html('Beban Investasi');
			}	
		}

	
	});

	if(sts == "add" || sts == "edit"){
		$('#id_investasi').on('change', function(){
			$('.beban_div').remove();
			var id_investasi = $('#id_investasi').val()
			$.post(host+'perubahan-danabersih-form/beban_investasi/'+id_investasi+uri, { 'editstatus':'edit','id':id_investasi, [csrf_token]:csrf_hash }, function(resp){
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
						window.location = host+'beban-investasi'+uri;
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