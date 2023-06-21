
		<div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">User</h4>
		</div>
        <div class="modal-body">
			<!-- form start -->
            <?php if(!empty($data_user)){
				?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('master/master_data/save_user').'/'.$data_user['iduser'];?>">
            <?php }else{
				?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('master/master_data/save_user');?>">
            <?php } ?>
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
            <div class="row">
				  <div class="col-md-12">
					  <div class="form-group">
						<label class="col-sm-4 control-label" for="iduser">ID User</label>
						<div class="col-sm-6">
						  <input type="text" value="<?php echo !empty($data_user) ? $data_user['iduser'] : '';?>" name="iduser" placeholder="iduser" id="iduser" class="form-control"/>
						</div>
					  </div>
					  <div class="form-group">
						<label class="col-sm-4 control-label" for="nmuser">Nama User</label>
						<div class="col-sm-6">
						  <input name="nmuser" type="text" value="<?php echo !empty($data_user) ? $data_user['nmuser'] : '';?>" id="nmuser" class="form-control " placeholder="nama user"/>
						</div>
					  </div>
					  <div class="form-group">
						 <label class="col-sm-4 control-label" for="idusergroup">ID User Group</label>
						  <div class="col-sm-6">
							<select class="form-control" id="idusergroup" name="idusergroup" required="required">
								<option value="">
								-- Pilih Jenis User --
								</option>
									<?php if(isset($data_group) && is_array($data_group)){?>
									<?php foreach($data_group as $group){?>
								<option value="<?php echo $group->idusergroup;?>" <?php if(!empty($data_user) && $group->idusergroup == $data_user['idusergroup']) echo 'selected="selected"';?>>
									<?php echo $group->idusergroup.' - '.$group->nmusergroup;?>
								</option>
									<?php }?>
								<?php }?>
							</select>
						  </div>
						</div>
						<div class="form-group">
						 <label class="col-sm-4 control-label" for="level">Level</label>
						  <div class="col-sm-6">
							<select class="form-control" id="level" name="level" required="required">
								<option value="">
								-- Pilih Level User --
								</option>
								<option value="DJA">DJA</option>
								<option value="TASPEN">TASPEN</option>
								<option value="ASABRI">ASABRI</option>
							</select>
						  </div>
						</div>
					  <div class="form-group">
						<label class="col-sm-4 control-label" for="password">Password</label>
						<div class="col-sm-6">
						  <input name="password" type="password" value="<?php echo !empty($data_user) ? $data_user['password'] : '';?>" id="password" class="form-control " placeholder="password"/>
						</div>
					  </div>
                </div>
                </div>
              <!-- /.box-body -->
              <div class="modal-footer">
				   <div class="col-sm-12">
						<button class="btn btn-primary btn-flat" type="submit">
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

  
	