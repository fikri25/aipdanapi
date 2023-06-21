function genPieChart(divnya, tipe, judul, data, pointformatnya, p1){
	Highcharts.setOptions({
		lang:{
			thousandsSep: ','
		},
	});
	Highcharts.chart(divnya, {
		chart: {
			// backgroundColor: 'rgba(0, 0, 0, 0.7)',
			color: "#fff",
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie',
			// width: '100px',
			
		},
		legend: {
			itemStyle: {
				// color: '#fff'
			}
		},
		credits: {
			enabled: false
		},
		title: {
			text: judul

		},
		tooltip: {
			pointFormat: 'Jumlah: <b>{point.y}</b>' + '<br/>{series.name}: <b>{point.percentage:.1f}%</b>', 

		},

		plotOptions: {
			pie: {
				allowPointSelect: false,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					// format: '<b>{point.name}</b> : {point.percentage:.1f} %',
					format: '<b>{point.percentage:.1f} %</b>',
					style: {
						width: '100px',
					},
					distance: 10,

				},
				size : p1,
				showInLegend: true,
			}
		},
		series: data
	} );
}

function genColumnChart(divnya, type, xxChart, yyChart, judul, pointformatnya, par1, par2){
	Highcharts.setOptions({
		lang:{
			thousandsSep: ','
		},
	});

	Highcharts.chart(divnya, {
        chart: {
            type: 'column',
            
            // backgroundColor: 'rgba(0, 0, 0, 0.5)',
        },
        title: {
            text: judul,
			style: {
				color: '#FFF',
				font: '16px Lucida Grande, Lucida Sans Unicode,' +
					' Verdana, Arial, Helvetica, sans-serif'
			}
        },
        xAxis: {
            categories: xxChart,
            reversed : par2,
            labels: {
				style: {
					color: '#000'
				}
			}
        },
        scrollbar: {
            enabled: false
        },

        rangeSelector: {
            selected: 1
        },
        yAxis: [{
        	labels: {
				overflow: 'justify',
				style: {
					color: '#000'
				}
			},
			title:{
				text:'JUMLAH',
			}
        },
        {
            min: 0,
            title: {
                text: ''
            },
        }, {
            title: {
                text: ''
            },
            opposite: true
        }],
        legend: {
            shadow: false,
            enabled: true,//(type == "pratut-tiga" ? false : true)
        },
        credits: {
        	enabled: false
        },
        tooltip: {
            shared:true,
			// pointFormat: ponitformatnya
        },
        plotOptions: {
	        column: {
	            pointPadding: 0.1,
	            borderWidth: 0
	        },
	        series: {
				cursor: (type == 'ctwna' ? 'pointer' : ""),
	        	dataLabels: {
	        		enabled: true,
	        		color: 'black',
	        		style: {fontWeight: 'bolder'},
	        		// formatter: function() {return this.x + ' : ' + this.y},
	        		inside: false,
	        		// rotation: 270
	        	},
				point: {
					events: {
						click: function () {
							if(type == "ctwna"){
								$.blockUI({ message: '<img width="100px" src="'+host+'__assets/images/loader.gif"><br/> Proses Data' });
								par1['idnya_wna'] = par1['id'][this.index];
								var negara = par1['negara'][this.index];
								
								// console.log(par1['idnya_wna']);
								$('#modalencuk').html('');
								$.post(host+'wna-detail/detail-wna-chart', par1, function (resp){
									 $('#headernya').html( "DETAIL CHART "+negara );
									 $('#modalencuk').html(resp);
									 $('#pesanModal').modal('show');
									 $.unblockUI();
								});
							}

							if(type == "spdp"){
								$.blockUI({ message: '<img width="100px" src="'+host+'__assets/images/loader.gif"><br/> Proses Data' });
								par1['idnya_jenis'] = par1['id_jenis'][this.index];
								par1['nama_jenis'] = this.category;
								
								$('#kotakan_spdp').hide();
								$('#tablean_spdp').html('');
								$.post(host+'pidana-umum3-dataperkara-table', par1, function (resp){
									$('#tablean_spdp').html(resp).show();
									$.unblockUI();
								});
							}
							
						}
					}
				 }
	        }
	    },
        series: yyChart
    });
}	

function genLineChart(divnya, type, xxChart, yyChart, judul, pointformatnya, par1, par2){
	Highcharts.setOptions({
		lang:{
			thousandsSep: ','
		},
	});

	Highcharts.chart(divnya, {
        chart: {
            type: 'line',
            
            // backgroundColor: 'rgba(0, 0, 0, 0.5)',
        },
        title: {
            text: judul,
			style: {
				color: '#FFF',
				font: '16px Lucida Grande, Lucida Sans Unicode,' +
					' Verdana, Arial, Helvetica, sans-serif'
			}
        },
        xAxis: {
            categories: xxChart,
            reversed : par2,
            labels: {
				style: {
					color: '#000'
				}
			}
        },
        scrollbar: {
            enabled: false
        },

        rangeSelector: {
            selected: 1
        },
        yAxis: [{
        	labels: {
				overflow: 'justify',
				style: {
					color: '#000'
				},
				formatter: function() {
					var ret,
					numericSymbols = ['Ribu', 'Juta', 'Miliar', 'Triliun', 'Kuadriliun', 'E'],
					i = numericSymbols.length;
					if(this.value >=1000) {
						while (i-- && ret === undefined) {
							multi = Math.pow(1000, i + 1);
							if (this.value >= multi && numericSymbols[i] !== null) {
								ret = (this.value / multi) + numericSymbols[i];
							}
						}
					}
					return '' + (ret ? ret : this.value);

				}
			},
			title:{
				// text:'Nominal (Rp)',
				text:par1,
			}
        },
        {
            min: 0,
            title: {
                text: ''
            },
        }, {
            title: {
                text: ''
            },
            opposite: true
        }],
        legend: {
            shadow: false,
            enabled: true,//(type == "pratut-tiga" ? false : true)
        },
        credits: {
        	enabled: false
        },
        tooltip: {
            shared:true,
			// pointFormat: ponitformatnya
        },
        plotOptions: {
	        column: {
	            pointPadding: 0.1,
	            borderWidth: 0
	        },
	        series: {
				cursor: (type == 'ctwna' ? 'pointer' : ""),
	        	dataLabels: {
	        		enabled: true,
	        		color: 'black',
	        		style: {fontWeight: 'bolder'},
	        		// formatter: function() {return this.x + ' : ' + this.y},
	        		inside: false,
	        		// rotation: 270
	        	},
				
	        }
	    },
        series: yyChart
    });
}

function getClientHeight(){
	var theHeight;
	if (window.innerHeight)
		theHeight=window.innerHeight;
	else if (document.documentElement && document.documentElement.clientHeight) 
		theHeight=document.documentElement.clientHeight;
	else if (document.body) 
		theHeight=document.body.clientHeight;
	
	return theHeight;
}

function getClientWidth(){
	var theWidth;
	if (window.innerWidth) 
		theWidth=window.innerWidth;
	else if (document.documentElement && document.documentElement.clientWidth) 
		theWidth=document.documentElement.clientWidth;
	else if (document.body) 
		theWidth=document.body.clientWidth;

	return theWidth;
}

var divcontainer;
function windowFormPanel(html,judul,width,height){
	divcontainer = $('#jendela');
	$(divcontainer).unbind();
	$('#isiJendela').html(html);
    $(divcontainer).window({
		title:judul,
		width:width,
		height:height,
		autoOpen:false,
		top: Math.round(getClientHeight()/2)-(height/2),
		left: Math.round(getClientWidth()/2)-(width/2),
		modal:true,
		maximizable:false,
		minimizable: false,
		collapsible: false,
		closable: true,
		resizable: false,
	    onBeforeClose:function(){	   
			$(divcontainer).window("close",true);
			//$(divcontainer).window("destroy",true);
			//$(divcontainer).window('refresh');
			return true;
	    }		
    });
    $(divcontainer).window('open');       
}
function windowFormClosePanel(){
    $(divcontainer).window('close');
	//$(divcontainer).window('refresh');
}

var container;
function windowForm(html,judul,width,height){
    container = "win"+Math.floor(Math.random()*9999);
    $("<div id="+container+"></div>").appendTo("body");
    container = "#"+container;
    $(container).html(html);
    $(container).css('padding','5px');
    $(container).window({
       title:judul,
       width:width,
       height:height,
       autoOpen:false,
       maximizable:false,
       minimizable: false,
	   collapsible: false,
       resizable: false,
       closable:true,
       modal:true,
	   onBeforeClose:function(){	   
			$(container).window("close",true);
			$(container).window("destroy",true);
			return true;
	   }
    });
    $(container).window('open');        
}
function closeWindow(){
    $(container).window('close');
    $(container).html("");
}


