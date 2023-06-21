 <!-- Main content -->
 <?php $tahun = $this->session->userdata('tahun'); ?>
 <?php $level = $this->session->userdata('level'); ?>
<div class="row">
 	<div class="col-xs-12">
 		<div class="nav-tabs-custom">
 			<?php $this->load->view('main/nav_tab_operasional_belanja_tahunan'); ?>
 			<div class="box box-default">
 				<div class="box-header with-border">
 					<h3 class="box-title">Pembayaran Pensiun Dari Dana APBN</h3>
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
 									<a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensemestersearch('index-pembayaran-pensiun','index-pembayaran-pensiun');">
 										<i class="fa fa-search"></i>
 									</a> 
 								</div>
 							</div>
                            <div  class="col-md-8"> 
                                <div class="form-group pull-right">
                                  <a href="#" data-target="#Modal_ket1" data-toggle="modal" class="btn btn-sm btn-warning btn-flat user" title="Keterangan"><i class="fa fa-info-circle"></i> Keterangan
                                  </a>

                                  &nbsp;&nbsp;
                                  <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genformtahunan('print-all', 'pembayaran_pensiun_apbn_cetak','pembayaran_pensiun_apbn_cetak');"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
                                  </a>  
                                  &nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
 						</div>
 					</div>
 					<div id="contentpane" class="layout layout-center scroll" style="padding:10px;">
 						<div class="panel panel-default">    
 							<div class="clear-fix">&nbsp;</div>
 							<ul class="nav nav-tabs" role="tablist">
 								<li class="active"><a href="#tab_list_data_aset_temuan" role="tab" data-toggle="tab"><strong>Kelompok Penerima</strong></a></li>
 								<li><a href="#tab_tambah_data" role="tab" data-toggle="tab"><strong>Jenis Penerima</strong></a></li>
 							</ul>
 							<div class="tab-content">
 								<!-- Start Tab List Data Aset Temuan -->        
 								<div class="tab-pane fade in active" id="tab_list_data_aset_temuan" style="margin-bottom: 100px;">
 									<p style="margin-left:10px;margin-top:20px;"></p>
 									<div class="table-responsive">
 										<table id="tbl-kelompok" class="table table-responsive table-bordered table-hover" width="100%">
 											<thead>
 												<tr>
 													<th rowspan="2">No</th>
 													<th rowspan="2">Kelompok Penerima</th>
 													<th colspan="2">RKA/RIT</th>
 													<th colspan="2">Tahun&nbsp;&nbsp;<span class="tahun"></span></th>
 													<th colspan="2">Tahun&nbsp;&nbsp;<span class="tahun_lalu"></span></th>
                                                    <th colspan="2">% Capaian Semester II</th>
                                                    <th colspan="2">% Kenaikan/Penurunan Semester I</th>
 												</tr>
 												<tr>
 													<th>Jumlah Penerima</th>
 													<th>Jumlah Pembayaran</th>
 													<th>Jumlah Penerima</th>
 													<th>Jumlah Pembayaran</th>
 													<th>Jumlah Penerima</th>
 													<th>Jumlah Pembayaran</th>
                                                    <th>Jumlah Penerima</th>
                                                    <th>Jumlah Pembayaran</th>
                                                    <th>Jumlah Penerima</th>
                                                    <th>Jumlah Pembayaran</th>
 												</tr>
 											</thead>
 											<tbody>
                                                <?php $no=1; ?>
 												<?php if(isset($data_kelompok) && is_array($data_kelompok)):?>
                                                    <?php foreach($data_kelompok as $kelompok):?>
                                                        <tr>
                                                            <td><?= $no++;?></td>
                                                            <td style="text-align: left;"><?=$kelompok['kelompok_penerima']?></td>
                                                            <td><?=($kelompok['rka_penerima'] != 0 ) ? rupiah($kelompok['rka_penerima']) : '-';?></td>
                                                            <td><?=($kelompok['rka_pembayaran'] != 0 ) ? rupiah($kelompok['rka_pembayaran']) : '-';?></td>
                                                            <td><?=($kelompok['jml_penerima_thn'] != 0 ) ? rupiah($kelompok['jml_penerima_thn']) : '-';?></td>
                                                            <td><?=($kelompok['jml_pembayaran_thn'] != 0 ) ? rupiah($kelompok['jml_pembayaran_thn']) : '-';?></td>
                                                            <td><?=($kelompok['jml_penerima_thn_lalu'] != 0 ) ? rupiah($kelompok['jml_penerima_thn_lalu']) : '-';?></td>
                                                            <td><?=($kelompok['jml_pembayaran_thn_lalu'] != 0 ) ? rupiah($kelompok['jml_pembayaran_thn_lalu']) : '-';?></td>
                                                            <td><?=($kelompok['pers_penerimaan'] != 0 ) ? persen($kelompok['pers_penerimaan']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_pembayaran'] != 0 ) ? persen($kelompok['pers_pembayaran']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_kenaikan_penerima'] != 0 ) ? persen($kelompok['pers_kenaikan_penerima']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_kenaikan_pembayaran'] != 0 ) ? persen($kelompok['pers_kenaikan_pembayaran']).'%' : '-';?></td>
                                                            
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif;?>
 											</tbody>
 										</table>
 										<!-- data keterangan  -->
                                        <div style="padding:4px;">
                                            <p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
                                            </p>
                                            <div style="padding:4px;border-style:groove;border-color:lightblue;">
                                                <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->keterangan_lap) ? $data_pembayaran_pensiun_ket_thn[0]->keterangan_lap : '');?></p>

                                                <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen : 
                                                    <a href="<?php echo site_url('tahunan/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_ket_thn[0]->id) ? $data_pembayaran_pensiun_ket_thn[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->file_lap) ? $data_pembayaran_pensiun_ket_thn[0]->file_lap : '');?></a>
                                                </p>

                                            </div>
                                        </div>
                                        <!-- end keterangan -->

 										<div class="box-footer with-border">
 											<div class="text-left">
 												<!-- <?php echo $paggination;?> -->
 											</div>
 										</div>

 									</div>
 								</div>

 								<!-- /.box-body -->

 								<div class="tab-pane fade in" id="tab_tambah_data" style="overflow-x:auto;">
 									<?php include 'index-pembayaran-jenis.php' ;?>
 								</div>
 								<!-- Modal input/edit -->
 								<div id="modal_kelompok" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
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
 			</div>
 		</div>
 	</div>
 	<!-- row -->

