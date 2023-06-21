 <!-- Main content -->
 <div class="row">
 	<div class="col-xs-12">
 		<div class="nav-tabs-custom">
      <?php $this->load->view('main/nav_tab_nama_pihak'); ?>
 			<div class="box box-default">
 				<div class="box-header with-border">
 					<h3 class="box-title">Nama Pihak</h3>
 				</div>
 				<!-- /.box-header -->
 				<div class="box-body" style="overflow-x:auto;">	
 					<div class="col-md-12">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <select class="form-control select2nya" id="iduser">
                    <option value="">
                      -- Pilih User --
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
              <div class="col-md-1">
                <div class="form-group">
                  <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensearch('index-mst-pihak','index-mst-pihak');">
                    <i class="fa fa-search"></i>
                  </a> 
                </div>
              </div>
              <div  class="col-md-8"> 
                <div class="form-group pull-right">
                  <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat adm" onClick="
                  genform('mst_pihak','mst_pihak','mst_pihak','','','','','add');">
                  <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
                </a>  
              </div>
            </div>
          </div>
        </div>
 					<table id="tbl-pihak" class="table table-responsive table-bordered table-hover">
 						<thead>
 							<tr>
                <th>No</th>
 								<th>Kode Pihak</th>
                <th>Nama Pihak</th>
 								<th>User</th>
 								<th width="100">#</th>
 							</tr>
 						</thead>
 						<tbody>
 							<?php $no=1; ?>
              <?php if(isset($data_mst_pihak) && is_array($data_mst_pihak)):?>
              <?php foreach($data_mst_pihak as $pihak):?>
                <tr>
                  <td style="text-align: center;"><?= $no++;?></td>
                  <td style="text-align: center;"><?=$pihak['kode_pihak']?></td>
                  <td style="text-align: left;"><?=$pihak['nama_pihak']?></td>
                  <?php 
                    if($pihak['iduser'] == 'TSN002'){
                      $iduser = 'TASPEN';
                    }elseif ($pihak['iduser'] == 'ASB003') {
                      $iduser = 'ASABRI';
                    }
                  ?>
                  <td style="text-align: left;"><?=$iduser;?></td>
                  <td>
                    <a href="javascript:void(0)" title="Edit" class="btn btn-success btn-sm btn-flat adm" onClick="genform('mst_pihak','mst_pihak','mst_pihak','','<?=$pihak['id'] ?>','','','edit');">
                      <i class="fa fa-edit"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-sm btn-flat adm" onClick="genform('delete', 'mst_pihak','mst_pihak','','<?=$pihak['id'] ?>','','','edit');">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach;?>
              <?php endif;?>
           </tbody>
         </table>
       </div>
       <!-- /.box-body -->
       <div class="box-footer with-border">
        <div class="text-left">
         <!-- <?php echo $paggination;?> -->
       </div>
     </div>
     <!-- Modal input/edit -->
     <div id="modal_pihak" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog">
       <div class="modal-content">


       </div>
     </div>
   </div>
 </div>
 <!-- /.box -->
</div>
</div>
<!-- /.col -->
</div>
    <!-- row -->

<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );

    $('#tbl-pihak').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
    
</script>
       