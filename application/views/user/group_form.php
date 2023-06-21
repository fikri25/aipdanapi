<div class="modal-dialog" style="width:700px; margin-top: 100px">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Form User Group</h4>
		</div>
		<div class="modal-body">
			<!-- form start -->
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger error" style="display: none;color: red; text-align: center;"></div>
				</div>
			</div>
			<form id="form_group" class="form-horizontal">
				<input type="hidden" value="<?php echo !empty($data_group) ? $data_group['idusergroup'] : '';?>" name="idusergroup" class="form-control"/>
				<input type="hidden" value="<?php echo !empty($sts) ? $sts : 'add';?>" name="sts" class="form-control"/>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-4 control-label" for="nmusergroup">User Group</label>
							<div class="col-sm-6">
								<input type="text" value="<?php echo !empty($data_group) ? $data_group['nmusergroup'] : '';?>" name="nmusergroup" placeholder="user group" id="nmusergroup" class="form-control"/>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<button onclick="simpan()" class="btn btn-primary btn-flat simpan" type="button" >
							Simpan
						</button>
						<button id="batal" type="reset" class="btn btn-warning btn-flat"  data-dismiss="modal" aria-hidden="true">
							Batal
						</button>
					</div>
				</div>
				<!-- /.box-footer -->
			</form>
		</div>

	</div>

</div>


<script type="text/javascript">
	function simpan(){
		var data = $('#form_group').serialize();
		$.LoadingOverlay("show"); 
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('user/simpan_group')?>",
			data: data,
			dataType: 'json',
			success: function(res){ 
				$.LoadingOverlay("hide", true);
				if($.isEmptyObject(res.error)){
					$('.error').css('display', 'none');
					$('.error').html(res.error);
				}else{
					$('.error').css('display', 'block');
					$('.error').html(res.error);
					notif_none();
				}
				
				if (res == 1) {
					$('#modal_group').modal('hide');
					$.messager.alert('SMART AIP','Data Tersimpan','info');
					setTimeout(function(){
						window.location.href="<?php echo base_url('user/role_setting'); ?>";
					}, 2000);
				}else if(res == 0) {
					$.messager.alert('SMART AIP','Proses Simpan Data Gagal','warning'); 
				}
			}
		});
	}


	function notif_none(){
		setTimeout(function(){$(".error").fadeOut('slow');},3000);
	}

</script>

