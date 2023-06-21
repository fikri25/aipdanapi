
		<div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Jenis Klaim</h4>
		</div>
        <div class="modal-body">
			<!-- form start -->
            <?php if(!empty($data_jenis_klaim)){
				?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('master/master_data/save_jenis_klaim').'/'.$data_jenis_klaim['kode_klaim'];?>">
            <?php }else{
				?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('master/master_data/save_jenis_klaim');?>">
            <?php } ?>
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
            <div class="row">
				  <div class="col-md-12">
					  <div class="form-group">
						<label class="col-sm-4 control-label" for="kode_klaim">Kode KLaim</label>
						<div class="col-sm-6">
						  <input type="text" value="<?php echo !empty($data_jenis_klaim) ? $data_jenis_klaim['kode_klaim'] : '';?>" name="kode_klaim" placeholder="Kode" id="kode_klaim" class="form-control"/>
						</div>
					  </div>
					  <div class="form-group">
						<label class="col-sm-4 control-label" for="jenis_klaim">Jenis Klaim</label>
						<div class="col-sm-6">
						  <input name="jenis_klaim" type="text" value="<?php echo !empty($data_jenis_klaim) ? $data_jenis_klaim['jenis_klaim'] : '';?>" id="jenis_klaim" class="form-control " placeholder="Klaim"/>
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

  
	