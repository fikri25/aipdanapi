 <!-- Main content -->
 <?php $tahun = $this->session->userdata('tahun'); ?>
 <?php $level = $this->session->userdata('level'); ?>
<div class="row">
 	<div class="col-xs-12">
 		<div class="nav-tabs-custom">
 			<?php $this->load->view('main/nav_tab_operasional_belanja'); ?>
 			<div class="box box-default">
 				<div class="box-header with-border">
 					<h3 class="box-title">Pembayaran Pensiun Dari Dana APBN</h3>
 					<p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Semesteran</p>

 				</div>
 				<!-- /.box-header -->
 				<div class="box-body" style="overflow-x:auto;">
 					<div class="col-md-12">
 						<div class="row">
 							<div class="col-md-3 adm">
 								<div class="form-group">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control select2nya" id="semester">
                                        <option value="">
                                          -- Semester --
                                        </option>
                                        <?php if(isset($opt_smt) && is_array($opt_smt)){?> 
                                            <?php foreach($opt_smt as $k=>$v){?>
                                                <option value="<?php echo $v['id'];?>" <?php if(!empty($semester) && $v['id'] == $semester) echo 'selected="selected"';?>>
                                                  <?php echo $v['txt'];?>
                                              </option>
                                            <?php }?>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>  
 							<div class="col-md-1">
 								<div class="form-group">
 									<a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensemestersearch('index-pembayaran-pensiun','index-pembayaran-pensiun');">
 										<i class="fa fa-search"></i>
 									</a> 
 								</div>
 							</div>
                            <div class="col-md-3 user">
                                &nbsp;&nbsp;
                            </div>
                            <div  class="col-md-5"> 
                                <div class="form-group dropdown pull-right user">
                                    <button class="btn btn-sm btn-warning btn-flat dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-info-circle"></i> Keterangan
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" data-target="#Modal_ket_sm1" data-toggle="modal" class="user user-smt1" title="Keterangan">Semester I</a>
                                        </li>
                                        <li>
                                            <a href="#" data-target="#Modal_ket_sm2" data-toggle="modal" class="user user-smt2" title="Keterangan">Semester II</a>
                                        </li>
                                    </ul>
                                </div> 
                                <div class="form-group pull-right">
                                    <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat user user-smt2" onClick="genformsemester('add', 'pembayaran_pensiun_apbn','pembayaran_pensiun_apbn');">
                                      <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
                                    </a>  
                                    &nbsp;&nbsp;
                                    <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat user user-smt2" onClick="genformsemester('add', 'pembayaran_pensiun_apbn_cabang','pembayaran_pensiun_apbn_cabang');">
                                      <i class="fa fa-plus"></i>&nbsp;&nbsp;Data Cabang
                                    </a>  
                                    &nbsp;&nbsp;

                                    <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genformsemester('print-all', 'pembayaran_pensiun_apbn_cetak','pembayaran_pensiun_apbn_cetak');">
                                      <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
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
                                        <?php if($this->session->flashdata('form_true')){?>
                                            <div id="notif">               
                                                <?php echo $this->session->flashdata('form_true');?>               
                                            </div>
                                        <?php } ?>
                                        <!-- ===================================== SEMESTER 2 ================================ -->
                                        <?php if($semester == 2 || $semester == ""):?>
 										<table id="tbl-kelompok" class="table table-responsive table-bordered table-hover" width="100%">
 											<thead>
 												<tr>
 													<th rowspan="2">No</th>
 													<th rowspan="2">Kelompok Penerima</th>
 													<th colspan="2">RKA/RIT</th>
 													<th colspan="2">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
                                                    <th colspan="2">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
                                                    <th colspan="2">% Capaian Semester II</th>
                                                    <th colspan="2">% Kenaikan/Penurunan Semester I</th>
                                                    <th class="user" rowspan="2">Edit</th>
                                                    <th class="user" rowspan="2">Hapus</th>
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
                                                            <td><?=($kelompok['jml_penerima_smt1'] != 0 ) ? rupiah($kelompok['jml_penerima_smt1']) : '-';?></td>
                                                            <td><?=($kelompok['jml_pembayaran_smt1'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt1']) : '-';?></td>
                                                            <td><?=($kelompok['jml_penerima_smt2'] != 0 ) ? rupiah($kelompok['jml_penerima_smt2']) : '-';?></td>
                                                            <td><?=($kelompok['jml_pembayaran_smt2'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt2']) : '-';?></td>
                                                            <td><?=($kelompok['pers_penerimaan'] != 0 ) ? persen($kelompok['pers_penerimaan']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_pembayaran'] != 0 ) ? persen($kelompok['pers_pembayaran']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_kenaikan_penerima'] != 0 ) ? persen($kelompok['pers_kenaikan_penerima']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_kenaikan_pembayaran'] != 0 ) ? persen($kelompok['pers_kenaikan_pembayaran']).'%' : '-';?></td>
                                                            <td class="user">
                                                                <?php if($kelompok['id_rka_smt1'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-primary btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Edit"><i class="fa fa-edit"></i> Pensiun APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn','pembayaran_pensiun_apbn','','<?=$kelompok['id_kelompok']?>','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn','pembayaran_pensiun_apbn','','<?=$kelompok['id_kelompok'] ?>','2');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?>
                                                                &nbsp;
                                                                <?php if($kelompok['id_smt1'] != "" || $kelompok['id_smt2'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-success btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Edit"><i class="fa fa-edit"></i> Cabang APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn_cabang','pembayaran_pensiun_apbn_cabang','','<?=$kelompok['id_kelompok']?>','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn_cabang','pembayaran_pensiun_apbn_cabang','','<?=$kelompok['id_kelompok'] ?>','2');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?>
                                                            </td>
                                                            <!-- delete -->
                                                            <td class="user">
                                                                <?php if($kelompok['id_rka_smt1'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-danger btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Hapus"><i class="fa fa-trash"></i> Pensiun APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_del','pembayaran_pensiun_apbn_del','','<?=$kelompok['id_kelompok']?>','1','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_del','pembayaran_pensiun_apbn_del','','<?=$kelompok['id_kelompok'] ?>','2','1');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?> 
                                                                &nbsp;
                                                                <?php if($kelompok['id_smt1'] != "" || $kelompok['id_smt2'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-danger btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Hapus"><i class="fa fa-trash"></i> Cabang APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_cabang_del','pembayaran_pensiun_apbn_cabang_del','','<?=$kelompok['id_kelompok']?>','1','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_cabang_del','pembayaran_pensiun_apbn_cabang_del','','<?=$kelompok['id_kelompok'] ?>','2','1');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?> 
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif;?>
 											</tbody>
 										</table>
                                        <?php endif;?>

                                        <!-- ====================================== SEMESTER 1 ================================ -->
                                        <?php if($semester == 1 ):?>
                                        <table id="tbl-kelompok" class="table table-responsive table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Kelompok Penerima</th>
                                                    <th colspan="2">RKA/RIT</th>
                                                    <th colspan="2">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
                                                    <th colspan="2">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
                                                    <th colspan="2">% Capaian Semester II</th>
                                                    <th colspan="2">% Kenaikan/Penurunan Semester I</th>
                                                    <th class="user" rowspan="2">Edit</th>
                                                    <th class="user" rowspan="2">Hapus</th>
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
                                                            <td><?=($kelompok['jml_penerima_smt2'] != 0 ) ? rupiah($kelompok['jml_penerima_smt2']) : '-';?></td>
                                                            <td><?=($kelompok['jml_pembayaran_smt2'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt2']) : '-';?></td>
                                                            <td><?=($kelompok['jml_penerima_smt1'] != 0 ) ? rupiah($kelompok['jml_penerima_smt1']) : '-';?></td>
                                                            <td><?=($kelompok['jml_pembayaran_smt1'] != 0 ) ? rupiah($kelompok['jml_pembayaran_smt1']) : '-';?></td>
                                                            <td><?=($kelompok['pers_penerimaan'] != 0 ) ? persen($kelompok['pers_penerimaan']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_pembayaran'] != 0 ) ? persen($kelompok['pers_pembayaran']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_kenaikan_penerima'] != 0 ) ? persen($kelompok['pers_kenaikan_penerima']).'%' : '-';?></td>
                                                            <td><?=($kelompok['pers_kenaikan_pembayaran'] != 0 ) ? persen($kelompok['pers_kenaikan_pembayaran']).'%' : '-';?></td>
                                                            <td class="user">
                                                                <?php if($kelompok['id_rka_smt1'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-primary btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Edit"><i class="fa fa-edit"></i> Pensiun APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn','pembayaran_pensiun_apbn','','<?=$kelompok['id_kelompok']?>','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn','pembayaran_pensiun_apbn','','<?=$kelompok['id_kelompok'] ?>','2');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?>
                                                                &nbsp;
                                                                <?php if($kelompok['id_smt1'] != "" || $kelompok['id_smt2'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-success btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Edit"><i class="fa fa-edit"></i> Cabang APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn_cabang','pembayaran_pensiun_apbn_cabang','','<?=$kelompok['id_kelompok']?>','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="Edit" onClick="genformsemester('edit', 'pembayaran_pensiun_apbn_cabang','pembayaran_pensiun_apbn_cabang','','<?=$kelompok['id_kelompok'] ?>','2');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?>
                                                            </td>
                                                            <!-- delete -->
                                                            <td class="user">
                                                                <?php if($kelompok['id_rka_smt1'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-danger btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Hapus"><i class="fa fa-trash"></i> Pensiun APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_del','pembayaran_pensiun_apbn_del','','<?=$kelompok['id_kelompok']?>','1','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_del','pembayaran_pensiun_apbn_del','','<?=$kelompok['id_kelompok'] ?>','2','1');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?> 
                                                                &nbsp;
                                                                <?php if($kelompok['id_smt1'] != "" || $kelompok['id_smt2'] != ""):?>
                                                                <div class="dropdown pull-right">
                                                                    <button class="btn btn-sm btn-danger btn-flat dropdown-toggle" type="button" data-toggle="dropdown" title="Hapus"><i class="fa fa-trash"></i> Cabang APBN
                                                                    <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt1" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_cabang_del','pembayaran_pensiun_apbn_cabang_del','','<?=$kelompok['id_kelompok']?>','1','1');">Semester I</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0)" class="user-smt2" title="delete" onClick="genformsemester('delete', 'pembayaran_pensiun_apbn_cabang_del','pembayaran_pensiun_apbn_cabang_del','','<?=$kelompok['id_kelompok'] ?>','2','1');">Semester II</a>
                                                                        </li>
                                                                     </ul>
                                                                </div> 
                                                                <?php endif;?> 
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </tbody>
                                        </table>
                                        <?php endif;?>

                                        
 										<!-- data keterangan  -->
                                        <div style="padding:4px;">
                                            <p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
                                            </p>
                                            <div style="padding:4px;border-style:groove;border-color:lightblue;">
                                                <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_ket_smt1[0]->keterangan_lap) ? $data_pembayaran_pensiun_ket_smt1[0]->keterangan_lap : '');?></p>

                                                <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester I : 
                                                    <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_ket_smt1[0]->id) ? $data_pembayaran_pensiun_ket_smt1[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_ket_smt1[0]->file_lap) ? $data_pembayaran_pensiun_ket_smt1[0]->file_lap : '');?></a>
                                                </p>
                                                <br>
                                                <?php if(isset($data_pembayaran_pensiun_ket_smt2[0]->id) != "") :?>
                                                    <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_pembayaran_pensiun_ket_smt2[0]->keterangan_lap) ? $data_pembayaran_pensiun_ket_smt2[0]->keterangan_lap : '');?></p>

                                                    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester II : 
                                                        <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_ket_smt2[0]->id) ? $data_pembayaran_pensiun_ket_smt2[0]->id : ''));?>"><?php echo (isset($data_pembayaran_pensiun_ket_smt2[0]->file_lap) ? $data_pembayaran_pensiun_ket_smt2[0]->file_lap : '');?></a>
                                                    </p>
                                                <?php endif; ?>
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
        <div class="modal fade" id="Modal_ket_sm1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel" style="font-weight:bold;margin-top:10px">KETERANGAN SEMESTER I</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <form class="form-horizontal" action="<?php echo base_url().'semesteran/operasional_belanja/save_keterangan'?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                                        <input type="hidden" name="jns_lap" value="ket_lkob_pembayaran_pensiun">
                                        <input type="hidden" name="nmdok" value="Lkob_Pembayaran_Pensiun_Semester">
                                        <input type="hidden" name="semester" value="1">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                                            <div class="col-sm-10">
                                                <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_pembayaran_pensiun_ket_smt1[0]->keterangan_lap) ? $data_pembayaran_pensiun_ket_smt1[0]->keterangan_lap : '');?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" name="id" value="<?php echo (isset($data_pembayaran_pensiun_ket_smt1[0]->id) ? $data_pembayaran_pensiun_ket_smt1[0]->id : '');?>">
                                                <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_pembayaran_pensiun_ket_smt1[0]->file_lap) ? $data_pembayaran_pensiun_ket_smt1[0]->file_lap : '');?>">
                                                <input type="file" name="filedata">
                                                <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                                                <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_ket_smt1[0]->id) ? $data_pembayaran_pensiun_ket_smt1[0]->id : ''));?>"><p><?php echo (isset($data_pembayaran_pensiun_ket_smt1[0]->file_lap) ? $data_pembayaran_pensiun_ket_smt1[0]->file_lap : '');?></p></a>
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

        <!-- MODAL KETERANGAN SMT-2-->
        <div class="modal fade" id="Modal_ket_sm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel2" style="font-weight:bold;margin-top:10px">KETERANGAN SEMESTER II</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <form class="form-horizontal" action="<?php echo base_url().'semesteran/operasional_belanja/save_keterangan'?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                                        <input type="hidden" name="jns_lap" value="ket_lkob_pembayaran_pensiun">
                                        <input type="hidden" name="semester" value="2">
                                        <input type="hidden" name="nmdok" value="Lkob_Pembayaran_Pensiun_Semester">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                                            <div class="col-sm-10">
                                                <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_pembayaran_pensiun_ket_smt2[0]->keterangan_lap) ? $data_pembayaran_pensiun_ket_smt2[0]->keterangan_lap : '');?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" name="id" value="<?php echo (isset($data_pembayaran_pensiun_ket_smt2[0]->id) ? $data_pembayaran_pensiun_ket_smt2[0]->id : '');?>">
                                                <input type="hidden" name="filedata" value="<?php echo (isset($data_pembayaran_pensiun_ket_smt2[0]->file_lap) ? $data_pembayaran_pensiun_ket_smt2[0]->file_lap : '');?>">
                                                <input type="file" name="filedata">
                                                <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                                                <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_pembayaran_pensiun_ket_smt2[0]->id) ? $data_pembayaran_pensiun_ket_smt2[0]->id : ''));?>"><p><?php echo (isset($data_pembayaran_pensiun_ket_smt2[0]->file_lap) ? $data_pembayaran_pensiun_ket_smt2[0]->file_lap : '');?></p></a>
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


    var smt = $('#semester').val();
    if (smt != "") {
      if(smt == 1){
        $('.thn').text(tahun);
        $('.thn-filter').text(tahun-1);
        console.log(smt);
      }else{
        $('.thn').text(tahun);
        $('.thn-filter').text(tahun);
      }
    }else{
      $('.thn').text(tahun);
      $('.thn-filter').text(tahun);
    }

</script>