// FORM BULANAN & MASTER DATA
function genform(type, modulnya, submodulnya, stswindow, p1, p2, p3, stscrudmodal){
	var id_tambahan = "";
	var nama_file = "";
	var table = submodulnya;
	var adafilenya = false;
	
	switch(submodulnya){
		case "aset_investasi": 
		case "bukan_investasi": 
		case "detail_aset_investasi": 
		case "detail_bukan_investasi": 
		case "danabersih_kewajiban": 
		// case "perubahan_dana_bersih": 
			var urlpostadd = host+'investasi-form/'+submodulnya;
			var urlpostedit = host+'investasi-form/'+submodulnya+'/'+p1+'/'+p2;
			var urldelete = host+'investasi-simpan/'+submodulnya;	
		break;
		case "arus_kas":
			var urlpostadd = host+'arus-kas-form/'+submodulnya;
			var urlpostedit = host+'arus-kas-form/'+submodulnya+'/'+p1;
			var urldelete = host+'arus-kas-simpan/'+submodulnya;	
			var urlcetakpdfall = host+'marketing-cetak/quotation/pdf';
		break;
		case "beban_investasi": 
		case "perubahan_dana_bersih": 
			var urlpostadd = host+'perubahan-danabersih-form/'+submodulnya;
			var urlpostedit = host+'perubahan-danabersih-form/'+submodulnya+'/'+p1;
		break;
		case "hasil_investasi":
			var urldelete = host+'investasi-simpan/'+submodulnya;
			var urlcetakpdfall = host+'marketing-cetak/quotation/pdf';
		break;

		case "pembayaran_pensiun_aip":
			var urlpostadd = host+'aspek-operasional-form/'+submodulnya;
		break;


		case "pendahuluan_cetak":
		case "cetak_bukti":
			var urlcetakpdfall = host+'pendahuluan-cetak/'+submodulnya+'/pdf';
		break;
		case "aset_investasi_cetak":
			var urlcetakpdfall = host+'investasi-cetak/'+submodulnya+'/pdf';
		break;
		case "hasil_investasi_cetak":
			var urlcetakpdfall = host+'hasil-investasi-cetak/'+submodulnya+'/pdf';
		break;
		case "bukan_investasi_cetak":
			var urlcetakpdfall = host+'bukan-investasi-cetak/'+submodulnya+'/pdf';
		break;
		case "dana_bersih_cetak":
			var urlcetakpdfall = host+'danabersih-cetak/'+submodulnya+'/pdf';
		break;
		case "perubahan_danabersih_cetak":
		case "beban_investasi_cetak":
			var urlcetakpdfall = host+'perubahan-danabersih-cetak/'+submodulnya+'/pdf';
		break;
		case "aruskas_cetak":
			var urlcetakpdfall = host+'aruskas-cetak/'+submodulnya+'/pdf';
		break;
		case "rincian_cetak":
			var urlcetakpdfall = host+'rincian-cetak/'+submodulnya+'/pdf';
		break;


		case "master_jenis_penerima":
		case "master_kelompok_penerima":
		case "master_klaim":
		case "master_aruskas":
		case "master_investasi":
		case "master_cabang":
		case "master_nama_pihak":
		case "mst_pihak":
			var urldelete = host+'master-simpan/'+submodulnya;
		break;
	}

	
	switch(type){
		case "add":
			$.LoadingOverlay("show");
			$.post(urlpostadd+uri, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "edit":
		case "delete":			
			if(type=='edit'){
				var iduser= $('#iduser').val();
				$.LoadingOverlay("show");
				$.post(urlpostedit+uri, { 'editstatus':'edit', 'id':p1, 'jns_form':p2, 'ts':table,'iduser':iduser, [csrf_token]:csrf_hash }, function(resp){
					$('.content').html(resp);
					$.LoadingOverlay("hide", true);
				});
			}else if(type=='delete'){
				$.messager.confirm('SMART AIP','Anda Yakin Ingin Menghapus Data Ini ?',function(re){
					if(re){

						$.LoadingOverlay("show");
						$.post(urldelete, {'id':p1, 'tipe':p2, 'p3':p3, 'editstatus':'delete', [csrf_token]:csrf_hash }, function(r){
							if(r==1){
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Data Terhapus",'info');
								if(submodulnya == 'aset_investasi'){
									setTimeout(function(){
										window.location = host+'bulanan/aset_investasi'+uri;
									}, 1000);
								}
								if(submodulnya == 'bukan_investasi'){
									setTimeout(function(){
										window.location = host+'bulanan/bukan_investasi'+uri;
									}, 1000);
								}
								if(submodulnya == 'arus_kas'){
									setTimeout(function(){
										window.location = host+'bulanan/arus_kas'+uri;
									}, 1000);
								}
								if(submodulnya == 'hasil_investasi'){
									setTimeout(function(){
										window.location = host+'bulanan/hasil_investasi'+uri;
									}, 1000);
								}	

								if(submodulnya == 'master_investasi' || submodulnya == 'master_cabang' 
									|| submodulnya == 'master_nama_pihak'|| submodulnya == 'master_jenis_penerima'
									|| submodulnya == 'master_kelompok_penerima'|| submodulnya == 'master_klaim'
									|| submodulnya == 'master_aruskas' || submodulnya == 'mst_pihak'){
									setTimeout(function(){
										window.location = host+'master/master_data/'+submodulnya;
									}, 1000);
								}	
							}else{
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Gagal Menghapus Data "+r,'error');
							}
						});	
					}
				});	
			}
			
		break;
	

		case "addhasil_investasi":
			if(stscrudmodal == 'add'){
				var urlpostaddmodal = host+'investasi-form/'+submodulnya;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlpostaddmodal+uri, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Hasil Investasi</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}else if(stscrudmodal == 'edit'){
				var urlposteditmodal =  host+'investasi-form/'+submodulnya+'/'+p1;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlposteditmodal+uri, {'editstatus':'edit', 'id':p1, 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Hasil Investasi</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}
			
		break;	

		case "master_jenis_penerima":
		case "master_kelompok_penerima":
		case "master_klaim":
		case "master_aruskas":
		case "master_aset_investasi":
		case "master_nama_pihak":
		case "mst_pihak":
		case "master_cabang":
			if(stscrudmodal == 'add'){
				var urlpostaddmodal = host+'master-form/'+submodulnya;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlpostaddmodal, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Master Data</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}else if(stscrudmodal == 'edit'){
				if (type == 'master_nama_pihak') {
					var urlposteditmodal =  host+'master-form/'+submodulnya+'/'+p1+'/'+p2+'/'+p3;
				}else{
					var urlposteditmodal =  host+'master-form/'+submodulnya+'/'+p1;
				}
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlposteditmodal, {'editstatus':'edit', 'id':p1, 'kd':p2, 'iduser':p3, 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Master Data</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}
			
		break;	

		case "print-all":
			var iduser= $('#iduser').val();	
			openWindowWithPost(urlcetakpdfall+uri,{'tp':'cetak','iduser':iduser ,[csrf_token]:csrf_hash});
		
		break;
		
	}


}


// FORM SEMESTER
function genformsemester(type, modulnya, submodulnya, stswindow, p1, p2, p3, stscrudmodal){
	var id_tambahan = "";
	var nama_file = "";
	var table = submodulnya;
	var adafilenya = false;
	
	switch(submodulnya){
		
		case "arus_kas":
			var urlpostadd = host+'arus-kas-form/'+submodulnya;
			var urlpostedit = host+'arus-kas-form/'+submodulnya+'/'+p1;
			var urldelete = host+'arus-kas-simpan/'+submodulnya;	
		break;

		case "pembayaran_aip":
		case "pembayaran_pensiun_aip_cabang":
		case "beban_tenaga_kerja":
		case "nilai_tunai":
			var urlpostadd = host+'aspek-operasional-form/'+submodulnya;
			var urlpostedit = host+'aspek-operasional-form/'+submodulnya+'/'+p1+'/'+p2;
			var urldelete = host+'aspek-operasional-simpan/'+submodulnya;	
			var urlcetakpdfall = host+'marketing-cetak/quotation/pdf';
		break;

		case "lkob_klaim":
		case "pembayaran_pensiun_apbn":
		case "pembayaran_pensiun_apbn_cabang":
			var urlpostadd = host+'operasional-belanja-form/'+submodulnya;
			var urlpostedit = host+'operasional-belanja-form/'+submodulnya+'/'+p1+'/'+p2;
			// var urldelete = host+'aspek-operasional-simpan/'+submodulnya;	
			var urldelete = host+'operasional-belanja-simpan/'+submodulnya;	
		break;

		case "pembayaran_pensiun_apbn_del":
			var urldelete = host+'aspek-operasional-simpan/pembayaran_aip';	
		break;
		case "pembayaran_pensiun_apbn_cabang_del":	
			var urldelete = host+'aspek-operasional-simpan/pembayaran_pensiun_aip_cabang';	
		break;


		case "nilai_tunai_cetak":
		case "pembayaran_pensiun_cabang_cetak":
		case "beban_cetak":
		case "pembayaran_pensiun_aip_cetak":
			var urlcetakpdfall = host+'aspek-operasional-cetak/'+submodulnya+'/pdf';
		break;

		case "dana_bersih_cetak":
		case "perubahan_dana_bersih_cetak":
		case "lkak_yoi_cetak":
			var urlcetakpdfall = host+'aspek-keuangan-cetak/'+submodulnya+'/pdf';
		break;

		case "karakteristik_investasi_cetak":
		case "beban_investasi_cetak":
		case "penerimaan_hasil_investasi_cetak":
		case "penempatan_investasi_cetak":
			var urlcetakpdfall = host+'aspek-investasi-cetak/'+submodulnya+'/pdf';
		break;

		case "pembayaran_pensiun_apbn_cetak":
		case "pembayaran_pensiun_apbn_cabang_cetak":
		case "klaim_cetak":
			var urlcetakpdfall = host+'operasional-belanja-cetak/'+submodulnya+'/pdf';
		break;

		case "lampiran_danabersih_cetak":
		case "lampiran_perubahan_danabersih_cetak":
		case "lampiran_aruskas_cetak":
			var urlcetakpdfall = host+'lampiran-cetak/'+submodulnya+'/pdf';
		break;

		case "index-pendahuluan-cetak":
		case "index-pernyataan-cetak":
			var urlcetakpdfall = host+'pendahuluan-semester-cetak/'+submodulnya+'/pdf';
		break;

	}

	
	switch(type){
		case "add":
			$.post(urlpostadd, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
			});
		break;
		case "edit":
		case "delete":			
			if(type=='edit'){
				// var iduser= $('#iduser').val();
				$.LoadingOverlay("show");
				$.post(urlpostedit, { 'editstatus':'edit', 'id':p1, 'semester':p2, 'ts':table, [csrf_token]:csrf_hash }, function(resp){
					$('.content').html(resp);
					$.LoadingOverlay("hide", true);
				});
			}else if(type=='delete'){
				$.messager.confirm('SMART AIP','Anda Yakin Ingin Menghapus Data Ini ?',function(re){
					if(re){

						$.LoadingOverlay("show");
						$.post(urldelete, {'editstatus':'delete', 'id':p1, 'kelompok':p1, 'semester':p2, 'sumber_dana':p3,  [csrf_token]:csrf_hash }, function(r){
							if(r==1){
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Data Terhapus",'info');
								if(submodulnya == 'nilai_tunai'){
									setTimeout(function(){
										window.location = host+'semesteran/aspek_operasional/nilai_tunai';
									}, 1000);
								}
								if(submodulnya == 'pembayaran_aip' || submodulnya == 'pembayaran_pensiun_aip_cabang'){
									setTimeout(function(){
										window.location = host+'semesteran/aspek_operasional/pembayaran_pensiun_aip';
									}, 1000);
								}
								if(submodulnya == 'pembayaran_pensiun_apbn_del' || submodulnya == 'pembayaran_pensiun_apbn_cabang_del'){
									setTimeout(function(){
										window.location = host+'semesteran/operasional_belanja/pembayaran_pensiun';
									}, 1000);
								}	
								if(submodulnya == 'beban_tenaga_kerja'){
									setTimeout(function(){
										window.location = host+'semesteran/aspek_operasional/beban';
									}, 1000);
								}
								if(submodulnya == 'lkob_klaim'){
									setTimeout(function(){
										window.location = host+'semesteran/operasional_belanja/klaim';
									}, 1000);
								}			

							}else{
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Gagal Menghapus Data "+r,'error');
							}
						});	
					}
				});	
			}
			
		break;
	

		case "karakteristik_investasi":
			if(stscrudmodal == 'add'){
				var urlpostaddmodal = host+'aspek-investasi-form/'+submodulnya;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlpostaddmodal, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Karakteristik dan Resiko Investasi</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}else if(stscrudmodal == 'edit'){
				var urlposteditmodal =  host+'aspek-investasi-form/'+submodulnya+'/'+p1;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlposteditmodal, {'editstatus':'edit', 'id':p1, 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Karakteristik dan Resiko Investasi</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}else if(stscrudmodal == 'delete'){
				var urlposteditmodal =  host+'aspek-investasi-simpan/'+submodulnya;
				$.messager.confirm('SMART AIP','Anda Yakin Ingin Menghapus Data Ini ?',function(re){
					if(re){
						$.LoadingOverlay("show");
						$('#modalidnya').html('');
						$.post(urlposteditmodal, {'editstatus':'delete', 'id':p1, 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
							if(resp==1){
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Data Terhapus",'info');
								if(submodulnya == 'karakteristik_investasi'){
									setTimeout(function(){
										window.location = host+'semesteran/aspek_investasi/karakteristik_invest';
									}, 1000);
								}
							}else{
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Gagal Menghapus Data "+r,'error');
							}
						});
					}
				});
			}
			
		break;	

		case "beban_tenaga_kerja":
			if(stscrudmodal == 'add'){
				var urlpostaddmodal = host+'aspek-operasional-form/'+submodulnya;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlpostaddmodal, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Jumlah Tenaga Kerja</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}else if(stscrudmodal == 'edit'){
				var urlposteditmodal =  host+'aspek-operasional-form/'+submodulnya+'/'+p1;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlposteditmodal, {'editstatus':'edit', 'id':p1, 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Jumlah Tenaga Kerja</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}else if(stscrudmodal == 'delete'){
				var urlposteditmodal =  host+'aspek-operasional-simpan/'+submodulnya;
				$.messager.confirm('SMART AIP','Anda Yakin Ingin Menghapus Data Ini ?',function(re){
					if(re){
						$.LoadingOverlay("show");
						$('#modalidnya').html('');
						$.post(urlposteditmodal, {'editstatus':'delete', 'id':p1, 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
							if(resp==1){
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Data Terhapus",'info');
								if(submodulnya == 'beban_tenaga_kerja'){
									setTimeout(function(){
										window.location = host+'semesteran/aspek_operasional/beban';
									}, 1000);
								}
							}else{
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Gagal Menghapus Data "+r,'error');
							}
						});
					}
				});
			}
			
		break;	

		case "master_aset_investasi":
			if(stscrudmodal == 'add'){
				var urlpostaddmodal = host+'master-form/'+submodulnya;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlpostaddmodal, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Master Data Investasi</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}else if(stscrudmodal == 'edit'){
				var urlposteditmodal =  host+'master-form/'+submodulnya+'/'+p1;
				$.LoadingOverlay("show");
				$('#modalidnya').html('');
				$.post(urlposteditmodal, {'editstatus':'edit', 'id_investasi':p1, 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
					$('#headernya').html("<b>Master Data Investasi</b>");
					$('#modalidnya').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
			}
			
		break;	

	

		case "print-all":
			var iduser= $('#iduser').val();	
			var smt= $('#semester').val();
			openWindowWithPost(urlcetakpdfall,{'tp':'cetak','iduser':iduser ,'semester':smt ,[csrf_token]:csrf_hash});
		
		break;
		
	}
}


// FORM TAHUNAN
function genformtahunan(type, modulnya, submodulnya, stswindow, p1, p2, p3, stscrudmodal){
	var id_tambahan = "";
	var nama_file = "";
	var table = submodulnya;
	var adafilenya = false;
	
	switch(submodulnya){
		case "nilai_tunai_cetak":
		case "pembayaran_pensiun_cabang_cetak":
		case "beban_cetak":
		case "pembayaran_pensiun_aip_cetak":
			var urlcetakpdfall = host+'aspek-operasional-thn-cetak/'+submodulnya+'/pdf';
		break;

		case "dana_bersih_cetak":
		case "perubahan_dana_bersih_cetak":
		case "lkak_yoi_cetak":
			var urlcetakpdfall = host+'aspek-keuangan-thn-cetak/'+submodulnya+'/pdf';
		break;

		case "karakteristik_investasi_cetak":
		case "beban_investasi_cetak":
		case "penerimaan_hasil_investasi_cetak":
		case "penempatan_investasi_cetak":
			var urlcetakpdfall = host+'aspek-investasi-thn-cetak/'+submodulnya+'/pdf';
		break;

		case "pembayaran_pensiun_apbn_cetak":
		case "pembayaran_pensiun_apbn_cabang_cetak":
		case "klaim_cetak":
			var urlcetakpdfall = host+'operasional-belanja-thn-cetak/'+submodulnya+'/pdf';
		break;

		case "lampiran_danabersih_cetak":
		case "lampiran_perubahan_danabersih_cetak":
		case "lampiran_aruskas_cetak":
			var urlcetakpdfall = host+'lampiran-thn-cetak/'+submodulnya+'/pdf';
		break;

		case "index-pendahuluan-thn-cetak":
		case "index-pernyataan-thn-cetak":
			var urlcetakpdfall = host+'pendahuluan-thn-cetak/'+submodulnya+'/pdf';
		break;

		case "keuangan_danabersih":
			var urlpostadd = host+'aspek-keuangan-thn-form/'+submodulnya;
			var urlpostedit = host+'aspek-keuangan-thn-form/'+submodulnya+'/'+p1;
			var urldelete = host+'aspek-keuangan-thn-simpan/'+submodulnya;	
		break;


	}

	switch(type){
		case "add":
			$.LoadingOverlay("show");
			$.post(urlpostadd, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "print-all":
			var iduser= $('#iduser').val();	
			openWindowWithPost(urlcetakpdfall,{'tp':'cetak','iduser':iduser ,[csrf_token]:csrf_hash});
		
		break;
	}
}


function gensearch(modulnya, submodulnya, stswindow, p1, p2, p3, stscrudmodal){
	var bln = id_bulan;
	var iduser_sess = iduser;
	var iduser= $('#iduser').val();
	var group= $('#group').val();
	switch(modulnya){
		case "index-investasi":
			$.LoadingOverlay("show");
			var urlpost = host+'investasi-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "sinkron-investasi":
			$.LoadingOverlay("show");
			var urlpost = host+'investasi-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$.messager.alert('SMART AIP','Data Tersimpan','info'); 
				$('#cancel').trigger('click');
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-danabersih":
			$.LoadingOverlay("show");
			var urlpost = host+'danabersih-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-perubahan-danabersih":
		case "index-beban-investasi":
			$.LoadingOverlay("show");
			var urlpost = host+'perubahan-danabersih-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-hasil-investasi":
			$.LoadingOverlay("show");
			var urlpost = host+'hasil-investasi-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-bukan-investasi":
			$.LoadingOverlay("show");
			var urlpost = host+'bukan-investasi-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-aruskas":
			$.LoadingOverlay("show");
			var urlpost = host+'aruskas-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-pendahuluan":
		case "index-pernyataan":
			$.LoadingOverlay("show");
			var urlpost = host+'pendahuluan-index/'+modulnya;
			$.post(urlpost+uri, {'id_bulan':bln, 'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-master-kelompok-penerima":
		case "index-master-klaim":
		case "index-master-aruskas":
		case "index-master-investasi":
		case "index-master-nama-pihak":
		case "index-mst-pihak":
		case "index-master-cabang":
			var kas= $('#kas').val();
			var flag= $('#flag').val();
			$.LoadingOverlay("show");
			var urlpost = host+'master-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, 'group':group, 'kas':kas, 'flag':flag, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		case "index-rincian":
			$.LoadingOverlay("show");
			var urlpost = host+'rincian-index/'+modulnya;
			$.post(urlpost+uri, {'iduser':iduser, 'id_bulan':bln, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
	}
}

function gensemestersearch(modulnya, submodulnya, stswindow, p1, p2, p3, stscrudmodal){
	var iduser= $('#iduser').val();
	var smt= $('#semester').val();
	var group= $('#group').val();
	switch(modulnya){
		case "index-beban":
		case "index-pembayaran-cabang":
		case "index-pembayaran-kelompok":
		case "index-nilai-tunai":
			$.LoadingOverlay("show");
			var urlpost = host+'aspek-operasional-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'semester':smt, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-perubahan-danabersih":
		case "index-lkak-yoi":
		case "index-danabersih":
			$.LoadingOverlay("show");
			var urlpost = host+'aspek-keuangan-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, 'semester':smt, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-karakteristik-investasi":
		case "index-beban-investasi":
		case "index-hasil-investasi":
		case "index-penempatan-investasi":
			$.LoadingOverlay("show");
			var urlpost = host+'aspek-investasi-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'semester':smt,  [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-lampiran":
		case "index-klaim":
		case "index-pembayaran-pensiun-cabang":
		case "index-pembayaran-pensiun":
			$.LoadingOverlay("show");
			var urlpost = host+'operasional-belanja-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'semester':smt, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-pendahuluan-semester":
		case "index-pernyataan-semester":
			$.LoadingOverlay("show");
			var urlpost = host+'pendahuluan-semester-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, 'semester':smt, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-lampiran-danabersih":
		case "index-lampiran-perubahan-danabersih":
		case "index-lampiran-aruskas":
			$.LoadingOverlay("show");
			var urlpost = host+'lampiran-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, 'semester':smt, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		
	}
}

function gentahunansearch(modulnya, submodulnya, stswindow, p1, p2, p3, stscrudmodal){
	var iduser= $('#iduser').val();
	var smt= $('#semester').val();
	var group= $('#group').val();
	var audit= $('#audit').val();
	switch(modulnya){
		case "index-beban":
		case "index-pembayaran-cabang":
		case "index-pembayaran-kelompok":
		case "index-nilai-tunai":
			$.LoadingOverlay("show");
			var urlpost = host+'aspek-operasional-thn-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-perubahan-danabersih":
		case "index-lkak-yoi":
		case "index-danabersih":
		case "index-audit-danabersih":
			$.LoadingOverlay("show");
			var urlpost = host+'aspek-keuangan-thn-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'jns_lap':audit, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-karakteristik-investasi":
		case "index-beban-investasi":
		case "index-hasil-investasi":
		case "index-penempatan-investasi":
			$.LoadingOverlay("show");
			var urlpost = host+'aspek-investasi-thn-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-lampiran":
		case "index-klaim":
		case "index-pembayaran-pensiun-cabang":
		case "index-pembayaran-pensiun":
			$.LoadingOverlay("show");
			var urlpost = host+'operasional-belanja-thn-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-pendahuluan-tahunan":
		case "index-pernyataan-tahunan":
			$.LoadingOverlay("show");
			var urlpost = host+'pendahuluan-thn-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, 'semester':smt, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-lampiran-danabersih":
		case "index-lampiran-perubahan-danabersih":
		case "index-lampiran-aruskas":
			$.LoadingOverlay("show");
			var urlpost = host+'lampiran-thn-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;
		
	}
}

function gendashboardsearch(modulnya, submodulnya, stswindow, p1, p2, p3, stscrudmodal){
	var iduser= $('#iduser').val();
	var id_bulan= $('#id_bulan').val();
	var smt= $('#semester').val();
	var group= $('#group').val();
	var audit= $('#audit').val();
	var ds= $('#dashboard').val();

	var bln_awal= $('#bln_awal').val();
	var tahun_awal= $('#tahun_awal').val();
	var bln_akhir= $('#bln_akhir').val();
	var tahun_akhir= $('#tahun_akhir').val();
	var detail_invest= $('#detail_invest').val();
	var jns_lap= $('#jns_lap').val();
	switch(modulnya){
		case "index-dashboard-analisis":
			if (iduser == "") {
				$.messager.alert('SMART AIP','Pilih User','warning'); 
				return false;
			}
			if (ds == "") {
				$.messager.alert('SMART AIP','Pilih Jenis Laporan','warning'); 
				return false;
			}

			$.LoadingOverlay("show");
			var urlpost = host+'dashboard-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'dashboard':ds,'id_bulan':id_bulan, [csrf_token]:csrf_hash  }, function(resp){
				$('.content-dashboard').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-dashboard-danabersih":
			if (iduser == "") {
				$.messager.alert('SMART AIP','Pilih User','warning'); 
				return false;
			}

			if (bln_awal == "" && bln_akhir == "") {
				$.messager.alert('SMART AIP','Pilih Bulan Awal dan Akhir','warning'); 
				return false;
			}else if (bln_awal == "" && bln_akhir != "") {
				$.messager.alert('SMART AIP','Bulan Awal tidak boleh kosong','warning'); 
				return false;
			}else if (bln_awal != "" && bln_akhir == "") {
				$.messager.alert('SMART AIP','Bulan Akhir tidak boleh kosong','warning'); 
				return false;
			}

			if (bln_awal > bln_akhir && tahun_awal > tahun_akhir) {
				$.messager.alert('SMART AIP','Bulan Awal tidak boleh lebih besar dari bulan akhir','warning'); 
				return false;
			}

			if (tahun_awal == "" && tahun_akhir == "") {
				$.messager.alert('SMART AIP','Pilih Tahun Awal dan Akhir','warning'); 
				return false;
			}else if (tahun_awal == "" && tahun_akhir != "") {
				$.messager.alert('SMART AIP','Tahun Awal tidak boleh kosong','warning'); 
				return false;
			}else if (tahun_awal != "" && tahun_akhir == "") {
				$.messager.alert('SMART AIP','Tahun Akhir tidak boleh kosong','warning'); 
				return false;
			}

			$.LoadingOverlay("show");
			var urlpost = host+'dashboard-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'dashboard':ds,'detail_invest':detail_invest,'id_bulan':id_bulan,'bln_awal':bln_awal,'bln_akhir':bln_akhir,'tahun_awal':tahun_awal,'tahun_akhir':tahun_akhir, [csrf_token]:csrf_hash  }, function(resp){
				$('.content-dashboard').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-dashboard-perubahandanabersih":
		case "index-dashboard-aruskas":
			if (iduser == "") {
				$.messager.alert('SMART AIP','Pilih User','warning'); 
				return false;
			}
			if (submodulnya == 'index-dashboard-perubahandanabersih') {
				if (jns_lap == "") {
					$.messager.alert('SMART AIP','Pilih Jenis Detail','warning'); 
					return false;
				}
			}
			if (bln_awal == "" && bln_akhir == "") {
				$.messager.alert('SMART AIP','Pilih Bulan Awal dan Akhir','warning'); 
				return false;
			}else if (bln_awal == "" && bln_akhir != "") {
				$.messager.alert('SMART AIP','Bulan Awal tidak boleh kosong','warning'); 
				return false;
			}else if (bln_awal != "" && bln_akhir == "") {
				$.messager.alert('SMART AIP','Bulan Akhir tidak boleh kosong','warning'); 
				return false;
			}

			if (bln_awal > bln_akhir && tahun_awal > tahun_akhir) {
				$.messager.alert('SMART AIP','Bulan Awal tidak boleh lebih besar dari bulan akhir','warning'); 
				return false;
			}

			if (tahun_awal == "" && tahun_akhir == "") {
				$.messager.alert('SMART AIP','Pilih Tahun Awal dan Akhir','warning'); 
				return false;
			}else if (tahun_awal == "" && tahun_akhir != "") {
				$.messager.alert('SMART AIP','Tahun Awal tidak boleh kosong','warning'); 
				return false;
			}else if (tahun_awal != "" && tahun_akhir == "") {
				$.messager.alert('SMART AIP','Tahun Akhir tidak boleh kosong','warning'); 
				return false;
			}

			$.LoadingOverlay("show");
			var urlpost = host+'dashboard-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'dashboard':ds,'jns_lap':jns_lap,'detail_invest':detail_invest,'id_bulan':id_bulan,'bln_awal':bln_awal,'bln_akhir':bln_akhir,'tahun_awal':tahun_awal,'tahun_akhir':tahun_akhir, [csrf_token]:csrf_hash  }, function(resp){
				$('.content-dashboard').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		case "index-aspek-operasional":
		case "index-aspek-belanja":
			if (iduser == "") {
				$.messager.alert('SMART AIP','Pilih User','warning'); 
				return false;
			}

			$.LoadingOverlay("show");
			var urlpost = host+'dashboard-index/'+modulnya;
			$.post(urlpost, {'iduser':iduser,'tahun_awal':tahun_awal, [csrf_token]:csrf_hash  }, function(resp){
				$('.content-dashboard').html(resp);
				$.LoadingOverlay("hide", true);
			});
		break;

		
	}
}


function remove_row_div(mod,param){
	switch(mod){
		case "aruskas_div":
			$('#aruskas_div_'+param).remove();
			idx_row_div--;
		break;
		case "pembayaran_pensiun_aip":
			$('#pembayaran_div_'+param).remove();
			idx_row_div--;
		break;
		case "pembayaran_pensiun_aip_depan":
			$('#pembayaran_div_depan_'+param).remove();
			idx_row_div--;
		break;
	}
}

function change_div(mod,param1,param2) {
	switch(mod){
		case "pembayaran_pensiun_aip":
			var cbg = $('.opt_cabang_'+param1).val();
			console.log(cbg);
			$('.cabang_'+param1).val(cbg)
		break;
		case "pembayaran_pensiun_aip_depan":
			var cbg = $('.opt_cabang_dpn_'+param1).val();
			console.log(cbg);
			$('.cabang_dpn_'+param1).val(cbg)
		break;
	}
}

function tambah_row_div(mod,param){
	html = "";
	switch(mod){
		case "aruskas_div":
			idx_row_div++;
			// console.log(idx_row_div);
			parsing = JSON.parse(param); 
			console.log(parsing);
			for (i=0; i<parsing.length; i++){
				if(i%2 == 0){
					var bgcolor = '#fff';
				}else{
					var bgcolor = '#F6F6F6';
				}
				html += '<div class="aruskas_div" id="aruskas_div_'+idx_row_div+'" idx="'+idx_row_div+'" style="border:1px solid #F0F0F0;padding:0px;background-color:'+bgcolor+'">';
				html += '	<div class="row">';
				html += '		<div class="col-md-4">';
				html += '			<div class="form-group">';
				html += '				<label>&nbsp;</label>';
				html += '				<select id="id_aruskas_'+idx_row_div+'" idx="'+idx_row_div+'" name="id_aruskas[]" class="form-control id_aruskas select2nya">';
				html += 					data_aruskas;
				// html += '				<option value="'+parsing[i].id+'" selected="selected">'+parsing[i].txt+'</option>';
				html += '				</select>';
				html += '			</div>';
				html += '		</div>';
				html += '		<div class="col-md-4">';
				html += '			<div class="form-group">';
				html += '				<label>&nbsp;</label>';
				html += '				<input type="text" name="saldo_bulan_berjalan[]" id="saldo_bulan_berjalan_'+idx_row_div+'" class="form-control  saldo_bulan_berjalan">';
				html += '			</div>';
				html += '		</div>';
				html += '		<div class="col-md-4">';
				html += '			<div class="form-group">';
				html += '				<label>&nbsp;</label>';
				html += '				<input type="text" name="saldo_bulan_lalu[]" class="form-control format_number saldo_bulan_lalu" id="saldo_bulan_lalu'+idx_row_div+'" />';
				html += '			</div>';
				html += '		</div>';
				// html += '		<div class="col-md-1 text-right" style="padding-top:23px;">';
				// html += '			<a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="remove_row_div(\''+mod+'\', \''+idx_row_div+'\');"><i class="fa fa-times"></i></a>';
				// html += '		</div>';
				html += '	</div>';
				html += '</div>';
			}
		break;
		case "pembayaran_pensiun_aip":
			idx_row_div++;
			// console.log(idx_row_div);
			
			if(idx_row_div%2 == 0){
				var bgcolor = '#fff';
			}else{
				var bgcolor = '#F6F6F6';
			}

			html += '<div class="pembayaran_div" id="pembayaran_div_'+idx_row_div+'" idx="'+idx_row_div+'" style="border:1px solid #F0F0F0;padding:0px;background-color:'+bgcolor+'">';
			html += '<div class="row" style="margin-top:15px;">';
			html += '	<div class="col-md-3">';
			html += '		<div class="form-group">';
			html += '			<label>Cabang<font color="red">&nbsp;*</font></label>';
			html += '			<select class="form-control select2nya opt_cabang_'+idx_row_div+'" id="opt_cabang_'+idx_row_div+'" onChange="change_div(\''+mod+'\', \''+idx_row_div+'\',\''+$(this.value)+'\');">';
			html +=              cabang;
			html += '			</select>';
			html += '			<label class="validation_error_message" for="semester"></label>'; 
			html += '		</div>';
			html += '	</div>';
			html += '	<div class="col-md-8 text-left" style="padding-top:23px; align:right">';
			html += '	</div>';
			html += '	<div class="col-md-1 text-left" style="padding-top:23px; align:right">';
			html += '		<a href="javascript:void(0);" class="btn btn-danger btn-sm btn-circle" onclick="remove_row_div(\''+mod+'\', \''+idx_row_div+'\');"><i class="fa fa-times"></i></a>';
			html += '	</div>';
			html += '</div>';
			html += '<div class="row">';
			html += '	<div class="col-md-3">';
			html += '		<label>Jenis Penerima</font></label>';
			html += '	</div>';
			html += '	<div class="col-md-3">';
			html += '		<label>Jumlah Penerima<font color="red">&nbsp;*</font></label>';
			html += '	</div>';
			html += '	<div class="col-md-3">';
			html += '		<label>Jumlah Pembayaran<font color="red">&nbsp;*</font></label>';
			html += '	</div>';
			html += '</div>';

			for (i=0; i<param.length; i++){
				html += '<div class="row">';
				html += '	<div class="col-md-3">';
				html += '		<div class="form-group">';
				html += '			<input type="hidden" id="cabang_'+idx_row_div+'" class="form-control cabang_'+idx_row_div+'" name="cabang[]" >';
				html += '			<input type="hidden" class="form-control idx="'+i+'" id_penerima_cbg_'+i+'" name="id_penerima_cbg[]" value="'+param[i].id+'">';
				html += '			<input type="text" class="form-control jenis_penerima" id="jenis_penerima_'+i+'" idx="'+i+'" value="'+param[i].txt+'" disabled="disabled"/>';	
				html += '		</div>';
				html += '	</div>';
				html += '	<div class="col-md-3">';
				html += '		<div class="form-group">';
				html += '			<input type="text" name="jml_penerima[]" class="form-control jml_penerima format_number" id="jml_penerima_'+i+'" idx="'+i+'" placeholder="Jumlah (Penerima)"/>';
				html += '		</div>';
				html += '	</div>';
				html += '	<div class="col-md-3">';
				html += '		<div class="form-group">';
				html += '			<input type="text" name="jml_pembayaran[]" class="form-control jml_pembayaran format_number" id="jml_pembayaran_'+i+'" idx="'+i+'" value="" placeholder="Jumlah (Pembayaran)"/>	';
				html += '		</div>';
				html += '	</div>';
				html += '</div>';
			}
			html += '</div>';

			
		break;
	}
	
	$('#'+mod).append(html);
	$(".select2nya").select2({ 'width':'100%' });
	$('.format_number').number(true, 0, ',', '.');

	
}

function tambah_row_semester(mod,param,param2){
	var tr_tbl;
	var no;
	switch(mod){
		case "nilai_tunai":
			no = idx_row;
			idx_row++;
			tr_tbl += '<tr class="tr_inv_" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_tbl += '<td width="8%" class="text-center">';
			tr_tbl += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" />';
			tr_tbl += '</td>';
			tr_tbl += '<td width="15%" class="text-center">';
			tr_tbl += '<select id="cabang_'+idx_row+'" idx="'+idx_row+'" name="cabang[]" class="form-control cabang select2nya">';
			tr_tbl += data_cabang;
			tr_tbl += '</select>';
			tr_tbl += '</td>';
			tr_tbl += '<td width="36%">';
			tr_tbl += '<input type="text" name="jml_penerima[]" class="form-control jml_penerima format_number" id="jml_penerima_'+idx_row+'" style="width:100%"/>';
			tr_tbl += '</td>';
			tr_tbl += '<td width="36%">';
			tr_tbl += '<input type="text" name="jml_pembayaran[]" class="form-control jml_pembayaran format_number" id="jml_pembayaran_'+idx_row+'" style="width:100%"/>';
			tr_tbl += '</td>';
			tr_tbl +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_tbl += '</tr>';
		break;
		case "lkob_klaim":
			no = idx_row;
			idx_row++;
			tr_tbl += '<tr class="tr_inv_" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_tbl += '<td width="8%" class="text-center">';
			tr_tbl += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" />';
			tr_tbl += '</td>';
			tr_tbl += '<td width="15%" class="text-center">';
			tr_tbl += '<select id="cabang_'+idx_row+'" idx="'+idx_row+'" name="cabang[]" class="form-control cabang select2nya">';
			tr_tbl += data_cabang;
			tr_tbl += '</select>';
			tr_tbl += '</td>';
			tr_tbl += '<td width="36%">';
			tr_tbl += '<input type="text" name="jml_klaim[]" class="form-control jml_klaim format_number" id="jml_klaim_'+idx_row+'" style="width:100%"/>';
			tr_tbl += '</td>';
			tr_tbl += '<td width="36%">';
			tr_tbl += '<input type="text" name="jml_pembayaran[]" class="form-control jml_pembayaran format_number" id="jml_pembayaran_'+idx_row+'" style="width:100%"/>';
			tr_tbl += '</td>';
			tr_tbl +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_tbl += '</tr>';
		break;
	}


	$('.'+mod).append(tr_tbl);
	$(".select2nya").select2({ 'width':'100%' });
	$('.format_number').number(true, 0, ',', '.');
}

function tambah_row(mod,param,param2){
	var tr_table;
	var no;
	
	
	switch(mod){
		case "form_master_investasi":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv_" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="10%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut_sub[]" class="form-control" id="no_urut_sub_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="85%">';
			tr_table += '<input type="text" name="jenis_investasi_sub[]" class="form-control jenis_investasi_sub" id="jenis_investasi_sub_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_master_nama_pihak":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv_" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="85%">';
			tr_table += '<select id="jns_invest_'+idx_row+'" idx="'+idx_row+'" name="jns_invest[]" class="form-control jns_invest select2invest">';
			tr_table += invest;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;

		// FORM ASET BUKAN INVESTASI
		// jns form = 10
		case "form_bkn_investasi_1":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_bkn_1" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_10 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_10 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_10 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="20%" class="saldo_akhir">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_10 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_bkn_investasi_bln_lalu_1":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_bkn_1" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu">';
				// tr_table += data_pihak;
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_10 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_10 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_10 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="20%" class="saldo_akhir">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_10 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';

			}
		break;
		// jns form = 11
		case "form_bkn_investasi_2":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_bkn_2" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_11 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_11 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_11 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_11  negative negative_'+idx_row+'" id="mutasi_amortisasi_'+idx_row+'" placeholder="mutasi amortisasi"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_11 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_bkn_investasi_bln_lalu_2":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_bkn_2" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu" readonly>';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_11 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_11 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_11 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_11  negative negative_'+idx_row+'" id="mutasi_amortisasi_'+idx_row+'" placeholder="mutasi amortisasi"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_11 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;

		// FORM ASET INVESTASI
		case "form_investasi_1":
			no = idx_row;
			idx_row++;
			// console.log(idx_row);
			tr_table += '<tr class="tr_inv form_1" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control no_urut" id="no_urut_'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<select id="cabang_'+idx_row+'" idx="'+idx_row+'" name="cabang[]" class="form-control cabang select2invest">';
			tr_table += cabang;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="bunga[]" class="form-control bunga_1 percent percent_'+idx_row+'" id="bunga_'+idx_row+'" placeholder="bunga"/>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_1 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="mutasi_penanaman[]" class="form-control jml_mutasi_penanaman_1 format_number" id="mutasi_penanaman_'+idx_row+'" placeholder="mutasi penanaman" />';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="mutasi_pencairan[]" class="form-control jml_mutasi_pencairan_1 negative negative_'+idx_row+'" id="mutasi_pencairan_'+idx_row+'" placeholder="mutasi pencairan"/>';
			tr_table += '</td>';
			tr_table += '<td width="20%" class="saldo_akhir">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_1 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_1":
			parsing = JSON.parse(param); 
			no = idx_row;
			idx_row++;
			for (i=0; i<parsing.length; i++){
				tr_table += '<tr class="tr_inv form_1" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu">';
				// tr_table += data_pihak;
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<select id="cabang_'+idx_row+'" idx="'+idx_row+'" name="cabang[]" class="form-control cabang select2invest">';
				// tr_table += cabang;
				tr_table += '<option value="'+parsing[i].cabang+'">'+parsing[i].nama_cabang+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="bunga[]" class="form-control bunga_1 percent percent_'+idx_row+'" id="bunga_'+idx_row+'" value="'+parsing[i].bunga+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_1 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="mutasi_penanaman[]" class="form-control jml_mutasi_penanaman_1 format_number" id="mutasi_penanaman_'+idx_row+'" placeholder="mutasi penanaman"/>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="mutasi_pencairan[]" class="form-control jml_mutasi_pencairan_1 negative negative_'+idx_row+'"" id="mutasi_pencairan_'+idx_row+'" placeholder="mutasi pencairan"/>';
				tr_table += '</td>';
				tr_table += '<td width="20%" class="saldo_akhir">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_1 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';

				// $('#cabang_'+idx_row).val(parsing[i].cabang).change();
				// console.log(parsing[i].cabang);
			}
		break;
		case "form_investasi_2":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_2" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" placeholder="no urut" />';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_2" id="nama_reksadana_'+idx_row+'" placeholder="nama"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_2 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_2 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'" placeholder="rate"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_2 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_2 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_2 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_2 negative negative_'+idx_row+'" id="mutasi_amortisasi_'+idx_row+'" placeholder="mutasi amortisasi" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_2 negative negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_2 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_2":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_2" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu" readonly>';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_2" id="nama_reksadana_'+idx_row+'" value="'+parsing[i].nama_reksadana+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_2 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'"  value="'+parsing[i].tgl_jatuh_tempo+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_2 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'"  value="'+parsing[i].r_kupon+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_2 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_2 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_2 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_2 negative negative_'+idx_row+'" id="mutasi_amortisasi_'+idx_row+'" placeholder="mutasi amortisasi"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_2 negative negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_2 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;
		case "form_investasi_3":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_3" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="nilai_perolehan[]" class="form-control nilai_perolehan_3 rupiah" id="nilai_perolehan_'+idx_row+'" placeholder="nilai perolehan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_3 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_3 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_3 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_3 negative negative_'+idx_row+'"" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_3 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="lembar_saham[]" class="form-control lembar_saham_3" id="lembar_saham_'+idx_row+'" placeholder="lembar saham"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="nilai_kapitalisasi_pasar[]" class="form-control nilai_kapitalisasi_pasar_3 format_number" id="nilai_kapitalisasi_pasar_'+idx_row+'" placeholder="Nilai Kapitalisasi Pasar"/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_3":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_3" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu">';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="nilai_perolehan[]" class="form-control nilai_perolehan_3 rupiah" id="nilai_perolehan_'+idx_row+'" value="'+parsing[i].nilai_perolehan+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_3 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_3 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_3 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_3 negative negative_'+idx_row+'"" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_3 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="lembar_saham[]" class="form-control lembar_saham_3" id="lembar_saham_'+idx_row+'" placeholder="lembar saham"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="nilai_kapitalisasi_pasar[]" class="form-control nilai_kapitalisasi_pasar_3 format_number" id="nilai_kapitalisasi_pasar_'+idx_row+'" placeholder="Nilai Kapitalisasi Pasar"/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;

		case "form_investasi_4":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_4" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control no_urut_4" id="no_urut_'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			// tr_table += '<td width="10%">';
			// tr_table += '<input type="text" name="manager_investasi[]" class="form-control manager_investasi_4" id="manager_investasi_'+idx_row+'" />';
			// tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_4" id="nama_reksadana_'+idx_row+'" placeholder="nama reksadana"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nilai_perolehan[]" class="form-control format_number nilai_perolehan_4" id="nilai_perolehan_'+idx_row+'" placeholder="nilai perolehan"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control format_number saldo_awal_4" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number jml_mutasi_pembelian_4" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control negative jml_mutasi_penjualan_4 negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_diskonto[]" class="form-control negative_'+idx_row+' jml_mutasi_diskonto_4" id="mutasi_diskonto_'+idx_row+'" placeholder="mutasi diskonto"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control negative_'+idx_row+' jml_mutasi_pasar_4" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number saldo_akhir_4" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="jml_unit_penyertaan[]" class="form-control jml_unit_penyertaan_4 format_number" id="jml_unit_penyertaan_'+idx_row+'" placeholder="jumlah unit"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nilai_dana_kelolaan[]" class="form-control nilai_dana_kelolaan_4 format_number" id="nilai_dana_kelolaan_'+idx_row+'" placeholder="Nilai Dana Kelolaan"/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_4":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_4" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control no_urut_4" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				// tr_table += '<td width="10%">';
				// tr_table += '<input type="text" name="manager_investasi[]" class="form-control manager_investasi_4" id="manager_investasi_'+idx_row+'" value="'+parsing[i].manager_investasi+'" readonly/>';
				// tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu">';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_4" id="nama_reksadana_'+idx_row+'" value="'+parsing[i].nama_reksadana+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nilai_perolehan[]" class="form-control format_number nilai_perolehan_4" id="nilai_perolehan_'+idx_row+'" value="'+parsing[i].nilai_perolehan+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_4 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number jml_mutasi_pembelian_4" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control negative jml_mutasi_penjualan_4 negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_diskonto[]" class="form-control negative_'+idx_row+' jml_mutasi_diskonto_4" id="mutasi_diskonto_'+idx_row+'" placeholder="mutasi diskonto"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control negative_'+idx_row+' jml_mutasi_pasar_4" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number saldo_akhir_4" id="saldo_akhir_'+idx_row+'"  placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="jml_unit_penyertaan[]" class="form-control jml_unit_penyertaan_4 format_number" id="jml_unit_penyertaan_'+idx_row+'" placeholder="jumlah unit"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nilai_dana_kelolaan[]" class="form-control nilai_dana_kelolaan_4 format_number" id="nilai_dana_kelolaan_'+idx_row+'" placeholder="Nilai Dana Kelolaan"/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;
		case "form_investasi_5":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_5" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control format_number saldo_awal_5" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number jml_mutasi_pembelian_5" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control negative jml_mutasi_penjualan_5 negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control negative_'+idx_row+' jml_mutasi_pasar_5" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number saldo_akhir_5" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="lembar_saham[]" class="form-control jml_lembar_saham_5" id="lembar_saham_'+idx_row+'" placeholder="lembar saham"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="harga_saham[]" class="form-control rupiah harga_saham_5" id="harga_saham_'+idx_row+'" placeholder="harga saham" readonly/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="persentase[]" class="form-control persentase_5 percent percent_'+idx_row+'" id="persentase_'+idx_row+'" placeholder="persentase"/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_5":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_5" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu">';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_5 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number jml_mutasi_pembelian_5" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control negative jml_mutasi_penjualan_5 negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control negative_'+idx_row+' jml_mutasi_pasar_5" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number saldo_akhir_5" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="lembar_saham[]" class="form-control jml_lembar_saham_5" id="lembar_saham_'+idx_row+'" placeholder="lembar saham"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="harga_saham[]" class="form-control format_number harga_saham_5" id="harga_saham_'+idx_row+'" placeholder="harga saham" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="persentase[]" class="form-control persentase_5 percent percent_'+idx_row+'" id="persentase_'+idx_row+'" placeholder="persentase"/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;

		case "form_investasi_6":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_6" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_6 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_6 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_6 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_nilai_wajar[]" class="form-control jml_mutasi_nilai_wajar_6 negative_'+idx_row+'" id="mutasi_nilai_wajar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_6 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_6":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_6" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu">';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_6 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_6 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_6 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_nilai_wajar[]" class="form-control jml_mutasi_nilai_wajar_6 negative_'+idx_row+'" id="mutasi_nilai_wajar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_6 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;

		case "form_investasi_7":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_7" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_7" id="nama_reksadana_'+idx_row+'" placeholder="nama"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="peringkat[]" class="form-control peringkat_7" id="peringkat_'+idx_row+'" placeholder="peringkat"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_7 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_7 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'" placeholder="rate"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_7 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_7 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_7 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_7 negative_'+idx_row+'" id="mutasi_amortisasi_'+idx_row+'" placeholder="mutasi amortisasi"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_7 negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_7 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_7":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_7" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu" readonly>';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_7" id="nama_reksadana_'+idx_row+'" value="'+parsing[i].nama_reksadana+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="peringkat[]" class="form-control peringkat_7" id="peringkat_'+idx_row+'" value="'+parsing[i].peringkat+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_7 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'"  value="'+parsing[i].tgl_jatuh_tempo+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_7 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'"  value="'+parsing[i].r_kupon+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_7 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_7 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_7 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_7 negative_'+idx_row+'" id="mutasi_amortisasi_'+idx_row+'" placeholder="mutasi amortisasi"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_7 negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_7 format_number" id="saldo_akhir_'+idx_row+'"  placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;

		case "form_investasi_8":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_8" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_8" id="nama_reksadana_'+idx_row+'" placeholder="nama"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="peringkat[]" class="form-control peringkat_8" id="peringkat_'+idx_row+'" placeholder="peringkat"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_8 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_8 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'" placeholder="rate"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_8 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_8 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_8 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_diskonto[]" class="form-control jml_mutasi_diskonto_8 negative_'+idx_row+'" id="mutasi_diskonto_'+idx_row+'" placeholder="mutasi diskonto"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_8 negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_8 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_8":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_8" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu" readonly>';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_8" id="nama_reksadana_'+idx_row+'" value="'+parsing[i].nama_reksadana+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="peringkat[]" class="form-control peringkat_8" id="peringkat_'+idx_row+'" value="'+parsing[i].peringkat+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_8 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'"  value="'+parsing[i].tgl_jatuh_tempo+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_8 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'"  value="'+parsing[i].r_kupon+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_8 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_8 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_8 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_diskonto[]" class="form-control jml_mutasi_diskonto_8 negative_'+idx_row+'" id="mutasi_diskonto_'+idx_row+'" placeholder="mutasi diskonto"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_8 negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_8 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;

		case "form_investasi_9":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_9" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" placeholder="no urut"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_4" id="nama_reksadana_'+idx_row+'" placeholder="nama"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="peringkat[]" class="form-control peringkat_9" id="peringkat_'+idx_row+'" placeholder="peringkat"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_9 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_9 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'" placeholder="rate"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_9 format_number" id="saldo_awal_'+idx_row+'" placeholder="saldo awal"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_9 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_9 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_9 negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_9 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_9":
			parsing = JSON.parse(param); 
				no = idx_row;
				idx_row++;
			for (i=0; i<parsing.length; i++){

				tr_table += '<tr class="tr_inv form_9" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu" readonly>';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nama_reksadana[]" class="form-control nama_reksadana_9" id="nama_reksadana_'+idx_row+'" value="'+parsing[i].nama_reksadana+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="peringkat[]" class="form-control peringkat_9" id="peringkat_'+idx_row+'" value="'+parsing[i].peringkat+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="tgl_jatuh_tempo[]" class="form-control tgl_jatuh_tempo_9 tanggalnya" id="tgl_jatuh_tempo_'+idx_row+'" value="'+parsing[i].tgl_jatuh_tempo+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="r_kupon[]" class="form-control r_kupon_9 percent percent_'+idx_row+'" id="r_kupon_'+idx_row+'" value="'+parsing[i].r_kupon+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_9 negative negative_'+idx_row+'" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_9 format_number" id="mutasi_pembelian_'+idx_row+'" placeholder="mutasi pembelian"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_9 negative negative_'+idx_row+'" id="mutasi_penjualan_'+idx_row+'" placeholder="mutasi penjualan"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_9 negative_'+idx_row+'" id="mutasi_pasar_'+idx_row+'" placeholder="mutasi kenaikan/penurunan"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_9 format_number" id="saldo_akhir_'+idx_row+'" placeholder="saldo akhir" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;
	}
	
	$('.'+mod).append(tr_table);
	$('.tanggalnya').datepicker({ 
		format: 'dd-mm-yyyy',
		todayHighlight:'TRUE',
		autoclose: true,

	});

	$(document).ready(function(){

		console.log(idx_row);
		new AutoNumeric.multiple('.negative_'+idx_row, {
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			decimalPlaces: 0,
			negativeSignCharacter: "-",
			maximumValue:99999999999999999999,
			minimumValue:-99999999999999999999

		});

		new AutoNumeric.multiple('.percent_'+idx_row, {
			alwaysAllowDecimalCharacter: true,
			decimalCharacter: ",",
			digitGroupSeparator: ".",
			suffixText: "%",
			decimalPlacesShownOnFocus: 2,
			unformatOnSubmit: true,
		});

		// $('.negative').keyup(function(){
		// 	let v = $(this).val();
		// 	const neg = v.startsWith('-');

		// 	v = v.replace(/[-\D]/g,'');

		// 	v = v != ''?''+v:'';
		// 	if(neg) v = '-'.concat(v);

		// 	$(this).val(v);
		// });

		// $('.negative').each(function(){
			
		// });


		// new AutoNumeric.multiple('.format_number', AutoNumeric.getPredefinedOptions().float);
		// new AutoNumeric.multiple('.format_number', AutoNumeric.getPredefinedOptions().float,{
		// 	allowDecimalPadding: false,
		// 	digitGroupSeparator: ".",
		// 	decimalPlaces: 0,
		// });

		// $('.format_number').number(true,0);
		$('.rupiah').number(true,0);
		$('.format_number').number(true, 0, ',', '.');
		$(".select2invest").select2({'width' : '100%'});
		$(".combo-bln-lalu").select2({'width' : '100%'});
		$(".combo-bln-lalu").attr('readonly',true);

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

		$(".form_bkn_1").on("keyup", function(){
			calculateInvestasiFormBkn1();
		});

		$(".form_bkn_2").on("keyup", function(){
			calculateInvestasiFormBkn2();
		});

		// calculateInvestasi();
	});

	

	// $(".tr_inv").on("keyup", function(){
	// 	var saldoawal_head = 0;
	// 	var mutasi_head = 0;
	// 	var saldoakhir_head = 0;
	// 	$(this).each(function () {
	// 		var val1 = 0;
	// 		var val2 = 0;
	// 		var val3 = 0;
	// 		var total = 0;
	// 		var m_pem = 0;
	// 		var m_penj = 0;
 //            if (!isNaN(parseFloat($(this).find(".saldo_awal_1").val()))) {
 //                val1 = parseFloat($(this).find(".saldo_awal_1").val());
 //            }
 //            if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_1").val()))) {
 //                val2 = parseFloat($(this).find(".jml_mutasi_pembelian_1").val());
 //            }
 //            if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_1").val()))) {
 //                val3 = parseFloat($(this).find(".jml_mutasi_penjualan_1").val());
 //            }
 //            total = val1 + val2 + val3;
 //            $(this).find(".saldo_akhir_1").val(total.toFixed(2));

            
 //            $(".saldo_awal_1").each(function(i){      
 //            	saldoawal_head += parseFloat( $(this).val());  
 //            });
 //            $(".saldo_akhir_1").each(function(i){      
 //            	saldoakhir_head += parseFloat( $(this).val());  
 //            });
 //            $(".jml_mutasi_pembelian_1").each(function(i){      
 //            	m_pem += parseFloat( $(this).val());  
 //            });
 //            $(".jml_mutasi_penjualan_1").each(function(i){      
 //            	m_penj += parseFloat( $(this).val());  
 //            });
 //            mutasi_head = (m_pem + m_penj);
			
 //            // return saldoawal_head;
 //        });
		
	// 	// console.log(saldoawal_head);
 //        $("#saldo_awal_head").val(saldoawal_head.toFixed(2));
 //        $("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
 //        $("#mutasi_head").val(mutasi_head.toFixed(2));
        
        
	// });



	// $('.tr_inv').bind({
	// 	keyup:function(){ 
	// 		var saldoawal_head = 0;
	// 		var mutasi_head = 0;
	// 		var saldoakhir_head = 0;
	// 		$(this).each(function () {
	// 			var val1 = 0;
	// 			var val2 = 0;
	// 			var val3 = 0;
	// 			var total = 0;
	// 			var m_pem = 0;
	// 			var m_penj = 0;
	// 			if (!isNaN(parseFloat($(this).find(".saldo_awal_1").val()))) {
	// 				val1 = parseFloat($(this).find(".saldo_awal_1").val());
	// 			}
	// 			if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_1").val()))) {
	// 				val2 = parseFloat($(this).find(".jml_mutasi_pembelian_1").val());
	// 			}
	// 			if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_1").val()))) {
	// 				val3 = parseFloat($(this).find(".jml_mutasi_penjualan_1").val());
	// 			}
	// 			total = val1 + val2 + val3;
	// 			$(this).find(".saldo_akhir_1").val(total.toFixed(2));


	// 			$(".saldo_awal_1").each(function(i){      
	// 				saldoawal_head += parseFloat( $(this).val());  
	// 			});
	// 			$(".saldo_akhir_1").each(function(i){      
	// 				saldoakhir_head += parseFloat( $(this).val());  
	// 			});
	// 			$(".jml_mutasi_pembelian_1").each(function(i){      
	// 				m_pem += parseFloat( $(this).val());  
	// 			});
	// 			$(".jml_mutasi_penjualan_1").each(function(i){      
	// 				m_penj += parseFloat( $(this).val());  
	// 			});
	// 			mutasi_head = (m_pem + m_penj);

 //            // return saldoawal_head;
 //        });

	// 	// console.log(saldoawal_head);
	// 	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	// 	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	// 	$("#mutasi_head").val(mutasi_head.toFixed(2));

 //    	}
 //    });



	// $(".angka").maskMoney({
	// 	precision:0,
	// 	thousands:'.',
	// 	decimal:',',
	// 	allowZero: true, 
	// 	defaultZero: false
	// });

	
}

// ASET BUKAN INVESTASI
function calculateInvestasiFormBkn2(){
	// var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_bkn_2').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_amrt = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_11").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_11").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_11").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_11").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_11").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_11").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_amortisasi_11").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_amortisasi_11").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4;
		$(this).find(".saldo_akhir_11").val(total.toFixed(2));


		$(".saldo_awal_11").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_11").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_11").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_11").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_amortisasi_11").each(function(i){      
			m_amrt += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_amrt);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		// realisasi_head = ((saldoakhir_head/rka)*100);


    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	// $("#realisasi_head").val(realisasi_head.toFixed(2));

}

function calculateInvestasiFormBkn1(){
	// var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_bkn_1').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var total = 0;
		var m_penm = 0;
		var m_penc = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_10").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_10").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_10").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_10").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_10").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_10").val().replace(/\./g,''));
		}


		// console.log(val1);

		// hitung saldo akhir detail
		total = val1 + val2 - val3;
		$(this).find(".saldo_akhir_10").val(total.toFixed(2));


		$(".saldo_awal_10").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_10").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_10").each(function(i){      
			m_penm += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_10").each(function(i){      
			m_penc += parseFloat( $(this).val().replace(/\./g,''));  
		});

		// hitung saldo akhir header
		mutasi_head = (m_penm - m_penc);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		// realisasi_head = ((saldoakhir_head/rka)*100);
		

    });

	// console.log(saldoawal_head);
	
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	// $("#realisasi_head").val(realisasi_head.toFixed(2));
}

// ASET INVESATSI
function calculateInvestasiForm1(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	
	$('.form_1').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var total = 0;
		var m_penm = 0;
		var m_penc = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_1").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_1").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penanaman_1").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_penanaman_1").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pencairan_1").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_pencairan_1").val().replace(/\./g,''));
		}

		// console.log(val3);
		// hitung saldo akhir detail
		total = val1 + val2 - val3;
		$(this).find(".saldo_akhir_1").val(total.toFixed(2));


		$(".saldo_awal_1").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_1").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penanaman_1").each(function(i){      
			m_penm += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pencairan_1").each(function(i){      
			m_penc += parseFloat( $(this).val().replace(/\./g,''));  
		});

		// hitung saldo akhir header
		mutasi_head = (m_penm - m_penc);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;
		

    });

	// console.log(saldoawal_head);
	
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));
}

