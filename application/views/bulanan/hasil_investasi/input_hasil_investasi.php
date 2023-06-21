<style type="text/css">
td.dataTables_empty{
	text-align: center;
}
/*.odd*/
</style>
<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>investasi-simpan/hasil_investasi" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id" value="<?php echo !empty($data) ? $data['id'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($id_bulan) ? $id_bulan['id_bulan'] : $this->session->userdata('id_bulan');?>">
	<?php if($editstatus == "edit"){ ?>
		<input type="hidden" name="id_investasi" value="<?php echo !empty($data) ? $data['id_investasi'] : '';?>">
	<?php } ?>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Hasil Investasi</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis Hasil Investasi<font color="red">&nbsp;*</font></label>
										<select class="form-control select2nya combo" id="id_investasi" name="id_investasi" required="required">
											<option value="">
												-- Pilih Jenis Hasil Investasi --
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
								<div class="col-md-4">
									<div class="form-group">
										<label>RIT<font color="red">&nbsp;*</font></label>
										<input type="text" placeholder="RIT" class="form-control format_number hasil" id="rka" name="rka" value="<?php echo !empty($data) ? $data['rka'] : '';?>" required="required">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Realisasi RIT (%)</label>
										<input type="text" placeholder="Realisasi RIT" class="form-control" id="realisasi_head" name="realisasi_rka" value="<?php echo !empty($data) ? $data['realisasi_rka'] : '';?>" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>Target YOI (%)</label>
										<input type="text" placeholder="Target YOI" class="form-control persentase" id="target_yoi" name="target_yoi" value="<?php echo !empty($data) ? $data['target_yoi'] : '';?>">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Saldo Awal</label>
										<input type="text" placeholder="Total Saldo Awal" class="form-control negative hasil" id="saldo_awal_invest" name="saldo_awal_invest" value="<?php echo !empty($data) ? $data['saldo_awal_invest'] : '';?>" required="required">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Mutasi</label>
										<input type="text" placeholder="Total Mutasi" class="form-control negative hasil" id="mutasi_invest" name="mutasi_invest" value="<?php echo !empty($data) ? $data['mutasi_invest'] : '';?>" required="required">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Saldo Akhir</label>
										<input type="text" placeholder="Total Saldo Akhir" class="form-control format_number" id="saldo_akhir_head" name="saldo_akhir_invest" value="<?php echo !empty($data) ? $data['saldo_akhir_invest'] : '';?>" readonly>
									</div>
								</div>
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
											<a href="<?php echo site_url('bulanan/aset_investasi/get_file_jenis/'.(isset($data['id']) ? $data['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:27px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
										</div>
									</div>
								<?php } ?>
							</div>
							<!-- KETERANGAN -->
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Keterangan</label>
										<textarea name="keterangan" placeholder="Keterangan" class="form-control"><?php echo (isset($data['keterangan']) ? $data['keterangan'] : '');?></textarea>
									</div>
								</div>
							</div>	

							<p style="font-size: 12px; font-style: italic; color: red" class="peringatan"> * Saldo awal dan RIT otomatis terisi apabila sudah input data bulan sebelumnya</p>

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
	var data_invest ='<?= !empty($data) ? $data['id_investasi'] : ''?>';
	

	$(document).ready(function(){
		$('.format_number').number(true, 0, ',', '.');
		$('.rupiah').number(true,0);
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

		new AutoNumeric.multiple('.persentase', {
			alwaysAllowDecimalCharacter: true,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			suffixText: "%",
			decimalPlacesShownOnFocus: 2,
			unformatOnSubmit: true,
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


		// $('.tbl-form').DataTable({
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
								$('#saldo_awal_invest').val("");
								$('#rka').val("");
							}else{

								$('#saldo_awal_invest').val(parsing_bln_lalu.saldo_bln_lalu);
								$('#rka').val(parsing_bln_lalu.rka);
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

	// edit
	if(sts == "edit"){
		$(".combo").select2({'disabled': true,});
	}

	$(".hasil").on("keyup", function(){
		calculateHasilInvestasi();
	});

	function calculateHasilInvestasi(){
		var saldo_awal_head = 0;
		var mutasi_head = 0;
		var rka = 0;
		var saldoakhir_head = 0;

		saldoawal_head = parseFloat($("#saldo_awal_invest").val().replace(/\./g,''));
		rka = parseFloat($("#rka").val().replace(/\./g,''));
		mutasi_head = parseFloat($("#mutasi_invest").val().replace(/\./g,''));


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
		saldo_awal_invest : "required",
		mutasi_invest : "required",
		
	};

	var messagesnya = {
		id_investasi : "<i style='color:red'>Harus Diisi</i>",
		rka : "<i style='color:red'>Harus Diisi</i>",
		saldo_awal_invest : "<i style='color:red'>Harus Diisi</i>",
		mutasi_invest : "<i style='color:red'>Harus Diisi</i>",
		
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
						window.location = host+'bulanan/hasil_investasi'+uri;
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