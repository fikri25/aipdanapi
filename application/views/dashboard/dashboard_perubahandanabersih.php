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
              <div class="col-md-3" style="display: none;">
                <div class="form-group">
                  <select class="form-control select2nya" id="dashboard">
                    <option value="">
                      -- Pilih Laporan --
                    </option>
                    <?php if(isset($opt_dashboard) && is_array($opt_dashboard)){?> 
                      <?php foreach($opt_dashboard as $k=>$v){?>
                        <option value="<?php echo $v['id'];?>" <?php if(!empty($iduser) && $v['id'] == $iduser) echo 'selected="selected"';?>>
                          <?php echo $v['txt'];?>
                        </option>
                      <?php }?>
                    <?php }?>
                  </select>
                </div>
              </div> 
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jenis Detail</label>
                  <select class="form-control select2nya" id="jns_lap">
                    <option value="">
                      --Pilih--
                    </option>
                    <?php if(isset($opt_perubahandanabersih) && is_array($opt_perubahandanabersih)){?> 
                      <?php foreach($opt_perubahandanabersih as $k=>$v){?>
                        <option value="<?php echo $v['id'];?>" <?php if(!empty($iduser) && $v['id'] == $iduser) echo 'selected="selected"';?>>
                          <?php echo $v['txt'];?>
                        </option>
                      <?php }?>
                    <?php }?>
                  </select>
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label>Bulan Awal</label>
                  <select class="form-control select2nya" id="bln_awal">
                    <option value="">
                      --Pilih--
                    </option>
                    <?php if(isset($opt_bln) && is_array($opt_bln)){?> 
                      <?php foreach($opt_bln as $k=>$v){?>
                        <option value="<?php echo $v['id'];?>" <?php if(!empty($id_bulan) && $v['id'] == $id_bulan) echo 'selected="selected"';?>>
                          <?php echo $v['txt'];?>
                        </option>
                      <?php }?>
                    <?php }?>
                  </select>
                </div>
              </div> 
              <div class="col-md-2" style="margin-right: -40px;margin-left: -20px;">
                <div class="form-group">
                  <label>Tahun Awal</label>
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
                  <p style="text-align: center;font-size: 12pt;font-weight: bold;">s/d</p>
                </div>
              </div>
              <div class="col-md-2" style="margin-left: -40px;margin-right: -20px;">
                <div class="form-group">
                  <label>Bulan Akhir</label>
                  <select class="form-control select2nya" id="bln_akhir">
                    <option value="">
                      --Pilih--
                    </option>
                    <?php if(isset($opt_bln) && is_array($opt_bln)){?> 
                      <?php foreach($opt_bln as $k=>$v){?>
                        <option value="<?php echo $v['id'];?>" <?php if(!empty($id_bulan) && $v['id'] == $id_bulan) echo 'selected="selected"';?>>
                          <?php echo $v['txt'];?>
                        </option>
                      <?php }?>
                    <?php }?>
                  </select>
                </div>
              </div> 
              <div class="col-md-2">
                <div class="form-group">
                  <label>Tahun Akhir</label>
                  <select class="form-control select2nya" id="tahun_akhir">
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
                  <br>
                  <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat tombol_cari" onClick="gendashboardsearch('index-dashboard-perubahandanabersih','index-dashboard-perubahandanabersih');">
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
 <?php $this->load->view('dashboard/dashboard_perubahandanabersih_detail'); ?>
</div>

<script type="text/javascript">

  $(".select2nya").select2( { 'width':'100%' } );

</script>