function calculateInvestasiForm2(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_2').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_amrt = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_2").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_2").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_2").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_2").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_2").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_2").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_amortisasi_2").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_amortisasi_2").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_2").val().replace(/\./g,'')))) {
			val5 = parseFloat($(this).find(".jml_mutasi_pasar_2").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4 + val5;
		$(this).find(".saldo_akhir_2").val(total.toFixed(2));


		$(".saldo_awal_2").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_2").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_2").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_2").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_amortisasi_2").each(function(i){      
			m_amrt += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pasar_2").each(function(i){      
			m_pasr += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_amrt + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;


    });

	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));

}


function calculateInvestasiForm3(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_3').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_amrt = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_3").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_3").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_3").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_3").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_3").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_3").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_3").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_pasar_3").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4;
		$(this).find(".saldo_akhir_3").val(total.toFixed(2));


		$(".saldo_awal_3").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_3").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_3").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_3").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pasar_3").each(function(i){      
			m_pasr += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;

    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));
}

function calculateInvestasiForm4(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_4').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_disk = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_4").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_4").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_4").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_4").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_4").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_4").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_diskonto_4").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_diskonto_4").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_4").val().replace(/\./g,'')))) {
			val5 = parseFloat($(this).find(".jml_mutasi_pasar_4").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4 + val5;
		$(this).find(".saldo_akhir_4").val(total.toFixed(2));


		$(".saldo_awal_4").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_4").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_4").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_4").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_diskonto_4").each(function(i){      
			m_disk += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pasar_4").each(function(i){      
			m_pasr += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_disk + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;


    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));

}


