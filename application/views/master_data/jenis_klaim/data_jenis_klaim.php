 <!-- Main content -->
			<div class="row">
                <div class="col-xs-12">
				  <div class="nav-tabs-custom">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Jenis Klaim</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="overflow-x:auto;">	
                        <p style="margin-bottom: 40px">
                        	<a id="hasil" href="<?php echo site_url('master/master_data/create_jenis_klaim');?>" data-target="#modal_klaim" data-toggle="modal" class="btn btn-sm btn-primary btn-flat pull-right" ><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Jenis Klaim</a>		
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
													<th>Kode Klaim</th>
													<th>Jenis Klaim</th>
													<th width="100">#</th>
												</tr>
                                </thead>
                                <tbody>
                                <?php if(isset($data_jenis_klaim) && is_array($data_jenis_klaim)){ 
                                			$no=1;
													foreach($data_jenis_klaim as $jenis_klaim) { ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo $no++;?></td>
                                            <td style="text-align: left"><?php echo $jenis_klaim->kode_klaim;?></td>
                                            <td style="text-align: left"><?php echo $jenis_klaim->jenis_klaim;?></td>
                                            <td>
                                                <a href="<?php echo site_url('master/master_data/edit_jenis_klaim').'/'.($jenis_klaim->kode_klaim);?>" data-target="#modal_klaim" data-toggle="modal" class="btn btn-xs btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></a>
                                                
                                                <a href='#modal_delete' class='btn btn-xs btn-default btn-flat' data-target='#modal_delete<?php echo $jenis_klaim->kode_klaim;?>' data-toggle='modal' onClick='confirm_delete("<?php echo site_url('master/master_data/delete_jenis_klaim').'/'.$jenis_klaim->kode_klaim;?>")'><i class='fa fa-trash'></i></a>
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