<!-- MODAL KETERANGAN SMT-1-->
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
                                    <form class="form-horizontal" action="<?php echo base_url().'tahunan/operasional_belanja/save_keterangan'?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                                        <input type="hidden" name="jns_lap" value="ket_lkob_pembayaran_pensiun">
                                        <input type="hidden" name="nmdok" value="Lkob_Pembayaran_Pensiun_Tahun">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                                            <div class="col-sm-10">
                                                <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->keterangan_lap) ? $data_pembayaran_pensiun_ket_thn[0]->keterangan_lap : '');?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" name="id" value="<?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->id) ? $data_pembayaran_pensiun_ket_thn[0]->id : '');?>">
                                                <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->file_lap) ? $data_pembayaran_pensiun_ket_thn[0]->file_lap : '');?>">
                                                <input type="file" name="filedata">
                                                <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                                                <a href="<?php echo site_url('tahunan/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_ket_thn[0]->id) ? $data_pembayaran_pensiun_ket_thn[0]->id : ''));?>"><p><?php echo (isset($data_pembayaran_pensiun_ket_thn[0]->file_lap) ? $data_pembayaran_pensiun_ket_thn[0]->file_lap : '');?></p></a>
                                            </div>
                                        </div>
                                        <div class="modal-footer with-border">
                                            <div class="col-sm-12">
                                                <?php if($level != "DJA"){?>
                                                    <button class="btn btn-warning btn-sm btn-flat pull-right" type="submit">
                                                        Simpan
                                                    </button>
                                                <?php } ?>
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
    $('#tbl-kelompok').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
    $('.tahun').text(tahun);
    $('.tahun_lalu').text(tahun - 1);
</script>