function calculateInvestasiForm5(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_5').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var hrg_saham = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_amrt = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_5").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_5").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_5").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_5").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_5").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_5").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_5").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_pasar_5").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_lembar_saham_5").val().replace(/\./g,'')))) {
			val5 = parseFloat($(this).find(".jml_lembar_saham_5").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4;
		$(this).find(".saldo_akhir_5").val(total.toFixed(2));

		hrg_saham = (total/val5);
		$(this).find(".harga_saham_5").val(hrg_saham.toFixed(2));

		$(".saldo_awal_5").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_5").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_5").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_5").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pasar_5").each(function(i){      
			m_pasr += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;

    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));
}

function calculateInvestasiForm6(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_6').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_amrt = 0;
		var m_nilw = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_6").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_6").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_6").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_6").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_6").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_6").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_nilai_wajar_6").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_nilai_wajar_6").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4;
		$(this).find(".saldo_akhir_6").val(total.toFixed(2));


		$(".saldo_awal_6").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_6").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_6").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_6").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_nilai_wajar_6").each(function(i){      
			m_nilw += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_nilw);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;

    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));
}

function calculateInvestasiForm7(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_7').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_amrt = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_7").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_7").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_7").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_7").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_7").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_7").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_amortisasi_7").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_amortisasi_7").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_7").val().replace(/\./g,'')))) {
			val5 = parseFloat($(this).find(".jml_mutasi_pasar_7").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4 + val5;
		$(this).find(".saldo_akhir_7").val(total.toFixed(2));


		$(".saldo_awal_7").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_7").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_7").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_7").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_amortisasi_7").each(function(i){      
			m_amrt += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pasar_7").each(function(i){      
			m_pasr += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_amrt + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;


    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));

}


