 <!-- Main content -->
			<div class="row">
                <div class="col-xs-12">
				  <div class="nav-tabs-custom">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">User Management</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="overflow-x:auto;">	
                        <p style="margin-bottom: 40px">
                        	<a id="hasil" href="<?php echo site_url('master/master_data/create_user');?>" data-target="#modal_klaim" data-toggle="modal" class="btn btn-sm btn-primary btn-flat pull-right" ><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah User</a>		
								</p>
							<?php if($this->session->flashdata('form_true')){?>
							<div id="notif">               
								<?php echo $this->session->flashdata('form_true');?>               
							</div>
							<?php } elseif($this->session->flashdata('form_false')){?>
							<div id="notif">               
								<?php echo $this->session->flashdata('form_false');?>               
							</div>
							<?php } ?>
                            <table id="example" class="table table-responsive table-bordered table-hover">
                                <thead>
												<tr>
													<th width="20">No</th>
													<th>ID User</th>
													<th>Nama User</th>
													<th>User Group</th>
													<th width="100">#</th>
												</tr>
                                </thead>
                                <tbody>
                                <?php if(isset($data_user) && is_array($data_user)){ 
                                			$no=1;
													foreach($data_user as $user) { ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo $no++;?></td>
                                            <td style="text-align: left"><?php echo $user->iduser;?></td>
                                            <td style="text-align: left"><?php echo $user->nmuser;?></td>
                                            <td style="text-align: left"><?php echo $user->idusergroup;?></td>
                                            <td>
                                                <a href="<?php echo site_url('master/master_data/edit_user').'/'.($user->iduser);?>" data-target="#modal_klaim" data-toggle="modal" class="btn btn-xs btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></a>
                                                
                                                <a href='#modal_delete' class='btn btn-xs btn-default btn-flat' data-target='#modal_delete<?php echo $user->iduser;?>' data-toggle='modal' onClick='confirm_delete("<?php echo site_url('master/master_data/delete_user').'/'.$user->iduser;?>")'><i class='fa fa-trash'></i></a>
															</td>
                                        </tr>
									<?php 
											}
										}?>
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
						<div id="modal_klaim" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
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