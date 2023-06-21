<div class="modal-dialog" style="">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Form User</h4>
		</div>
		<div class="modal-body">
			<!-- form start -->
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger error" style="display: none;color: red; text-align: center;"></div>
				</div>
			</div>
			<form id="form_user" class="form-horizontal">
				<input type="hidden" value="<?php echo !empty($sts) ? $sts : 'add';?>" name="sts" class="form-control"/>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group" hidden>
							<label class="col-sm-4 control-label" for="iduser">User ID</label>
							<div class="col-sm-6">
								<input type="text" value="<?php echo !empty($data_user) ? $data_user['iduser'] : '';?>" name="iduser" placeholder="iduser" id="iduser" class="form-control" <?php if ($sts == 'edit'){ echo 'readonly';}?>/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="idusergroup">User Group</label>
							<div class="col-sm-6">
								<select class="form-control" id="idusergroup" name="idusergroup">
								<?php if(isset($group) && is_array($group)){?>
										<?php foreach($group as $gp){?>
											<option value="<?php echo $gp['idusergroup'];?>" <?php if(!empty($data_user) && $gp['idusergroup'] == $data_user['idusergroup']) echo 'selected="selected"';?>>
												<?php echo $gp['nmusergroup'];?>
											</option>
										<?php }?>
									<?php }?>
									
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="nama_lengkap">Nama Lengkap</label>
							<div class="col-sm-6">
								<input type="text" value="<?php echo !empty($data_user) ? $data_user['nama_lengkap'] : '';?>" name="nama_lengkap" placeholder="nama" id="nmuser" class="form-control"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="username">Username</label>
							<div class="col-sm-6">
								<input name="nmuser" type="text" value="<?php echo !empty($data_user) ? $data_user['nmuser'] : '';?>" id="username" class="form-control format_number" placeholder="nmuser"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="password">Password</label>
							<div class="col-sm-6">
								<!-- <div class="input-group"> -->
									<input type="hidden" name="password_lama"  value="<?php echo !empty($pass) ? $pass : '';?>">
									<div class="input-group">
										<input type="password" name="password" placeholder="password" id="pass" class="form-control required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"/>
										<span class="input-group-addon">
											<a href="javascript:void(0);" onclick="konversi_pwd_text('pass')" id="iconPass"><i class="fa fa-eye"></i></a>
										</span> 
									</div>
									<!-- <span class="input-group-addon">
										<a href="javascript:void(0);" onclick="konversi_pwd_text()">Show</a>
									</span>  -->
								<!-- </div> -->
								<?php if ($sts == 'edit'):?>
									<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Input password jika ingin diubah, kosongkan password jika tidak ingin diubah</p>
								<?php endif; ?>
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
						<button type="reset" class="btn btn-warning btn-flat"  data-dismiss="modal" aria-hidden="true">
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
	$('#idusergroup').select2({ width: '100%' });

	$('#modal_user').on('hidden.bs.modal',function(e){
		$('#modal_user').removeData();
	});

	function simpan(){
		var data = $('#form_user').serialize();
		$.LoadingOverlay("show"); 
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('user/simpan_user')?>",
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
					$('#modal_user').modal('hide');
					$.messager.alert('SMART AIP','Data Tersimpan','info');
					setTimeout(function(){
						window.location.href="<?php echo base_url('user'); ?>";
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
    
    function konversi_pwd_text(id){
		if($('input#'+id)[0].type=="password"){
			$('input#'+id)[0].type = 'text';
			$('#iconPass').html('<i class="fa fa-eye-slash"></i>');
		}
		else {
			$('input#'+id)[0].type = 'password';
			$('#iconPass').html('<i class="fa fa-eye"></i>');
		}
	}
</script>

