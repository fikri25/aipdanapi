 <!-- Main content -->
 <div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Role Setting - <?= $role['nmusergroup']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <input type="hidden" id="role_id" name="role_id" value="<?= $role['idusergroup'] ?>">
                <a href="<?php echo base_url()?>user/role_setting" class="btn btn-primary btn-sm" style="margin-bottom: 0px;"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Kembali</a>

                <a class="btn btn-info btn-sm" id="simpan_role" style="float:right;"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</a>
                <a class="btn btn-success btn-sm" style="float:right;margin-right:5px;" id="selectall"><i class="fa fa-check"></i>&nbsp;&nbsp;Select All</a>
                <a class="btn btn-danger btn-sm" style="float:right;margin-right:5px;" id="unselectall"><i class="fa fa-times"></i>&nbsp;&nbsp;UnSelect All</a>

                <table id="tbl-user" class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr style='background-color:#3C8DBC;'>
                            <th width="5%">#</th>
                            <th>Menu</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($menu_acc as $m) : ?>
                            <tr style="font-weight: bold;">
                                <td style="text-align: center;"><?= $i; ?></td>
                                <td style="text-align: left;"><?= $m['parent']; ?></td>
                                <td style="text-align: center">
                                    <div class="form-check">
                                        <input class="form-check-input cek" type="checkbox" <?= check_access($role['idusergroup'], $m['id']); ?> data-role="<?= $role['idusergroup']; ?>" data-menu="<?= $m['id']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php if($m['type_menu'] == "PC"){ ?>
                                <?php foreach ($m['child'] as $ch) : ?>
                                    <tr>
                                        <td></td>
                                        <td style="padding-left:40px;text-align: left"><?= $ch['menu']; ?></td>
                                        <td style="text-align: center">
                                            <div class="form-check">
                                                <input class="form-check-input cek" type="checkbox" <?= check_access($role['idusergroup'], $ch['id']); ?> data-role="<?= $role['idusergroup']; ?>" data-menu="<?= $ch['id']; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php } ?>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- row -->
<script type="text/javascript">
    $('#tbl-user').DataTable({
        "paging":false,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
        "info": false,
    });

    $('#selectall').on('click',function(e){
        $(".cek").attr('checked', true );
    });

    $('#unselectall').on('click',function(e){
        $(".cek").attr('checked', false );
    });

    $('#simpan_role').on('click',function(e){
        var role_id = $('#role_id').val();
        var pilih={};
        $('.cek:checkbox:checked').each(function(i) { 
            pilih[i]=$(this).attr("data-menu");
            
        });

        $.LoadingOverlay("show"); 
        $.ajax({
            url: "<?= base_url('user/simpan_datarole'); ?>",
            type: 'post',
            data: {
                menuId: pilih,
                roleId: role_id,
                [csrf_token]:csrf_hash
            },
            success: function(res) {
                $.LoadingOverlay("hide", true);
                if (res == 1) {
                    $.messager.alert('SMART AIP','Data Tersimpan','info');
                    $('#cancel').trigger('click');
                    setTimeout(function(){
                        document.location.href = "<?= base_url('role-app/'); ?>" + role_id;
                    }, 1000);
                   
                } 
                else {
                    $.messager.alert('SMART AIP','Proses Simpan Data Gagal ','warning'); 
                }
            }
        });
        
    });



</script>
