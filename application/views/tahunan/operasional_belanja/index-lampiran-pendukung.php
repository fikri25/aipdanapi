 <!-- Main content -->
 <?php $tahun = $this->session->userdata('tahun'); ?>
 <?php $level = $this->session->userdata('level'); ?>
 <div class="row">
 	<div class="col-xs-12">
 		<div class="nav-tabs-custom">
 			<?php $this->load->view('main/nav_tab_operasional_belanja_tahunan'); ?>
 			<div class="box box-default">
 				<div class="box-header with-border">
 					<h3 class="box-title">Lampiran Pendukung</h3>
 					<p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Tahunan</p>

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
 									<a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensemestersearch('index-lampiran','index-lampiran');">
 										<i class="fa fa-search"></i>
 									</a> 
 								</div>
 							</div>
                            <div class="col-md-4">
                                &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <?php if($this->session->flashdata('form_true')){?>
                        <div id="notif">               
                          <?php echo $this->session->flashdata('form_true');?>               
                      </div>
                  <?php } ?>
                  <div class="col-md-12">
                    <div class="tab-pane fade in" id="">
                        <form class="form-horizontal" action="<?php echo base_url().'tahunan/operasional_belanja/save_keterangan'?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                            <input type="hidden" name="jns_lap" value="ket_lamporan_pendukung_lkob">
                            <input type="hidden" name="nmdok" value="lkob_Lampiran_Pendukung_Tahun">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="keterangan" class="form-control" style="height:130px;width:50%;" id="keterangan" rows="10" placeholder="Keterangan"><?php echo (isset($lampiran_lkob_thn[0]->keterangan_lap) ? $lampiran_lkob_thn[0]->keterangan_lap : '');?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="id" value="<?php echo (isset($lampiran_lkob_thn[0]->id) ? $lampiran_lkob_thn[0]->id : '');?>">
                                    <input type="hidden" name="filedata_lama" value="<?php echo (isset($lampiran_lkob_thn[0]->file_lap) ? $lampiran_lkob_thn[0]->file_lap : '');?>">
                                    <input type="file" name="filedata">
                                    <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                                    <a href="<?php echo site_url('tahunan/operasional_belanja/get_file/'.(isset($lampiran_lkob_thn[0]->id) ? $lampiran_lkob_thn[0]->id : ''));?>"><p><?php echo (isset($lampiran_lkob_thn[0]->file_lap) ? $lampiran_lkob_thn[0]->file_lap : '');?></p></a>
                                </div>
                            </div>
                            <?php if($level != "DJA"){?>
                                <button style="height:30px; margin-bottom:10px; margin-left:5px;" class="btn btn-primary btn-md btn-flat" type="submit">
                                    Simpan
                                </button>
                            <?php } ?>
                        </form>
                    </div>
                    
                </div>
                
                <!-- /.col -->
            </div>
        </div>
    </div>
</div>
<!-- row -->
<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );
    $('#tbl-cabang-2').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
</script>