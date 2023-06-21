<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><b>AIP</b></span>
        <span class="logo-lg"><b>SMART </b>AIP</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navigasi</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php
                        $level = $this->session->userdata('level');
                        if ($level == 'DJA') { 
                            $foto_profile="files/profiles/logo-dja.jpg";
                        }elseif ($level == 'TASPEN') {
                            $foto_profile="files/profiles/logo-taspen.jpg";
                        }elseif ($level == 'ASABRI') {
                            $foto_profile="files/profiles/logo-asabri.jpg";
                        }else{
                            $foto_profile="files/profiles/_noprofile.jpg";
                        }
                    ?>
                    <img src="<?php echo site_url($foto_profile); ?>" class="user-image img-bordered-dsw" />
                    <span class="hidden-xs"><?php echo $this->session->userdata('nama_lengkap') ?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <img src="<?php echo site_url($foto_profile); ?>" class="img-circle" />
                        <p>
                            <?php echo $this->session->userdata('nama_lengkap') ?>
                        </p>
                    </li>

                    <li class="user-footer">
                         <div class="pull-left">
                            <a href="javascript:void()" id="change_pw" class="btn btn-default btn-flat">Ubah Password</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo site_url("login/logout_user") ?>" class="btn btn-default btn-flat">Keluar</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
     </div>
    </nav>
</header>

<div id="modalPassword" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Password</h4>
            </div>
            <form class="form-horizontal" id="form-baru">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
                    <div id="notif_change_pw">
                    </div>
                    <input type="hidden" id="nmuser_change" class="form-control input-sm" name="nmuser_change" placeholder="Username" maxlength="30" value="<?= $this->session->userdata('nmuser')?>" readonly/>
                    <div class="form-group ">
                        <label for="old_pass" class="col-sm-3 control-label input-sm">Password Lama</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" value="" id="c_password" name="c_password" class="form-control input-sm input_pass" placeholder="Password Lama"> 
                                <span class="input-group-addon">
                                    <a href="javascript:void(0);" onclick="konversi_pwd_text('c_password','iconPassOld')" id="iconPassOld"><i class="fa fa-eye"></i></a>
                                </span> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="new_pass" class="col-sm-3 control-label input-sm">Password Baru</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" value="" id="n_password" name="n_password" class="form-control input-sm" placeholder="Password Baru"> 
                                <span class="input-group-addon">
                                    <a href="javascript:void(0);" onclick="konversi_pwd_text('n_password','iconPassNew')" id="iconPassNew"><i class="fa fa-eye"></i></a>
                                </span> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="con_pass" class="col-sm-3 control-label input-sm">Konfirmasi Password Baru</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" value="" id="n2_password" name="n2_password" class="form-control input-sm" placeholder="Konfirmasi Password Baru"> 
                                <span class="input-group-addon">
                                    <a href="javascript:void(0);" onclick="konversi_pwd_text('n2_password','iconPassCon')" id="iconPassCon"><i class="fa fa-eye"></i></a>
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="submit" value="Simpan" id="simpan" class="btn btn-flat btn-primary btn-md">
                    <button type="button" class="btn btn-flat btn-md btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on("click", "#change_pw", function(e) {
        $('#modalPassword').modal('show');
        e.preventDefault();
    });


    function konversi_pwd_text(id,icon){
            if($('input#'+id)[0].type=="password"){
                $('input#'+id)[0].type = 'text';
                $('#'+icon).html('<i class="fa fa-eye-slash"></i>');
            }
            else {
                $('input#'+id)[0].type = 'password';
                $('#'+icon).html('<i class="fa fa-eye"></i>');
            }
        }

        $('#form-baru').submit(function(e) {

              $.ajax({
                method: 'POST',
                url: '<?php echo base_url('change-password'); ?>',
                data: new FormData(this),
                contentType:false,
                cache : false,
                processData:false,
              })
              .done(function(data) {
                var out = jQuery.parseJSON(data);
                    
                    if (out.sts == '0') {
                        $('#notif_change_pw').html('<div class="alert alert-success alert-dismissible">'+out.msg+'</div>');
                        setTimeout(function(){$("#modalPassword").modal('hide'); window.location = host+'login/logout_user';},2000);
                    }else{
                        $('#notif_change_pw').html('<div class="alert alert-danger alert-dismissible">'+out.msg+'</div>');
                        setTimeout(function(){$("#modalPassword").modal('hide');},3000);
                    }
              })
              
              e.preventDefault();

            // }
        
      });


    $('#modalPassword').on('hidden.bs.modal', function(e) {
        $(this).find('#form-baru')[0].reset();
    });
</script>