  <!-- Main content -->
  <?php $level = $this->session->userdata('level');?>
  <?php $tahun = $this->session->userdata('tahun');?>
  <style type="text/css">
    .lebel{
      font-weight: bold;
      font-size: 16px;
    }
  </style>
  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Pendahuluan</h3>
            <?php if($semester == '1'){ ?>
              <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Semester I</p>
            <?php } if ($semester == '2') { ?>
              <p class="box-title pull-right" style="margin-right:20px"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Semester II</p>
            <?php } ?>
          </div>
          <br>
          <!-- /.box-header -->                        
          <div class="box-body">
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
                <!-- <div class="col-md-3">
                  <div class="form-group">
                    <select class="form-control select2nya" name="semester" id="semester">
                      <option value="">
                        -- Pilih --
                      </option>
                      <?php if(isset($opt_smt) && is_array($opt_smt)){?> 
                        <?php foreach($opt_smt as $k=>$v){?>
                          <option value="<?php echo $v['id'];?>" <?php if(!empty($semester) && $v['id'] == $semester) echo 'selected="selected"';?>>
                            <?php echo $v['txt'];?>
                          </option>
                        <?php }?>
                      <?php }?>
                    </select>
                    <label class="validation_error_message" for="semester"></label>
                  </div>
                </div> -->
                <div class="col-md-1">
                  <div class="form-group adm">
                    <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensemestersearch('index-pendahuluan-semester','index-pendahuluan-semester');">
                      <i class="fa fa-search"></i>
                    </a> 
                  </div>
                </div>
                <!-- <div class="col-md-3 user"></div> -->
                <div  class="col-md-8"> 
                  <div class="form-group pull-right">
                   <!--  <a href="<?php echo site_url('semesteran/pendahuluan/laporan_Pendahuluan_PDF');?>" target="blank" class="btn btn-sm btn-danger btn-flat pull-right"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF</a> -->
                    <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genformsemester('print-all', 'index-pendahuluan-cetak','index-pendahuluan-cetak');">
                    <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
                    </a>  
                    &nbsp;&nbsp;&nbsp;
                  </div>
                </div>
              </div>
            </div>
            <br>
            <br>
            <br>
            <?php if($this->session->flashdata('form_true')){?>
              <div id="notif">               
                <?php echo $this->session->flashdata('form_true');?>               
              </div>
            <?php } ?>
            <legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'></legend>
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url('semesteran/pendahuluan/save_pendahuluan');?>">
              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
              <div class="row">
                <div class="col-md-12">
                  <!--apabila menggunakan Id unik gunakan Input Id-->
                  <input type="hidden" name="id" value="<?php echo (isset($data_pendahuluan[0]->id) ? $data_pendahuluan[0]->id : '');?>" id="kode" class="form-control">
                  <!-- <div class="col-sm-3">
                    <div class="form-group">
                      <label for="tujuan_laporan" class="lebel">Semester :</label>
                      <select class="form-control select2nya" name="semester" id="semester">
                        <option value="">
                          -- Pilih --
                        </option>
                        <?php if(isset($opt_smt) && is_array($opt_smt)){?> 
                          <?php foreach($opt_smt as $k=>$v){?>
                            <option value="<?php echo $v['id'];?>" <?php if(!empty($data_pendahuluan) && $v['id'] == $data_pendahuluan[0]->semester) echo 'selected="selected"';?>>
                              <?php echo $v['txt'];?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                      <label class="validation_error_message" for="semester"></label>
                    </div>
                  </div> -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="tujuan_laporan" class="lebel">Pihak yang Menjadi Tujuan Laporan :</label>
                      <textarea name="tujuan_laporan" placeholder="Tujuan Laporan" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->tujuan_laporan) ? $data_pendahuluan[0]->tujuan_laporan : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="latar_belakang" class="lebel">Latar Belakang Pelaporan :</label>
                      <textarea name="latar_belakang" class="form-control ckeditor" placeholder="Latar Belakang"><?php echo (isset($data_pendahuluan[0]->latar_belakang) ? $data_pendahuluan[0]->latar_belakang : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="priode" class="lebel">Periode Pelaporan :</label>
                      <textarea name="periode" class="form-control ckeditor" placeholder="Periode Pelaporan"><?php echo (isset($data_pendahuluan[0]->periode) ? $data_pendahuluan[0]->periode : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="kejadian_penting" class="lebel">Kejadian Penting :</label>
                      <textarea name="kejadian_penting" placeholder="Kejadian Penting" id="kejadian_penting" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->kejadian_penting) ? $data_pendahuluan[0]->kejadian_penting : '');?></textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="kejadian_penting" class="lebel">Susunan Direksi :</label>
                      <textarea name="direksi" placeholder="Kejadian Penting" id="direksi" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->direksi) ? $data_pendahuluan[0]->direksi : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="kejadian_penting" class="lebel">Susunan Komisaris :</label>
                      <textarea name="komisaris" placeholder="Kejadian Penting" id="komisaris" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->komisaris) ? $data_pendahuluan[0]->komisaris : '');?></textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="alamat" class="lebel">Alamat Kantor Pusat :</label>
                      <textarea name="alamat" placeholder="alamat" id="alamat" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->alamat) ? $data_pendahuluan[0]->alamat : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="keterangan" class="lebel">Keterangan :</label>
                      <textarea name="keterangan" placeholder="keterangan" id="keterangan" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->keterangan) ? $data_pendahuluan[0]->keterangan : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12" style="background-color: #dae7ef;">
                    <div class="form-group" style="margin-left: 20px;">
                      <label for="keterangan" class="lebel">Unggah Dokumen</label>
                      <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_pendahuluan[0]->file) ? $data_pendahuluan[0]->file : '');?>">
                      <input type="hidden" name="nmdok" value="Pendahuluan_Semester">
                      <input type="file" name="filedata">
                      <p style="margin-top:15px;">File harus bertipe pdf,doc atau docx.</p>
                      <a href="<?php echo site_url('semesteran/pendahuluan/get_file/'.(isset($data_pendahuluan[0]->id) ? $data_pendahuluan[0]->id : '').get_uri());?>"><p><?php echo (isset($data_pendahuluan[0]->file) ? $data_pendahuluan[0]->file : '');?></p></a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.panel-body -->
              <div class="modal-footer with-border">
               <div class="col-sm-12">
                  <button class="btn btn-primary btn-flat pull-right user" type="submit" style="margin-right:50px">
                    Simpan
                  </button>
              </div>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>
        <!-- /.col -->

      </div>
    </div>
    <!-- /.box -->
  </div>
</div>

<script type="text/javascript">
   $(".select2nya").select2( { 'width':'100%' } );

   $(".ckeditor").each(function () {
     CKEDITOR.replace( $(this).attr("name") );
   })

   CKEDITOR.config.toolbar = [
    ['Styles','Format','Font','FontSize'],
    '/',
    ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ];
</script>

