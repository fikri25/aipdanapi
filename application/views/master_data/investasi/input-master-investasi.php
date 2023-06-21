<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}
	/*.odd*/
</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>master-simpan/master_investasi" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id_investasi" value="<?php echo !empty($data) ? $data['id_investasi'] : '';?>">
	<input type="hidden" name="no_urut" value="<?php echo !empty($data) ? $data['no_urut'] : '';?>">
	<input type="hidden" name="no_urut_group" value="<?php echo !empty($data) ? $data['no_urut_group'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Master Data Investasi</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-2">
									<label>User<font color="red">&nbsp;*</font></label>
									<select class="form-control select2nya" id="iduser" name="iduser" required="required">
										<option value="">
											-- Pilih --
										</option>
										<?php if(isset($opt_user) && is_array($opt_user)){?> 
											<?php foreach($opt_user as $k=>$v){?>
												<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['iduser']) echo 'selected="selected"';?>>
													<?php echo $v['txt'];?>
												</option>
											<?php }?>
										<?php }?>
									</select>
									<label class="validation_error_message" for="iduser"></label>
								</div>
								<div class="col-md-3">
									<label>Group Investasi<font color="red">&nbsp;*</font></label>
									<select class="form-control select2nya group" id="group" name="group" required="required">
										<option value="">
											-- Pilih --
										</option>
										<?php if(isset($group) && is_array($group)){?> 
											<?php foreach($group as $k=>$v){?>
												<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['group']) echo 'selected="selected"';?>>
													<?php echo $v['txt'];?>
												</option>
											<?php }?>
										<?php }?>
									</select>
									<label class="validation_error_message" for="group"></label>
								</div>
								<div class="col-md-3 dt1">
									<label>Group Dana Bersih<font color="red">&nbsp;*</font></label>
									<select class="form-control select2nya id_dana_besih" id="id_dana_besih" name="id_dana_besih">
										<option value="">
											-- Pilih --
										</option>
										<?php if(isset($opt_danabersih) && is_array($opt_danabersih)){?> 
											<?php foreach($opt_danabersih as $k=>$v){?>
												<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['id_dana_besih']) echo 'selected="selected"';?>>
													<?php echo $v['txt'];?>
												</option>
											<?php }?>
										<?php }?>
									</select>
									<label class="validation_error_message" for="id_dana_besih"></label>
								</div>
								<div class="col-md-4 dt2">
									<label>Group Perubahan Dana Bersih<font color="red">&nbsp;*</font></label>
									<select class="form-control select2nya id_perubahan_dana_bersih" id="id_perubahan_dana_bersih" name="id_perubahan_dana_bersih">
										<option value="">
											-- Pilih --
										</option>
										<?php if(isset($opt_perubahan) && is_array($opt_perubahan)){?> 
											<?php foreach($opt_perubahan as $k=>$v){?>
												<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['id_perubahan_dana_bersih']) echo 'selected="selected"';?>>
													<?php echo $v['txt'];?>
												</option>
											<?php }?>
										<?php }?>
									</select>
									<label class="validation_error_message" for="id_perubahan_dana_bersih"></label>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-7">
									<div class="form-group">
										<label>Jenis Investasi<font color="red">&nbsp;*</font></label>
										<input type="text" placeholder="Jenis Investasi" class="form-control" id="jenis_investasi" name="jenis_investasi" value="<?php echo !empty($data) ? $data['jenis_investasi'] : '';?>" required="required">
									</div>
								</div>
								<div class="col-md-2">
									<label>Jenis Form</label>
									<select class="form-control select2nya" id="jns_form" name="jns_form">
										<option value="">
											-- Pilih --
										</option>
										<?php if(isset($form) && is_array($form)){?> 
											<?php foreach($form as $k=>$v){?>
												<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['jns_form']) echo 'selected="selected"';?>>
													<?php echo $v['txt'];?>
												</option>
											<?php }?>
										<?php }?>
									</select>
								</div>
								<div class="col-md-3">
									<label>Type Data<font color="red">&nbsp;*</font></label>
									<select class="form-control select2nya" id="type_sub_jenis_investasi" name="type_sub_jenis_investasi" required="required">
										<option value="">
											-- Pilih --
										</option>
										<?php if(isset($type) && is_array($type)){?> 
											<?php foreach($type as $k=>$v){?>
												<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['type_sub_jenis_investasi']) echo 'selected="selected"';?>>
													<?php echo $v['txt'];?>
												</option>
											<?php }?>
										<?php }?>
									</select>
									<label class="validation_error_message" for="type_sub_jenis_investasi"></label>
								</div>
							</div>	
							<div class="row" id="sub">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Sub Jenis Investasi</legend>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th width="10%">No Urut</th>
														<th width="85%">Sub Jenis Investasi</th>
														<th class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
													</tr>
												</thead>
												<tbody class="form_master_investasi">
													<?php if($editstatus == "edit") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_1" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut_sub[]" class="form-control no_urut_1" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<input type="text" name="jenis_investasi_sub[]" class="form-control jenis_investasi_sub" id="jenis_investasi_sub_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['jenis_investasi'];?>"/>		
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
	$('.dt2').hide();
	$('.dt1').hide();	

	$(document).ready(function(){
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );
	
		// $('#tbl-form').DataTable({
		// 	"paging":false,
		// 	"searching": false,
		// 	"ordering": false,
		// 	"lengthChange": false,
		// 	"info": false,
		// });
		// get data bulan lalu
		$('#id_investasi').on('change', function(){
			$.post(host+'investasi-display/cek_aset_investasi'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp){
				if(resp){
					parsing = JSON.parse(resp);
					
					if(parsing.total == '0'){
						$.post(host+'investasi-display/data_bulan_lalu_hasilinvest'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp1){

							parsing_bln_lalu = JSON.parse(resp1)
							if(parsing_bln_lalu == "" || parsing_bln_lalu == null ){
								$('#saldo_awal_head').val(0);
							}else{

								$('#saldo_awal_head').val(parsing_bln_lalu.saldo_bln_lalu);
							}

							console.log(parsing_bln_lalu);

						});
					}else{
						$.messager.alert('SMART AIP','Anda sudah input data '+parsing.jenis_investasi+' !','warning');
						return false;
					}
				}
			});

		});


	});

	$('.tambah_detail').on('click', function(){
		var val = $('#type_sub_jenis_investasi').val();
		if(val == "" || val == null){
			$.messager.alert('SMART AIP','Pilih Tipe terlebih dahulu!','warning');
			return false;	
		}
		if(val == 'PC'){
			tambah_row('form_master_investasi');
		}else{
			$.messager.alert('SMART AIP','Tipe data harus PC!','warning');
			return false;
		}
	});

	$('.group').on('change', function(){
		var val = $(this).val();
		console.log(val);
		if(val == 'INVESTASI' || val == 'BUKAN INVESTASI' || val == 'KEWAJIBAN'){
			$('.dt1').show();
			$('.dt2').hide();
		}else if (val == 'HASIL INVESTASI' || val == 'IURAN' || val == 'BEBAN' || val == 'NILAI INVESTASI' || val == 'ASET TETAP') {
			$('.dt2').show();
			$('.dt1').hide();
		}else{
			$('.dt2').hide();
			$('.dt1').hide();	
		}
		
	});

	// edit
	if(sts == "edit"){
		$( document ).ready(function() {
			$('.group').trigger('change');
			
		});
	}

	
	// form action
	var rulesnya = {
		iduser : "required",
		jenis_investasi : "required",
		group : "required",
		type_sub_jenis_investasi : "required",
		
	};

	var messagesnya = {
		iduser : "<i style='color:red'>Harus Diisi</i>",
		jenis_investasi : "<i style='color:red'>Harus Diisi</i>",
		group : "<i style='color:red'>Harus Diisi</i>",
		type_sub_jenis_investasi : "<i style='color:red'>Harus Diisi</i>",
		
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
						window.location = host+'master/master_data/master_investasi';
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