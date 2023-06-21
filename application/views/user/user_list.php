 <!-- Main content -->
 <div class="row">
 	<div class="col-md-12">
 		<div class="box box-default">
 			<div class="box-header with-border">
 				<h3 class="box-title"><b>User List</b></h3>
 			</div>
 			<!-- /.box-header -->
 			<div class="box-body">
 				<a href="<?php echo site_url('user/create_user');?>" data-target="#modal_user" data-toggle="modal" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah</a>

 				<table class="table table-hover" id="tbl_user">
 					<thead>
 						<tr>
 							<th width="5%">No</th>
 							<th>Nama Lengkap</th>
 							<th>Group</th>
 							<th width="10%">Aksi</th>
 						</tr>
 					</thead>
 					<tbody>
 						<?php $i = 1; ?>
 						<?php foreach ($user_list as $usr) : ?>
 							<tr>
 								<td style="text-align: center;"><?= $i; ?></td>
 								<td style="text-align: left;"><?= $usr['nmuser']; ?></td>
 								<td style="text-align: left;"><?= $usr['nmusergroup']; ?></td>
 								<td style="text-align: center;">
 									<a href="<?php echo site_url('user/edit_user').'/'.$usr['iduser'];?>" data-target="#modal_user" data-toggle="modal" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></a>
 									&nbsp;
 									<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-flat hapus_user" data-id="<?php echo $usr['iduser']; ?>" title="Hapus"><i class="fa fa-trash"></i></a>
 								</td>
 							</tr>
 							<?php $i++; ?>
 						<?php endforeach; ?>
 					</tbody>
 				</table>

 			</div>
 			<!-- /.box-body -->
 			<div id="modal_user" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
 				<!-- content modal -->
 				<div class="modal-dialog">
 					<div class="modal-content">

 					</div>
 				</div>
 			</div>

 		</div>
 		<!-- /.box -->
 	</div>
 	<!-- /.col -->
 </div>
 <!-- row -->

<script type="text/javascript">
	$(document).ready(function() {
		$('#tbl_user').DataTable({
			"paging": false,
			"lengthChange": false,
			"searching": false,
			"ordering": false,
			"pageLength": 10,
		});

		$('#modal_user').on('hidden.bs.modal',function(e){
			$('#modal_user').removeData();
		});

	});

	$('#tbl_user').on('click', 'a.hapus_user', function (e) {
    	var iduser = {};
    	iduser = $(this).attr('data-id');
    	$.messager.confirm('SMART AIP','Anda Yakin Ingin Menghapus Data Ini ?',function(re){
    		if(re){
    			$.LoadingOverlay("show");
    			$.post('<?php echo base_url() ?>user/hapus_user', { where: { iduser }, [csrf_token]:csrf_hash }, res =>{
    				if(res == 1){
    					$.LoadingOverlay("hide", true);
    					$.messager.alert('SMART AIP',"Data Terhapus",'info');
    					setTimeout(function(){
    						window.location.href="<?php echo base_url('user'); ?>";	
    					}, 1000);
    				}else{
    					$.LoadingOverlay("hide", true);
    					$.messager.alert('SMART AIP',"Gagal Menghapus Data",'error');
    				}
    			});	
    		}
    	});	
    });

	function konversi_pwd_text(){
		if($('input#pass')[0].type=="password")$('input#pass')[0].type = 'text';
		else $('input#pass')[0].type = 'password';
    }

    
</script>

