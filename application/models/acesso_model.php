<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Acesso_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
		# $this->output->enable_profiler(TRUE);
	}

	public function search_module($id=NULL, $tabela=NULL) 
	{
		# Pesquisar modulo.
		if (!is_null($id)) 
			$this->db->where('id', $id);

		if (is_null($tabela)) 
			$tabela = 'modulos';
		
		# Query
		$query = $this->db->get($tabela);
		return $query;
	}

	public function consulta_militares() 
	{
		$data = array(  
			'matricula'=>$this->input->post('matricula'), 
			'senha'=>md5($this->input->post('senha'))
		);

		$this->db->where('matricula', $data['matricula']);
		$this->db->where('senha', $data['senha']);
		$sql = "SELECT
							militares.id,
							militares.nome_guerra,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
							militares.matricula
							FROM
								militares
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								WHERE militares.matricula = '".$data['matricula']."' AND militares.senha = '".$data['senha']."'";
		$query = $this->db->query($sql);
		return $query;
	}

	public function consulta_modulos($data) 
	{
		# Consultar modulos.
		$this->db->where('id', $data['sistema']);
		$query = $this->db->get('modulos', 1);
		return $query;
	}

	/**
	 * @param $metodo,, $id
	 * 
	 */
	public function getPermissao($uri, $id) {
		// $uri .= "/cbmrn/".$uri; 
		if (empty($id)) 
			$id = 0; 

		$sql="SELECT
						militares.id,
						militares.nome_guerra,
						CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
						grupos_permissoes.nome AS grupo,
						permissoes.nome AS uri
						FROM
							militares
							INNER JOIN militares_grupos_permissoes ON militares.id = militares_grupos_permissoes.militares_id
							INNER JOIN grupos_permissoes_permissoes ON militares_grupos_permissoes.grupos_permissoes_id = grupos_permissoes_permissoes.grupos_permissoes_id
							INNER JOIN permissoes ON grupos_permissoes_permissoes.permissoes_id = permissoes.id
							INNER JOIN grupos_permissoes ON grupos_permissoes.id = grupos_permissoes_permissoes.grupos_permissoes_id
							INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
						WHERE militares.id=$id AND pagina='$uri'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return TRUE;
		else return FALSE;
	}
}