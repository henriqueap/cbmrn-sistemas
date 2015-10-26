<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */

class Publico_model extends CI_Model
{
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
	}

	public function cadastro($data){
	   if (is_array($data)) {
	   		$query=$this->db->query("select codigo from boletins where codigo='".$data['codigo']."'");
	   		$query2=$this->db->query("select date(data_gerado) as data_gerado from boletins where date(data_gerado)='".date('Y-m-d',strtotime($data['data_gerado']))."'");	
	   		if($query->num_rows()==0){
	   			if($query2->num_rows()==0){
			   		if($data['boletimExtra']===false){
				   		$data2 = array( 
				   			'codigo'=>$data['codigo'],
							'data_gerado'=>$data['data_gerado'],
							'data_publicado'=>$data['data_publicado'],
							'nome_boletim'=>$data['nome_boletim']
						);  
			   			$this->db->insert('boletins', $data2);
			   			//echo 99; teste de entrada na condicão
			   			return true;
		   			}else{
		   				//echo 22; teste de entrada na condicão
		   				return false;
		   			}
	   			}else{
	   				if($data['boletimExtra']===false){
	   					//echo 33; teste de entrada na condicão
					   	$valor=2;
		   				return $valor;
		   			}	
			   		else{
			   			//echo 44; teste de entrada na condicão
			   			$valor=3;
	   					return $valor;	
			   		}
	       		}
	       	}else{	        	
	        	if($data['boletimExtra']==1){
			   		$data2 = array(
			   			'codigo'=>$data['codigo'],
						'data_gerado'=>$data['data_gerado'],
						'data_publicado'=>$data['data_publicado'],
						'nome_boletim'=>$data['nome_boletim']
					);

		   			 $this->db->insert('boletins', $data2);
		   			 //echo 55; teste de entrada na condicão
		   			return true;
				}else{
					//echo 66; teste de entrada na condicão
					return false;
				}
	   		}		
		}else{
			//echo 77; teste de entrada na condicão
			return false;
		}	
	}

	public function excluir($id) {
		if (!is_null($id)) {
			$query=$this->db->query("select nome_boletim from boletins where id=$id")->row();
			unlink("uploads/".$query->nome_boletim);
			$this->db->where('id', $id);
			$this->db->delete('boletins'); 
			return TRUE;
		}else{
			return FALSE;
		}	
     }	

	public function consulta(){
		$query=$this->db->query("select * from boletins");
		return $query;
	} 

	public function numMeses(){
		$query=$this->db->query("select Distinct EXTRACT(MONTH FROM data_gerado) AS mes, EXTRACT(YEAR FROM data_gerado) AS ano from boletins order by data_gerado asc");
		return $query;
	} 

	public function numAnos(){
		$query=$this->db->query("select Distinct EXTRACT(YEAR FROM data_gerado) AS ano from boletins");
		return $query;
	} 

	public function resultadoConsulta($data){
		if(is_array($data)){
			$query=$this->db->query("select * from boletins where date(data_publicado) BETWEEN '".$data['dataIni']."' and '".$data['dataFim']."'");
			return $query;
		}else{
			return false;
		}
	} 
}