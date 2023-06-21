 <!-- Main content -->
 <?php $level = $this->session->userdata('level');?>
 <?php $tahun = $this->session->userdata('tahun');?>
 <div class="row">
  <div class="col-xs-12">
    <div class="nav-tabs-custom">
      <?php $this->load->view('main/nav_tab_lampiran_tahunan'); ?>
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Aset Investasi</h3>
          <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp;Tahunan</p>
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
                  <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gentahunansearch('index-lampiran-aruskas','index-lampiran-aruskas');">
                    <i class="fa fa-search"></i>
                  </a> 
                </div>
              </div>
              <div  class="col-md-8"> 
                <div class="form-group pull-right">
                  <a href="#" data-target="#Modal_ket1" data-toggle="modal" class="btn btn-sm btn-warning btn-flat user" title="Keterangan"><i class="fa fa-info-circle"></i> Keterangan
                  </a>

                  &nbsp;&nbsp;
                  <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genformtahunan('print-all', 'lampiran_aruskas_cetak','lampiran_aruskas_cetak');">
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
        <table id="example" class="table table-responsive table-bordered table-hover">
          <thead>
           <tr>
            <th width="40%">URAIAN</th>
            <th width="27%">Tahun&nbsp;&nbsp;<span class="tahun"></span></th>
            <th width="27%">Tahun&nbsp;&nbsp;<span class="tahun_lalu"></span></th>
            <!-- <th width="6%">Action</th> -->
          </tr>

        </thead>
        <tbody>
          <?php
          $totkas = 0;
          $totkasprev = 0;
          ?>
          <?php if(isset($arus_kas) && is_array($arus_kas)):?>
          <?php foreach($arus_kas as $kas):?>
            <tr style="font-weight: bold; background-color:#c1e1f3;">
              <td style="text-align: left;" colspan="3"><?=$kas['judul_kas']?></td>
            </tr>
            <?php foreach($kas['child'] as $child):?>
              <tr>
                <td style="text-align: left;padding-left: 35px"><?=$child['arus_kas']?></td>
                <?php foreach($child['subchild'] as $subchl):?>
                  <td style="text-align: right;"><?=($subchl['saldo_thn'] != 0 ) ? rupiah($subchl['saldo_thn']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchl['saldo_thn_lalu'] != 0 ) ? rupiah($subchl['saldo_thn_lalu']) : '-';?></td>
                <?php endforeach;?>
              </tr>
            <?php endforeach;?>
            <tr style="font-weight: bold; background-color:#e6f5fe;">
              <td style="text-align: left;"><?=$kas['judul']?></td>
              <td style="text-align: right;"><?=($kas['sum'] != 0 ) ? rupiah($kas['sum']) : '-';?></td>
              <td style="text-align: right;"><?=($kas['sumprev'] != 0 ) ? rupiah($kas['sumprev']) : '-';?></td>
            </tr>
            <?php
            $totkas += $kas['sum'];
            $totkasprev += $kas['sumprev'];
            ?>

          <?php endforeach;?>
        <?php endif;?>
        <?php
        // $kas_bank = (isset($kas_bank['saldo_akhir']) ? $kas_bank['saldo_akhir'] : 0) ;
        // $kas_akhir2 =  $kas_bank+$totkasprev;
        // $kas_akhir1 = $totkas+$kas_akhir2;

        ?>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
          <td style="text-align: left;">KENAIKAN (PENURUNAN) KAS dan BANK</td>
          <td style="text-align: right;"><?=rupiah($totkas);?></td>
          <td style="text-align: right;"><?=rupiah($totkasprev);?></td>
          <!-- <td style="text-align: left;"></td> -->
        </tr>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
          <td style="text-align: left;">KAS DAN BANK PADA AWAL BULAN</td>
          <td style="text-align: right;"><?=rupiah($kas_bank['saldo_awal_smt1']);?></td>
          <td style="text-align: right;"><?= rupiah($kas_bank['saldo_awal_smt2']);?></td>
        </tr>
        <tr style="font-weight: bold; background-color:#d2ebf9;">
          <td style="text-align: left;">KAS DAN BANK PADA AKHIR BULAN</td>
          <td style="text-align: right;"><?=rupiah($kas_bank['saldo_akhir_smt1']);?></td>
          <td style="text-align: right;"><?= rupiah($kas_bank['saldo_akhir_smt2']);?></td>
        </tr>


      </tbody>
    </table>
    <br>
    <!-- data keterangan  -->
    <div style="padding:4px;">
      <p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
      </p>
      <div style="padding:4px;border-style:groove;border-color:lightblue;">
        <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_lamp_aruskas_ket_thn[0]->keterangan_lap) ? $data_lamp_aruskas_ket_thn[0]->keterangan_lap : '');?></p>

        <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen Semester I : 
          <a href="<?php echo site_url('tahunan/lampiran/get_file/'.(isset($data_lamp_aruskas_ket_thn[0]->id) ? $data_lamp_aruskas_ket_thn[0]->id : ''));?>"><?php echo (isset($data_lamp_aruskas_ket_thn[0]->file_lap) ? $data_lamp_aruskas_ket_thn[0]->file_lap : '');?></a>
        </p>

      </div>
    </div>
    <!-- end keterangan -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer with-border">
   <div class="text-left">
     <!-- <?php echo $paggination;?> -->
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
              <form class="form-horizontal" action="<?php echo base_url().'tahunan/lampiran/save_keterangan'?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                <input type="hidden" name="jns_lap" value="ket_lamp_aruskas">
                <input type="hidden" name="nmdok" value="Lampiran_Arus_Kas_Tahun">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_lamp_aruskas_ket_thn[0]->keterangan_lap) ? $data_lamp_aruskas_ket_thn[0]->keterangan_lap : '');?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo (isset($data_lamp_aruskas_ket_thn[0]->id) ? $data_lamp_aruskas_ket_thn[0]->id : '');?>">
                    <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_lamp_aruskas_ket_thn[0]->file_lap) ? $data_lamp_aruskas_ket_thn[0]->file_lap : '');?>">
                    <input type="file" name="filedata">
                    <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                    <a href="<?php echo site_url('tahunan/lampiran/get_file/'.(isset($data_lamp_aruskas_ket_thn[0]->id) ? $data_lamp_aruskas_ket_thn[0]->id : ''));?>"><p><?php echo (isset($data_lamp_aruskas_ket_thn[0]->file_lap) ? $data_lamp_aruskas_ket_thn[0]->file_lap : '');?></p></a>
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
  $('.tahun').text(tahun);
  $('.tahun_lalu').text(tahun - 1);
</script>


