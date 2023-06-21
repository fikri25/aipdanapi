<!-- Main content -->
<style type="text/css">
  td.left{
    text-align: left;
    margin-left: 35px;
  }
  td.right{
    text-align: right;
  }


</style>
<?php $level = $this->session->userdata('level');?>
<?php $tahun = $this->session->userdata('tahun');?>
<div class="row">
  <div class="col-xs-12">
    <div class="nav-tabs-custom">
      <?php $this->load->view('main/nav_tab_lampiran'); ?>
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Perubahan Dana Bersih</h3>
          <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp;Semesteran</p>
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
                  <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensemestersearch('index-lampiran-perubahan-danabersih','index-lampiran-perubahan-danabersih');">
                    <i class="fa fa-search"></i>
                  </a> 
                </div>
              </div>
              <div class="col-md-4 user">
                &nbsp;&nbsp;
              </div>
              <div class="col-md-1 adm">
                &nbsp;&nbsp;
              </div>
              <div  class="col-md-4"> 
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
                   <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genformsemester('print-all', 'lampiran_perubahan_danabersih_cetak','lampiran_perubahan_danabersih_cetak');"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
                   </a>  
                    &nbsp;&nbsp;&nbsp;
                  </div>
              </div>
            </div>
          </div>
          <?php if($this->session->flashdata('form_true')){?>
            <div id="notif">               
              <?php echo $this->session->flashdata('form_true');?>               
            </div>
          <?php } ?>

          <!-- ======================================================SEMESTER 2 ================================ -->
          <?php if($semester == 2 || $semester == ""):?>
          <table id="example" class="table table-responsive table-bordered table-hover">
            <thead>
              <tr>
                <th width="40%">URAIAN</th>
                <th width="30%">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
                <th width="30%">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
              </tr>

            </thead>
            <tbody>
              <?php
                $totkas = 0;
                $totkasprev = 0;
                $dbersih_awal1 = 0;
                $dbersih_akhir1 = 0;
                $dbersih_akhir2 = 0;
              ?>
              <?php if(isset($data_perubahan_danabersih) && is_array($data_perubahan_danabersih)):?>
                <?php foreach($data_perubahan_danabersih as $perubahan_danabersih):?>
                  <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
                    <td style="text-align: left;color: #303a3f;" colspan="3"><?=$perubahan_danabersih['uraian']?></td>
                  </tr>
                    <?php foreach($perubahan_danabersih['child'] as $child):?>
                      <?php if($child['group'] == 'HASIL INVESTASI'):?>
                        <tr>
                          <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="3"><?=$child['judul_head']?></td>
                        </tr>
                      <?php endif;?>
                      <?php foreach($child['subchild'] as $subchild):?>

                        <?php if($subchild['type'] == 'PC'):?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <?php else:?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td style="text-align: right;"><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
                          <td style="text-align: right;"><?=($subchild['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_bln_lalu']) : '-';?></td>
                        </tr>
                        <?php endif;?>

                        <?php if($subchild['type'] == 'PC'):?>
                          <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                            <tr>
                              <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                              <td style="text-align: right;"><?=($subchild3['saldo_akhir'] != 0 ) ? rupiah($subchild3['saldo_akhir']) : '-';?></td>
                              <td style="text-align: right;"><?=($subchild3['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_bln_lalu']) : '-';?></td>
                            </tr>
                          <?php endforeach;?>
                        <?php endif;?>
                      <?php endforeach;?>
                      <?php if($child['group'] == 'HASIL INVESTASI' || $child['group'] == 'NILAI INVESTASI'):?>
                      <tr style="font-weight: bold;">
                        <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
                      </tr>
                      <?php endif;?>
                    <?php endforeach;?>
                    <tr style="font-weight: bold; background-color:#d2ebf9;">
                      <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
                      <td style="text-align: right;"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
                      <td style="text-align: right;"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
                    </tr>
                <?php endforeach;?>
              <?php endif;?>
              <?php
                $saldo_akhir1 = (!empty($tot_perubahan[0]->saldo_akhir_smt1) ? $tot_perubahan[0]->saldo_akhir_smt1 : '0');
                $saldo_akhir2 = (!empty($tot_perubahan[1]->saldo_akhir_smt1) ? $tot_perubahan[1]->saldo_akhir_smt1 : '0');
                $saldo_akhir_smt1 = (!empty($tot_perubahan[0]->saldo_akhir_smt2) ? $tot_perubahan[0]->saldo_akhir_smt2 : '0');
                $saldo_akhir_smt2 = (!empty($tot_perubahan[1]->saldo_akhir_smt2) ? $tot_perubahan[1]->saldo_akhir_smt2 : '0');

                // $dbersih_awal1 = ((!empty($total_dbersih['saldo_akhir']) ? $total_dbersih['saldo_akhir']: '0');
                // $dbersih_awal2 = (!empty($total_dbersih['saldo_akhir_bln_lalu']) ? $total_dbersih['saldo_akhir_bln_lalu']: '0');
                $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_bln_lalu) ? $total_bersih[0]->saldo_akhir_bln_lalu : '0');
                $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_bln_lalu) ? $total_bersih[1]->saldo_akhir_bln_lalu : '0');

                $dbersih_awal2 =  $total_bersih1 -  $total_bersih2;
                $tot = $saldo_akhir1 - $saldo_akhir2;
                $tot_prev = $saldo_akhir_smt1 - $saldo_akhir_smt2;
                $dbersih_akhir2 =  $tot_prev + $dbersih_awal2;
                $dbersih_akhir1 =  $tot + $dbersih_akhir2;

              ?>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
                <td style="text-align: right;"><?=rupiah($tot);?></td>
                <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
              </tr>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_awal2);?></td>
              </tr>
               <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir1);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
              </tr>
            </tbody>
          </table>
          <?php endif;?>

          <!-- ======================================================SEMESTER 1 ================================ -->
          <?php if($semester == 1 ):?>
          <table id="example" class="table table-responsive table-bordered table-hover">
            <thead>
              <tr>
                <th width="40%">URAIAN</th>
                <th width="30%">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
                <th width="30%">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
              </tr>

            </thead>
            <tbody>
              <?php
                $totkas = 0;
                $totkasprev = 0;
                $dbersih_awal1 = 0;
                $dbersih_akhir1 = 0;
                $dbersih_akhir2 = 0;
              ?>
              <?php if(isset($data_perubahan_danabersih) && is_array($data_perubahan_danabersih)):?>
                <?php foreach($data_perubahan_danabersih as $perubahan_danabersih):?>
                  <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
                    <td style="text-align: left;color: #303a3f;" colspan="3"><?=$perubahan_danabersih['uraian']?></td>
                  </tr>
                    <?php foreach($perubahan_danabersih['child'] as $child):?>
                      <?php if($child['group'] == 'HASIL INVESTASI'):?>
                        <tr>
                          <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="3"><?=$child['judul_head']?></td>
                        </tr>
                      <?php endif;?>
                      <?php foreach($child['subchild'] as $subchild):?>

                        <?php if($subchild['type'] == 'PC'):?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <?php else:?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td style="text-align: right;"><?=($subchild['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_bln_lalu']) : '-';?></td>
                          <td style="text-align: right;"><?=($subchild['saldo_akhir'] != 0 ) ? rupiah($subchild['saldo_akhir']) : '-';?></td>
                        </tr>
                        <?php endif;?>

                        <?php if($subchild['type'] == 'PC'):?>
                          <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                            <tr>
                              <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                              <td style="text-align: right;"><?=($subchild3['saldo_akhir_bln_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_bln_lalu']) : '-';?></td>
                              <td style="text-align: right;"><?=($subchild3['saldo_akhir'] != 0 ) ? rupiah($subchild3['saldo_akhir']) : '-';?></td>
                            </tr>
                          <?php endforeach;?>
                        <?php endif;?>
                      <?php endforeach;?>
                      <?php if($child['group'] == 'HASIL INVESTASI'):?>
                      <tr style="font-weight: bold;">
                        <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
                      </tr>
                      <?php endif;?>
                    <?php endforeach;?>
                    <tr style="font-weight: bold; background-color:#d2ebf9;">
                      <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
                      <td style="text-align: right;"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
                      <td style="text-align: right;"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
                    </tr>
                <?php endforeach;?>
              <?php endif;?>
              <?php
                $saldo_akhir1 = (!empty($tot_perubahan[0]->saldo_akhir_smt1) ? $tot_perubahan[0]->saldo_akhir_smt1 : '0');
                $saldo_akhir2 = (!empty($tot_perubahan[1]->saldo_akhir_smt1) ? $tot_perubahan[1]->saldo_akhir_smt1 : '0');
                $saldo_akhir_smt1 = (!empty($tot_perubahan[0]->saldo_akhir_smt2) ? $tot_perubahan[0]->saldo_akhir_smt1 : '0');
                $saldo_akhir_smt2 = (!empty($tot_perubahan[1]->saldo_akhir_smt2) ? $tot_perubahan[1]->saldo_akhir_smt2 : '0');

                // $dbersih_awal1 = ((!empty($total_dbersih['saldo_akhir']) ? $total_dbersih['saldo_akhir']: '0');
                // $dbersih_awal2 = (!empty($total_dbersih['saldo_akhir_bln_lalu']) ? $total_dbersih['saldo_akhir_bln_lalu']: '0');
                $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_bln_lalu) ? $total_bersih[0]->saldo_akhir_bln_lalu : '0');
                $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_bln_lalu) ? $total_bersih[1]->saldo_akhir_bln_lalu : '0');

                $dbersih_awal2 =  $total_bersih1 -  $total_bersih2;
                $tot = $saldo_akhir1 - $saldo_akhir2;
                $tot_prev = $saldo_akhir_smt1 - $saldo_akhir_smt2;
                $dbersih_akhir2 =  $tot_prev + $dbersih_awal2;
                $dbersih_akhir1 =  $tot + $dbersih_akhir2;

              ?>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
                <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
                <td style="text-align: right;"><?=rupiah($tot);?></td>
              </tr>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_awal2);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
              </tr>
               <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir1);?></td>
              </tr>
            </tbody>
          </table>
          <?php endif;?>
          <br>
          <!-- data keterangan  -->
          <div style="padding:4px;">
            <p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
            </p>
            <div style="padding:4px;border-style:groove;border-color:lightblue;">
              <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->keterangan_lap) ? $data_perubahan_danabersih_ket_smt1[0]->keterangan_lap : '');?></p>

              <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester I : 
                <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_perubahan_danabersih_ket_smt1[0]->id) ? $data_perubahan_danabersih_ket_smt1[0]->id : ''));?>"><?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->file_lap) ? $data_perubahan_danabersih_ket_smt1[0]->file_lap : '');?></a>
              </p>  
              <br>
              <?php if(isset($data_perubahan_danabersih_ket_smt2[0]->id) != "") :?>
                <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->keterangan_lap) ? $data_perubahan_danabersih_ket_smt2[0]->keterangan_lap : '');?></p>

                <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester II : 
                  <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_perubahan_danabersih_ket_smt2[0]->id) ? $data_perubahan_danabersih_ket_smt2[0]->id : ''));?>"><?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->file_lap) ? $data_perubahan_danabersih_ket_smt2[0]->file_lap : '');?></a>
                </p>
              <?php endif; ?>
            </div>
          </div>
          <!-- end keterangan -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.col -->
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

                <input type="hidden" name="jns_lap" value="ket_lkob_perubahan_danabersih">
                <input type="hidden" name="nmdok" value="Lkob_Perubahan_Danabersih_Semester">
                <input type="hidden" name="semester" value="1">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->keterangan_lap) ? $data_perubahan_danabersih_ket_smt1[0]->keterangan_lap : '');?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->id) ? $data_perubahan_danabersih_ket_smt1[0]->id : '');?>">
                    <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->file_lap) ? $data_perubahan_danabersih_ket_smt1[0]->file_lap : '');?>">
                    <input type="file" name="filedata">
                    <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                    <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_perubahan_danabersih_ket_smt1[0]->id) ? $data_perubahan_danabersih_ket_smt1[0]->id : ''));?>"><p><?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->file_lap) ? $data_perubahan_danabersih_ket_smt1[0]->file_lap : '');?></p></a>
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

                <input type="hidden" name="jns_lap" value="ket_lkob_perubahan_danabersih">
                <input type="hidden" name="semester" value="2">
                <input type="hidden" name="nmdok" value="Lkob_Perubahan_Danabersih_Semester">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->keterangan_lap) ? $data_perubahan_danabersih_ket_smt2[0]->keterangan_lap : '');?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->id) ? $data_perubahan_danabersih_ket_smt2[0]->id : '');?>">
                    <input type="hidden" name="filedata" value="<?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->file_lap) ? $data_perubahan_danabersih_ket_smt2[0]->file_lap : '');?>">
                    <input type="file" name="filedata">
                    <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                    <a href="<?php echo site_url('semesteran/operasional_belanja/get_file/'.(isset($data_perubahan_danabersih_ket_smt2[0]->id) ? $data_perubahan_danabersih_ket_smt2[0]->id : ''));?>"><p><?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->file_lap) ? $data_perubahan_danabersih_ket_smt2[0]->file_lap : '');?></p></a>
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

