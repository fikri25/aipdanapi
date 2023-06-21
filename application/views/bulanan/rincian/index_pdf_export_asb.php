<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
    Rincian - <?php echo (isset($bulan[0]->nama_bulan) ? $bulan[0]->nama_bulan : '');?>
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    a) Rincian Investasi Per Pihak
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2" style="width:3%;">No.</th>
            <th rowspan="2">Nama Pihak</th>
            <th colspan="21">Jenis Investasi</th>
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
                <td style="text-align: right;"><?=persen($persen_pihak['persen']);?>%</td>
            </tr>
        <?php endforeach;?>
    <?php endif;?>
</tbody>
<tr style="background-color: #d8d8d8; font-weight: bold;">
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
</tr> 
</table>
<pagebreak></pagebreak>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
    b) Rincian Bukan Investasi
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
    <thead>
        <tr>
            <th rowspan="2" style="width:3%;">No.</th>
            <th rowspan="2" width="20%">Nama Pihak</th>
            <th colspan="21">Jenis Investasi</th>
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
            <th>Piutang BUM KPR</th>
            <th>Piutang PUM KPR</th>
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
                <td style="text-align: right;"><?=($bkninvest['piutang_bum_kpr'] != 0 ) ? rupiah($bkninvest['piutang_bum_kpr']) : '-';?></td>
                <td style="text-align: right;"><?=($bkninvest['piutang_pum_kpr'] != 0 ) ? rupiah($bkninvest['piutang_pum_kpr']) : '-';?></td>
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
<tr style="background-color: #d8d8d8; font-weight: bold;">
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
        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_bum_kpr'] != 0 ) ? rupiah($sum_bkn_invest['piutang_bum_kpr']) : '-';?></td>
        <td style="text-align: right;"><?=($sum_bkn_invest['piutang_pum_kpr'] != 0 ) ? rupiah($sum_bkn_invest['piutang_pum_kpr']) : '-';?></td>
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
        <td style="text-align: right;"><?=($tot_persen_pihak != 0 ) ? rupiah($tot_persen_pihak).'%' : '-';?></td>
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
        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_bum_kpr'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_bum_kpr']).'%' : '-';?></td>
        <td style="text-align: right;"><?=($persen_sum_bkn_invest['piutang_pum_kpr'] != 0 ) ? persen($persen_sum_bkn_invest['piutang_pum_kpr']).'%' : '-';?></td>
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
</tr> 
</table>


<!-- <br> -->
<!-- data keterangan  -->
<!-- <div>
    <p style="margin-left:15px;font-size: 14px;font-weight: bold">Keterangan :</p>
    <p style="margin-left:10px;font-size: 12px;margin-right: 15px;margin-left: 15px;text-align: justify;"><?php echo (isset($data_hasil_investasi_ket[0]->keterangan_lap) ? $data_hasil_investasi_ket[0]->keterangan_lap : '');?></p>
</div> -->
<!-- end keterangan -->