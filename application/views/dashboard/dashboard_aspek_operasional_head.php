<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Nilai Tunai</h3>
                </div>
                <div class="box-body" style="overflow-x:auto;">
                    <table id="tbl-cabang-2" class="table table-responsive table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2" width="15%">Uraian</th>
                                <th colspan="2">Semester I&nbsp;&nbsp;<span class="tahun"></span></th>
                                <th colspan="2">Semester II&nbsp;&nbsp;<span class="tahun"></span></th>
                                <th colspan="2">Pertumbuhan</th>
                            </tr>
                            <tr>
                                <th>Jumlah Penerima</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Jumlah Penerima</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Nominal</th>
                                <th>Persentase</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($nilai_tunai) && is_array($nilai_tunai)):?>
                            <?php foreach($nilai_tunai as $header):?>
                                <tr>
                                    <td style="text-align: left;"><?=$header['judul']?></td>
                                    <td><?=rupiah($header['jml_penerima_smt1']);?></td>
                                    <td><?=rupiah($header['jml_pembayaran_smt1']);?></td>
                                    <td><?=rupiah($header['jml_penerima_smt2']);?></td>
                                    <td><?=rupiah($header['jml_pembayaran_smt2']);?></td>
                                    <td><?=rupiah($header['nom_pertumbuhan']);?></td>
                                    <td><?=persen($header['pers_pertumbuhan']).'%' ;?></td>
                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Kelompok Penerima</h3>
                </div>
                <div class="box-body" style="overflow-x:auto;">
                    <table id="tbl-cabang-2" class="table table-responsive table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2" width="15%">Kelompok Penerima</th>
                                <th colspan="2">Semester I&nbsp;&nbsp;<span class="tahun"></span></th>
                                <th colspan="2">Semester II&nbsp;&nbsp;<span class="tahun"></span></th>
                                <th colspan="2">Pertumbuhan</th>
                            </tr>
                            <tr>
                                <th>Jumlah Penerima</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Jumlah Penerima</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Nominal</th>
                                <th>Persentase</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($data_kelompok) && is_array($data_kelompok)):?>
                            <?php foreach($data_kelompok as $header):?>
                                <tr>
                                    <td style="text-align: left;"><?=$header['kelompok_penerima']?></td>
                                    <td><?=rupiah($header['jml_penerima_smt1']);?></td>
                                    <td><?=rupiah($header['jml_pembayaran_smt1']);?></td>
                                    <td><?=rupiah($header['jml_penerima_smt2']);?></td>
                                    <td><?=rupiah($header['jml_pembayaran_smt2']);?></td>
                                    <td><?=rupiah($header['nom_pertumbuhan']);?></td>
                                    <td><?=persen($header['pers_pertumbuhan']).'%' ;?></td>
                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Jenis Penerima</h3>
                </div>
                <div class="box-body" style="overflow-x:auto;">
                    <table id="tbl-cabang-2" class="table table-responsive table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2" width="15%">Jenis Penerima</th>
                                <th colspan="2">Semester I&nbsp;&nbsp;<span class="tahun"></span></th>
                                <th colspan="2">Semester II&nbsp;&nbsp;<span class="tahun"></span></th>
                                <th colspan="2">Pertumbuhan</th>
                            </tr>
                            <tr>
                                <th>Jumlah Penerima</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Jumlah Penerima</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Nominal</th>
                                <th>Persentase</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($data_jenis) && is_array($data_jenis)):?>
                            <?php foreach($data_jenis as $header):?>
                                <tr>
                                    <td style="text-align: left;"><?=$header['jenis_penerima']?></td>
                                    <td><?=rupiah($header['jml_penerima_smt1']);?></td>
                                    <td><?=rupiah($header['jml_pembayaran_smt1']);?></td>
                                    <td><?=rupiah($header['jml_penerima_smt2']);?></td>
                                    <td><?=rupiah($header['jml_pembayaran_smt2']);?></td>
                                    <td><?=rupiah($header['nom_pertumbuhan']);?></td>
                                    <td><?=persen($header['pers_pertumbuhan']).'%' ;?></td>
                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
var tahun_filter = '<?= $tahun; ?>';
if (tahun_filter != "") {
    tahun_filter = tahun_filter;
}else {
    tahun_filter =  tahun ; 
}

$(".select2nya").select2( { 'width':'100%' } );
$('.tahun').text(tahun_filter);
</script>