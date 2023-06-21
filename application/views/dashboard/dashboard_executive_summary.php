<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Pilihan</h3>
        </div>
        <div class="box-body">
          <div class="col-md-3">
            <div class="form-group">
              <select class="form-control select2nya" id="iduser">
                <option value="">
                  -- Pilih User--
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
          <div class="col-md-3">
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
          <div class="col-md-3 bln">
            <div class="form-group">
              <select class="form-control select2nya" id="id_bulan">
                <option value="">
                  -- Pilih Bulan --
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
          <div class="col-md-1">
            <div class="form-group">
              <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat tombol_cari" onClick="gendashboardsearch('index-dashboard-analisis','index-dashboard-analisis');">
                <i class="fa fa-search"></i>
              </a> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="content-dashboard">
 <?php $this->load->view('dashboard/dashboard_executive_summary_bulanan'); ?>
</div>
<script type="text/javascript">
	$('.bln').hide();
  $('.smt').hide();
  $('.thn').hide();

  $(".select2nya").select2( { 'width':'100%' } );


  $('#dashboard').on('change', function(){
    var val = $(this).val();
    console.log(val);
    if(val == 'BULANAN'){
        $('.bln').show();
        $('.smt').hide();
        $('.thn').hide();
    }else if(val == 'SEMESTERAN'){
        $('.bln').hide();
        $('.smt').show();
        $('.thn').hide();
    }else if(val == 'TAHUNAN'){
        $('.bln').hide();
        $('.smt').hide();
        $('.thn').show();
    }else{
        $('.bln').hide();
        $('.smt').hide();
        $('.thn').hide();
    }
    
});

$('.tahun').text(tahun);
</script>

