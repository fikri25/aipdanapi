  <!-- Main content -->
  <?php $tahun = $this->session->userdata("tahun");?>
  <?php $semester = $this->session->userdata('semester');?>
  <?php $level = $this->session->userdata('level');?>
  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Pernyataan</h3>
            <?php if($semester == '1'){ ?>
              <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Semester I</p>
            <?php } if ($semester == '2') { ?>
              <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Semester II</p>
            <?php } ?>
          </div>
          <br>
          <!-- /.box-header -->  
          <div class="row" style="margin-left: 50px">
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
                <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensemestersearch('index-pernyataan-semester','index-pernyataan-semester');">
                  <i class="fa fa-search"></i>
                </a> 
              </div>
            </div>
          </div>  
          <br>     
          <!-- <legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'></legend>                -->
          <div class="box-body">
            <?php if($this->session->flashdata('form_true')){?>
              <div id="notif">               
                <?php echo $this->session->flashdata('form_true');?>               
              </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-12">
                <div style="margin-left: 50px;margin-right: 50px">
                  <p style="font-weight: bold">
                    <h4 align="center">SURAT PERNYATAAN DIREKSI</h4>
                    <h4 align="center">TANGGUNG JAWAB ATAS LAPORAN SEMESTERAN</h4>
                    <?php if($iduser == 'TSN002'):?>
                    <h4 align="center">PENGELOLAAN AKUMULASI IURAN PENSIUN PEGAWAI NEGERI SIPIL DAN PEJABAT NEGARA</h4>
                    <?php endif;?>
                    <?php if($iduser == 'ASB003'):?>
                    <h4 align="center">PENGELOLAAN AKUMULASI IURAN PENSIUN TNI/POLRI</h4>
                    <?php endif;?>
                    <h4 align="center" style="text-transform: uppercase;">SEMESTER&nbsp;<?php if($semester == '1'){echo "I";}else{echo "II";} ?>&nbsp;TAHUN&nbsp;<?php echo $tahun; ?></h4>
                  </p>
                  <hr style="height:3px;background-color:#a8a8a8;">
                  <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url('semesteran/pendahuluan/update_status');?>">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <table>
                      <tbody>
                        <tr>
                          <td><p>Kami yang bertandatangan di bawah ini&nbsp;&nbsp;</p></td>
                          <td><p>:</p></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td><p>Nama</p></td>
                          <td><p>:</p></td>
                          <td><p>&nbsp;&nbsp;<input type="text" name="nama_penandatangan" value="<?php echo (isset($data_pendahuluan[0]->nama_penandatangan) ? $data_pendahuluan[0]->nama_penandatangan : '');?>" placeholder="Nama" style="width:80%" required="required" <?php if (isset($data_pendahuluan[0]->status) == "Selesai"){echo 'disabled="disabled"';}?>></p></td>
                        </tr>
                        <tr>
                          <td><p>Alamat Kantor</p></td>
                          <td><p>:</p></td>
                          <?php if($iduser == 'TSN002'):?>
                          <td><p>&nbsp;&nbsp;Jl. Letjen Suprapto No. 45 – Cempaka Putih Jakarta Pusat 10520 DKI Jakarta</p></td>
                          <?php endif;?>
                           <?php if($iduser == 'ASB003'):?>
                          <td><p>&nbsp;&nbsp;Jl. Mayjen Sutoyo No 11, Jakarta Timur</p></td>
                          <?php endif;?>
                        </tr>
                        <tr>
                          <td><p>Jabatan</p></td>
                          <td><p>:</p></td>
                          <td><p>&nbsp;&nbsp;<input type="text" name="jabatan" value="<?php echo (isset($data_pendahuluan[0]->jabatan) ? $data_pendahuluan[0]->jabatan : '');?>" placeholder="Jabatan" style="width:80%" required="required" <?php if (isset($data_pendahuluan[0]->status) == "Selesai"){echo 'disabled="disabled"';}?>></p></td>
                        </tr>
                        <tr>
                          <td><p>Menyatakan bahwa</p></td>
                          <td><p>:</p></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>

                    <?php if($iduser == 'TSN002'):?>
                      <p>1. Bertanggung jawab atas penyusunan dan penyajian laporan semesteran pengelolaan akumulasi iuran pensiun Pegawai Negeri Sipil dan Pejabat Negara;</p>
                      <p>2. Laporan keuangan laporan semesteran pengelolaan akumulasi iuran pensiun dan pejabat negara telah disusun dan disajikan sesuai dengan ketentuan yang berlaku; </p>
                      <p>3. Semua informasi dalam laporan-laporan semesteran pengelolaan akumulasi iuran pensiun dan pejabat negara telah dimuat secara lengkap dan benar.</p>
                      <p>Demikian peryataan ini dibuat dengan sebenarnya.</p><br><br>
                    <?php endif;?>
                    <?php if($iduser == 'ASB003'):?>
                      <p>1. Bertanggung jawab atas penyusunan dan penyajian laporan semesteran pengelolaan akumulasi iuran pensiun TNI/POLRI;</p>
                      <p>2. Laporan keuangan laporan semesteran pengelolaan akumulasi iuran pensiun TNI/POLRI telah disusun dan disajikan sesuai dengan ketentuan yang berlaku; </p>
                      <p>3. Semua informasi dalam laporan-laporan semesteran pengelolaan akumulasi iuran pensiun TNI/POLRI telah dimuat secara lengkap dan benar.</p>
                      <p>Demikian peryataan ini dibuat dengan sebenarnya.</p><br><br>
                    <?php endif;?>

                    <?php if (isset($data_pendahuluan[0]->status) == "Selesai"){ ?>
                      <p style="text-align: center;">Jakarta, <?php echo indo_tgl($data_pendahuluan[0]->status_tgl);?></p>
                    <?php } else { ?>
                      <p style="text-align: center;">Jakarta, <?php echo indo_tgl(date('Y-m-d'));?></p>
                    <?php } ?>

                    <?php if (isset($data_pendahuluan[0]->status) == "Selesai"){ ?>
                      <p style="text-align: center;"><?php echo (isset($data_pendahuluan[0]->jabatan) ? $data_pendahuluan[0]->jabatan : '');?></p>
                    <?php } else { ?>
                      <p style="text-align: center;">..................</p>
                    <?php } ?>

                    <p style="text-align: center;"> Ttd.</p>

                    <?php if (isset($data_pendahuluan[0]->status) == "Selesai"){ ?>
                      <p style="text-align: center; font-weight: bold"><?php echo (isset($data_pendahuluan[0]->nama_penandatangan) ? $data_pendahuluan[0]->nama_penandatangan : '');?></p>
                    <?php } else { ?>
                      <p style="text-align: center;">..................</p>
                    <?php } ?>

                    <hr style="height:3px;background-color:#a8a8a8;">
                  </div>
                  <?php if (isset($data_pendahuluan[0]->status) != NULL){?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="status" style="margin-left: 50px;margin-right: 50px">Status</label>
                      <div class="col-sm-7" style="margin-bottom: 15px">
                        <span class="badge" style="background-color: green; padding-bottom: 5px"><?php echo (isset($data_pendahuluan[0]->status) ? $data_pendahuluan[0]->status : '');?></span>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <!-- /.panel-body -->
              <div class="modal-footer with-border" style="margin-left: 50px;margin-right: 50px">
                <div class="col-sm-12">
                 <?php if($level != "DJA"){?>
                    <a href="<?php echo site_url('#').get_uri();?>" data-target="#modal" data-toggle="modal" class="btn btn-success btn-flat <?php if (isset($data_pendahuluan[0]->status) == "Selesai"){echo 'disabled';}?>" style="margin-right: 0px"><i class="fa fa-check"></i>&nbsp;&nbsp;Simpan</a>

                    <?php if (isset($data_pendahuluan[0]->status) != NULL){?>
                      <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genformsemester('print-all', 'index-pernyataan-cetak','index-pernyataan-cetak');">
                        <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak Bukti
                      </a>  
                    <?php } ?>
                  <?php } ?>
                </div>
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.box -->
      </div>
    </div>

    <!-- MODAL APPROVE -->
    <div class="modal fade modal-warning" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p class="modal-title" style="text-align:center;font-size:15px;">Apakah anda yakin ingin menyelesaikan laporan semesteran ?</p>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group form-group-sm">
                  <!-- <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url('semesteran/pendahuluan/update_status');?>"> -->
                    <input type="hidden" name="status" value="Selesai">
                    <div>
                      <button class="btn btn-outline btn-sm btn-flat pull-right" type="submit">OK</button>
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
</script>