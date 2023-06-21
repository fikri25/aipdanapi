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
        <?php $this->load->view('main/nav_tab_view'); ?>
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Pendahuluan</h3>
            <p class="box-title pull-right" style="margin-right:40px"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo (isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '').' - '. $tahun;?></p>
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
                <div class="col-md-1">
                  <div class="form-group adm">
                    <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensearch('index-pendahuluan','index-pendahuluan');">
                      <i class="fa fa-search"></i>
                    </a> 
                  </div>
                </div>
                <div  class="col-md-8"> 
                  <div class="form-group pull-right">
                    <!-- <a href="<?php echo site_url('bulanan/pendahuluan/laporan_Pendahuluan_PDF').get_uri();?>" target="blank" class="btn btn-sm btn-danger btn-flat pull-right"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF</a> -->
                    <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genform('print-all', 'pendahuluan_cetak','pendahuluan_cetak');">
                      <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
                    </a>  
                  </div>
                </div>
              </div>
            </div>
            <br>
            <br>
            <hr>
            <?php if($this->session->flashdata('form_true')){?>
              <div id="notif">               
                <?php echo $this->session->flashdata('form_true');?>               
              </div>
            <?php } ?>

            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url('bulanan/pendahuluan/save');?>">
              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
              <div class="row">
                <div class="col-md-12">
                  <!--apabila menggunakan Id unik gunakan Input Id-->
                  <input type="hidden" name="id" value="<?php echo (isset($data_pendahuluan[0]->id) ? $data_pendahuluan[0]->id : '');?>" id="kode" class="form-control">
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
                      <label for="keterangan" class="lebel">Pernyataan Tanggung Jawab :</label>
                      <textarea name="keterangan" placeholder="Keterangan" id="keterangan" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->keterangan) ? $data_pendahuluan[0]->keterangan : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="direksi" class="lebel">Nama dan Jabatan :</label>
                      <textarea name="direksi" placeholder="Dewan Direksi" id="direksi" class="form-control ckeditor"><?php echo (isset($data_pendahuluan[0]->direksi) ? $data_pendahuluan[0]->direksi : '');?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12" style="background-color: #dae7ef;">
                    <div class="form-group" style="margin-left: 20px;">
                      <label for="keterangan" class="lebel">Unggah Dokumen</label>
                      <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_pendahuluan[0]->file) ? $data_pendahuluan[0]->file : '');?>">
                      <input type="hidden" name="nmdok" value="Pendahuluan">
                      <input type="file" name="filedata">
                      <p style="margin-top:15px;">Dokumen harus bertipe pdf,doc atau docx</p>
                      <a href="<?php echo site_url('bulanan/pendahuluan/get_file/'.(isset($data_pendahuluan[0]->id) ? $data_pendahuluan[0]->id : '').get_uri());?>"><p><?php echo (isset($data_pendahuluan[0]->file) ? $data_pendahuluan[0]->file : '');?></p></a>

                    </div>
                  </div>
                </div>
              </div>
              <!-- /.panel-body -->
              <div class="modal-footer with-border">
               <div class="col-sm-12">
                  <button class="btn btn-primary btn-flat pull-right user-bln" type="submit" style="margin-right:50px">
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

