<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('main/utama_link'); ?>
        <link href="<?=base_url('assets/plugins/iCheck/square/blue.css');?>" rel="stylesheet" type="text/css" />
        <link type="text/css" rel="Stylesheet" href="<?php echo CaptchaUrls::LayoutStylesheetUrl() ?>" />
        <script src="<?=base_url('assets/plugins/iCheck/icheck.min.js');?>" type="text/javascript"></script>
        <style media="screen">
           .select-style{height: 34px; border: 1px solid #d2d6de}
           .select-style select{height: 34px; width: 97%; border: none; box-shadow: none; background: transparent}
           .select-style select:focus {outline: none}
        }
        </style>
        
    </head>
    <body class="login-page" style="background: url(<?php echo base_url('files/images/bg-1.png') ?>) no-repeat center;">
        <div class="login-box">
            <div class="login-box-body dsw-border" style="padding-bottom:20px;border-top: 6px solid #3c8dbc; border-bottom: 10px solid #f39c12" >
                <div class="login-logo" style="margin-bottom:30px; border:none">
                    <img src="<?php echo base_url() ?>files/images/SmartAIPSmall.png"/></br>
                    <p style="font-size: 14px;margin-top: -20px">Akumulasi Iuran Pensiun</p>
                </div>
                    <!-- <p class="login-box-msg">Input Username & Password</p> -->
                    <?php
                        if ($this->session->flashdata('sukses')){ ?>
                            <div class="alert alert-danger alert-dismissible" id="notif_login">
                                <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                                <?php echo $this->session->flashdata('sukses'); ?>
                            </div>
                    <?php }  ?>
                    <form class="form-horizontal" autocomplete="off" id="form_sbn" method="POST" action="<?php echo base_url('login/login_user');?>">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" autocomplete="off" id="nmuser" class="form-control" name="nmuser" placeholder="" maxlength="30" required="required"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-unlock"></i>
                                    </div>
                                    <input type="password" autocomplete="off" id="pass" class="form-control" name="password" placeholder="" maxlength="255" required="required"/>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <select id="tahun" name="tahun" class="form-control select2nya" required="required">
                                        <?php
                                            $thn_skr = date('Y');
                                            // $thn_skr = 2020;
                                            for($x = $thn_skr; $x >= 2020; $x--){
                                            ?>  
                                            <option value="<?php echo $x?>"> <?php echo $x ?></option>
                                        <?php 
                                             }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-shield"></i>
                                    </div>
                                    <input type="text" class="form-control" name="CaptchaCode" id="CaptchaCode" value="" maxlength="6" placeholder="Captcha" required />
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <?php echo $captchaHtml; ?>
                        </div>

                        <div class="row">
                            <div class="col-xs-8">
                                <span class="infoLogin"></span>
                            </div>
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </body>
    <footer>
            <div class="small text-center">
            <a href="http://www.anggaran.kemenkeu.go.id">Copyright &copy; 2018 Kementerian Keuangan RI</a>
            </div>
    </footer>
    <script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$("#notif_login").fadeIn('slow');},400);});
            setTimeout(function(){$("#notif_login").fadeOut('slow');},2000);

            $(".select2nya").select2( { 'width':'100%' } );
    </script>
    <script>
        $(document).ready(function(){
            $("a[title ~= 'CI']").removeAttr("style");
            $("a[title ~= 'CI']").removeAttr("href");
            $("a[title ~= 'CI']").css('display', 'none');
            
            $("a[title ~= 'Speak']").removeAttr("style");
            $("a[title ~= 'Speak']").removeAttr("href");
            $("a[title ~= 'Speak']").css('display', 'none');

        });
        
        // $("#pass").focus(function(e){
        //     $(this).attr("type",'password');
        // }); 
    </script>

</html>