function calculateInvestasiForm8(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_8').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_disk = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_8").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_8").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_8").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_8").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_8").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_8").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_diskonto_8").val().replace(/\./g,'')))) {
			val4 = parseFloat($(this).find(".jml_mutasi_diskonto_8").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_8").val().replace(/\./g,'')))) {
			val5 = parseFloat($(this).find(".jml_mutasi_pasar_8").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val4 + val5;
		$(this).find(".saldo_akhir_8").val(total.toFixed(2));


		$(".saldo_awal_8").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_8").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_8").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_8").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_diskonto_8").each(function(i){      
			m_disk += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pasar_8").each(function(i){      
			m_pasr += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_disk + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;


    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));

}

function calculateInvestasiForm9(){
	var rka = $('#rka').val();
	var saldoawal_head = 0;
	var mutasi_head = 0;
	var saldoakhir_head = 0;
	var realisasi_head = 0;
	$('.form_9').each(function () {
		var val1 = 0;
		var val2 = 0;
		var val3 = 0;
		var val4 = 0;
		var val5 = 0;
		var total = 0;
		var m_pem = 0;
		var m_penj = 0;
		var m_disk = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_9").val().replace(/\./g,'')))) {
			val1 = parseFloat($(this).find(".saldo_awal_9").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_9").val().replace(/\./g,'')))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_9").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_9").val().replace(/\./g,'')))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_9").val().replace(/\./g,''));
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_9").val().replace(/\./g,'')))) {
			val5 = parseFloat($(this).find(".jml_mutasi_pasar_9").val().replace(/\./g,''));
		}
		total = val1 + val2 - val3 + val5;
		$(this).find(".saldo_akhir_9").val(total.toFixed(2));


		$(".saldo_awal_9").each(function(i){      
			s_awal += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".saldo_akhir_9").each(function(i){      
			s_akhir += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pembelian_9").each(function(i){      
			m_pem += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_penjualan_9").each(function(i){      
			m_penj += parseFloat( $(this).val().replace(/\./g,''));  
		});
		$(".jml_mutasi_pasar_9").each(function(i){      
			m_pasr += parseFloat( $(this).val().replace(/\./g,''));  
		});

		mutasi_head = (m_pem - m_penj + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		if(isNaN(realisasi_head)) realisasi_head = 0;


    });

	// console.log(saldoawal_head);
	$("#saldo_awal_head").val(saldoawal_head.toFixed(2));
	$("#saldo_akhir_head").val(saldoakhir_head.toFixed(2));
	$("#mutasi_head").val(mutasi_head.toFixed(2));
	$("#realisasi_head").val(realisasi_head.toFixed(2));

}


