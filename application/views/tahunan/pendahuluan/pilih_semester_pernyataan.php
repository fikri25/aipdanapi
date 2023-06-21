 <!-- Main content -->
 <div class="row">
 	<div class="col-md-12">
 		<div class="box box-default">
 			<div class="box-header with-border">
 				<h3 class="box-title"></h3>
 			</div>
 			<!-- /.box-header -->
 			<div class="box-body" style="">
 				<div class="col-md-6">
 					<div class="box box-primary box-solid">
 						<div class="box-header with-border">
 							<h3 class="box-title">Pilih Semester</h3>

 							<div class="box-tools pull-right">
 								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-times"></i>
 								</button>
 							</div>
 							<!-- /.box-tools -->
 						</div>
 						<!-- /.box-header -->
 						<div class="box-body">
 							<form action="<?php echo site_url('semesteran/pendahuluan/pernyataan_direksi')?>" method="post">
 								<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
 								<div class="box-body pad">
 									<div class="row"> 
 										<div class="col-md-12">
 											<div class="col-md-6">
 												<div class="form-group">
 													<label for="sel1">Semester</label>
 													<select class="form-control select2nya" id="semester" name="semester" onChange="this.form.submit()">
 														<option value="">
 															-- Pilih Semester --
 														</option>
 														<option value="1">Semester I</option>
 														<option value="2">Semester II</option>
 													</select>
 												</div>
 											</div>
 										</div>
 									</div>
 								</div>
 							</form>
 						</div>
 						<!-- /.box-body -->
 					</div>
 					<!-- /.box -->
 				</div>
 				<!-- /.col -->

 			</div>
 			<!-- /.box-body -->

 		</div>
 		<!-- /.box -->
 	</div>
 	<!-- /.col -->
 </div>
 <!-- row -->
 <script type="text/javascript">
 	$(".select2nya").select2( { 'width':'100%' } );
 </script>
