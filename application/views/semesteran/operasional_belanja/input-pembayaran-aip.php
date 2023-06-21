<style type="text/css">
	td.dataTables_empty{
		text-align: center;
	}
	/*.odd*/
</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>aspek-operasional-simpan/pembayaran_aip" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id" value="<?php echo !empty($data) ? $data['id'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<!-- Kode sumber dana 1 = APBN , 2 = AIP -->
	<input type="hidden" name="sumber_dana" value="1">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Pembayaran Pensiun</h3>
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
								<div class="col-md-3">
									<div class="form-group">
										<label>Kelompok Penerima<font color="red">&nbsp;*</font></label>
										<select class="form-control select2nya" name="kelompok" id="kelompok">
											<option value="">
												-- Pilih --
											</option>
											<?php if(isset($kelompok) && is_array($kelompok)){?> 
												<?php foreach($kelompok as $k=>$v){?>
													<option value="<?php echo $v['id'];?>" <?php if(!empty($data) && $v['id'] == $data['id_kelompok']) echo 'selected="selected"';?>>
														<?php echo $v['txt'];?>
													</option>
												<?php }?>
											<?php }?>
										</select>
										<label class="validation_error_message" for="kelompok"></label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<label>Jenis Penerima</font></label>
								</div>
								<div class="col-md-3">
									<label>RKA Penerima<font color="red">&nbsp;*</font></label>
								</div>
								<div class="col-md-3">
									<label>RKA Pembayaran<font color="red">&nbsp;*</font></label>
								</div>
							</div>
							<?php if($editstatus == "edit") :?>
								<?php if(isset($data_detail) && is_array($data_detail)):?>
								<?php $idx=1;?>
								<?php foreach($data_detail as  $detail):?>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<input type="hidden" class="form-control id_penerima" name="id_penerima[]" value="<?= $detail['id_penerima'];?>">
												<input type="text" class="form-control jenis_penerima" id="jenis_penerima_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['jenis_penerima'];?>" disabled="disabled"/>		
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<input type="text" name="rka_penerima[]" class="form-control rka_penerima format_number" id="rka_penerima_<?=$idx;?>" idx="<?=$idx;?>" value="<?= !empty($detail) ? $detail['rka_penerima'] : '';?>" placeholder="RKA (Penerima)"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<input type="text" name="rka_pembayaran[]" class="form-control rka_pembayaran format_number" id="rka_pembayaran_<?=$idx;?>" idx="<?=$idx;?>" value="<?= !empty($detail) ? $detail['rka_pembayaran'] : '';?>" placeholder="RKA (Pembayaran)"/>	
											</div>
										</div>
									</div>
								<?php $idx++;?>
								<?php endforeach;?>
								<?php endif;?>
							<?php endif;?>

							<?php if($editstatus == "add") :?>
								<?php if(isset($jenis) && is_array($jenis)):?>
								<?php $idx=1;?>
								<?php foreach($jenis as  $detail):?>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<input type="hidden" class="form-control id_penerima" name="id_penerima[]" value="<?= $detail['id'];?>">
												<input type="text" class="form-control jenis_penerima" id="jenis_penerima_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['txt'];?>" disabled="disabled"/>		
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<input type="text" name="rka_penerima[]" class="form-control rka_penerima format_number" id="rka_penerima_<?=$idx;?>" idx="<?=$idx;?>" placeholder="RKA (Penerima)"/>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<input type="text" name="rka_pembayaran[]" class="form-control rka_pembayaran format_number" id="rka_pembayaran_<?=$idx;?>" idx="<?=$idx;?>" placeholder="RKA (Pembayaran)"/>	
											</div>
										</div>
									</div>
								<?php $idx++;?>
								<?php endforeach;?>
								<?php endif;?>
							<?php endif;?>
							<br>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<button href="javascript:void(0);" id="save" class="btn btn-primary btn-flat" type="submit">
										Simpan
									</button>	
									<a href="<?php echo site_url('semesteran/operasional_belanja/pembayaran_pensiun');?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
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
	var kelompok ='<?= !empty($data) ? $data['id_kelompok'] : ''?>';

	

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



		// $('.format_number').keyup(function(){
		// 	let v = $(this).val();
		// 	const neg = v.startsWith('-');

		// 	v = v.replace(/[-\D]/g,'');

		// 	v = v != ''?''+v:'';
		// 	if(neg) v = '-'.concat(v);

		// 	$(this).val(v);
		// });


		// currency minus

		// $('.format_number').on('keyup',function(){
		// 	var customCurrency = value => currency(value, { pattern: '!#', negativePattern: '(!#)', separator: ".", precision: 0});
		// 	// customCurrency(1234567.89).format();  // => "$ 1,234,567.89"
		// 	let v = customCurrency($(this).val()).format(); // => "($ 1,234,567.89)"
		// 	$('#rka').val(v);
		// });


		$('.tbl-form').DataTable({
			"paging":false,
			"searching": false,
			"ordering": false,
			"lengthChange": false,
			"info": false,
		});


	});

	// edit
	// if(sts == "edit"){
	// 	$( document ).ready(function() {
	// 		$('#id_investasi').val(data_invest).trigger('change');
	// 		// $(".combo-invest").select2({'disabled': true,});
			
	// 	});
	// }

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
						window.location = host+'semesteran/operasional_belanja/pembayaran_pensiun';
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