function NumberFormat(value) {
	
    var jml= new String(value);
    if(jml=="null" || jml=="NaN") jml ="0";
    jml1 = jml.split(","); 
    jml2 = jml1[0];
    amount = jml2.split("").reverse();

    var output = "";
    for ( var i = 0; i <= amount.length-1; i++ ){
        output = amount[i] + output;
        if ((i+1) % 3 == 0 && (amount.length-1) !== i)output = ',' + output;
    }
    //if(jml1[1]===undefined) jml1[1] ="00";
   // if(isNaN(output))  output = "0";
    return output; // + "." + jml1[1];
}

function cariDataTreeGridnya(type, acak){
	var post_search = {};
	switch(type){
		case "request_pengambilan":
		case "history_pengambilan":
		case "request_pengantaran":
		case "history_pengantaran":
		case "data_invoice":
		case "data_order":
		case "data_lain":
			post_search['kat_tgl'] = $('#kat_tgl_'+acak).val();
			post_search['date_start'] = $('#date_start_'+acak).val();
			post_search['date_end'] = $('#date_end_'+acak).val();
			post_search['kat'] = $('#kat_'+acak).val();
			post_search['key'] = $('#key_'+acak).val();
		break;
	}
	
	$('#grid_'+type).treegrid('reload', post_search);
}

