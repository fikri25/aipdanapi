<div class="tab-content">
    <div id="rincian_investasi_pihak" class="tab-pane fade in active">
        <div class="box-body" style="overflow-x:auto;">
            <p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
                Rincian Aset Bukan Investasi Per Pihak
            </p>

            <?php if($this->session->flashdata('form_true')){?>
                <div id="notif">
                    <?php echo $this->session->flashdata('form_true');?>
                </div>
            <?php } ?>

            <table id="tab_rincian_invest2" class="table table-responsive table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2" style="width:3%;">No.</th>
                        <th rowspan="2" width="20%">Nama Pihak</th>
                        <th colspan="19">Jenis Investasi</th>
                        <th rowspan="2" style="width:13%">Total Per Pihak</th>
                        <th rowspan="2" style="width:13%">% Per Pihak</th>
                    </tr>
                    <tr>
                        <th>Kas dan Bank</th>
                        <th>Piutang Iuran</th>
                        <th>Piutang Investasi</th>
                        <th>Piutang Hasil Investasi</th>
                        <th>Piutang Lainnya</th>
                        <th>Piutang Biaya Konpensasi Bank</th>
                        <th>Uang Muka PPH</th>
                        <th>Piutang Pihak Ke tiga</th>
                        <th>Piutang Denda</th>
                        <th>Cadangan Penyisihan</th>
                        <th>Bangunan</th>
                        <th>Tanah dan Bangunan</th>
                        <th>Aset Lainnya</th>
                        <th>Kendaraan</th>
                        <th>Komputer</th>
                        <th>Inventaris Kantor</th>
                        <th>Hak Guna Bangunan</th>
                        <th>Aset Tidak Berwujud</th>
                        <th>Aset Tetap</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no=1; 
                        $tot_persen_pihak = 0;
                    ?>
                    <?php if(isset($rincian_bkn_invest) && is_array($rincian_bkn_invest)):?>
                    <?php foreach($rincian_bkn_invest as $bkninvest):?>
                        <tr>
                            <td><?= $no++;?></td>
                            <td style="text-align: left;"><?=$bkninvest['nama_pihak']?></td>
                            <td style="text-align: right;"><?=($bkninvest['kas_bank'] != 0 ) ? rupiah($bkninvest['kas_bank']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['piutang_iuran'] != 0 ) ? rupiah($bkninvest['piutang_iuran']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['piutang_investasi'] != 0 ) ? rupiah($bkninvest['piutang_investasi']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['piutang_hasil_invest'] != 0 ) ? rupiah($bkninvest['piutang_hasil_invest']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['piutang_lainnya'] != 0 ) ? rupiah($bkninvest['piutang_lainnya']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['piutang_biaya_konpensasi_bank'] != 0 ) ? rupiah($bkninvest['piutang_biaya_konpensasi_bank']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['uangmuka_pph'] != 0 ) ? rupiah($bkninvest['uangmuka_pph']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['piutang_pihak_ketiga'] != 0 ) ? rupiah($bkninvest['piutang_pihak_ketiga']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['piutang_denda'] != 0 ) ? rupiah($bkninvest['piutang_denda']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['cadangan_penyisihan'] != 0 ) ? rupiah($bkninvest['cadangan_penyisihan']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['bangunan'] != 0 ) ? rupiah($bkninvest['bangunan']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['tanah_bangunan'] != 0 ) ? rupiah($bkninvest['tanah_bangunan']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['aset_lainnya'] != 0 ) ? rupiah($bkninvest['aset_lainnya']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['kendaraan'] != 0 ) ? rupiah($bkninvest['kendaraan']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['komputer'] != 0 ) ? rupiah($bkninvest['komputer']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['inventaris_kantor'] != 0 ) ? rupiah($bkninvest['inventaris_kantor']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['hak_guna_bangunan'] != 0 ) ? rupiah($bkninvest['hak_guna_bangunan']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['aset_tdk_berwujud'] != 0 ) ? rupiah($bkninvest['aset_tdk_berwujud']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['aset_tetap'] != 0 ) ? rupiah($bkninvest['aset_tetap']) : '-';?></td>
                            <td style="text-align: right;"><?=($bkninvest['total_perpihak'] != 0 ) ? rupiah($bkninvest['total_perpihak']) : '-';?></td>
                            <?php
                            $persen_pihak['persen'] = ($sum_bkn_invest['total_perpihak']!=0)?($bkninvest['total_perpihak']/$sum_bkn_invest['total_perpihak'])*100:0;

                            $tot_persen_pihak += $persen_pihak['persen'];
                            ?>
                            <td style="text-align: right;"><?=($persen_pihak['persen'] != 0 ) ? persen($persen_pihak['persen']).'%' : '-';?></td>
                        </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </tbody>
                <tfoot style="background-color: #d8d8d8; font-weight: bold;">
                    <tr>
                        <td style="text-align: left;" colspan="2">Total Per Jenis Bukan Investasi</td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['kas_bank'] != 0 ) ? rupiah($sum_bkn_invest['kas_bank']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_iuran'] != 0 ) ? rupiah($sum_bkn_invest['piutang_iuran']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_investasi'] != 0 ) ? rupiah($sum_bkn_invest['piutang_investasi']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_hasil_invest'] != 0 ) ? rupiah($sum_bkn_invest['piutang_hasil_invest']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_lainnya'] != 0 ) ? rupiah($sum_bkn_invest['piutang_lainnya']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_biaya_konpensasi_bank'] != 0 ) ? rupiah($sum_bkn_invest['piutang_biaya_konpensasi_bank']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['uangmuka_pph'] != 0 ) ? rupiah($sum_bkn_invest['uangmuka_pph']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_pihak_ketiga'] != 0 ) ? rupiah($sum_bkn_invest['piutang_pihak_ketiga']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_denda'] != 0 ) ? rupiah($sum_bkn_invest['piutang_denda']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['cadangan_penyisihan'] != 0 ) ? rupiah($sum_bkn_invest['cadangan_penyisihan']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['bangunan'] != 0 ) ? rupiah($sum_bkn_invest['bangunan']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['tanah_bangunan'] != 0 ) ? rupiah($sum_bkn_invest['tanah_bangunan']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['aset_lainnya'] != 0 ) ? rupiah($sum_bkn_invest['aset_lainnya']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['kendaraan'] != 0 ) ? rupiah($sum_bkn_invest['kendaraan']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['komputer'] != 0 ) ? rupiah($sum_bkn_invest['komputer']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['inventaris_kantor'] != 0 ) ? rupiah($sum_bkn_invest['inventaris_kantor']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['hak_guna_bangunan'] != 0 ) ? rupiah($sum_bkn_invest['hak_guna_bangunan']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['aset_tdk_berwujud'] != 0 ) ? rupiah($sum_bkn_invest['aset_tdk_berwujud']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['aset_tetap'] != 0 ) ? rupiah($sum_bkn_invest['aset_tetap']) : '-';?></td>
                        <td style="text-align: right;"><?=($sum_bkn_invest['total_perpihak'] != 0 ) ? rupiah($sum_bkn_invest['total_perpihak']) : '-';?></td>
                        <td style="text-align: right;"><?=($tot_persen_pihak != 0 ) ? persen($tot_persen_pihak).'%' : '-';?></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;" colspan="2">% Persen Per Jenis Bukan Investasi</td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['kas_bank'] != 0 ) ? persen($persen_sum_bkn_invest['kas_bank']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_iuran'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_iuran']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_investasi'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_investasi']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_hasil_invest'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_hasil_invest']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_lainnya'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_lainnya']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_biaya_konpensasi_bank'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_biaya_konpensasi_bank']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['uangmuka_pph'] != 0 ) ? persen($persen_sum_bkn_invest['uangmuka_pph']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_pihak_ketiga'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_pihak_ketiga']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_denda'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_denda']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['cadangan_penyisihan'] != 0 ) ? persen($persen_sum_bkn_invest['cadangan_penyisihan']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['bangunan'] != 0 ) ? persen($persen_sum_bkn_invest['bangunan']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['tanah_bangunan'] != 0 ) ? persen($persen_sum_bkn_invest['tanah_bangunan']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['aset_lainnya'] != 0 ) ? persen($persen_sum_bkn_invest['aset_lainnya']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['kendaraan'] != 0 ) ? persen($persen_sum_bkn_invest['kendaraan']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['komputer'] != 0 ) ? persen($persen_sum_bkn_invest['komputer']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['inventaris_kantor'] != 0 ) ? persen($persen_sum_bkn_invest['inventaris_kantor']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['hak_guna_bangunan'] != 0 ) ? persen($persen_sum_bkn_invest['hak_guna_bangunan']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['aset_tdk_berwujud'] != 0 ) ? persen($persen_sum_bkn_invest['aset_tdk_berwujud']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['aset_tetap'] != 0 ) ? persen($persen_sum_bkn_invest['aset_tetap']).'%' : '-';?></td>
                        <td style="text-align: right;"><?=($persen_sum_bkn_invest['total_perpihak'] != 0 ) ? persen($persen_sum_bkn_invest['total_perpihak']).'%' : '-';?></td>
                        <td></td>
                    </tr>
                </tfoot>  
            </table>
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
</div>

<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );

    $('#tab_rincian_invest2').DataTable({
        "paging":true,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
    });
    
</script>