 <!-- Main content -->
 <div class="row">
 	<div class="col-md-12">
 		<div class="box box-default">
 			<div class="box-header with-border">
 				  <h3 class="box-title">User Group</h3>
 			</div>
 			<!-- /.box-header -->
 			<div class="box-body">
 				<a href="<?php echo base_url('user/create_group');?>" data-target="#modal_group" data-toggle="modal" class="btn btn-sm btn-primary btn-flat"  style="margin-bottom: 0px;"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah</a>
 				
 				<table id="tbl_group" class="table table-responsive table-bordered table-hover">
 					<thead>
 						<tr>
 							<th width="5%">#</th>
 							<th>User Group</th>
 							<th width="20%">Aksi</th>
 						</tr>
 					</thead>
 					<tbody>
 						<?php $i = 1; ?>
 						<?php foreach ($role as $r) : ?>
 							<tr>
 								<td style="text-align: center"><?= $i; ?></td>
 								<td style="text-align: left"><?= $r['nmusergroup']; ?></td>
 								<td style="text-align: center">
 									<a href="<?= base_url('role-app/').$r['idusergroup']; ?>" class="btn btn-primary btn-sm btn-flat" title="Hak Akses"><i class="fa fa-gear"></i>&nbsp;&nbsp;Hak Akses</a>
 									&nbsp;&nbsp;
									<a href="<?php echo base_url('user/edit_group').'/'.$r['idusergroup'];?>" data-target="#modal_group" data-toggle="modal" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></a>
											&nbsp;&nbsp;
									<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-flat hapus_group" data-id="<?php echo $r['idusergroup']; ?>" title="Hapus"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
						<?php $i++; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
 			</div>
 			<!-- /.box-body -->
 			<!-- /.box-body -->
 			<div id="modal_group" class="modal fade" data-refresh="true" class="modal fade" tabindex="-1" role="dialog">
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
 		$('#tbl_group').DataTable({
 			"paging":false,
 			"searching": false,
 			"ordering": false,
 			"lengthChange": false,
 			"info": false,
 		});

 		$('#modal_group').on('hidden.bs.modal',function(e){
 			$('#modal_group').removeData();
 		});

 	});

 	$('#tbl_group').on('click', 'a.hapus_group', function (e) {
 		var idusergroup = {};
 		idusergroup = $(this).attr('data-id');
 		$.messager.confirm('SMART AIP','Anda Yakin Ingin Menghapus Data Ini ?',function(re){
 			if(re){
 				$.LoadingOverlay("show");
 				$.post('<?php echo base_url() ?>user/hapus_group', { where: { idusergroup }, [csrf_token]:csrf_hash }, res =>{
 					if(res == 1){
 						$.LoadingOverlay("hide", true);
 						$.messager.alert('SMART AIP',"Data Terhapus",'info');
 						setTimeout(function(){
 							window.location.href="<?php echo base_url('user/role_setting'); ?>";	
 						}, 1000);
 					}else{
 						$.LoadingOverlay("hide", true);
 						$.messager.alert('SMART AIP',"Gagal Menghapus Data",'error');
 					}
 				});	
 			}
 		});	
 	});

</script>

