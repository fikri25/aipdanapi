<!-- Main content -->
<?php $tahun = $this->session->userdata("tahun");?>
<?php $level = $this->session->userdata('level');?>
<div class="row">
	<div class="col-xs-12">
		<div class="nav-tabs-custom">
			<?php $this->load->view('main/nav_tab_view'); ?>
			<div class="box box-default">
                <div class="box-header with-border">
                  <p class="box-title pull-right" style="margin-right:40px"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo (isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '').' - '. $tahun;?></p>
                </div>
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
                                    <a href="javascript:void(0)" title="Add" class="btn btn-primary btn-sm btn-flat" onClick="gensearch('index-rincian','index-rincian');">
                                        <i class="fa fa-search"></i>
                                    </a> 
                                </div>
                            </div>
                            <div  class="col-md-8"> 
                                <div class="form-group pull-right">
                                    <a href="#" data-target="#Modal_ket1" data-toggle="modal" class="btn btn-sm btn-warning btn-flat user-bln" title="Keterangan"><i class="fa fa-info-circle"></i> Keterangan
                                    </a>
                                    &nbsp;&nbsp;
                                   <!--  <a href="<?php echo site_url('bulanan/rincian/laporan_Rincian_PDF').get_uri();?>" target="blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF
                                    </a> -->
                                    <a href="javascript:void(0)" title="Add" class="btn btn-danger btn-sm btn-flat" onClick="genform('print-all', 'rincian_cetak','rincian_cetak');">
                                        <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Cetak PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($this->session->flashdata('form_true')){?>
                        <div id="notif">               
                            <?php echo $this->session->flashdata('form_true');?>               
                        </div>
                    <?php } ?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#rincian_investasi_pihak">Rincian Aset Investasi</a></li>
                        <li><a data-toggle="tab" href="#rincian_bukan_investasi">Rincian Aset Bukan Investasi</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="rincian_investasi_pihak" class="tab-pane fade in active">
                            <div class="box-body" style="overflow-x:auto;">
                                <p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
                                    Rincian Aset Investasi Per Pihak
                                </p>
                                <table id="tab_rincian_invest1" class="table table-responsive table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="width:3%;">No.</th>
                                            <th rowspan="2" width="20%">Nama Pihak</th>
                                            <th colspan="22">Jenis Investasi</th>
                                            <th rowspan="2" style="width:13%">Total Per Pihak</th>
                                            <th rowspan="2" style="width:13%">% Per Pihak</th>
                                        </tr>
                                        <tr>
                                            <th>Deposito</th>
                                            <th>Sertifikat Deposito</th>
                                            <th>Surat Utang Negara</th>
                                            <th>Sukuk Pemerintah</th>
                                            <th>Obligasi Korporasi</th>
                                            <th>Sukuk Korporasi</th>
                                            <th>Obligasi Mata Uang Asing</th>
                                            <th>Medium Term Notes</th>
                                            <th>Saham</th>
                                            <th>Reksadana</th>
                                            <th>Dana Investasi KIK</th>
                                            <th>Penyertaan Langsung</th>
                                            <th>Tanah dan Bangunan</th>
                                            <th>Reksadana Pasar Uang</th>
                                            <th>Reksadana Pendapatan Tetap</th>
                                            <th>Reksadana Campuran</th>
                                            <th>Reksadana Saham</th>
                                            <th>Reksadana Terproteksi</th>
                                            <th>Reksadana Pinjaman</th>
                                            <th>Reksadana Index</th>
                                            <th>Reksadana KIK</th>
                                            <th>Reksadana Penyertaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $no=1; 
                                            $tot_persen_pihak = 0;
                                        ?>
                                        <?php if(isset($rincian_invest) && is_array($rincian_invest)):?>
                                        <?php foreach($rincian_invest as $invest):?>
                                            <tr>
                                                <td><?= $no++;?></td>
                                                <td style="text-align: left;"><?=$invest['nama_pihak']?></td>
                                                <td style="text-align: right;"><?=($invest['deposito'] != 0 ) ? rupiah($invest['deposito']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['sertifikat_deposito'] != 0 ) ? rupiah($invest['sertifikat_deposito']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['sun'] != 0 ) ? rupiah($invest['sun']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['sukuk_pemerintah'] != 0 ) ? rupiah($invest['sukuk_pemerintah']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['obligasi_korporasi'] != 0 ) ? rupiah($invest['obligasi_korporasi']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['sukuk_korporasi'] != 0 ) ? rupiah($invest['sukuk_korporasi']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['obligasi_mata_uang'] != 0 ) ? rupiah($invest['obligasi_mata_uang']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['mtn'] != 0 ) ? rupiah($invest['mtn']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['saham'] != 0 ) ? rupiah($invest['saham']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana'] != 0 ) ? rupiah($invest['reksadana']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['dana_invest_kik'] != 0 ) ? rupiah($invest['dana_invest_kik']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['penyertaan_langsung'] != 0 ) ? rupiah($invest['penyertaan_langsung']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['tanah_bangunan'] != 0 ) ? rupiah($invest['tanah_bangunan']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_pasar_uang'] != 0 ) ? rupiah($invest['reksadana_pasar_uang']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_pendapatan_tetap'] != 0 ) ? rupiah($invest['reksadana_pendapatan_tetap']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_campuran'] != 0 ) ? rupiah($invest['reksadana_campuran']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_saham'] != 0 ) ? rupiah($invest['reksadana_saham']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_terproteksi'] != 0 ) ? rupiah($invest['reksadana_terproteksi']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_pinjaman'] != 0 ) ? rupiah($invest['reksadana_pinjaman']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_index'] != 0 ) ? rupiah($invest['reksadana_index']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_kik'] != 0 ) ? rupiah($invest['reksadana_kik']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['reksadana_penyertaaan_diperdagangkan'] != 0 ) ? rupiah($invest['reksadana_penyertaaan_diperdagangkan']) : '-';?></td>
                                                <td style="text-align: right;"><?=($invest['total_perpihak'] != 0 ) ? rupiah($invest['total_perpihak']) : '-';?></td>
                                                <?php
                                                    $persen_pihak['persen'] = ($sum_invest['total_perpihak']!=0)?($invest['total_perpihak']/$sum_invest['total_perpihak'])*100:0;

                                                    $tot_persen_pihak += $persen_pihak['persen'];
                                                ?>
                                                <td style="text-align: right;"><?=($persen_pihak['persen'] != 0 ) ? persen($persen_pihak['persen']).'%' : '-';?></td>
                                            </tr>
                                        <?php endforeach;?>
                                        <?php endif;?>
                                    </tbody>
                                    <tfoot style="background-color: #d8d8d8; font-weight: bold;">
                                        <tr>
                                            <td style="text-align: left;" colspan="2">Total Per Jenis Investasi</td>
                                            <td style="text-align: right;"><?=($sum_invest['deposito'] != 0 ) ? rupiah($sum_invest['deposito']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['sertifikat_deposito'] != 0 ) ? rupiah($sum_invest['sertifikat_deposito']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['sun'] != 0 ) ? rupiah($sum_invest['sun']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['sukuk_pemerintah'] != 0 ) ? rupiah($sum_invest['sukuk_pemerintah']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['obligasi_korporasi'] != 0 ) ? rupiah($sum_invest['obligasi_korporasi']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['sukuk_korporasi'] != 0 ) ? rupiah($sum_invest['sukuk_korporasi']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['obligasi_mata_uang'] != 0 ) ? rupiah($sum_invest['obligasi_mata_uang']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['mtn'] != 0 ) ? rupiah($sum_invest['mtn']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['saham'] != 0 ) ? rupiah($sum_invest['saham']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana'] != 0 ) ? rupiah($sum_invest['reksadana']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['dana_invest_kik'] != 0 ) ? rupiah($sum_invest['dana_invest_kik']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['penyertaan_langsung'] != 0 ) ? rupiah($sum_invest['penyertaan_langsung']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['tanah_bangunan'] != 0 ) ? rupiah($sum_invest['tanah_bangunan']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_pasar_uang'] != 0 ) ? rupiah($sum_invest['reksadana_pasar_uang']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_pendapatan_tetap'] != 0 ) ? rupiah($sum_invest['reksadana_pendapatan_tetap']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_campuran'] != 0 ) ? rupiah($sum_invest['reksadana_campuran']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_saham'] != 0 ) ? rupiah($sum_invest['reksadana_saham']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_terproteksi'] != 0 ) ? rupiah($sum_invest['reksadana_terproteksi']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_pinjaman'] != 0 ) ? rupiah($sum_invest['reksadana_pinjaman']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_index'] != 0 ) ? rupiah($sum_invest['reksadana_index']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_kik'] != 0 ) ? rupiah($sum_invest['reksadana_kik']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['reksadana_penyertaaan_diperdagangkan'] != 0 ) ? rupiah($sum_invest['reksadana_penyertaaan_diperdagangkan']) : '-';?></td>
                                            <td style="text-align: right;"><?=($sum_invest['total_perpihak'] != 0 ) ? rupiah($sum_invest['total_perpihak']) : '-';?></td>
                                            <td style="text-align: right;"><?=($tot_persen_pihak != 0 ) ? persen($tot_persen_pihak).'%' : '-';?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;" colspan="2">% Persen Per Jenis Investasi</td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['deposito'] != 0 ) ? persen($persen_sum_invest['deposito']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['sertifikat_deposito'] != 0 ) ? persen($persen_sum_invest['sertifikat_deposito']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['sun'] != 0 ) ? persen($persen_sum_invest['sun']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['sukuk_pemerintah'] != 0 ) ? persen($persen_sum_invest['sukuk_pemerintah']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['obligasi_korporasi'] != 0 ) ? persen($persen_sum_invest['obligasi_korporasi']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['sukuk_korporasi'] != 0 ) ? persen($persen_sum_invest['sukuk_korporasi']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['obligasi_mata_uang'] != 0 ) ? persen($persen_sum_invest['obligasi_mata_uang']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['mtn'] != 0 ) ? persen($persen_sum_invest['mtn']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['saham'] != 0 ) ? persen($persen_sum_invest['saham']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana'] != 0 ) ? persen($persen_sum_invest['reksadana']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['dana_invest_kik'] != 0 ) ? persen($persen_sum_invest['dana_invest_kik']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['penyertaan_langsung'] != 0 ) ? persen($persen_sum_invest['penyertaan_langsung']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['tanah_bangunan'] != 0 ) ? persen($persen_sum_invest['tanah_bangunan']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_pasar_uang'] != 0 ) ? persen($persen_sum_invest['reksadana_pasar_uang']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_pendapatan_tetap'] != 0 ) ? persen($persen_sum_invest['reksadana_pendapatan_tetap']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_campuran'] != 0 ) ? persen($persen_sum_invest['reksadana_campuran']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_saham'] != 0 ) ? persen($persen_sum_invest['reksadana_saham']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_terproteksi'] != 0 ) ? persen($persen_sum_invest['reksadana_terproteksi']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_pinjaman'] != 0 ) ? persen($persen_sum_invest['reksadana_pinjaman']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_index'] != 0 ) ? persen($persen_sum_invest['reksadana_index']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_kik'] != 0 ) ? persen($persen_sum_invest['reksadana_kik']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['reksadana_penyertaaan_diperdagangkan'] != 0 ) ? persen($persen_sum_invest['reksadana_penyertaaan_diperdagangkan']).'%' : '-';?></td>
                                            <td style="text-align: right;"><?=($persen_sum_invest['total_perpihak'] != 0 ) ? persen($persen_sum_invest['total_perpihak']).'%' : '-';?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>    
                                </table>
                                <br>
                                <!-- data keterangan  -->
                                <div style="padding:4px;">
                                    <p style="margin-left:15px;font-size: 18px;font-weight: bold">Keterangan :
                                    </p>
                                    <div style="padding:4px;border-style:groove;border-color:lightblue;">
                                        <p style="margin-left:10px;font-size: 14px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_rincian_ket[0]->keterangan_lap) ? $data_rincian_ket[0]->keterangan_lap : '');?></p>

                                        <p style="margin-left:15px;font-size: 14px;font-weight: bold">Dokumen : 
                                            <a href="<?php echo site_url('bulanan/rincian/get_file/'.(isset($data_rincian_ket[0]->id) ? $data_rincian_ket[0]->id : ''));?>"><?php echo (isset($data_rincian_ket[0]->file_lap) ? $data_rincian_ket[0]->file_lap : '');?></a>
                                        </p>

                                  </div>
                              </div>
                              <!-- end keterangan -->
                            </div>
                        </div>
                        <div id="rincian_bukan_investasi" class="tab-pane fade">
                             <?php include 'index-rincian-bkn-invest-tsn.php' ;?>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>
</div>
<!-- MODAL KETERANGAN SMT-1-->
<div class="modal fade" id="Modal_ket1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel" style="font-weight:bold;margin-top:10px">KETERANGAN</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group form-group-sm">
              <form class="form-horizontal" action="<?php echo base_url().'bulanan/rincian/save_keterangan'?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

                <input type="hidden" name="jns_lap" value="ket_rincian">
                <input type="hidden" name="nmdok" value="Rincian">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_rincian_ket[0]->keterangan_lap) ? $data_rincian_ket[0]->keterangan_lap : '');?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo (isset($data_rincian_ket[0]->id) ? $data_rincian_ket[0]->id : '');?>">
                    <input type="hidden" name="filedata_lama" value="<?php echo (isset($data_rincian_ket[0]->file_lap) ? $data_rincian_ket[0]->file_lap : '');?>">
                    <input type="file" name="filedata">
                    <p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
                    <a href="<?php echo site_url('bulanan/rincian/get_file/'.(isset($data_rincian_ket[0]->id) ? $data_rincian_ket[0]->id : ''));?>"><p><?php echo (isset($data_rincian_ket[0]->file_lap) ? $data_rincian_ket[0]->file_lap : '');?></p></a>
                  </div>
                </div>
                <div class="modal-footer with-border">
                  <div class="col-sm-12">
                      <button class="btn btn-warning btn-sm btn-flat pull-right user-bln" type="submit">
                        Simpan
                      </button>
                  </div>
                </div>
              </form>
              <!-- /form -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );

    $('#tab_rincian_invest1').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
    
</script>