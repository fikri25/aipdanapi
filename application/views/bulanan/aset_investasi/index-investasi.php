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
                                            <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat user-bln" onClick="genform('add', 'aset_investasi','aset_investasi');">
                                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
                                            </a> 
                                            &nbsp;&nbsp;
                                            <a href="#" data-target="#Modal_ket1" data-toggle="modal" class="btn btn-sm btn-warning btn-flat user-bln" title="Keterangan"><i class="fa fa-info-circle"></i> Keterangan
                                            </a>

                                            &nbsp;&nbsp;
                                            <!-- <a href="<?php echo site_url('bulanan/aset_investasi/laporan_investasi_PDF').get_uri();?>" target="blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF
                                            </a> -->
                                            <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genform('print-all', 'aset_investasi_cetak','aset_investasi_cetak');">
                                              <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
                                            </a>  
                                            <!-- &nbsp;&nbsp; -->
                                            <!-- <a href="javascript:void(0)" title="Sinkron Data Bulan lalu" class="btn btn-success btn-sm btn-flat" onClick="gensearch('sinkron-investasi','sinkron-investasi');">
                                              <i class="fa fa-refresh"></i>&nbsp;&nbsp;Sinkron
                                            </a>   -->
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
                                        <th width="10">No</th>
                                        <th width="30%">Jenis Investasi</th>
                                        <th>RIT</th>
    									<th>Saldo Awal</th>
                                        <th>Mutasi</th>
                                        <th>Saldo Akhir</th>
                                        <th width="8%">(%) Realisasi RIT</th>
                                        <th width="13%">Action</th>
									</tr>
								
                                </thead>
                                <tbody>
                                <?php $no=1; ?>
    							<?php if(isset($data_invest) && is_array($data_invest)):?>
                                    <?php foreach($data_invest as $invest):?>
                                        <?php if($invest['type'] == 'P'):?>
                                            <tr class="cek">
                                                <td><?= $no++;?></td>
                                                <td style="text-align: left;"><?=$invest['jenis_investasi']?></td>
                                                <td><?=($invest['rka'] != 0 ) ? rupiah($invest['rka']) : '-';?></td>
                                                <td><?=($invest['saldo_awal'] != 0 ) ? rupiah($invest['saldo_awal']) : '-';?></td>
                                                <td><?=($invest['mutasi'] != 0 ) ? rupiah($invest['mutasi']) : '-';?></td>
                                                <td><?=($invest['saldo_akhir'] != 0 ) ? rupiah($invest['saldo_akhir']) : '-';?></td>
                                                <td><?=($invest['realisasi_rka'] != 0 ) ? persen($invest['realisasi_rka']).'%' : '-';?></td>
                                                <td>
                                                    <?php if($invest['id'] != ""):?>
                                                    <a href="javascript:void(0)" title="Edit" class="btn btn-success btn-sm btn-flat user-bln" onClick="genform('edit', 'aset_investasi','aset_investasi','','<?=$invest['id'] ?>','<?=$invest['jns_form']?>');">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    &nbsp;
                                                   <a href="javascript:void(0)" title="Detail" class="btn btn-primary btn-sm btn-flat" onClick="genform('edit', 'detail_aset_investasi','detail_aset_investasi','','<?=$invest['id'] ?>','<?=$invest['jns_form']?>');">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                    &nbsp;
                                                   <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-sm btn-flat user-bln" onClick="genform('delete', 'aset_investasi','aset_investasi','','<?=$invest['id'] ?>','<?=$invest['jns_form']?>');">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endif;?>
                                        <?php foreach($invest['child'] as $child):?>
                                            <?php if($child['type'] == 'PC'):?>
                                                <tr>
                                                    <td><?= $no++;?></td>
                                                    <td style="text-align: left;"><?=$child['jenis_investasi']?></td>
                                                    <td><?=($child['rka'] != 0 ) ? rupiah($child['rka']) : '-';?></td>
                                                    <td><?=($child['saldo_awal'] != 0 ) ? rupiah($child['saldo_awal']) : '-';?></td>
                                                    <td><?=($child['mutasi'] != 0 ) ? rupiah($child['mutasi']) : '-';?></td>
                                                    <td><?=($child['saldo_akhir'] != 0 ) ? rupiah($child['saldo_akhir']) : '-';?></td>
                                                    <td><?=($child['realisasi_rka'] != 0 ) ? persen($child['realisasi_rka']).'%' : '-';?></td>
                                                    <td></td>
                                                </tr>
                                            <?php endif;?>
                                            <?php foreach($child['subchild'] as $subchild):?>
                                                <!-- <?php if($child['type'] == 'PC'):?> -->
                                                    <tr>
                                                        <td><?= $no++;?></td>
                                                        <td style="text-align: left; padding-left:30px;color: #6c7275;"><?='- '.$subchild['jenis_investasi']?></td>
                                                        <td><?=($subchild['rka'] != 0 ) ? rupiah($subchild['rka']) : '-';?></td>
                                                        <td><?=($subchild['saldo_awal'] != 0 ) ? rupiah($subchild['saldo_awal']) : '-';?></td>
                                                        <td><?=($subchild['mutasi'] != 0 ) ? rupiah($subchild['mutasi']) : '-';?></td>
                                                        <td><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
                                                        <td><?=($subchild['realisasi_rka'] != 0 ) ? persen($subchild['realisasi_rka']).'%' : '-';?></td>
                                                        <td>
                                                            <?php if($subchild['id'] != ""):?>
                                                                <a href="javascript:void(0)" title="Edit" class="btn btn-success btn-sm btn-flat user" onClick="genform('edit', 'aset_investasi','aset_investasi','','<?=$subchild['id'] ?>','<?=$subchild['jns_form']?>');">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                &nbsp;
                                                                <a href="javascript:void(0)" title="Detail" class="btn btn-primary btn-sm btn-flat" onClick="genform('edit', 'detail_aset_investasi','detail_aset_investasi','','<?=$subchild['id'] ?>','<?=$subchild['jns_form']?>');">
                                                                    <i class="fa fa-list"></i>
                                                                </a>
                                                                &nbsp;
                                                                <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-sm btn-flat user" onClick="genform('delete', 'aset_investasi','aset_investasi','','<?=$subchild['id'] ?>','<?=$subchild['jns_form']?>');">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            <?php endif;?>
                                                        </td>
                                                    </tr>
                                                <!-- <?php endif;?> -->

                                            <?php endforeach;?>
                                        <?php endforeach;?>
                                    <?php endforeach;?>
                                <?php endif;?>
                                </tbody>
                                <tfoot style="background-color: #d8d8d8; font-weight: bold;">
                                    <td></td>
                                    <td>Total</td>
                                    <td><?=($sum['rka'] != 0 ) ? rupiah($sum['rka']) : '-';?></td>
                                    <td><?=($sum['saldo_awal'] != 0 ) ? rupiah($sum['saldo_awal']) : '-';?></td>
                                    <td><?=($sum['mutasi'] != 0 ) ? rupiah($sum['mutasi']) : '-';?></td>
                                    <td><?=($sum['saldo_akhir'] != 0 ) ? rupiah($sum['saldo_akhir']) : '-';?></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>    
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

                                   <p style="margin-left:0px;font-size: 16px;font-weight: bold">Dokumen : <a href="<?php echo site_url('bulanan/aset_investasi/get_file/'.(isset($data_posisi_investasi_ket[0]->id) ? $data_posisi_investasi_ket[0]->id : '').get_uri());?>"><p><?php echo (isset($data_posisi_investasi_ket[0]->file_lap) ? $data_posisi_investasi_ket[0]->file_lap : '');?></p></a></p>
                                 </div>
                              </div>
                           <!-- end keterangan -->
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
                                    <input type="hidden" name="jns_lap" value="ket_aset_investasi">
                                    <input type="hidden" name="nmdok" value="Aset_Investasi">
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
                                             <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_posisi_investasi_ket[0]->file_lap) ? $data_posisi_investasi_ket[0]->file_lap : '');?>">
                                            <input type="file" name="filedata">
                                            <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                                            <a href="<?php echo site_url('bulanan/aset_investasi/get_file/'.(isset($data_posisi_investasi_ket[0]->id) ? $data_posisi_investasi_ket[0]->id : '').get_uri());?>"><p><?php echo (isset($data_posisi_investasi_ket[0]->file_lap) ? $data_posisi_investasi_ket[0]->file_lap : '');?></p></a>
                                         </div>
                                        </div>
                                    <div class="modal-footer with-border">
                                        <div class="col-sm-12">
                                            <button class="btn btn-warning btn-sm btn-flat pull-right user-bln" type="submit">
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
   
    $('#tbl-invest').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });



</script>
       
    