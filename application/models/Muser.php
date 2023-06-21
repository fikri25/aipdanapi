<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Muser extends CI_Model
{
	public function updateData($table, $data,$id){
		$this->db->where('iduser', $id);
		$this->db->update($table, $data);
		return true ;
	}

	public function updateDataGroup($table, $data,$id){
		$this->db->where('idusergroup', $id);
		$this->db->update($table, $data);
		return true ;
	}

	public function insert_user($table, $data){
		$this->db->insert($table, $data);
		return true ;
	}


	function insertData($table, $data){
    	try {
			if(key($data)=='0'){ ///batch / single insert
				$newData = array();
				foreach ($data as $key => $value) {
					$newArr = array_merge($value);
					array_push($newData, $newArr);
				}
				$this->db->insert_batch($table, $newData);
			}else{
				$data = array_merge($data);
				$this->db->insert($table, $data);
			}
			$stat = true;
		} catch (\Throwable $th) {
			$stat = false;
		}	
		return $stat;
	}


	function deleteData($table, $where=NULL){

		$this->db->trans_start();
			try {				
				if($where !== NULL){
					$query = $this->db->delete($table, $where);
				}else{
					$query = $this->db->delete($table);
				}
				$stat = true;
			} catch (\Throwable $th) {
				$stat = false;
			}
		$this->db->trans_complete();
		return $stat;
	}

	function get_new_id($table,$p1=''){
		$this->db->trans_start();
		$where  = " WHERE 1=1 ";
		switch ($table) {
			case 't_user':
				switch ($p1) {
					case 1:
						$level = 'DJA';
						$kdlevel = 'DJA';
						break;
					case 2:
						$level = 'TASPEN';
						$kdlevel = 'TSN';
						break;
					case 3:
						$level = 'ASABRI';
						$kdlevel = 'ASB';
						break;
					case 4:
						$level = 'SUPER ADMIN';
						$kdlevel = 'ADM';
						break;
					case 5:
						$level = 'TAMU';
						$kdlevel = 'TAM';
						break;
					default:
						$level = 'TAM';
						break;
				}
				$res = $this->db->query('SELECT MAX(RIGHT(iduser,3)) as kode FROM t_user where level = "'.$level.'" AND LEFT(iduser,3) = "'.$kdlevel.'"')->row();

				break;
			
			default:
				
				break;
		}
		$this->db->trans_complete();
		$convertKode = ((int)$res->kode)+1;		
		$kodeBaru = $kdlevel.substr('00'.$convertKode,-3);
		return $kodeBaru;
	}

	
	function getdata($type="", $balikan="", $p1="", $p2="", $p3=""){
        $where  = " WHERE 1=1 ";
		$array = array();
		
		switch($type){
			case 'user_list':
				$sql = "
					SELECT A.*, B.nmusergroup
					FROM t_user A
					LEFT JOIN t_user_group B ON B.idusergroup = A.idusergroup
					ORDER BY B.idusergroup ASC
				";
			break;

			case "data_menu_role":
				$sql = "

					SELECT A.*, B.*, C.*
					FROM user_sub_menu A 
					LEFT JOIN user_menu B ON B.id = A.menu_id
					LEFT JOIN user_access_menu C ON C.menu_id = B.id
					WHERE A.is_active = 1
					GROUP BY A.id
				";
			break;
			case "data_menu_usr":
				$sql = "
					SELECT A.idusergroup, B.menu, B.url, B.icon, B.is_active, B.type_menu, B.id as tbl_menu_id
					FROM tbl_access_menu A
					LEFT JOIN tbl_menu B ON B.id = A.tbl_menu_id
					WHERE A.idusergroup= '".$this->auth['idusergroup']."'  
					AND (B.type_menu='P' OR B.type_menu='PC') AND B.is_active='1'
					ORDER BY B.no_urut ASC
				";

				$parent = $this->db->query($sql)->result_array();
				$menu = array();
				foreach($parent as $v){
					$menu[$v['tbl_menu_id']]=array();
					$menu[$v['tbl_menu_id']]['id']=$v['tbl_menu_id'];
					$menu[$v['tbl_menu_id']]['parent']=$v['menu'];
					$menu[$v['tbl_menu_id']]['icon_menu']=$v['icon'];
					$menu[$v['tbl_menu_id']]['url']=$v['url'];
					$menu[$v['tbl_menu_id']]['type_menu']=$v['type_menu'];
					$menu[$v['tbl_menu_id']]['child']=array();
					$sql="
						SELECT A.cl_user_group_id, B.menu, B.url, B.icon, B.is_active, B.type_menu, B.id as tbl_menu_id
						FROM tbl_access_menu A
						LEFT JOIN tbl_menu B ON B.id = A.tbl_menu_id
						WHERE A.cl_user_group_id= '".$this->auth['cl_user_group_id']."' 
						AND (B.type_menu='C' OR B.type_menu='CH') AND B.is_active='1' AND b.parent_id=".$v['tbl_menu_id']."
						ORDER BY B.no_urut ASC
					";
					$child = $this->db->query($sql)->result_array();
					foreach($child as $x){
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]=array();
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['id']=$x['tbl_menu_id'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['menu']=$x['menu'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['type_menu']=$x['type_menu'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['url']=$x['url'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['icon_menu']=$x['icon'];

	        			# level 3......
				        // if($x['type_menu'] == 'CHC'){
				        //   	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'] = array();
				        //   	$sqlSubChild="
					       //    	SELECT A.cl_user_group_id, B.tbl_menu_id, B.menu, B.url, B.icon, B.is_active, B.type_menu, B.id as tbl_menu_id
					       //    	FROM tbl_access_menu A
					       //    	LEFT JOIN tbl_menu B ON B.id = A.tbl_menu_id
					       //    	WHERE A.cl_user_group_id= '".$this->auth['cl_user_group_id']."' 
					       //    	AND B.type_menu='CC' 
					       //    	AND B.is_active='1' 
					       //    	AND b.parent_id_2=".$v['tbl_menu_id']."
					       //    	ORDER BY B.tbl_menu_id ASC
				        //  	";
				        //   	$SubChild = $this->db->query($sqlSubChild)->result_array();
				        //   	foreach($SubChild as $z){
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['sub_menu'] = $z['menu'];
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['type_menu'] = $z['type_menu'];
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['url'] = $z['url'];
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['icon_menu'] = $z['icon'];
				        //   	}
				        // }

					}
				}
				$array = $menu;
				// echo "<pre>"; print_r($menu);exit;
			break;

			case "data_menu_all_usr":

				// if($p1 != 1 ){
				// 	$where .= " AND B.id NOT IN (12,13,14,15)";
				// }

				$sql = "
					SELECT B.menu, B.url, B.icon, B.is_active, B.type_menu, B.id as tbl_menu_id, B.id
					FROM tbl_menu B
					$where
					AND (B.type_menu='P' OR B.type_menu='PC') AND B.is_active='1'
					ORDER BY B.no_urut ASC
				";

				$parent = $this->db->query($sql)->result_array();
				$menu = array();
				foreach($parent as $v){
					$menu[$v['tbl_menu_id']]=array();
					$menu[$v['tbl_menu_id']]['id']=$v['tbl_menu_id'];
					$menu[$v['tbl_menu_id']]['parent']=$v['menu'];
					$menu[$v['tbl_menu_id']]['icon_menu']=$v['icon'];
					$menu[$v['tbl_menu_id']]['url']=$v['url'];
					$menu[$v['tbl_menu_id']]['type_menu']=$v['type_menu'];
					$menu[$v['tbl_menu_id']]['child']=array();
					$sql="
						SELECT B.menu, B.url, B.icon, B.is_active, B.type_menu, B.id as tbl_menu_id, B.id
						FROM tbl_menu B
						$where
						AND (B.type_menu='C' OR B.type_menu='CH') AND B.is_active='1' AND B.parent_id=".$v['tbl_menu_id']."
						ORDER BY B.no_urut ASC
					";
					$child = $this->db->query($sql)->result_array();
					foreach($child as $x){
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]=array();
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['id']=$x['tbl_menu_id'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['menu']=$x['menu'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['type_menu']=$x['type_menu'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['url']=$x['url'];
						$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['icon_menu']=$x['icon'];

	        			# level 3......
				        // if($x['type_menu'] == 'CHC'){
				        //   	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'] = array();
				        //   	$sqlSubChild="
					       //    	SELECT B.tbl_menu_id, B.menu, B.url, B.icon, B.is_active, B.type_menu, B.id as tbl_menu_id
					       //    	FROM tbl_menu B
					       //    	AND B.type_menu='CC' 
					       //    	AND B.is_active='1' 
					       //    	AND B.parent_id_2=".$v['tbl_menu_id']."
					       //    	ORDER BY B.tbl_menu_id ASC
				        //  	";
				        //   	$SubChild = $this->db->query($sqlSubChild)->result_array();
				        //   	foreach($SubChild as $z){
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['sub_menu'] = $z['menu'];
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['type_menu'] = $z['type_menu'];
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['url'] = $z['url'];
					       //    	$menu[$v['tbl_menu_id']]['child'][$x['tbl_menu_id']]['sub_child'][$z['tbl_menu_id']]['icon_menu'] = $z['icon'];
				        //   	}
				        // }

					}
				}

				$array = $menu;
				// echo "<pre>"; print_r($menu);exit;
			break;
		}
		
		if($balikan == 'json'){
			return $this->lib->json_grid($sql,$type);
		}elseif($balikan == 'row_array'){
			return $this->db->query($sql)->row_array();
		}elseif($balikan == 'result'){
			return $this->db->query($sql)->result();
		}elseif($balikan == 'result_array'){
			return $this->db->query($sql)->result_array();
		}elseif($balikan == 'json_encode'){
			$data = $this->db->query($sql)->result_array(); 
			return json_encode($data);
		}elseif($balikan == 'variable'){
			return $array;
		}
		
    }
	
	function id_user()
	{ 
		 $csql = $this->db->query("select * from cl_user_group ");
		return $csql->result_array();
	} 
	
	function id_user2()
	{ 
			$csql = $this->db->query("select * from cl_user_group where id<>'1'");
			return $csql->result_array();
			
	}

}
