function genGridResepsionis(modnya, divnya, lebarnya, tingginya, par1){
	if(lebarnya == undefined){
		lebarnya = getClientWidth()-250;
	}
	if(tingginya == undefined){
		tingginya = getClientHeight()-450;
	}

	var kolom ={};
	var frozen ={};
	var judulnya;
	var param={};
	var urlnya;
	var urlglobal="";
	var url_detil="";
	var post_detil={};
	var fitnya;
	var klik=false;
	var doble_klik=false;
	var pagesizeboy = 10;
	var singleSelek = true;
	var nowrap_nya = true;
	var footer=false;
	var row_number=true;
	var paging=true;
	
	switch(modnya){
		case "buku_tamu":
			judulnya = "";
			urlnya = "buku_tamu";
			fitnya = true;
			param=par1;
			row_number=true;
			frozen[modnya] = [	
				{field:'nama_tamu',title:'Nama Tamu',width:200, halign:'center',align:'left'},		
			];
			kolom[modnya] = [				
								
				{field:'nama_perusahaan',title:'Nama Perusahaan',width:190, halign:'center',align:'left'},				
				{field:'no_hp_tamu',title:'No Handphone',width:190, halign:'center',align:'left'},
				{field:'tujuan',title:'Tujuan',width:190, halign:'center',align:'left'},					
				{field:'bertemu_dengan',title:'Bertemu Dengan',width:190, halign:'center',align:'left'},					
				{field:'tanggal_datang',title:'Tanggal Kedatangan',width:190, halign:'center',align:'center'},					
				{field:'jam_datang',title:'Waktu Kedatangan',width:190, halign:'center',align:'center'},					
			];
		break;
		case "data_kurir":
			judulnya = "";
			urlnya = "data_kurir";
			fitnya = true;
			param=par1;
			row_number=false;
			frozen[modnya] = [	
				{field:'nama_lengkap',title:'Nama Kurir',width:200, halign:'center',align:'left'},		
			];
			kolom[modnya] = [								
				{field:'jml_tugas',title:'Jumlah Penugasan',width:190, halign:'center',align:'right'},								
			];
		break;
	}
	
	urlglobal = host+'resepsionis-data/'+urlnya;
	grid_nya_order = $("#"+divnya).datagrid({
		title:judulnya,
		height:tingginya,
		width:lebarnya,
		rownumbers:row_number,
		iconCls:'database',
		fit:fitnya,
		striped:true,
		pagination:paging,
		remoteSort: false,
		showFooter:footer,
		singleSelect:singleSelek,
		url: urlglobal,		
		nowrap: nowrap_nya,
		pageSize:pagesizeboy,
		pageList:[10,20,30,40,50,100,200],
		queryParams:param,
		frozenColumns:[
			frozen[modnya]
		],
		columns:[
			kolom[modnya]
		],
		onLoadSuccess:function(d){
			$('.btn_grid').linkbutton();
		},
		onClickRow:function(rowIndex,rowData){
			if(modnya=='ldap_user'){
				$('#user_ldap').val(rowData.samaccountname);
				$('#user_na').html(rowData.samaccountname);
				$('#nama_na').html(rowData.displayname);
			}
		},
		onDblClickRow:function(rowIndex,rowData){
			
		},
		toolbar: '#tb_'+modnya,
		rowStyler: function(index,row){
			if(modnya == 'list_work_order'){
				if(row.flag_opr){
					if (row.flag_opr == 0){
						return 'background-color:#FDF0C5;';
					}else if (row.flag_opr == 1){
						return 'background-color:#D6E2F3;';
					}
				}else{
					if(row.agent_cc != null){
						return 'background-color:#CDF8D6;'; //warna ijo toska staff AGENT
					}else{
						return 'background-color:#FFDDDD;'; // warna merah terang - staff BO
					} 
					
				}
				
			}else if(modnya == 'xxx'){
				
			}
			
		},
		onLoadSuccess: function(data){
			var $panel = $("#"+divnya).datagrid('getPanel');
			if(data.total == 0){
				var $info = '<div class="info-empty" style="margin-top:20%;">Data Tidak Tersedia</div>';
				$($panel).find(".datagrid-view").append($info);
			}else{
				$($panel).find(".datagrid-view").append('');
				$('.info-empty').remove();
			}
		},
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

function genTreeGridResepsionis(modnya, divnya, lebarnya, tingginya, par1){
	if(lebarnya == undefined){
		lebarnya = getClientWidth()-250;
	}
	if(tingginya == undefined){
		tingginya = getClientHeight()-110;
	}

	var kolom ={};
	var frozen ={};
	var judulnya;
	var param={};
	var urlnya;
	var urlglobal="";
	var url_detil="";
	var post_detil={};
	var fitnya;
	var klik=false;
	var doble_klik=false;
	var pagesizeboy = 10;
	var singleSelek = true;
	var nowrap_nya = true;
	var footer=false;
	var row_number=true;
	var paging=true;
	
	switch(modnya){
		case "request_pengambilan":
		case "history_pengambilan":
			judulnya = "";
			urlnya = modnya;
			fitnya = true;
			param=par1;
			row_number=false;
			nowrap_nya = false;
			frozen[modnya] = [
				{field:'no',title:'No.',width:70, halign:'center',align:'center'},					
				{field:'level',title:'No. Order Pengambilan',width:250, halign:'center',align:'left'},			
			];
			kolom[modnya] = [[
				{field:'no_order',title:'No. Order',width:150, halign:'center',align:'left'},
				{field:'status_data',title:'Status Data',width:150, halign:'center',align:'center',
					styler: function(value,row,index){
						if(value == 'PROSES'){
							return 'background-color:#65f68b';
						}else if(value == 'SELESAI'){
							return 'background-color:#61d1f6';
						}else if(value == 'REQUEST ADMIN'){
							return 'background-color:#f6c165';
						}
					}
				},					
				{field:'catatan',title:'Catatan',width:300, halign:'center',align:'left'},					
				{field:'status_antar',title:'Alamat Pengambilan',width:150, halign:'center',align:'left'},											
				{field:'nama_lengkap',title:'Kurir',width:150, halign:'center',align:'center'},					
				{field:'tanggal_order',title:'Tgl. Order Pengambilan',width:150, halign:'center',align:'center'},	
				{field:'tanggal_selesai',title:'Tgl. Selesai',width:150, halign:'center',align:'center'},					
			]];
		break;

		case "request_pengantaran":
		case "history_pengantaran":
			judulnya = "";
			urlnya = modnya;
			fitnya = true;
			param=par1;
			row_number=false;
			nowrap_nya = false;
			frozen[modnya] = [
				{field:'no',title:'No.',width:70, halign:'center',align:'center'},					
				{field:'level',title:'No. Order Pengantaran',width:250, halign:'center',align:'left'},			
			];
			kolom[modnya] = [[
				{field:'no_order',title:'No. Order',width:150, halign:'center',align:'left'},
				{field:'status_data',title:'Status Data',width:150, halign:'center',align:'center',
					styler: function(value,row,index){
						if(value == 'PROSES'){
							return 'background-color:#65f68b';
						}else if(value == 'SELESAI'){
							return 'background-color:#61d1f6';
						}else if(value == 'REQUEST ADMIN'){
							return 'background-color:#f6c165';
						}
					}
				},					
				{field:'catatan',title:'Catatan',width:300, halign:'center',align:'left'},					
				{field:'status_antar',title:'Alamat Pengantaran',width:150, halign:'center',align:'left'},											
				{field:'nama_kurir',title:'Kurir',width:150, halign:'center',align:'center'},					
				{field:'tanggal_order',title:'Tgl. Order Pengantaran',width:150, halign:'center',align:'center'},	
				{field:'tanggal_selesai',title:'Tgl. Selesai',width:150, halign:'center',align:'center'},							
			]];
		break;

		case "data_invoice":
			judulnya = "";
			urlnya = modnya;
			fitnya = true;
			param=par1;
			row_number=false;
			nowrap_nya = false;
			frozen[modnya] = [
				{field:'no',title:'No.',width:70, halign:'center',align:'center'},					
				{field:'level',title:'No. Pengantaran',width:250, halign:'center',align:'left'},			
			];
			kolom[modnya] = [[
				{field:'nama_perusahaan',title:'Nama Perusahaan/Klien',width:250, halign:'center',align:'left'},		
				{field:'jml_invoice',title:'Jumlah Invoice',width:150, halign:'center',align:'right'},					
				{field:'status_data',title:'Status',width:150, halign:'center',align:'left'},											
				{field:'nama_kurir',title:'Nama Kurir',width:150, halign:'center',align:'left'},					
				{field:'tgl_input',title:'Tgl. Input',width:150, halign:'center',align:'center'},	
				{field:'create_by',title:'Petugas Input',width:150, halign:'center',align:'left'},							
			]];

		break;

		case "data_order":
			judulnya = "";
			urlnya = modnya;
			fitnya = true;
			param=par1;
			row_number=false;
			nowrap_nya = false;
			frozen[modnya] = [
				{field:'no',title:'No.',width:70, halign:'center',align:'center'},					
				{field:'level',title:'No. Pengantaran',width:250, halign:'center',align:'left'},			
			];
			kolom[modnya] = [[
				// {field:'nama_perusahaan',title:'Nama Perusahaan/Klien',width:150, halign:'center',align:'left'},	
				{field:'no_order',title:'No. Order',width:150, halign:'center',align:'left'},						
				{field:'status_data',title:'Status',width:150, halign:'center',align:'left'},											
				{field:'nama_kurir',title:'Nama Kurir',width:150, halign:'center',align:'left'},					
				{field:'tgl_input',title:'Tgl. Input',width:150, halign:'center',align:'center'},	
				{field:'create_by',title:'Petugas Input',width:150, halign:'center',align:'left'},							
			]];

		break;

		case "data_lain":
			judulnya = "";
			urlnya = modnya;
			fitnya = true;
			param=par1;
			row_number=false;
			nowrap_nya = false;
			frozen[modnya] = [
				{field:'no',title:'No.',width:70, halign:'center',align:'center'},					
				{field:'level',title:'No. Pengantaran',width:250, halign:'center',align:'left'},			
			];
			kolom[modnya] = [[
				{field:'alamat_tujuan',title:'Alamat Tujuan',width:150, halign:'center',align:'left'},							
				{field:'keperluan',title:'Keperluan',width:150, halign:'center',align:'left'},							
				{field:'status_data',title:'Status',width:150, halign:'center',align:'left'},										
				{field:'nama_kurir',title:'Nama Kurir',width:150, halign:'center',align:'left'},					
				{field:'tgl_input',title:'Tgl. Input',width:150, halign:'center',align:'center'},	
				{field:'create_by',title:'Petugas Input',width:150, halign:'center',align:'left'},							
			]];

		break;
	}
	
	urlglobal = host+'resepsionis-data-tree/'+urlnya;
	grid_tree_order = $("#"+divnya).treegrid({
		title:judulnya,
		height:tingginya,
		width:lebarnya,
		url: urlglobal,
		rownumbers:row_number,
		nowrap: nowrap_nya,
		idField:'id',
		treeField:'level',
		remoteSort: false,
		singleSelect:singleSelek,
		collapsible:true,
		queryParams:param,
		pagination:paging,
		pageSize:pagesizeboy,
		pageList:[10,20,30,40,50,100,200],
		frozenColumns:[
			frozen[modnya]
		],
		columns:
			kolom[modnya]
		,
		onClickRow:function(row){
			
		},
		onDblClickRow:function(row){
			
		},
		rowStyler: function(row){
			if (modnya == "request_pengambilan"){
				if(row.tipe_level == 'Order Header'){
					return 'background-color:#FBEBBC;font-weight:bold;font-size:16px;';
				}
			}

			if (modnya == "history_pengambilan"){
				if(row.tipe_level == 'Order Header'){
					return 'background-color:#FBEBBC;font-weight:bold;font-size:16px;';
				}
			}

			if (modnya == "request_pengantaran"){
				if(row.tipe_level == 'Order Header'){
					return 'background-color:#FBEBBC;font-weight:bold;font-size:16px;';
				}
			}

			if (modnya == "history_pengantaran"){
				if(row.tipe_level == 'Order Header'){
					return 'background-color:#FBEBBC;font-weight:bold;font-size:16px;';
				}
			}

			if (modnya == "data_invoice" || modnya == "data_order" || modnya == "data_lain"){
				if(row.tipe_level == 'Order Header'){
					return 'background-color:#FBEBBC;font-weight:bold;font-size:16px;';
				}
			}
			
		},
		onLoadSuccess: function(row, data){
			//console.log(row);
			//console.log(data);
			var $panel = $("#"+divnya).datagrid('getPanel');
			if(data.rows == 0){
				var $info = '<div class="info-empty" style="margin-top:20%;">Data Tidak Tersedia</div>';
				$($panel).find(".datagrid-view").append($info);
			}else{
				$($panel).find(".datagrid-view").append('');
				$('.info-empty').remove();
			}
		},
	});
}

function genform(type, modulnya, submodulnya, stswindow, p1, p2, p3){
	var urlpostadd = host+'investasi-form/'+submodulnya;
	var urlpost = host+'investasi-form/'+submodulnya+'/'+p1+'/'+p2;
	var urldelete = host+'investasi-simpan/'+submodulnya;
	var id_tambahan = "";
	var nama_file = "";
	var table = submodulnya;
	var adafilenya = false;
	
	switch(submodulnya){
		case "dokumen": 
			
		break;
	}
	
	switch(type){
		case "add":
			$.post(urlpostadd+uri, {'editstatus':'add', 'ts':table, [csrf_token]:csrf_hash  }, function(resp){
				$('.content').html(resp);
			});
		break;
		case "edit":
		case "delete":			
			if(type=='edit'){
				$.LoadingOverlay("show");
				$.post(urlpost+uri, { 'editstatus':'edit', 'id':p1, 'jns_form':p2, 'ts':table, [csrf_token]:csrf_hash }, function(resp){
					
					$('.content').html(resp);
					$.LoadingOverlay("hide", true);
				});
			}else if(type=='delete'){
				$.messager.confirm('SMART AIP','Anda Yakin Ingin Menghapus Data Ini ?',function(re){
					if(re){

						$.LoadingOverlay("show");
						$.post(urldelete, {'id':p1, 'editstatus':'delete', [csrf_token]:csrf_hash }, function(r){
							if(r==1){
								$.LoadingOverlay("hide", true);
								$.messager.alert('SMART AIP',"Data Terhapus",'info');
								if(submodulnya == 'aset_investasi'){
									setTimeout(function(){
										window.location = host+'bulanan/aset_investasi'+uri;
									}, 1000);
								}
								if(submodulnya == 'aset_bukan_investasi'){
									setTimeout(function(){
										window.location = host+'bulanan/bukan_investasi'+uri;
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
	

		case "list_tugas":
		case "posisi_sekarang":
			var row = $("#grid_"+submodulnya).datagrid('getSelected');
			if(row){
				
				if(submodulnya == "data_invoice" || submodulnya == "data_order" || submodulnya == "data_lain"){
					if(row.tipe_level != 'Order Header'){
						$.messager.alert('PT. Biantara Jaya Services',"Harus di Level Order Header",'error');
						return false;
					}
				}

				$.LoadingOverlay("show");
				$('#modalencuk').html('');
				$.post(host+'resepsionis-form/'+type, { 'editstatus':'edit', 'ts':table, id:row.tbl_user_kurir_id }, function(resp){
					$('#headernya').html("<b>Pengantaran Kurir</b>");
					$('#modalencuk').html(resp);
					$('#pesanModal').modal('show');
					$.LoadingOverlay("hide", true);
				});
				
			}else{
				$.messager.alert('PT. Biantara Jaya Services',"Pilih Data Yang Akan Diproses",'error');
			}
		break;

		
		
	}
}

function remove_row_div_resepsionis(mod,param){
	switch(mod){
		case "bd_form_pengambilan":
			$('#tr_pengambilan_'+param).remove();
			idx_row_div--;
		break;
	}
}
function tambah_row_div_resepsionis(mod,param){
	html = "";
	switch(mod){
		case "bd_form_pengambilan":
			var no = idx_row_div;
			idx_row_div++;
			
			if(idx_row_div%2 == 0){
				var bgcolor = '#fff';
			}else{
				var bgcolor = '#F6F6F6';
			}
			
			html += '<div id="tr_pengambilan_'+idx_row_div+'" idx="'+idx_row_div+'" style="border:1px solid #F0F0F0;padding:10px;background-color:'+bgcolor+'">';
			html += '	<div class="row">';
			html += '		<div class="col-md-4">';
			html += '			<div class="form-group">';
			html += '				<label>Order </label> <select id="no_order_'+idx_row_div+'" idx="'+idx_row_div+'" name="no_order[]" class="form-control no_order select2nya"> </select>';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-2">';
			html += '			<div class="form-group">';
			html += '				<label>Dokumen </label> <input type="text" name="dokumen[]" id="dokumen_'+idx_row_div+'" class="form-control" autocomplete="off">';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-3">';
			html += '			<div class="form-group">';
			html += '				<label>Alamat </label> <input type="text" name="alamat[]" class="form-control" id="alamat'+idx_row_div+'" />';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-2">';
			html += '			<div class="form-group">';
			html += '				<label>Penerima </label> <input type="text" name="penerima[]" class="form-control" id="penerima'+idx_row_div+'" />';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-1 text-right" style="padding-top:23px;">';
			html += '			<a href="javascript:void(0);" class="btn btn-danger btn-circle" onclick="remove_row_div_resepsionis(\''+mod+'\', \''+idx_row_div+'\');"><i class="fa fa-times"></i></a>';
			html += '		</div>';
			html += '	</div>';
			html += '</div>';
		break;

		case "form_investasi_1":
			var no = idx_row_div;
			idx_row_div++;
			
			if(idx_row_div%2 == 0){
				var bgcolor = '#fff';
			}else{
				var bgcolor = '#F6F6F6';
			}
			
			html += '<div id="tr_pengambilan_'+idx_row_div+'" idx="'+idx_row_div+'" style="border:1px solid #F0F0F0;padding:10px;background-color:'+bgcolor+'">';
			html += '	<div class="row">';
			html += '		<div class="col-md-4">';
			html += '			<div class="form-group">';
			html += '				<label>Order </label> <select id="no_order_'+idx_row_div+'" idx="'+idx_row_div+'" name="no_order[]" class="form-control no_order select2nya"> </select>';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-2">';
			html += '			<div class="form-group">';
			html += '				<label>Dokumen </label> <input type="text" name="dokumen[]" id="dokumen_'+idx_row_div+'" class="form-control" autocomplete="off">';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-3">';
			html += '			<div class="form-group">';
			html += '				<label>Alamat </label> <input type="text" name="alamat[]" class="form-control" id="alamat'+idx_row_div+'" />';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-2">';
			html += '			<div class="form-group">';
			html += '				<label>Penerima </label> <input type="text" name="penerima[]" class="form-control" id="penerima'+idx_row_div+'" />';
			html += '			</div>';
			html += '		</div>';
			html += '		<div class="col-md-1 text-right" style="padding-top:23px;">';
			html += '			<a href="javascript:void(0);" class="btn btn-danger btn-circle" onclick="remove_row_div_resepsionis(\''+mod+'\', \''+idx_row_div+'\');"><i class="fa fa-times"></i></a>';
			html += '		</div>';
			html += '	</div>';
			html += '</div>';
		break;
	}
	
	$('#'+mod).append(html);
	$(".select2nya").select2({ 'width':'100%' });
	$(".angka").maskMoney({
		precision:0,
		thousands:'.',
		decimal:',',
		allowZero: true, 
		defaultZero: false
	});	
	
	$('.jenis_request').on('change', function(){
		var biaya_hpp = "";
		var idx = $(this).attr('idx');
		var layanan_id = $('#cl_layanan_id_'+idx).val();
		if($('#cl_layanan_id_'+idx).val() != ""){
			$.post(host+'order-display/layanan', { 'id':layanan_id, 'jenis_request':$(this).val(), 'idx':idx }, function(resp){
				if(resp){
					var parse = JSON.parse(resp);
					
					if($('#jenis_request_'+idx).val() == 'SQ'){
						biaya_hpp = parse.data.hpp_sq;
					}else if($('#jenis_request_'+idx).val() == 'EXPRESS'){
						biaya_hpp = parse.data.hpp_express;
					}else if($('#jenis_request_'+idx).val() == 'REGULAR'){
						biaya_hpp = parse.data.hpp_regular;
					}
					
					$('#biaya_kasbon_'+idx).val(NumberFormat(biaya_hpp));
					$('#detail_paket_'+idx).html(parse.html);
				}
				
			} );
		}else{
			$.messager.alert('PT. BJS - APPS','Pilih Layanan Terlebih Dahulu!','warning'); 
		}
	});
	$('.layanan').on('change', function(){
		var biaya_hpp = "";
		var idx = $(this).attr('idx');
		$.post(host+'order-display/layanan', { 'id':$(this).val() }, function(resp){
			if(resp){
				var parse = JSON.parse(resp);
				$('#input_tipe_layanan_'+idx).val(parse.data.tipe_layanan);
			}
		} );
	});
	
}

function tambah_row(mod,param,param2){
	var tr_table;
	var no;
	
	
	switch(mod){
		case "form_investasi_1":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_1" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_1 format_number" id="saldo_awal_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_1 format_number" id="mutasi_pembelian_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="20%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_1 format_number" id="mutasi_penjualan_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="20%" class="saldo_akhir">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_1 format_number" id="saldo_akhir_'+idx_row+'" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_1":
			parsing = JSON.parse(param); 
			for (i=0; i<parsing.length; i++){
				no = idx_row;
				idx_row++;

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
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_1 format_number" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_1 format_number" id="mutasi_pembelian_'+idx_row+'"';
				tr_table += '</td>';
				tr_table += '<td width="20%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_1 format_number" id="mutasi_penjualan_'+idx_row+'"';
				tr_table += '</td>';
				tr_table += '<td width="20%" class="saldo_akhir">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_1 format_number" id="saldo_akhir_'+idx_row+'" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';

			}
		break;
		case "form_investasi_2":
			no = idx_row;
			idx_row++;

			tr_table += '<tr class="tr_inv form_2" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
			tr_table += '<td width="5%" class="text-center">';
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_2 format_number" id="saldo_awal_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_2 format_number" id="mutasi_pembelian_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_2 format_number" id="mutasi_penjualan_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_2 format_number" id="mutasi_amortisasi_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_2 format_number" id="mutasi_pasar_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="15%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_2 format_number" id="saldo_akhir_'+idx_row+'" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_2":
			parsing = JSON.parse(param); 
			for (i=0; i<parsing.length; i++){
				no = idx_row;
				idx_row++;

				tr_table += '<tr class="tr_inv form_2" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut_'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak combo-bln-lalu" readonly>';
				tr_table += '<option value="'+parsing[i].kode_pihak+'">'+parsing[i].nama_pihak+'</option>';
				tr_table += '</select>';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_2 format_number" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_2 format_number" id="mutasi_pembelian_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_2 format_number" id="mutasi_penjualan_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control jml_mutasi_amortisasi_2 format_number" id="mutasi_amortisasi_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_2 format_number" id="mutasi_pasar_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="15%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_2 format_number" id="saldo_akhir_'+idx_row+'" readonly/>';
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
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_3 format_number" id="saldo_awal_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_3 format_number" id="mutasi_pembelian_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_3 format_number" id="mutasi_penjualan_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_3 format_number" id="mutasi_pasar_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="13%">';
			tr_table += '<input type="text" name="lembar_saham[]" class="form-control lembar_saham_3" id="lembar_saham_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_3 format_number" id="saldo_akhir_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_3":
			parsing = JSON.parse(param); 
			for (i=0; i<parsing.length; i++){
				no = idx_row;
				idx_row++;

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
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control saldo_awal_3 format_number" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control jml_mutasi_pembelian_3 format_number" id="mutasi_pembelian_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control jml_mutasi_penjualan_3 format_number" id="mutasi_penjualan_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control jml_mutasi_pasar_3 format_number" id="mutasi_pasar_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="13%">';
				tr_table += '<input type="text" name="lembar_saham[]" class="form-control lembar_saham_3" id="lembar_saham_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control saldo_akhir_3 format_number" id="saldo_akhir_'+idx_row+'" />';
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
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="manager_investasi[]" class="form-control" id="manager_investasi_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="nama_reksadana[]" class="form-control" id="nama_reksadana_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control format_number" id="saldo_awal_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number" id="mutasi_pembelian_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control format_number" id="mutasi_penjualan_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control format_number" id="mutasi_amortisasi_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control format_number" id="mutasi_pasar_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="jml_unit_reksadana[]" class="form-control" id="jml_unit_reksadana_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number" id="saldo_akhir_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_4":
			parsing = JSON.parse(param); 
			for (i=0; i<parsing.length; i++){
				no = idx_row;
				idx_row++;

				tr_table += '<tr class="tr_inv form_4" id="tr_inv_'+idx_row+'" idx="'+idx_row+'">';
				tr_table += '<td width="5%" class="text-center">';
				tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" value="'+parsing[i].no_urut+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="manager_investasi[]" class="form-control" id="manager_investasi_'+idx_row+'" value="'+parsing[i].manager_investasi+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="nama_reksadana[]" class="form-control" id="nama_reksadana_'+idx_row+'" value="'+parsing[i].nama_reksadana+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control format_number saldo_awal_4" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'"/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number jml_mutasi_pembelian_4" id="mutasi_pembelian_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control format_number jml_mutasi_penjualan_4" id="mutasi_penjualan_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_amortisasi[]" class="form-control format_number jml_mutasi_amortisasi_4" id="mutasi_amortisasi_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control format_number jml_mutasi_pasar_4" id="mutasi_pasar_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="jml_unit_reksadana[]" class="form-control jml_unit_reksadana_4" id="jml_unit_reksadana_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number saldo_akhir_4" id="saldo_akhir_'+idx_row+'" />';
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
			tr_table += '<input size="2" type="text" name="no_urut[]" class="form-control" id="no_urut'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<select id="nama_pihak_'+idx_row+'" idx="'+idx_row+'" name="nama_pihak[]" class="form-control nama_pihak select2invest">';
			tr_table += data_pihak;
			tr_table += '</select>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_awal[]" class="form-control format_number saldo_awal_5" id="saldo_awal_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number jml_mutasi_pembelian_5" id="mutasi_pembelian_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control format_number jml_mutasi_penjualan_5" id="mutasi_penjualan_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control format_number jml_mutasi_pasar_5" id="mutasi_pasar_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="lembar_saham[]" class="form-control jml_lembar_saham_5" id="lembar_saham_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="harga_saham[]" class="form-control format_number harga_saham_5" id="harga_saham_'+idx_row+'" readonly/>';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="persentase[]" class="form-control persentase_5" id="persentase_'+idx_row+'" />';
			tr_table += '</td>';
			tr_table += '<td width="10%">';
			tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number saldo_akhir_5" id="saldo_akhir_'+idx_row+'" readonly/>';
			tr_table += '</td>';
			tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
			tr_table += '</tr>';
		break;
		case "form_investasi_bln_lalu_5":
			parsing = JSON.parse(param); 
			for (i=0; i<parsing.length; i++){
				no = idx_row;
				idx_row++;

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
				tr_table += '<input type="text" name="saldo_awal[]" class="form-control format_number saldo_awal_5" id="saldo_awal_'+idx_row+'" value="'+parsing[i].saldo_akhir+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pembelian[]" class="form-control format_number jml_mutasi_pembelian_5" id="mutasi_pembelian_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_penjualan[]" class="form-control format_number jml_mutasi_penjualan_5" id="mutasi_penjualan_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="mutasi_pasar[]" class="form-control format_number jml_mutasi_pasar_5" id="mutasi_pasar_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="lembar_saham[]" class="form-control jml_lembar_saham_5" id="lembar_saham_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="harga_saham[]" class="form-control format_number harga_saham_5" id="harga_saham_'+idx_row+'" readonly/>';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="persentase[]" class="form-control persentase_5" id="persentase_'+idx_row+'" />';
				tr_table += '</td>';
				tr_table += '<td width="10%">';
				tr_table += '<input type="text" name="saldo_akhir[]" class="form-control format_number saldo_akhir_5" id="saldo_akhir_'+idx_row+'" readonly/>';
				tr_table += '</td>';
				tr_table +=	'<td width="5%" class="text-center"><a href="javascript:void(0);" class="btn btn-danger btn-circle btn-sm" onclick="$(this).parents(\'tr\').first().remove();"><i class="fa fa-times"></i></a></td>';
				tr_table += '</tr>';
			}
		break;
	}
	
	$('.'+mod).append(tr_table);
	$('.tanggalnya').datepicker({ 
		format: 'yyyy-mm-dd'
	});

	$(document).ready(function(){

		$('.format_number').number(true,0);
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

	$('.jenis_request').on('change', function(){
		var biaya_hpp = "";
		var idx = $(this).attr('idx');
		var layanan_id = $('#cl_layanan_id_'+idx).val();
		if($('#cl_layanan_id_'+idx).val() != ""){
			$.post(host+'order-display/layanan', { 'id':layanan_id }, function(resp){
				if(resp){
					var parse = JSON.parse(resp);
					
					if($('#jenis_request_'+idx).val() == 'SQ'){
						biaya_hpp = parse.data.hpp_super_express;
					}else if($('#jenis_request_'+idx).val() == 'EXPRESS'){
						biaya_hpp = parse.data.hpp_express;
					}else if($('#jenis_request_'+idx).val() == 'REGULAR'){
						biaya_hpp = parse.data.hpp_regular;
					}
					
					$('#biaya_kasbon_'+idx).val(NumberFormat(biaya_hpp));
				}
				
			} );
		}else{
			$.messager.alert('PT. BJS - APPS','Pilih Layanan Terlebih Dahulu!','warning'); 
		}
	});
	$('.layanan').on('change', function(){
		var biaya_hpp = "";
		var idx = $(this).attr('idx');
		$.post(host+'order-display/layanan', { 'id':$(this).val() }, function(resp){
			if(resp){
				var parse = JSON.parse(resp);
				var html = "";
				
				$('#tipe_layanan_'+idx).html(parse.data.tipe_layanan);
				$('#input_tipe_layanan_'+idx).val(parse.data.tipe_layanan);
				
				if(parse.detail.length > 0){
					html += "<h5>Detail Paket : </h5>";
					html += "<ol>";
					$.each(parse.detail, function(idx, i){
						html += "<li>"+i.nama_layanan+"</li>";
					});
					html += "</ol>";
				}
				
				$('#detail_paket_'+idx).html(html);
				
				if($('#jenis_request_'+idx).val() != ""){
					if($('#jenis_request_'+idx).val() == 'SQ'){
						biaya_hpp = parse.data.hpp_super_express;
					}else if($('#jenis_request_'+idx).val() == 'EXPRESS'){
						biaya_hpp = parse.data.hpp_express;
					}else if($('#jenis_request_'+idx).val() == 'REGULAR'){
						biaya_hpp = parse.data.hpp_regular;
					}
					
					$('#biaya_kasbon_'+idx).val(NumberFormat(biaya_hpp));
				}
				
			}
			
		} );
	});
}


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
		var m_pem = 0;
		var m_penj = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_1").val()))) {
			val1 = parseFloat($(this).find(".saldo_awal_1").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_1").val()))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_1").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_1").val()))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_1").val());
		}

		// hitung saldo akhir detail
		total = val1 + val2 - val3;
		$(this).find(".saldo_akhir_1").val(total.toFixed(2));


		$(".saldo_awal_1").each(function(i){      
			s_awal += parseFloat( $(this).val());  
		});
		$(".saldo_akhir_1").each(function(i){      
			s_akhir += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pembelian_1").each(function(i){      
			m_pem += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_penjualan_1").each(function(i){      
			m_penj += parseFloat( $(this).val());  
		});

		// hitung saldo akhir header
		mutasi_head = (m_pem - m_penj);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);
		

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
		if (!isNaN(parseFloat($(this).find(".saldo_awal_2").val()))) {
			val1 = parseFloat($(this).find(".saldo_awal_2").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_2").val()))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_2").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_2").val()))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_2").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_amortisasi_2").val()))) {
			val4 = parseFloat($(this).find(".jml_mutasi_amortisasi_2").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_2").val()))) {
			val5 = parseFloat($(this).find(".jml_mutasi_pasar_2").val());
		}
		total = val1 + val2 - val3 + val4 + val5;
		$(this).find(".saldo_akhir_2").val(total.toFixed(2));


		$(".saldo_awal_2").each(function(i){      
			s_awal += parseFloat( $(this).val());  
		});
		$(".saldo_akhir_2").each(function(i){      
			s_akhir += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pembelian_2").each(function(i){      
			m_pem += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_penjualan_2").each(function(i){      
			m_penj += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_amortisasi_2").each(function(i){      
			m_amrt += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pasar_2").each(function(i){      
			m_pasr += parseFloat( $(this).val());  
		});

		mutasi_head = (m_pem - m_penj + m_amrt + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);


    });

	// console.log(saldoawal_head);
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
		if (!isNaN(parseFloat($(this).find(".saldo_awal_3").val()))) {
			val1 = parseFloat($(this).find(".saldo_awal_3").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_3").val()))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_3").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_3").val()))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_3").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_3").val()))) {
			val4 = parseFloat($(this).find(".jml_mutasi_pasar_3").val());
		}
		total = val1 + val2 - val3 + val4;
		$(this).find(".saldo_akhir_3").val(total.toFixed(2));


		$(".saldo_awal_3").each(function(i){      
			s_awal += parseFloat( $(this).val());  
		});
		$(".saldo_akhir_3").each(function(i){      
			s_akhir += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pembelian_3").each(function(i){      
			m_pem += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_penjualan_3").each(function(i){      
			m_penj += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pasar_3").each(function(i){      
			m_pasr += parseFloat( $(this).val());  
		});

		mutasi_head = (m_pem - m_penj + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);

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
		var m_amrt = 0;
		var m_pasr = 0;
		var s_awal = 0;
		var s_akhir = 0;
		if (!isNaN(parseFloat($(this).find(".saldo_awal_4").val()))) {
			val1 = parseFloat($(this).find(".saldo_awal_4").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_4").val()))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_4").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_4").val()))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_4").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_amortisasi_4").val()))) {
			val4 = parseFloat($(this).find(".jml_mutasi_amortisasi_4").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_4").val()))) {
			val5 = parseFloat($(this).find(".jml_mutasi_pasar_4").val());
		}
		total = val1 + val2 - val3 + val4 + val5;
		$(this).find(".saldo_akhir_4").val(total.toFixed(2));


		$(".saldo_awal_4").each(function(i){      
			s_awal += parseFloat( $(this).val());  
		});
		$(".saldo_akhir_4").each(function(i){      
			s_akhir += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pembelian_4").each(function(i){      
			m_pem += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_penjualan_4").each(function(i){      
			m_penj += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_amortisasi_4").each(function(i){      
			m_amrt += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pasar_4").each(function(i){      
			m_pasr += parseFloat( $(this).val());  
		});

		mutasi_head = (m_pem - m_penj + m_amrt + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);


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
		if (!isNaN(parseFloat($(this).find(".saldo_awal_5").val()))) {
			val1 = parseFloat($(this).find(".saldo_awal_5").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pembelian_5").val()))) {
			val2 = parseFloat($(this).find(".jml_mutasi_pembelian_5").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_penjualan_5").val()))) {
			val3 = parseFloat($(this).find(".jml_mutasi_penjualan_5").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_mutasi_pasar_5").val()))) {
			val4 = parseFloat($(this).find(".jml_mutasi_pasar_5").val());
		}
		if (!isNaN(parseFloat($(this).find(".jml_lembar_saham_5").val()))) {
			val5 = parseFloat($(this).find(".jml_lembar_saham_5").val());
		}
		total = val1 + val2 - val3 + val4;
		$(this).find(".saldo_akhir_5").val(total.toFixed(2));

		hrg_saham = (total/val5);
		$(this).find(".harga_saham_5").val(hrg_saham.toFixed(2));

		$(".saldo_awal_5").each(function(i){      
			s_awal += parseFloat( $(this).val());  
		});
		$(".saldo_akhir_5").each(function(i){      
			s_akhir += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pembelian_5").each(function(i){      
			m_pem += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_penjualan_5").each(function(i){      
			m_penj += parseFloat( $(this).val());  
		});
		$(".jml_mutasi_pasar_5").each(function(i){      
			m_pasr += parseFloat( $(this).val());  
		});

		mutasi_head = (m_pem - m_penj + m_pasr);
		saldoawal_head = s_awal;
		saldoakhir_head = (s_awal + mutasi_head);
		realisasi_head = ((saldoakhir_head/rka)*100);

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