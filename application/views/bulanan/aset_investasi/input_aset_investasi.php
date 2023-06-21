<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>investasi-simpan/aset_investasi" enctype="multipart/form-data" >
	<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
	<input type="hidden" name="id" value="<?php echo !empty($data) ? $data['id'] : '';?>">
	<input type="hidden" name="jns_form" id="jns_form" value="<?php echo !empty($data) ? $data['jns_form'] : '';?>">
	<input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
	<input type="hidden" id="bulan" name="id_bulan" value="<?=!empty($id_bulan) ? $id_bulan['id_bulan'] : $this->session->userdata('id_bulan');?>">
	<?php if($editstatus == "edit"){ ?>
	<input type="hidden" name="id_investasi" value="<?php echo !empty($data) ? $data['id_investasi'] : '';?>">
	<?php } ?>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Form Aset Investasi</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis Investasi<font color="red">&nbsp;*</font></label>
										<select class="form-control combo-invest" id="id_investasi" name="id_investasi" required="required">
											<option value="">
												-- Pilih Jenis Investasi --
											</option>
											<?php if(isset($data_jenis) && is_array($data_jenis)){?>
												<?php foreach($data_jenis as $jenis){?>
													<option value="<?php echo $jenis->id_investasi;?>" <?php if(!empty($data) && $jenis->id_investasi == $data['id_investasi']) echo 'selected="selected"';?>>
														<?php echo $jenis->jenis_investasi;?>
													</option>
												<?php }?>
											<?php }?>
										</select>
										<label class="validation_error_message" for="id_investasi"></label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>RIT<font color="red">&nbsp;*</font></label>
										<input type="text" placeholder="RIT" class="form-control format_number" id="rka" name="rka" value="<?php echo !empty($data) ? $data['rka'] : '';?>" required="required">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Realisasi RIT (%)</label>
										<input type="text" placeholder="Realisasi RKA" class="form-control" id="realisasi_head" name="realisasi_rka" value="<?php echo !empty($data) ? $data['realisasi_rka'] : '';?>" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Saldo Awal</label>
										<input type="text" placeholder="Total Saldo Awal" class="form-control format_number" id="saldo_awal_head" name="saldo_awal_invest" value="<?php echo !empty($data) ? $data['saldo_awal_invest'] : '';?>" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Mutasi</label>
										<input type="text" placeholder="Total Mutasi" class="form-control format_number" id="mutasi_head" name="mutasi_invest" value="<?php echo !empty($data) ? $data['mutasi_invest'] : '';?>" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Saldo Akhir</label>
										<input type="text" placeholder="Total Saldo Akhir" class="form-control format_number" id="saldo_akhir_head" name="saldo_akhir_invest" value="<?php echo !empty($data) ? $data['saldo_akhir_invest'] : '';?>" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="keterangan" class="lebel">Unggah Dokumen</label>
										<input type="hidden" name="filedata_lama" value="<?php echo (isset($data['filedata']) ? $data['filedata'] : '');?>">
										<input type="file" name="filedata" class="form-control">
										<p style="margin-top:15px;"></p>
										<p style="font-size: 11px; font-style: italic;" class="peringatan"> * Dokumen harus bertipe pdf, doc atau docx</p>
									</div>
								</div>
								<?php if($editstatus == "edit" && $data['filedata'] != ""){?>
								<div class="col-md-2">
									<div class="form-group">
										<label for="keterangan" class="lebel"></label>
										<a href="<?php echo site_url('bulanan/aset_investasi/get_file_jenis/'.(isset($data['id']) ? $data['id'] : '').get_uri());?>" class="btn btn-sm btn-primary btn-flat" style="margin-top:27px;" title="Lihat Dokumen"><i class="fa fa-file-o"></i></a>
									</div>
								</div>
								<?php } ?>
							</div>

							<!-- FORM - 1 -->
							<div class="row form-1" id="form-1">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 1)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_1" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Cabang</th>
														<th rowspan="2">Return/Bunga</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="2">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_1" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Penanaman</th>
															<th>Pencairan</th>
														</tr>

													</tr>
												</thead>
												<tbody class="form_investasi_1 form_investasi_bln_lalu_1">
													<?php if($editstatus == "edit" && $data['jns_form'] == "1") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_1" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_1" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_<?=$idx;?>"  name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																	</td>
																	<td>
																		<select id="cabang_<?=$idx;?>"  name="cabang[]" class="form-control cabang select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($cabang) && is_array($cabang)):?>
																				<?php foreach($cabang as $cbg):?>
																					<option value="<?= $cbg['id'];?>" 
																						<?php if(!empty($detail) && $cbg['id'] == $detail['cabang']) echo 'selected="selected"';?> >
																						<?= $cbg['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>	
																	</td>
																	<td>
																		<input type="text" name="bunga[]" class="form-control bunga_1 percent" id="bunga_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['bunga'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_1 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penanaman[]" class="form-control jml_mutasi_penanaman_1 format_number" id="mutasi_penanaman_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penanaman'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pencairan[]" class="form-control jml_mutasi_pencairan_1 negative" id="mutasi_pencairan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pencairan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_1 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</fieldset>
								</div>
							</div>

							<!-- FORM - 2 -->
							<div class="row form-2" id="form-2">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 2)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_2" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Nama Keterangan</th>
														<th rowspan="2">Tgl Jatuh Tempo</th>
														<th rowspan="2">Rate</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="4">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_2" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan</th>
															<th>Diskonto/Premium</th>
															<th>Kenaikan/Penurunan Harga Pasar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_2 form_investasi_bln_lalu_2">
													<?php if($editstatus == "edit" && $data['jns_form'] == "2") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_2" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_1" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_"  name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_2" id="nama_reksadana_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nama_reksadana'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_2 tanggalnya" id="tgl_jatuh_tempo_<?=$idx;?>" idx="<?=$idx;?>" value="<?= tgl_format($detail['tgl_jatuh_tempo']);?>"/>		
																	</td>
																	<td>
																		<input type="text" name="r_kupon[]" class="form-control r_kupon_2 percent" id="r_kupon_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['r_kupon'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_2 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_2 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_2 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_2 negative" id="mutasi_amortisasi_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_amortisasi'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_2 negative" id="mutasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pasar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_2 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</fieldset>
								</div>
							</div>

							<!-- FORM - 3 -->
							<div class="row form-3" id="form-3">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 3)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_3" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Nilai Perolehan</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="3">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2">Lembar Saham</th>
														<th rowspan="2">Nilai Kapitalisasi Pasar</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_3" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan</th>
															<th>Kenaikan/Penurunan Harga Pasar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_3 form_investasi_bln_lalu_3">
													<?php if($editstatus == "edit" && $data['jns_form'] == "3") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_3" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_3" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_"  name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="nilai_perolehan[]" class="form-control nilai_perolehan_3 rupiah" id="nilai_perolehan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nilai_perolehan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_3 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_3 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_3 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_3 negative" id="mutasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pasar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_3 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>
																	<td>
																		<input type="text" name="lembar_saham[]" class="form-control jml_lembar_saham_3 format_number" id="lembar_saham_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['lembar_saham'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="nilai_kapitalisasi_pasar[]" class="form-control jml_nilai_kapitalisasi_pasar_3 format_number" id="nilai_kapitalisasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nilai_kapitalisasi_pasar'];?>"/>		
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>		
									</fieldset>
								</div>
							</div>

							<!-- FORM - 4 -->
							<div class="row form-4" id="form-4">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 4)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_4" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table id="example" class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<!-- <th rowspan="2">Manager Investasi</th> -->
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Nama Reksadana</th>
														<th rowspan="2">Nilai Perolehan</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="4">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2">Jumlah Unit</th>
														<th rowspan="2">Nilai Dana Kelolaan</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_4" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan</th>
															<th>Diskonto/Premium</th>
															<th>Kenaikan/Penurunan Harga Pasar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_4 form_investasi_bln_lalu_4">
													<?php if($editstatus == "edit" && $data['jns_form'] == "4") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_4" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_4" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<!-- <td>
																		<input type="text" name="manager_investasi[]" class="form-control manager_investasi_4" id="manager_investasi_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['manager_investasi'];?>"/>		
																	</td> -->
																	<td>
																		<select id="nama_pihak_"  name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_4" id="nama_reksadana_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nama_reksadana'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="nilai_perolehan[]" class="form-control nilai_perolehan_4 format_number" id="nilai_perolehan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nilai_perolehan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_4 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_4 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_4 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_diskonto[]" class="form-control jml_mutasi_diskonto_4 negative" id="mutasi_diskonto_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_diskonto'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_4 negative" id="mutasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pasar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_4 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>
																	<td>
																		<input type="text" name="jml_unit_penyertaan[]" class="form-control jml_unit_penyertaan_4 format_number" id="jml_unit_penyertaan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['jml_unit_penyertaan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="nilai_dana_kelolaan[]" class="form-control nilai_dana_kelolaan_4 format_number" id="nilai_dana_kelolaan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nilai_dana_kelolaan'];?>"/>		
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
												
									</fieldset>
								</div>
							</div>

							<!-- FORM - 5 -->
							<div class="row form-5" id="form-5">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 5)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_5" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="3">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2">Lembar Saham</th>
														<th rowspan="2">Harga Saham</th>
														<th rowspan="2">Persentase (%)</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_5" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan</th>
															<th>Kenaikan/Penurunan Harga Pasar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_5 form_investasi_bln_lalu_5">
													<?php if($editstatus == "edit" && $data['jns_form'] == "5") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_5" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_5" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_"  name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_5 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_5 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_5 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_5 negative" id="mutasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pasar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_5 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>
																	<td>
																		<input type="text" name="lembar_saham[]" class="form-control jml_lembar_saham_5 format_number" id="lembar_saham_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['lembar_saham'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="harga_saham[]" class="form-control harga_saham_5 rupiah" id="harga_saham_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['harga_saham'];?>" readonly/>		
																	</td>
																	<td>
																		<input type="text" name="persentase[]" class="form-control jml_persentase_5 percent" id="persentase_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['persentase'];?>"/>		
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>		
									</fieldset>
								</div>
							</div>

							<!-- FORM - 6 -->
							<div class="row form-6" id="form-6">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 6)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_6" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="3">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_6" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan</th>
															<th>Kenaikan/Penurunan Nilai Wajar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_6 form_investasi_bln_lalu_6">
													<?php if($editstatus == "edit" && $data['jns_form'] == "6") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_6" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_6" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_<?=$idx;?>"  name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_6 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_6 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_6 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_nilai_wajar[]" class="form-control jml_mutasi_nilai_wajar_6 negative" id="mutasi_nilai_wajar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_nilai_wajar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_6 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>		
									</fieldset>
								</div>
							</div>

							<!-- FORM - 7 -->
							<div class="row form-7" id="form-7">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 7)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_7" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Nama Keterangan</th>
														<th rowspan="2">Peringkat</th>
														<th rowspan="2">Tgl Jatuh Tempo</th>
														<th rowspan="2">Rate Kupon</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="4">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_7" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan/Jatuh Tempo</th>
															<th>Amortisasi</th>
															<th>Kenaikan/Penurunan Harga Pasar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_7 form_investasi_bln_lalu_7">
													<?php if($editstatus == "edit" && $data['jns_form'] == "7") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_7" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_7" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_<?=$idx;?>" name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_7 id="nama_reksadana_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nama_reksadana'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="peringkat[]" class="form-control peringkat_7" id="peringkat_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['peringkat'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_7 tanggalnya" id="tgl_jatuh_tempo_<?=$idx;?>" idx="<?=$idx;?>" value="<?= tgl_format($detail['tgl_jatuh_tempo']);?>"/>
																	</td>
																	<td>
																		<input type="text" name="r_kupon[]" class="form-control r_kupon_7 percent" id="r_kupon_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['r_kupon'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_7 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_7 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_7 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_7 negative" id="mutasi_amortisasi_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_amortisasi'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_7 negative" id="mutasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pasar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_7 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</fieldset>
								</div>
							</div>

							<!-- FORM - 8 -->
							<div class="row form-8" id="form-8">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 8)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_8" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Nama Keterangan</th>
														<th rowspan="2">Peringkat</th>
														<th rowspan="2">Tgl Jatuh Tempo</th>
														<th rowspan="2">Rate Kupon</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="4">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_7" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan/Jatuh Tempo</th>
															<th>Diskonto/Premium</th>
															<th>Kenaikan/Penurunan Harga Pasar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_8 form_investasi_bln_lalu_8">
													<?php if($editstatus == "edit" && $data['jns_form'] == "8") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_8" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_8" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_<?=$idx;?>" name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_8" id="nama_reksadana_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nama_reksadana'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="peringkat[]" class="form-control peringkat_8" id="peringkat_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['peringkat'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_8 tanggalnya" id="tgl_jatuh_tempo_<?=$idx;?>" idx="<?=$idx;?>" value="<?= tgl_format($detail['tgl_jatuh_tempo']);?>"/>	
																	</td>
																	<td>
																		<input type="text" name="r_kupon[]" class="form-control r_kupon_8 percent" id="r_kupon_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['r_kupon'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_8 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_8 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_8 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_diskonto[]" class="form-control jml_mutasi_diskonto_8 negative" id="mutasi_diskonto_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_diskonto'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_8 negative" id="mutasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pasar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_8 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</fieldset>
								</div>
							</div>

							<!-- FORM - 9 -->
							<div class="row form-9" id="form-9">
								<div class='col-md-12'>
									<br/>
									<fieldset class='form-group'>
										<legend style='font-size:16px;border-width: 2px;border-color: #2f87b7;'>Detail Investasi (Form - 9)</legend>
										<p>	  
											<a href="javascript:void(0);" id="bulan_lalu_form_8" class="btn btn-sm btn-primary btn-flat bulan_lalu_form"><i class="fa fa-plus"></i>&nbsp;&nbsp;Data Bulan Lalu</a>
										</p>
										<p style="font-size: 11px; font-style: italic; color: red" class="peringatan"> * Data bulan lalu hanya bisa di generate dari bulan Februari s/d Desember !</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover tbl-form" id="tbl-form" width="100%">
												<thead>
													<tr style='background-color:#3C8DBC;'>
														<th rowspan="2">No Urut</th>
														<th rowspan="2">Nama Pihak</th>
														<th rowspan="2">Nama Keterangan</th>
														<th rowspan="2">Peringkat</th>
														<th rowspan="2">Tgl Jatuh Tempo</th>
														<th rowspan="2">Rate Kupon</th>
														<th rowspan="2">Saldo Awal</th>
														<th colspan="3">Mutasi</th>
														<th rowspan="2">Saldo Akhir</th>
														<th rowspan="2" class='text-center' style='vertical-align:middle;' width='5%'>
															<a href="javascript:void(0);" id="tambah_detail_8" class="btn btn-success btn-sm tambah_detail"><i class="fa fa-plus"></i></a>
														</th>
														<tr>
															<th>Pembelian</th>
															<th>Penjualan/Jatuh Tempo</th>
															<th>Kenaikan/Penurunan Harga Pasar</th>
														</tr>
														
													</tr>
												</thead>
												<tbody class="form_investasi_9 form_investasi_bln_lalu_9">
													<?php if($editstatus == "edit" && $data['jns_form'] == "9") :?>
														<?php if(isset($data_detail) && is_array($data_detail)):?>
															<?php $idx=1;?>
															<?php foreach($data_detail as  $detail):?>
																<tr class="form_9" id="tr_inv_<?=$idx;?>" idx="<?=$idx;?>">
																	<td>
																		<input type="text" size="2" name="no_urut[]" class="form-control no_urut_9" id="no_urut_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['no_urut'];?>"/>	
																	</td>
																	<td>
																		<select id="nama_pihak_<?=$idx;?>" name="nama_pihak[]" class="form-control nama_pihak select2nya">
																			<option value="">-- Pilih --</option>
																			<?php if(isset($combo) && is_array($combo)):?>
																				<?php foreach($combo as $combo_pihak):?>
																					<option value="<?= $combo_pihak['id'];?>" 
																						<?php if(!empty($detail) && $combo_pihak['id'] == $detail['kode_pihak']) echo 'selected="selected"';?> >
																						<?= $combo_pihak['txt'];?>
																					</option>
																				<?php endforeach;?>
																			<?php endif;?>

																		</select>
																			
																	</td>
																	<td>
																		<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_8" id="nama_reksadana_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['nama_reksadana'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="peringkat[]" class="form-control peringkat_9" id="peringkat_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['peringkat'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_9 tanggalnya" id="tgl_jatuh_tempo_<?=$idx;?>" idx="<?=$idx;?>" value="<?= tgl_format($detail['tgl_jatuh_tempo']);?>"/>		
																	</td>
																	<td>
																		<input type="text" name="r_kupon[]" class="form-control r_kupon_9 percent" id="r_kupon_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['r_kupon'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_awal[]" class="form-control saldo_awal_9 negative" id="saldo_awal_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_awal'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_9 format_number" id="mutasi_pembelian_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pembelian'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_9 negative" id="mutasi_penjualan_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_penjualan'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_9 negative" id="mutasi_pasar_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['mutasi_pasar'];?>"/>		
																	</td>
																	<td>
																		<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_9 format_number" id="saldo_akhir_<?=$idx;?>" idx="<?=$idx;?>" value="<?= $detail['saldo_akhir'];?>" readonly/>
																	</td>

																	<td class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="$(this).closest('tr').first().remove();"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php $idx++;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</fieldset>
								</div>
							</div>

							<!-- KETERANGAN -->
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Keterangan</label>
										<textarea name="keterangan" placeholder="Keterangan" class="form-control"><?php echo (isset($data['keterangan']) ? $data['keterangan'] : '');?></textarea>
									</div>
								</div>
							</div>
			
							<hr />
							<div class="row">
								<div class="col-md-12">
									<button href="javascript:void(0);" id="save" class="btn btn-primary btn-flat" type="submit">
										Simpan
									</button>	
									<a href="<?php echo site_url('bulanan/aset_investasi').get_uri();?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
								</div>
							</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</form>

<script type="text/javascript">
	var rulesnya = "";
	var messagesnya = "";
	var idx_row = 1;
	var sts ='<?= !empty($editstatus) ? $editstatus: ''?>';
	var data_pihak ='<?= !empty($data) ? $data['id_investasi'] : ''?>';
	var idusr ='<?= $this->session->userdata('iduser'); ?>';
	// $('.peringatan').css('display','none');
	
	$(".no_urut").validatebox({
		required:true
	});

	$(document).ready(function(){
		$('.format_number').number(true, 0, ',', '.');
		$('.rupiah').number(true,0);
		// $('.format_number').number(true, 0);
		$(".select2nya, .combo-invest").select2( { 'width':'100%' } );

		
		
		new AutoNumeric.multiple('.negative', {
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			decimalPlaces: 0,
			negativeSignCharacter: "-",
			maximumValue:99999999999999999999,
			minimumValue:-99999999999999999999
		});

		new AutoNumeric.multiple('.percent', {
			alwaysAllowDecimalCharacter: true,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			suffixText: "%",
			decimalPlacesShownOnFocus: 2,
			unformatOnSubmit: true
		});

		$('.tanggalnya').datepicker({ 
			format: 'dd-mm-yyyy',
			todayHighlight:'TRUE',
			autoclose: true,
		});

		// new AutoNumeric.multiple('.number_test',{
		// 	allowDecimalPadding: false,
		// 	caretPositionOnFocus: "start",
		// 	decimalCharacter: ",",
		// 	decimalPlaces: 0,
		// 	decimalPlacesShownOnBlur: 0,
		// 	decimalPlacesShownOnFocus: 0,
		// 	digitGroupSeparator: ".",
		// 	eventBubbles: false,
		// 	maximumValue: "100000000000000000000",
		// 	minimumValue: "-100000000000000000000",
		// 	negativeBracketsTypeOnBlur: "(,)",
		// 	negativeSignCharacter: "−"
		// });



		// $("#rka").keyup(function(){
		// 	var rka = parseFloat($("#rka").val().replace(/\./g,''));
		// 	console.log(rka);
		// });


		// new AutoNumeric.multiple('.rupiah', {
		// 	alwaysAllowDecimalCharacter: true,
		// 	decimalCharacter: ".",
		// 	digitGroupSeparator: ",",
		// 	currencySymbol: "Rp",
		// 	decimalPlacesShownOnFocus: 2,
		// 	unformatOnSubmit: true
		// });


		// new AutoNumeric('.autoPercent', {
		// 	alwaysAllowDecimalCharacter: true,
		// 	decimalCharacter: ",",
		// 	digitGroupSeparator: ".",
		// 	suffixText: "%",
		// 	decimalPlacesShownOnFocus: 2,
		// 	unformatOnSubmit: true
		// }
		// );
		
		



		// $('.negative').keyup(function(){
		// 	let v = $(this).val();
		// 	const neg = v.startsWith('-');

		// 	v = v.replace(/[-\D]/g,'');

		// 	v = v != ''?''+v:'';
		// 	if(neg) v = '-'.concat(v);

		// 	$(this).val(v);
		// });


		// currency minus

		// $('.format_number').on('keyup',function(){
		// 	var customCurrency = value => currency(value, { pattern: '!#', negativePattern: '(!#)', separator: ".", precision: 0});
		// 	// customCurrency(1234567.89).format();  // => "$ 1,234,567.89"
		// 	let v = customCurrency($(this).val()).format(); // => "($ 1,234,567.89)"
		// 	$('#rka').val(v);
		// });


		$('.tbl-form').DataTable({
			"paging":false,
			"searching": false,
			"ordering": false,
			"lengthChange": false,
			"info": false,
		});

		$('.form-2,.form-3,.form-4,.form-5,.form-6,.form-7,.form-8,.form-9').css('display','none');
		// get data bulan lalu
		$('.bulan_lalu_form').on('click', function(){
			var form = $('#jns_form').val();
			if($('#id_investasi').val() == ""){
				$.messager.alert('SMART AIP','Pilih Jenis Investasi Terlebih Dahulu!','warning'); 
				return false;
			}
			if($('#rka').val() == "" || $('#rka').val() == '0'){
				$.messager.alert('SMART AIP','Input RKA/RIT Terlebih Dahulu!','warning'); 
				return false;
			}
			if($('#bulan').val() == 1){
				$.messager.alert('SMART AIP','Tidak bisa generate data bulan Januari !','warning'); 
				return false;
			}

			$.LoadingOverlay("show");
			$.post(host+'investasi-display/data_bulan_lalu_form'+uri, { 'jns_form':form, 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp){

				parsing_bln_lalu = JSON.parse(resp)
				if(parsing_bln_lalu.length == '0'){
					$.messager.alert('SMART AIP','Data bulan lalu tidak ditemukan !','warning'); 
					$.LoadingOverlay("hide", true);
					return false;

				}

				console.log(parsing_bln_lalu);

				$('.dataTables_empty').remove();
				if(form == 1){
					$('.form_1').remove();
					tambah_row('form_investasi_bln_lalu_1', resp);
				}
				if(form == 2){
					$('.form_2').remove();
					tambah_row('form_investasi_bln_lalu_2', resp);
				}
				if(form == 3){
					$('.form_3').remove();
					tambah_row('form_investasi_bln_lalu_3', resp);
				}
				if(form == 4){
					$('.form_4').remove();
					tambah_row('form_investasi_bln_lalu_4', resp);
				}
				if(form == 5){
					$('.form_5').remove();
					tambah_row('form_investasi_bln_lalu_5', resp);
				}
				if(form == 6){
					$('.form_6').remove();
					tambah_row('form_investasi_bln_lalu_6', resp);
				}
				if(form == 7){
					$('.form_7').remove();
					tambah_row('form_investasi_bln_lalu_7', resp);
				}
				if(form == 8){
					$('.form_8').remove();
					tambah_row('form_investasi_bln_lalu_8', resp);
				}
				if(form == 9){
					$('.form_9').remove();
					tambah_row('form_investasi_bln_lalu_9', resp);
				}
				$.LoadingOverlay("hide", true);
			});

		});


	});



	// add new row
	$('.tambah_detail').on('click', function(){
		if($('#id_investasi').val() == ""){
			$.messager.alert('SMART AIP','Pilih Jenis Investasi Terlebih Dahulu!','warning'); 
			return false;
		}else if($('#rka').val() == ""){
			$.messager.alert('SMART AIP','Input RKA/RIT Terlebih Dahulu!','warning'); 
			return false;
		}else{
			parsing = parsing_form;
			var form = "";
			if(parsing.jns_form == 1) {
				var form = "form_investasi_1";
				
			}
			if(parsing.jns_form == 2){
				var form = "form_investasi_2";
			}
			if(parsing.jns_form == 3){
				var form = "form_investasi_3";
			}
			if(parsing.jns_form == 4){
				var form = "form_investasi_4";
			}
			if(parsing.jns_form == 5){
				var form = "form_investasi_5";
			}
			if(parsing.jns_form == 6){
				var form = "form_investasi_6";
			}
			if(parsing.jns_form == 7){
				var form = "form_investasi_7";
			}
			if(parsing.jns_form == 8){
				var form = "form_investasi_8";
			}
			if(parsing.jns_form == 9){
				var form = "form_investasi_9";
			}

			$('.dataTables_empty').remove();
			tambah_row(form);
		}
		
	});

	// add new row old
	// $('#tambah_detail_1').on('click', function(){
	// 	if($('#id_investasi').val() == ""){
	// 		$.messager.alert('SMART AIP','Pilih Jenis Investasi Terlebih Dahulu!','warning'); 
	// 		return false;
	// 	}else{
	// 		$('.dataTables_empty').remove();
	// 		tambah_row('form_investasi_1');
	// 	}
		
	// });


	// get combo nama pihak
	$('#id_investasi').on('change', function(){
		$('.tr_inv').remove();
		$.post(host+'investasi-display/cek_aset_investasi'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp){
			if(resp){
				parsing = JSON.parse(resp);
				if(parsing.total == '0'){
					$.post(host+'investasi-display/data_pihak'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp1){
						if(resp1){
							data_pihak = resp1;
							// console.log(data_pihak);
						}
					});
					// data cabang
					$.post(host+'investasi-display/cabang'+uri, {[csrf_token]:csrf_hash }, function(resp){
						if(resp){
							cabang = resp;
							// console.log(cabang);
						}
					});
					// ambil data rka bulan lalu
					$.post(host+'investasi-display/data_bulan_lalu_hasilinvest'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp1){

						parsing_bln_lalu = JSON.parse(resp1)
						if(parsing_bln_lalu == "" || parsing_bln_lalu == null ){
							$('#rka').val("");
						}else{
							$('#rka').val(parsing_bln_lalu.rka);
						}

						console.log(parsing_bln_lalu);

					});
					// if(parsing.jns_form == "4"){
					// 	$.post(host+'investasi-display/sub_reksadana'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp2){
					// 		if(resp2){
					// 			sub_reksadana = resp2;
					// 			// console.log(sub_reksadana);
					// 		}
					// 	});
					// }
				}else{
					if(sts == "edit"){
						$.post(host+'investasi-display/data_pihak'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp1){
							if(resp1){
								data_pihak = resp1;
								// console.log(data_pihak);
							}
						});

						// data cabang
						$.post(host+'investasi-display/cabang'+uri, {[csrf_token]:csrf_hash }, function(resp){
							if(resp){
								cabang = resp;
								// console.log(cabang);
							}
						});
					}else{
						$.messager.alert('SMART AIP','Anda sudah input data '+parsing.jenis_investasi+' !','warning');
						return false;
					}
				}
			}
		});

		$.post(host+'investasi-display/form_invest'+uri, { 'jns_investasi':$('#id_investasi').val(), [csrf_token]:csrf_hash }, function(resp){
			if(resp){
				parsing_form = JSON.parse(resp);
				console.log(parsing_form);
				$('#jns_form').val(parsing_form.jns_form);
				if(parsing_form.jns_form == 1) {
					$('.form-1').css('display','block');
					$('.form-2,.form-3,.form-4,.form-5,.form-6,.form-7,.form-8,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 2){
					$('.form-2').css('display','block');
					$('.form-1,.form-3,.form-4,.form-5,.form-6,.form-7,.form-8,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 3){
					$('.form-3').css('display','block');
					$('.form-1,.form-2,.form-4,.form-5,.form-6,.form-7,.form-8,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 4){
					$('.form-4').css('display','block');
					$('.form-1,.form-2,.form-3,.form-5,.form-6,.form-7,.form-8,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 5){
					$('.form-5').css('display','block');
					$('.form-1,.form-2,.form-4,.form-3,.form-6,.form-7,.form-8,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 6){
					$('.form-6').css('display','block');
					$('.form-1,.form-2,.form-4,.form-3,.form-5,.form-7,.form-8,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 7){
					$('.form-7').css('display','block');
					$('.form-1,.form-2,.form-4,.form-3,.form-5,.form-6,.form-8,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 8){
					$('.form-8').css('display','block');
					$('.form-1,.form-2,.form-4,.form-3,.form-5,.form-6,.form-7,.form-9').css('display','none');
				}else if(parsing_form.jns_form == 9){
					$('.form-9').css('display','block');
					$('.form-1,.form-2,.form-4,.form-3,.form-5,.form-6,.form-7,.form-8').css('display','none');
				}else{
					$.messager.alert('SMART AIP','Form Input '+parsing_form.jenis_investasi+' belum tersedia !','warning');
					return false;
				}
			}
		});
	});


	// edit
	if(sts == "edit"){
		$( document ).ready(function() {
			$('#id_investasi').val(data_pihak).trigger('change');
			$(".combo-invest").select2({'disabled': true,});
			// fungsi calculate
			$(".form_1").on("keyup", function(){
				calculateInvestasiForm1();
			});
			$(".form_2").on("keyup", function(){
				calculateInvestasiForm2();
			});
			$(".form_3").on("keyup", function(){
				calculateInvestasiForm3();
			});
			$(".form_4").on("keyup", function(){
				calculateInvestasiForm4();
			});
			$(".form_5").on("keyup", function(){
				calculateInvestasiForm5();
			});
			$(".form_6").on("keyup", function(){
				calculateInvestasiForm6();
			});
			$(".form_7").on("keyup", function(){
				calculateInvestasiForm7();
			});
			$(".form_8").on("keyup", function(){
				calculateInvestasiForm8();
			});
			$(".form_9").on("keyup", function(){
				calculateInvestasiForm9();
			});

			var form = $('#jns_form').val();
			
			if(form == '1'){
				calculateInvestasiForm1();
			}
			if(form == '2'){
				calculateInvestasiForm2();
			}
			if(form == '3'){
				calculateInvestasiForm3();
			}
			if(form == '4'){
				calculateInvestasiForm4();
			}
			if(form == '5'){
				calculateInvestasiForm5();
			}
			if(form == '6'){
				calculateInvestasiForm6();
			}
			if(form == '7'){
				calculateInvestasiForm7();
			}
			if(form == '8'){
				calculateInvestasiForm8();
			}
			if(form == '9'){
				calculateInvestasiForm9();
			}


		});
	}

	

	var rulesnya = {
		id_investasi : "required",
		rka : "required",
		"nama_pihak[]": "required",
		"cabang[]": "required",
		"saldo_awal[]": "required",
		"mutasi_penanaman[]": "required",
		"mutasi_pencairan[]": "required",

		"mutasi_pembelian[]": "required",
		"mutasi_penjualan[]": "required",
		"mutasi_amortisasi[]": "required",
		"mutasi_pasar[]": "required",
		"mutasi_nilai_wajar[]": "required",

		"lembar_saham[]": "required",
		"mutasi_diskonto[]": "required",

	};

	var messagesnya = {
		id_investasi : "<i style='color:red'>Harus Diisi</i>",
		rka : "<i style='color:red'>Harus Diisi</i>",
		"nama_pihak[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"cabang[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"saldo_awal[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"mutasi_penanaman[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"mutasi_pencairan[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",

		"mutasi_pembelian[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"mutasi_penjualan[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"mutasi_amortisasi[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"mutasi_pasar[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"mutasi_nilai_wajar[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",

		"lembar_saham[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",
		"mutasi_diskonto[]" : "<i style='color:red; font-size: 8pt' >Tidak Boleh Kosong</i>",

	}

	$( "#form_<?=$acak;?>" ).validate( {
		rules: rulesnya,
		messages: messagesnya,
		submitHandler: function(form) {
			$.LoadingOverlay("show");
			submit_form('form_<?=$acak;?>',function(r){
				if(r==1){ 
					$.messager.alert('SMART AIP','Data Tersimpan','info'); 
					$('#cancel').trigger('click');
					
					var id_investasi = $('#id_investasi').val();
					var jns_form= $('#jns_form').val();
					var bulan= $('#bulan').val();
					$.post(host+'investasi-display/cek_id'+uri, { 'id_investasi':id_investasi, 'jns_form':jns_form, 'id_bulan':bulan, 'iduser':idusr, [csrf_token]:csrf_hash }, function(resp){
						if (resp) {
							parsing = JSON.parse(resp);
							genform('edit', 'aset_investasi','aset_investasi','',parsing.id, parsing.jns_form);
						}
					});
				}else{ 
					$.messager.alert('SMART AIP','Proses Simpan Data Gagal '+r,'warning'); 
				}
				$.LoadingOverlay("hide", true);
			});
		
		},
		errorPlacement: function(error, element) {
	        var name = element.attr('name');
	        var errorSelector = '.validation_error_message[for="' + name + '"]';
	        var $element = $(errorSelector);
	        if ($element.length) { 
	            $(errorSelector).html(error.html());
	        } else {
	            error.insertAfter(element);
	        }
	    }
	} );


</script>