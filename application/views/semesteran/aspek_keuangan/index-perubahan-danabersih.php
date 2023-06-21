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
      <?php $this->load->view('main/nav_tab_aspek_keuangan'); ?>
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Perubahan Dana Bersih</h3>
          <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp;SEMESTERAN</p>
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
                  <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensemestersearch('index-perubahan-danabersih','index-perubahan-danabersih');">
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
                      <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genformsemester('print-all', 'perubahan_dana_bersih_cetak','perubahan_dana_bersih_cetak');">
                        <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
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
           <!-- ================================= SEMESTER 2 ================================ -->
          <?php if($semester == 2 || $semester == ""):?>
          <table id="example" class="table table-responsive table-bordered table-hover">
            <thead>
              <tr>
                <th rowspan="2" width="30%">URAIAN</th>
                <th rowspan="2" width="10%">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
                <th rowspan="2" width="10%">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
                <th rowspan="2" width="10%">RKA</th>
                <th rowspan="2" width="10%">Persentase Capaian Semester II terhadap RKA</th>
                <th colspan="2" width="10%">Kenaikan/Penurunan</th>
              </tr>
              <tr>
                <th>Nominal</th>
                <th>Persentase</th>
              </tr>

            </thead>
            <tbody>
              <?php if(isset($data_perubahan_danabersih) && is_array($data_perubahan_danabersih)):?>
                <?php foreach($data_perubahan_danabersih as $perubahan_danabersih):?>
                  <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
                    <td style="text-align: left;color: #303a3f;" colspan="7"><?=$perubahan_danabersih['uraian']?></td>
                  </tr>
                    <?php foreach($perubahan_danabersih['child'] as $child):?>
                      <?php if($child['group'] == 'HASIL INVESTASI'):?>
                        <tr>
                          <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="7"><?=$child['judul_head']?></td>
                        </tr>
                      <?php endif;?>
                      <?php foreach($child['subchild'] as $subchild):?>

                        <?php if($subchild['type'] == 'PC'):?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                        </tr>
                        <?php else:?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td class="right"><?=($subchild['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild['saldo_akhir_smt1']) : '-';?></td>
                          <td class="right"><?=($subchild['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild['saldo_akhir_smt2']) : '-';?></td>
                          <td class="right"><?=($subchild['rka_sem1'] != 0 ) ? rupiah($subchild['rka_sem1']) : '-';?></td>
                          <td class="right"><?=($subchild['perst_rka_sem1'] != 0 ) ? persen($subchild['perst_rka_sem1']).'%' : '-';?></td>
                          <td class="right"><?=($subchild['nominal'] != 0 ) ? rupiah($subchild['nominal']) : '-';?></td>
                          <td class="right"><?=($subchild['persentase'] != 0 ) ? persen($subchild['persentase']).'%' : '-';?></td>
                        </tr>
                        <?php endif;?>

                        <?php if($subchild['type'] == 'PC'):?>
                          <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                            <tr>
                              <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                              <td class="right"><?=($subchild3['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt1']) : '-';?></td>
                              <td class="right"><?=($subchild3['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt2']) : '-';?></td>
                              <td class="right"><?=($subchild3['rka_sem1'] != 0 ) ? rupiah($subchild3['rka_sem1']) : '-';?></td>
                              <td class="right"><?=($subchild3['perst_rka_sem1'] != 0 ) ? persen($subchild3['perst_rka_sem1']).'%' : '-';?></td>
                              <td class="right"><?=($subchild3['nominal'] != 0 ) ? rupiah($subchild3['nominal']) : '-';?></td>
                              <td class="right"><?=($subchild3['persentase'] != 0 ) ? persen($subchild3['persentase']).'%' : '-';?></td>

                            </tr>
                          <?php endforeach;?>
                        <?php endif;?>
                      <?php endforeach;?>
                      <?php if($child['group'] == 'HASIL INVESTASI' || $child['group'] == 'NILAI INVESTASI'):?>
                      <tr style="font-weight: bold;">
                        <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['rka_sem1_lvl2'] != 0 ) ? rupiah($child['rka_sem1_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_perst_rkasem2_lvl2'] != 0 ) ? persen($child['sum_perst_rkasem2_lvl2']).'%' : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['nominal_lvl2'] != 0 ) ? rupiah($child['nominal_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['persentase_lvl2'] != 0 ) ? persen($child['persentase_lvl2']).'%' : '-';?></td>
                      </tr>
                      <?php endif;?>
                    <?php endforeach;?>
                    <tr style="font-weight: bold; background-color:#d2ebf9;">
                      <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
                      <td  class="right"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['rka_sem1_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['rka_sem1_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['sum_perst_rkasem2_lvl1'] != 0 ) ? persen($perubahan_danabersih['sum_perst_rkasem2_lvl1']).'%' : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['nominal_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['nominal_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['persentase_lvl1'] != 0 ) ? persen($perubahan_danabersih['persentase_lvl1']).'%' : '-';?></td>
                    </tr>
                <?php endforeach;?>
              <?php endif;?>
              <?php
                $saldo_akhir_smt1_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt1) ? $tot_perubahan[0]->saldo_akhir_smt1 : '0');
                $saldo_akhir_smt1_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt1) ? $tot_perubahan[1]->saldo_akhir_smt1 : '0');
                $saldo_akhir_smt2_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt2) ? $tot_perubahan[0]->saldo_akhir_smt2 : '0');
                $saldo_akhir_smt2_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt2) ? $tot_perubahan[1]->saldo_akhir_smt2 : '0');

                $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_smt2) ? $total_bersih[0]->saldo_akhir_smt2 : '0');
                $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_smt2) ? $total_bersih[1]->saldo_akhir_smt2 : '0');
                $dbersih1 = (isset($data_perubahan_danabersih[0]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[0]['rka_sem1_lvl1'] : 0) ;
                $dbersih2 = (isset($data_perubahan_danabersih[1]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[1]['rka_sem1_lvl1'] : 0) ;
                // penngkatan (penurunan)
                $tot = $saldo_akhir_smt1_1 - $saldo_akhir_smt1_2;
                $tot_prev = $saldo_akhir_smt2_1 - $saldo_akhir_smt2_2;
                $tot_rka = $dbersih1 - $dbersih2;
                $tot_pers_rka = ($tot_rka!=0)?($tot_prev/$tot_rka):0;
                $tot_nominal =  $tot_prev - $tot;
                $tot_persentase = ($tot!=0)?($tot_nominal/$tot)*100:0;

                // dana bersih awal & akhir
                $dbersih_awal1 =  $total_bersih1 - $total_bersih2;
                $dbersih_akhir1 = $tot + $dbersih_awal1;
                $dbersih_awal2 =  $dbersih_akhir1;
                $dbersih_akhir2 = $tot_prev + $dbersih_awal2;
                $dbersih_rka_awal = $dbersih_akhir2;
                $dbersih_rka_akhir = $tot_rka + $dbersih_rka_awal;
                $dbersih_prsn_rka_awal = ($dbersih_rka_awal!=0)?($dbersih_awal2/$dbersih_rka_awal)*100:0;
                $dbersih_prsn_rka_akhir = ($dbersih_rka_akhir!=0)?($dbersih_akhir2/$dbersih_rka_akhir)*100:0;
                $dbersih_nominal_awal = $dbersih_awal2 - $dbersih_awal1;
                $dbersih_nominal_akhir = $dbersih_akhir2 - $dbersih_akhir1;
                $dbersih_persentase_awal = ($dbersih_awal1!=0)?($dbersih_nominal_awal/$dbersih_awal1)*100:0;
                $dbersih_persentase_akhir = ($dbersih_akhir1!=0)?($dbersih_nominal_akhir/$dbersih_akhir1)*100:0;

              ?>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
                <td style="text-align: right;"><?=rupiah($tot);?></td>
                <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
                <td style="text-align: right;"><?=rupiah($tot_rka);?></td>
                <td style="text-align: right;"><?=persen($tot_pers_rka);?>%</td>
                <td style="text-align: right;"><?=rupiah($tot_nominal);?></td>
                <td style="text-align: right;"><?=persen($tot_persentase);?>%</td>
              </tr>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_awal1);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_awal2);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_rka_awal);?></td>
                <td style="text-align: right;"><?=persen($dbersih_prsn_rka_awal);?>%</td>
                <td style="text-align: right;"><?=rupiah($dbersih_nominal_awal);?></td>
                <td style="text-align: right;"><?=persen($dbersih_persentase_awal);?>%</td>
              </tr>
               <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir1);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_rka_akhir);?></td>
                <td style="text-align: right;"><?=persen($dbersih_prsn_rka_akhir);?>%</td>
                <td style="text-align: right;"><?=rupiah($dbersih_nominal_akhir);?></td>
                <td style="text-align: right;"><?=persen($dbersih_persentase_akhir);?>%</td>
              </tr>
            </tbody>
          </table>
          <?php endif;?>

          <!-- ========================================= SEMESTER 1 ================================ -->
          <?php if($semester == 1 ):?>
          <table id="example" class="table table-responsive table-bordered table-hover">
            <thead>
              <tr>
                <th rowspan="2" width="30%">URAIAN</th>
                <th rowspan="2" width="10%">Semester II&nbsp;&nbsp;<span class="thn-filter"></span></th>
                <th rowspan="2" width="10%">Semester I&nbsp;&nbsp;<span class="thn"></span></th>
                <th rowspan="2" width="10%">RKA</th>
                <th rowspan="2" width="10%">Persentase Capaian Semester II terhadap RKA</th>
                <th colspan="2" width="10%">Kenaikan/Penurunan</th>
              </tr>
              <tr>
                <th>Nominal</th>
                <th>Persentase</th>
              </tr>

            </thead>
            <tbody>
              <?php if(isset($data_perubahan_danabersih) && is_array($data_perubahan_danabersih)):?>
                <?php foreach($data_perubahan_danabersih as $perubahan_danabersih):?>
                  <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
                    <td style="text-align: left;color: #303a3f;" colspan="7"><?=$perubahan_danabersih['uraian']?></td>
                  </tr>
                    <?php foreach($perubahan_danabersih['child'] as $child):?>
                      <?php if($child['group'] == 'HASIL INVESTASI'):?>
                        <tr>
                          <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="7"><?=$child['judul_head']?></td>
                        </tr>
                      <?php endif;?>
                      <?php foreach($child['subchild'] as $subchild):?>

                        <?php if($subchild['type'] == 'PC'):?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"></td>
                        </tr>
                        <?php else:?>
                        <tr>
                          <td class="left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                          <td class="right"><?=($subchild['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild['saldo_akhir_smt2']) : '-';?></td>
                          <td class="right"><?=($subchild['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild['saldo_akhir_smt1']) : '-';?></td>
                          <td class="right"><?=($subchild['rka_sem1'] != 0 ) ? rupiah($subchild['rka_sem1']) : '-';?></td>
                          <td class="right"><?=($subchild['perst_rka_sem1'] != 0 ) ? persen($subchild['perst_rka_sem1']).'%' : '-';?></td>
                          <td class="right"><?=($subchild['nominal'] != 0 ) ? rupiah($subchild['nominal']) : '-';?></td>
                          <td class="right"><?=($subchild['persentase'] != 0 ) ? persen($subchild['persentase']).'%' : '-';?></td>
                        </tr>
                        <?php endif;?>

                        <?php if($subchild['type'] == 'PC'):?>
                          <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                            <tr>
                              <td class="left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                              <td class="right"><?=($subchild3['saldo_akhir_smt2'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt2']) : '-';?></td>
                              <td class="right"><?=($subchild3['saldo_akhir_smt1'] != 0 ) ? rupiah($subchild3['saldo_akhir_smt1']) : '-';?></td>
                              <td class="right"><?=($subchild3['rka_sem1'] != 0 ) ? rupiah($subchild3['rka_sem1']) : '-';?></td>
                              <td class="right"><?=($subchild3['perst_rka_sem1'] != 0 ) ? persen($subchild3['perst_rka_sem1']).'%' : '-';?></td>
                              <td class="right"><?=($subchild3['nominal'] != 0 ) ? rupiah($subchild3['nominal']) : '-';?></td>
                              <td class="right"><?=($subchild3['persentase'] != 0 ) ? persen($subchild3['persentase']).'%' : '-';?></td>

                            </tr>
                          <?php endforeach;?>
                        <?php endif;?>
                      <?php endforeach;?>
                      <?php if($child['group'] == 'HASIL INVESTASI'):?>
                      <tr style="font-weight: bold;">
                        <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['rka_sem1_lvl2'] != 0 ) ? rupiah($child['rka_sem1_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_perst_rkasem2_lvl2'] != 0 ) ? persen($child['sum_perst_rkasem2_lvl2']).'%' : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['nominal_lvl2'] != 0 ) ? rupiah($child['nominal_lvl2']) : '-';?></td>
                        <td style="text-align: right; background-color:#e6f5fe;"><?=($child['persentase_lvl2'] != 0 ) ? persen($child['persentase_lvl2']).'%' : '-';?></td>
                      </tr>
                      <?php endif;?>
                    <?php endforeach;?>
                    <tr style="font-weight: bold; background-color:#d2ebf9;">
                      <td class="left"><?=$perubahan_danabersih['judul_total']?></td>
                      <td  class="right"><?=($perubahan_danabersih['sum_prev_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_prev_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['sum_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['sum_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['rka_sem1_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['rka_sem1_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['sum_perst_rkasem2_lvl1'] != 0 ) ? persen($perubahan_danabersih['sum_perst_rkasem2_lvl1']).'%' : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['nominal_lvl1'] != 0 ) ? rupiah($perubahan_danabersih['nominal_lvl1']) : '-';?></td>
                      <td  class="right"><?=($perubahan_danabersih['persentase_lvl1'] != 0 ) ? persen($perubahan_danabersih['persentase_lvl1']).'%' : '-';?></td>
                    </tr>
                <?php endforeach;?>
              <?php endif;?>
              <?php
                $saldo_akhir_smt1_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt1) ? $tot_perubahan[0]->saldo_akhir_smt1 : '0');
                $saldo_akhir_smt1_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt1) ? $tot_perubahan[1]->saldo_akhir_smt1 : '0');
                $saldo_akhir_smt2_1 = (!empty($tot_perubahan[0]->saldo_akhir_smt2) ? $tot_perubahan[0]->saldo_akhir_smt2 : '0');
                $saldo_akhir_smt2_2 = (!empty($tot_perubahan[1]->saldo_akhir_smt2) ? $tot_perubahan[1]->saldo_akhir_smt2 : '0');

                $total_bersih1 = (!empty($total_bersih[0]->saldo_akhir_smt2) ? $total_bersih[0]->saldo_akhir_smt2 : '0');
                $total_bersih2 = (!empty($total_bersih[1]->saldo_akhir_smt2) ? $total_bersih[1]->saldo_akhir_smt2 : '0');
                $dbersih1 = (isset($data_perubahan_danabersih[0]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[0]['rka_sem1_lvl1'] : 0) ;
                $dbersih2 = (isset($data_perubahan_danabersih[1]['rka_sem1_lvl1']) ? $data_perubahan_danabersih[1]['rka_sem1_lvl1'] : 0) ;
                // penngkatan (penurunan)
                $tot = $saldo_akhir_smt1_1 - $saldo_akhir_smt1_2;
                $tot_prev = $saldo_akhir_smt2_1 - $saldo_akhir_smt2_2;
                $tot_rka = $dbersih1 - $dbersih2;
                $tot_pers_rka = ($tot_rka!=0)?($tot_prev/$tot_rka):0;
                $tot_nominal =  $tot_prev - $tot;
                $tot_persentase = ($tot!=0)?($tot_nominal/$tot)*100:0;

                // dana bersih awal & akhir
                $dbersih_awal1 =  $total_bersih1 - $total_bersih2;
                $dbersih_akhir1 = $tot + $dbersih_awal1;
                $dbersih_awal2 =  $dbersih_akhir1;
                $dbersih_akhir2 = $tot_prev + $dbersih_awal2;
                $dbersih_rka_awal = $dbersih_akhir2;
                $dbersih_rka_akhir = $tot_rka + $dbersih_rka_awal;
                $dbersih_prsn_rka_awal = ($dbersih_rka_awal!=0)?($dbersih_awal2/$dbersih_rka_awal)*100:0;
                $dbersih_prsn_rka_akhir = ($dbersih_rka_akhir!=0)?($dbersih_akhir2/$dbersih_rka_akhir)*100:0;
                $dbersih_nominal_awal = $dbersih_awal2 - $dbersih_awal1;
                $dbersih_nominal_akhir = $dbersih_akhir2 - $dbersih_akhir1;
                $dbersih_persentase_awal = ($dbersih_awal1!=0)?($dbersih_nominal_awal/$dbersih_awal1)*100:0;
                $dbersih_persentase_akhir = ($dbersih_akhir1!=0)?($dbersih_nominal_akhir/$dbersih_akhir1)*100:0;

              ?>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">PENINGKATAN (PENURUNAN)</td>
                <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
                <td style="text-align: right;"><?=rupiah($tot);?></td>
                <td style="text-align: right;"><?=rupiah($tot_rka);?></td>
                <td style="text-align: right;"><?=persen($tot_pers_rka);?>%</td>
                <td style="text-align: right;"><?=rupiah($tot_nominal);?></td>
                <td style="text-align: right;"><?=persen($tot_persentase);?>%</td>
              </tr>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AWAL PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_awal2);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_awal1);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_rka_awal);?></td>
                <td style="text-align: right;"><?=persen($dbersih_prsn_rka_awal);?>%</td>
                <td style="text-align: right;"><?=rupiah($dbersih_nominal_awal);?></td>
                <td style="text-align: right;"><?=persen($dbersih_persentase_awal);?>%</td>
              </tr>
               <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH AKHIR PERIODE</td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir2);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_akhir1);?></td>
                <td style="text-align: right;"><?=rupiah($dbersih_rka_akhir);?></td>
                <td style="text-align: right;"><?=persen($dbersih_prsn_rka_akhir);?>%</td>
                <td style="text-align: right;"><?=rupiah($dbersih_nominal_akhir);?></td>
                <td style="text-align: right;"><?=persen($dbersih_persentase_akhir);?>%</td>
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
                <a href="<?php echo site_url('semesteran/aspek_keuangan/get_file/'.(isset($data_perubahan_danabersih_ket_smt1[0]->id) ? $data_perubahan_danabersih_ket_smt1[0]->id : ''));?>"><?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->file_lap) ? $data_perubahan_danabersih_ket_smt1[0]->file_lap : '');?></a>
              </p>
              <br>
              <?php if(isset($data_perubahan_danabersih_ket_smt2[0]->id) != "") :?>
                <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->keterangan_lap) ? $data_perubahan_danabersih_ket_smt2[0]->keterangan_lap : '');?></p>

                <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester II : 
                  <a href="<?php echo site_url('semesteran/aspek_keuangan/get_file/'.(isset($data_perubahan_danabersih_ket_smt2[0]->id) ? $data_perubahan_danabersih_ket_smt2[0]->id : ''));?>"><?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->file_lap) ? $data_perubahan_danabersih_ket_smt2[0]->file_lap : '');?></a>
                </p>
              <?php endif; ?>
            </div>
          </div>
          <!-- end keterangan -->
        </div>
        <!-- /.box-body -->

        <div id="modal_invest" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">

            </div>
          </div>
        </div>
        <div id="modal_invest1" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
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
              <form class="form-horizontal" action="<?php echo base_url().'semesteran/aspek_keuangan/save_keterangan'?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                <input type="hidden" name="jns_lap" value="ket_lkak_perubahan_danabersih">
                <input type="hidden" name="nmdok" value="Lkak_Perubahan_Danabersih_Semester">
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
                    <a href="<?php echo site_url('semesteran/aspek_keuangan/get_file/'.(isset($data_perubahan_danabersih_ket_smt1[0]->id) ? $data_perubahan_danabersih_ket_smt1[0]->id : ''));?>"><p><?php echo (isset($data_perubahan_danabersih_ket_smt1[0]->file_lap) ? $data_perubahan_danabersih_ket_smt1[0]->file_lap : '');?></p></a>
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
              <form class="form-horizontal" action="<?php echo base_url().'semesteran/aspek_keuangan/save_keterangan'?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                <input type="hidden" name="jns_lap" value="ket_lkak_perubahan_danabersih">
                <input type="hidden" name="semester" value="2">
                <input type="hidden" name="nmdok" value="Lkak_Perubahan_Danabersih_Semester">
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
                    <a href="<?php echo site_url('semesteran/aspek_keuangan/get_file/'.(isset($data_perubahan_danabersih_ket_smt2[0]->id) ? $data_perubahan_danabersih_ket_smt2[0]->id : ''));?>"><p><?php echo (isset($data_perubahan_danabersih_ket_smt2[0]->file_lap) ? $data_perubahan_danabersih_ket_smt2[0]->file_lap : '');?></p></a>
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
  $(document).ready(function() {
    //Fixing jQuery Click Events for the iPad
    var ua = navigator.userAgent,
    event = (ua.match(/iPad/i)) ? "touchstart" : "click";
    if ($('.table').length > 0) {
      $('.table .header').on(event, function() {
        $(this).toggleClass("active", "").nextUntil('.header').css('display', function(i, v) {
          return this.style.display === 'table-row' ? 'none' : 'table-row';
        });
      });
    }
  })


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