function cariDataGridnya(type, acak){
	var post_search = {};
	switch(type){
		case "buku_tamu":
		case "data_kurir":
			post_search['kat_tgl'] = $('#kat_tgl_'+acak).val();
			post_search['date_start'] = $('#date_start_'+acak).val();
			post_search['date_end'] = $('#date_end_'+acak).val();
			post_search['kat'] = $('#kat_'+acak).val();
			post_search['key'] = $('#key_'+acak).val();
		break;
	}
	
	$('#grid_'+type).datagrid('reload', post_search);
}


function reloadTreeGridOrder(type, acak){
	var post_search = {};

	$('#kat_'+acak).prop('selectedIndex',0);
	$('#kat_tgl_'+acak).prop('selectedIndex',0);
	$('#date_start_'+acak).val('');
	$('#date_end_'+acak).val('');
	$('#key_'+acak).val('');
	
	$('#grid_'+type).treegrid('reload' ,post_search);
}


function reloadGridOrder(type, acak){
	var post_search = {};

	$('#kat_'+acak).prop('selectedIndex',0);
	$('#kat_tgl_'+acak).prop('selectedIndex',0);
	$('#date_start_'+acak).val('');
	$('#date_end_'+acak).val('');
	$('#key_'+acak).val('');

	
	$('#grid_'+type).datagrid('reload' ,post_search);
}

