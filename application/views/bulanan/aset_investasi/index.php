 <!-- Main content -->
            <?php $level = $this->session->userdata('level');?>
            <?php $tahun = $this->session->userdata('tahun');?>
            <div class="row">
                <div class="col-xs-12">
				  <div class="nav-tabs-custom">
                    <?php $this->load->view('main/nav_tab_view'); ?>
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Aset Investasi</h3>
                            <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo (isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '').' - '. $tahun;?></p>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="overflow-x:auto;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group adm">
                                            <select class="form-control select2nya" id="iduser">
                                                <option value="">
                                                    -- Pilih --
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
                                        <div class="form-group adm">
                                            <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensearch('index-investasi','index-investasi');">
                                                <i class="fa fa-search"></i>
                                            </a> 
                                        </div>
                                    </div>
                                    <div  class="col-md-8"> 
                                        <div class="form-group pull-right">
                                            <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat user" onClick="genform('add', 'aset_investasi','aset_investasi');" disabled>
                                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
                                            </a>  
                                            &nbsp;&nbsp;
                                            <a href="#" data-target="#Modal_ket1" data-toggle="modal" class="btn btn-sm btn-warning btn-flat user" title="Keterangan"><i class="fa fa-info-circle"></i> Keterangan
                                            </a>

                                            &nbsp;&nbsp;
                                            <a href="<?php echo site_url('bulanan/aset_investasi/laporan_investasi_PDF').get_uri();?>" target="blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF
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
                                        <th width="9">No</th>
                                        <th>Jenis Investasi</th>
                                        <th>RIT</th>
    									<th>Saldo Awal</th>
                                        <th>Mutasi</th>
                                        <th>Saldo Akhir</th>
                                        <th width="10%">(%) Realisasi RIT</th>
                                        <th width="15%">Action</th>
									</tr>
								
                                </thead>
                                <tbody>
							
                                    <?php 
										$no=1;
										if(isset($data_invest) && is_array($data_invest)){ ?>
                                    	<?php $tot=0; $jml=0; $akh=0;$rka=0; 
										foreach($data_invest as $data_investasi){?>
                                        <tr>
                                            <td><?php echo $no++;?></td>
                                            <td style="text-align: left"><?php echo $data_investasi->jenis_investasi;?></td>
                                            <td><?php echo rupiah($data_investasi->rka);?></td>
                                            <td><?php echo rupiah($data_investasi->saldo_awal_invest);?></td>
                                            <td><?php echo rupiah($data_investasi->mutasi_invest);?></td>
                                            <td><?php echo rupiah($data_investasi->saldo_akhir_invest);?></td>
                                            <td><?php echo $data_investasi->realisasi_rka;?></td>
                                            <td>
                                                <a href="javascript:void(0)" title="Edit" class="btn btn-success btn-sm btn-flat user" onClick="genform('edit', 'aset_investasi','aset_investasi','','<?=$data_investasi->id ?>','<?=$data_investasi->jns_form?>');">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                               <!--  <?php if($level != "DJA"){?>
												<a href="<?php echo site_url('investasi-form/aset_investasi').'/'.($data_investasi->id).get_uri();?>" class="btn btn-xs btn-success btn-flat <?php if ($status[0]->status == "Approved"){echo 'disabled';}?>"><i class="fa fa-pencil"></i></a>
                                                <?php }?> -->

												&nbsp;
                                               <a href="javascript:void(0)" title="Detail" class="btn btn-primary btn-sm btn-flat" onClick="genform('edit', 'detail_aset_investasi','detail_aset_investasi','','<?=$data_investasi->id ?>','<?=$data_investasi->jns_form?>');">
                                                    <i class="fa fa-list"></i>
                                                </a>
                                                &nbsp;
                                               <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-sm btn-flat user" onClick="genform('delete', 'aset_investasi','aset_investasi','','<?=$data_investasi->id ?>','<?=$data_investasi->jns_form?>');">
                                                    <i class="fa fa-trash"></i>
                                                </a>
											</td>
                                        </tr>
											<?php
												$tot += $data_investasi->saldo_awal_invest;
												$jml += $data_investasi->mutasi_invest;
                                                $akh += $data_investasi->saldo_akhir_invest;
												$rka += $data_investasi->rka;
											} ?>
										
										<tfoot>
											<!-- <th><a href="<?php echo site_url('#').get_uri();?>" data-target="#modal" data-toggle="modal" class="btn btn-xs btn-primary btn-flat" ><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah</a></th> -->
											<th></th>
											<th>Total</th>
                                            <th style="text-align: right"><?php echo rupiah($rka);?></th>
											<th style="text-align: right"><?php echo rupiah($tot);?></th>
											<th style="text-align: right"><?php echo rupiah($jml);?></th>
											<th style="text-align: right"><?php echo rupiah($akh);?></th>
											<th></th>
											<th></th>
										</tfoot>	
                                 <?php } ?>	
                              </tbody>
                            </table>
                            <br>
                            <!-- data keterangan  -->
                              <div style="padding:4px;">
                                 <p style="margin-left:0px;font-size: 18px;font-weight: bold">Keterangan
                                    <!-- <?php if($level != "DJA"){?> 
                                    <a href="#" data-target="#Modal_ket1" data-toggle="modal" class="btn btn-sm btn-success btn-flat" title="Keterangan"><i class="fa fa-plus"></i> Keterangan
                                    </a>
                                    <?php } ?> -->
                                </p>
                                 <div style="padding:4px;border-style:groove;border-color:lightblue;">
                                    <p style="font-size: 14px;margin-right: 15px;margin-left: 0px;text-align: justify;"><?php echo (isset($data_posisi_investasi_ket[0]->keterangan_lap) ? $data_posisi_investasi_ket[0]->keterangan_lap : '');?>
                                        
                                    </p>

                                   <p style="margin-left:0px;font-size: 16px;font-weight: bold">Dokumen : <a href="<?php echo site_url('bulanan/posisi_investasi/get_file/'.(isset($data_posisi_investasi_ket[0]->id) ? $data_posisi_investasi_ket[0]->id : '').get_uri());?>"><p><?php echo (isset($data_posisi_investasi_ket[0]->file_lap) ? $data_posisi_investasi_ket[0]->file_lap : '');?></p></a></p>
                                 </div>
                              </div>
                           <!-- end keterangan -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer with-border">
                           <div class="text-left">
                               <?php echo $paggination;?>
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
   <div class="modal fade" id="Modal_ket1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="myModalLabel" style="font-weight:bold;margin-top:10px">KETERANGAN</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <form class="form-horizontal" action="<?php echo base_url().'bulanan/aset_investasi/save_keterangan'?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                    <input type="hidden" name="jns_lap" value="ket_posisi_investasi">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                                            <div class="col-sm-10">
                                                <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_posisi_investasi_ket[0]->keterangan_lap) ? $data_posisi_investasi_ket[0]->keterangan_lap : '');?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                                         <div class="col-sm-10">
                                            <input type="hidden" name="id" value="<?php echo (isset($data_posisi_investasi_ket[0]->id) ? $data_posisi_investasi_ket[0]->id : '');?>">
                                            <input type="hidden" name="filedata" value="<?php echo (isset($data_posisi_investasi_ket[0]->file_lap) ? $data_posisi_investasi_ket[0]->file_lap : '');?>">
                                            <input type="file" name="filedata">
                                            <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                                            <a href="<?php echo site_url('bulanan/posisi_investasi/get_file/'.(isset($data_posisi_investasi_ket[0]->id) ? $data_posisi_investasi_ket[0]->id : '').get_uri());?>"><p><?php echo (isset($data_posisi_investasi_ket[0]->file_lap) ? $data_posisi_investasi_ket[0]->file_lap : '');?></p></a>
                                         </div>
                                        </div>
                                    <div class="modal-footer with-border">
                                        <div class="col-sm-12">
                                            <button class="btn btn-warning btn-sm btn-flat pull-right <?php if ($status[0]->status == "Approved"){echo 'disabled';}?>" type="submit">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- /form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );

    $(".user").attr('disabled', 'disabled');

    $('#tbl-invest').DataTable({
        "paging":false,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
    
</script>
       
    