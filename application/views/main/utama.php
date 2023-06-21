<!DOCTYPE html>
<html>
<head><?php $this->load->view('main/utama_link'); ?></head>
<!-- <?php $side=''; if ( $this->session->userdata('kdusergroup')=='999' ) $side='sidebar-collapse'; ?> -->
<body class="skin-blue fixed sidebar-mini <?php //echo $side ?>">
    <style>
		.table td{
			border: 1px solid #b8b8b8 !important;
			text-align: right;
		}
		.table th {
		border: 1px solid #b8b8b8 !important;
		background-color: #4f7184 !important;
		color: #fff !important;
		text-align: center;
		}
		.foot{
			background-color: #f8f8f8 !important;
			text-align: center;
			font-weight:bold;
		}
		.skin-blue .sidebar-menu > li.header {
		  color: #9fa6aa;
		  background: #434d53;
		}

		td.dataTables_empty{
			text-align: center;
		}
		/*.odd*/

		<?php
			$iduser= $this->session->userdata('idusergroup');
			if($iduser == "1"){
				echo '
					.user{
						display: none;
					}
				';
				echo '
					.user-bln{
						display: none;
						pointer-events:none;
					}
				';
			}

			if($iduser == "2" || $iduser == "3" ){
				echo '
					.adm{
						display: none;
					}
				';
				
				$sts_bln=pendahuluan_bln();
				if ($sts_bln['status'] == 'Selesai'){
					echo '
					.user-bln{
						pointer-events:none;
						opacity: 0.6 !important;
					}
					';
				}


				$sts_smt1=pendahuluan_smt('1');
				if ($sts_smt1['status'] == 'Selesai'){
					echo '
					.user-smt1{
						pointer-events:none;
						opacity: 0.6 !important;
					}
					';
				}


				$sts_smt2=pendahuluan_smt('2');
				if ($sts_smt2['status'] == 'Selesai'){
					echo '
					.user-smt2{
						pointer-events:none;
						opacity: 0.6 !important;
					}
					';
				}
				
// 				print_r($sts_bln['status']);exit();
			}



		?>
	</style>
	<div class="wrapper">
        <?php $this->load->view('main/utama_topmenu'); ?>
        <?php $this->load->view('main/utama_sidebar'); ?>
		
        <div class="content-wrapper">
            <section class="content-header">
            <h1><?php echo $bread['header'] ?></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><?php echo $bread['subheader'] ?></li>
            </ol>
            </section>

            <section class="content">
                <?php $this->load->view( $view ); ?>
            </section>
        </div>

        <footer class="main-footer"><!-- 
            <div class="pull-right hidden-xs small">
                <p></p>
            </div> -->
            <div class="small">
            <a href="http://www.anggaran.kemenkeu.go.id">Copyright &copy; 2018 Kementerian Keuangan RI</a>
            </div>
        </footer>
    </div>
	<!-- Modal Popup untuk delete--> 
	<div id="modal_delete" class="modal fade modal-info" data-refresh="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content" style="margin-top:100px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p class="modal-title" style="text-align:center;font-size:15px;">Apakah anda yakin ingin menghapus data ini ?</p>
				</div>
				<div class="modal-footer" style="margin:0px; border-top:px; text-align:right;">
					<a href="#" class="btn btn-outline btn-sm btn-flat" id="delete_link">Hapus</a>
					<button type="button" class="btn btn-outline btn-sm btn-flat" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>	
	<!--end modal-->
	<!-- Modal -->
	<!-- <div style='overflow:hidden;' class="modal fade" id="pesanModal" role="dialog" data-refresh="true" aria-hidden="true"> -->
	<div style='' class="modal fade" id="pesanModal" role="dialog" data-refresh="true" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<span id="headernya"></span>
					<button id='button_close' type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div id='modalidnya' class="modal-product">
					</div> <!-- .modal-product -->
				</div> <!-- .modal-body -->
			</div> <!-- .modal-content -->
		</div> <!-- .modal-dialog -->
	</div>
	<!-- END Modal -->
</body>
</html>
