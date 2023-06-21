 <!-- Main content -->
            <?php $level = $this->session->userdata('level');?>
            <?php $tahun = $this->session->userdata('tahun');?>
            <style type="text/css">
                td.subchild{
                    padding-left: 50px;
                }
            </style>
            <div class="row">
                <div class="col-xs-12">
				  <div class="nav-tabs-custom">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Jenis Investasi</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="overflow-x:auto;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control select2nya" id="group">
                                                <option value="">
                                                    -- Pilih Group --
                                                </option>
                                                <?php if(isset($group) && is_array($group)){?> 
                                                    <?php foreach($group as $k=>$v){?>
                                                        <option value="<?php echo $v['id'];?>" <?php if(!empty($dtgroup) && $v['id'] == $dtgroup) echo 'selected="selected"';?>>
                                                            <?php echo $v['txt'];?>
                                                        </option>
                                                    <?php }?>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensearch('index-master-investasi','index-master-investasi');">
                                                <i class="fa fa-search"></i>
                                            </a> 
                                        </div>
                                    </div>
                                    <div  class="col-md-6"> 
                                        <div class="form-group pull-right">
                                            <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat adm" onClick="
                                            genform('master_aset_investasi','master_aset_investasi','master_aset_investasi','','','','','add');">
                                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
                                            </a>  
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php if($this->session->flashdata('form_true')){?>
							<div id="notif">               
								<?php echo $this->session->flashdata('form_true');?>               
							</div>
							<?php } ?>
                            <table id="tbl-invest" class="table table-bordered table-striped table-hover tbl-form">
                                <thead>
									<tr>
                                        <th width="5%">No</th>
                                        <th width="55%">Jenis Investasi</th>
                                        <th width="15%">Group Investasi</th>
                                        <th width="15%">User</th>
                                        <th width="10%">Action</th>
									</tr>
								
                                </thead>
                                <tbody>
                                <?php $no=1; ?>
                                <?php if(isset($mst_invest) && is_array($mst_invest)):?>
                                    <?php foreach($mst_invest as $invest):?>
                                        <tr>
                                            <td style="text-align: center;"><?= $no++;?></td>
                                            <td style="text-align: left;"><?=$invest['jenis_investasi']?></td>
                                            <td style="text-align: left;"><?=$invest['group'];?></td>
                                            <?php 
                                            if($invest['iduser'] == 'TSN002'){
                                                $iduser = 'TASPEN';
                                              }elseif ($invest['iduser'] == 'ASB003') {
                                                $iduser = 'ASABRI';
                                            }
                                            ?>
                                            <td style="text-align: left;"><?=$iduser;?></td>
                                            <td>
                                                <a href="javascript:void(0)" title="Edit" class="btn btn-success btn-sm btn-flat adm" onClick="genform('master_aset_investasi','master_aset_investasi','master_aset_investasi','','<?=$invest['id_investasi'] ?>','','','edit');">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                &nbsp;
                                                <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-sm btn-flat adm" onClick="genform('delete', 'master_investasi','master_investasi','','<?=$invest['id_investasi'] ?>','<?=$invest['type'] ?>');">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                                </tbody>  
                            </table>
                            <br>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer with-border">
                           <div class="text-left">
                              <!--  <?php echo $paggination;?> -->
                           </div>
                        </div>
                        <div id="modal_invest1" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
                           <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                              </div>
                          </div>
                        </div>
                    </div>
                    <!-- Modal input/edit -->
                    <!-- /.box -->
                	</div>
               </div>
               <!-- /.col -->
            </div>
            <!-- row -->
   <!-- MODAL KETERANGAN -->



<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );

    $('#tbl-invest').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
    
</script>
       
    