function submit_form(frm,func){
	var url = jQuery('#'+frm).attr("url");
   // $.messager.progress();
	jQuery('#'+frm).form('submit',{
            url:url,
            onSubmit: function(){
				var isValid = $(this).form('validate');
				if (!isValid){
					//$.messager.progress('close');	// hide progress bar while the form is invalid
				}
				return isValid;	
            },
            success:function(data){
                if (func == undefined ){
                     if (data == "1"){
                        pesan('Data Sudah Disimpan ','Sukses');
                    }else{
                         pesan(data,'Result');
                    }
                }else{
                    func(data);
                }
				//$.messager.progress('close');
            },
            error:function(data){
                 if (func == undefined ){
                     pesan(data,'Error');
                }else{
                    func(data);
                }
            }
    });
}


function openWindowWithPost(url,params){
    var newWindow = window.open(url, 'winpost'); 
    if (!newWindow) return false;
    var html = "";
    html += "<html><head></head><body><form  id='formid' method='post' action='" + url + "'>";

    $.each(params, function(key, value) { 
		if (value instanceof Array || value instanceof Object) {
			$.each(value, function(key1, value1) { 
				html += "<input type='hidden' name='" + key + "["+key1+"]' value='" + value1 + "'/>";
			});
		}else{
			html += "<input type='hidden' name='" + key + "' value='" + value + "'/>";
		}
    });
   
    html += "</form><script type='text/javascript'>document.getElementById(\"formid\").submit()</script></body></html>";
    newWindow.document.write(html);
    return newWindow;
}