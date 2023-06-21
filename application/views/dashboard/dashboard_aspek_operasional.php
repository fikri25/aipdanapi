<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Pilihan</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label>User</label>
                  <select class="form-control select2nya" id="iduser">
                    <option value="">
                      --Pilih User--
                    </option>
                    <?php if(isset($opt_user) && is_array($opt_user)){?> 
                      <?php foreach($opt_user as $k=>$v){?>
                        <option value="<?php echo $v['id'];?>" <?php if(!empty($iduser) && $v['id'] == $iduser) echo 'selected="selected"';?>>
                          <?php echo $v['txt'];?>
                        </option>
                      <?php }?>
                    <?php }?>
                  </select>
                </div>
              </div> 
              <div class="col-md-2" style="">
                <div class="form-group">
                  <label>Tahun</label>
                  <select class="form-control select2nya" id="tahun_awal">
                    <option value="">
                      --Pilih--
                    </option>
                    <?php
                    $thn_skr = date('Y');
                    for($x = $thn_skr; $x >= 2019; $x--){
                      ?>  
                      <option value="<?php echo $x?>"> <?php echo $x ?></option>
                      <?php 
                    }
                    ?>
                  </select>
                </div>
              </div> 
              <div class="col-md-1">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <br>
                  <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat tombol_cari" onClick="gendashboardsearch('index-aspek-operasional','index-aspek-operasional');">
                    <i class="fa fa-search"></i>
                  </a> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="content-dashboard">
 <?php $this->load->view('dashboard/dashboard_aspek_operasional_head'); ?>
</div>

<script type="text/javascript">

  $(".select2nya").select2( { 'width':'100%' } );

</script>
