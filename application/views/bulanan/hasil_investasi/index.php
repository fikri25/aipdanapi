 <!-- Main content -->
 <?php $level = $this->session->userdata('level');?>
 <?php $tahun = $this->session->userdata('tahun');?>
 <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <?php $this->load->view('main/nav_tab_view'); ?>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Hasil Investasi</h3>
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
                                <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensearch('index-hasil-investasi','index-hasil-investasi');">
                                    <i class="fa fa-search"></i>
                                </a> 
                            </div>
                        </div>
                        <div  class="col-md-8"> 
                            <div class="form-group pull-right">
                                <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat user-bln" onClick="genform('addhasil_investasi', 'hasil_investasi','hasil_investasi','','','','','add');">
                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
                                </a>  
                                &nbsp;&nbsp;
                                <a href="#" data-target="#Modal_ket1" data-toggle="modal" class="btn btn-sm btn-warning btn-flat user-bln" title="Keterangan"><i class="fa fa-info-circle"></i> Keterangan
                                </a>

                                &nbsp;&nbsp;
                                <!-- <a href="<?php echo site_url('bulanan/hasil_investasi/laporan_HasilInvestasi_PDF').get_uri();?>" target="blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF
                                </a> -->
                                <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genform('print-all', 'hasil_investasi_cetak','hasil_investasi_cetak');">
                                  <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
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
                <table id="hasil-invest" class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="9">No</th>
                            <th>Jenis Investasi</th>
                            <th>RIT</th>
                            <th>Saldo Awal</th>
                            <th>Mutasi</th>
                            <th>Saldo Akhir</th>
                            <th>(%) Realisasi RIT</th>
                            <th class="user-bln">#</th>
                        </tr>

                    </thead>
                    <tbody>

                        <?php 
                        $no=1;
                        if(isset($data_hasil_investasi) && is_array($data_hasil_investasi)){ ?>
                            <?php $tot=0; $jml=0; $akh=0;$rka=0; 
                            foreach($data_hasil_investasi as $hasil_investasi){?>
                                <tr id='tabHasilInvestasi'>
                                    <td style="text-align: center;"><?php echo $no++;?></td>
                                    <td style="text-align: left;"><?php echo $hasil_investasi->jenis_investasi;?></td>
                                    <td><?php echo rupiah($hasil_investasi->rka);?></td>
                                    <td><?php echo rupiah($hasil_investasi->saldo_awal_invest);?></td>
                                    
                                    <td><?=($hasil_investasi->mutasi_invest != 0 ) ? rupiah($hasil_investasi->mutasi_invest) : '-';?></td>
                                    <td><?php echo rupiah($hasil_investasi->saldo_akhir_invest);?></td>
                                    <td><?php echo $hasil_investasi->realisasi_rka;?></td>
                                    <td class="user-bln">
                                        <a href="javascript:void(0)" title="Edit" class="btn btn-success btn-sm btn-flat" onClick="genform('addhasil_investasi', 'hasil_investasi','hasil_investasi','','<?=$hasil_investasi->id ?>','','','edit');">
                                            <i class="fa fa-edit"></i>
                                        </a> 
                                        &nbsp;
                                        <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-sm btn-flat" onClick="genform('delete', 'hasil_investasi','hasil_investasi','','<?=$hasil_investasi->id ?>','');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <?php
                                    $tot += $hasil_investasi->saldo_awal_invest;
                                    $jml += $hasil_investasi->mutasi_invest;
                                    $akh += $hasil_investasi->saldo_akhir_invest;
                                    $rka += $hasil_investasi->rka;
                                } ?>

                            <tfoot style="background-color: #d8d8d8; font-weight: bold;">
                                <td></td>
                                <td>Total</td>
                                <td><?php echo rupiah($rka);?></td>
                                <td><?php echo rupiah($tot);?></td>
                                <td><?php echo rupiah($jml);?></td>
                                <td><?php echo rupiah($akh);?></td>
                                <td></td>
                                <td class="user-bln"></td>
                            </tfoot>	
                    <?php } ?>	
                </tbody>
            </table>
            <br>
            <!-- data keterangan  -->
            <div style="padding:4px;">
                 <p style="margin-left:0px;font-size: 18px;font-weight: bold">Keterangan </p>
            </div>

            <div style="padding:4px;border-style:groove;border-color:lightblue;">
                <p style="margin-left:0px;font-size: 14px;margin-right: 15px;margin-left: 0px;text-align: justify;"><?php echo (isset($data_hasil_investasi_ket[0]->keterangan_lap) ? $data_hasil_investasi_ket[0]->keterangan_lap : '');?></p>
                <p style="margin-left:0px;font-size: 14px;font-weight: bold">Dokumen : <a href="<?php echo site_url('bulanan/aset_investasi/get_file/'.(isset($data_hasil_investasi_ket[0]->id) ? $data_hasil_investasi_ket[0]->id : ''));?>"><?php echo (isset($data_hasil_investasi_ket[0]->file_lap) ? $data_hasil_investasi_ket[0]->file_lap : '');?></a>
                </p>
            </div>

                <!-- end keterangan -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer with-border">
               <div class="text-left">
                   <!-- <?php echo $paggination;?> -->
               </div>
           </div>
           <!-- /.Modal form edit/input -->
           <div id="modal_hasil_investasi" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
               <div class="modal-dialog modal-md">
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
                            <form class="form-horizontal" action="<?php echo base_url().'bulanan/hasil_investasi/save_keterangan'?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                <input type="hidden" name="jns_lap" value="ket_hasil_investasi">
                                <input type="hidden" name="nmdok" value="Hasil Investasi">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_hasil_investasi_ket[0]->keterangan_lap) ? $data_hasil_investasi_ket[0]->keterangan_lap : '');?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="id" value="<?php echo (isset($data_hasil_investasi_ket[0]->id) ? $data_hasil_investasi_ket[0]->id : '');?>">
                                        <input type="hidden" name="filedata" value="<?php echo (isset($data_hasil_investasi_ket[0]->file_lap) ? $data_hasil_investasi_ket[0]->file_lap : '');?>">
                                        <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_hasil_investasi_ket[0]->file_lap) ? $data_hasil_investasi_ket[0]->file_lap : '');?>">
                                        <input type="file" name="filedata">
                                        <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                                        <a href="<?php echo site_url('bulanan/aset_investasi/get_file/'.(isset($data_hasil_investasi_ket[0]->id) ? $data_hasil_investasi_ket[0]->id : '').get_uri());?>"><p><?php echo (isset($data_hasil_investasi_ket[0]->file_lap) ? $data_hasil_investasi_ket[0]->file_lap : '');?></p></a>
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
    $('#hasil').on('click', function () {
        localStorage.clear();
        var cell = $("#tabHasilInvestasi > td:nth-child(2)");
        var data = [];
        for (var i = 0; i < cell.length; i++) {
           data.push(cell[i].innerText);
       }
       localStorage.setItem('myArray', JSON.stringify(data));
   });


    $('#hasil-invest').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
        "info": false,
    });

</script>

    