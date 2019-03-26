<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Cursos_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}	

	public function salvarArea($params) {
			if (!is_array($params)) {
				return false;
			}
			else {
				$data = array('area' => $params['area'], 'operacional' => ($params['operacional'] != '')? 1 : 0);
				if (count($params)==2) {
					$this->db->insert('area_cursos', $data);
				}
				else {
					$this->db->where('id', $params['id']);
					$this->db->update('area_cursos', $data);
				}
			}
			#echo $this->db->last_query(); die();
			return($this->db->affected_rows()>0)? true : false;
	}

	public function salvarCurso($params) {
		#var_dump($params); die();
			if (!is_array($params)) {
				return false;
			}
			else {
				#$data = array('area' => $params['area'], 'operacional' => ($params['operacional'] != '')? 1 : 0);
				if (count($params)==3) {
					$this->db->insert('cursos', $params);
				}
				else {
					$id=array_pop($params);
					$this->db->where('id', $id);
					$this->db->update('cursos', $params);
				}
			}
			#echo $this->db->last_query(); die();
			return($this->db->affected_rows()>0)? true : false;
	}

	public function listarAreas($id=NULL) {
		$this->db->order_by("id", "asc"); 
		$lista= (is_null($id))? $this->db->get_where('area_cursos', array('ativo'=> 1)):  $this->db->get_where('area_cursos', array('id'=>$id));
		return ($lista->num_rows() > 0) ? $lista : FALSE ;
	}


	public function excluirArea($params) {

			if (!is_array($params)) {
				return false;
			}
			else {
				$data['ativo']=0;
				$this->db->where('id', $params['id']);
				$this->db->update($params['tabela'], $data);
			}
			#echo $this->db->last_query(); die();
			return($this->db->affected_rows()>0)? true : false;
	}

	public function listarCursos($id=NULL) {
		$sql="SELECT
				cursos.id,
				cursos.curso,
				cursos.sigla,
				area_cursos.id AS idarea,
				area_cursos.area,
				area_cursos.operacional
				FROM
				cursos
				INNER JOIN area_cursos ON cursos.idarea = area_cursos.id";
		$sql.= (is_null($id))? " WHERE cursos.ativo=1" : " WHERE cursos.id=$id";
		$sql.= " ORDER BY cursos.id ASC";
		$lista=$this->db->query($sql);
		return ($lista->num_rows() > 0) ? $lista : FALSE ;
	}

	public function excluirCurso($params) {
			
			if (!is_array($params)) {
				return false;
			}
			else {
				$data['ativo']=0;
				$this->db->where('id', $params['id']);
				$this->db->update($params['tabela'], $data);
			}
			#echo $this->db->last_query(); die();
			return($this->db->affected_rows()>0)? true : false;
	}

	public function listarCursosIn() {
		$this->db->order_by('cursos.id', 'ASC');
		$this->db->join('area_cursos', 'cursos.idarea = area_cursos.id', 'INNER');
		$this->db->where('cursos.ativo', 0); 
		$this->db->select('cursos.id, cursos.curso, cursos.ativo, area_cursos.area, area_cursos.operacional');
		$lista=$this->db->get('cursos');
		# echo $this->db->last_query(); die();
		return ($lista->num_rows() > 0) ? $lista : FALSE ;
	}

	public function reativarCursos($data) {
		$contador=0;
		if ((is_array($data))&&(count($data)>0)) {
			foreach ($data as $chv=>$val) {
				$sql = "UPDATE cursos SET cursos.ativo = 1 WHERE cursos.id= $chv";
				$this->db->query($sql);
				$contador += ($this->db->affected_rows()>0)? 1 : 0;
			}
			return $contador;
		}
		else {
			return FALSE;
		}
	}

	public function turmasCursos($id=NULL) {
		$sql="SELECT
						turmas_cursos.id,
						cursos.curso,
						CONCAT('de ',DATE_FORMAT(turmas_cursos.inicio_curso, '%d/%m/%Y'),' a ',DATE_FORMAT(turmas_cursos.fim_curso, '%d/%m/%Y')) AS periodo,
						turmas_cursos.instituicao,
						CONCAT(cursos.sigla,turmas_cursos.turma,'/',turmas_cursos.exercicio) AS turma_ano,
						turmas_cursos.turma,
						turmas_cursos.carga_horaria,
						turmas_cursos.inicio_matricula,
						turmas_cursos.local,
						turmas_cursos.valor,
						turmas_cursos.inicio_curso AS inicio,
						turmas_cursos.fim_curso AS fim,
						turmas_cursos.periodo_matricula AS dias,
						turmas_cursos.idcurso,
						turmas_cursos.exercicio,
						turmas_cursos.vagas
					FROM
						turmas_cursos
					INNER JOIN cursos ON turmas_cursos.idcurso = cursos.id";
		$sql.= (is_null($id))? " WHERE DATE_ADD(turmas_cursos.fim_curso,INTERVAL + 1 DAY) >= NOW()" : " WHERE turmas_cursos.id=$id";
		$sql.= " ORDER BY turmas_cursos.id ASC";
		
		$lista=$this->db->query($sql);
		return ($lista->num_rows() > 0) ? $lista : FALSE ;
	}

	public function salvarTurma($params) {
			#var_dump($params); die();
				if (!is_array($params)) {
					return false;
				}
				else {
					#$data = array('area' => $params['area'], 'operacional' => ($params['operacional'] != '')? 1 : 0);
					if (count($params)==12) {
						$this->db->insert('turmas_cursos', $params);
					}
					else {
						$id=array_pop($params);
						$this->db->where('id', $id);
						$this->db->update('turmas_cursos', $params);
					}
				}
				#echo $this->db->last_query(); die();
				return($this->db->affected_rows()>0)? true : false;
		}

		public function matriculasCursos($id) {
				$sql="SELECT
							matricula_curso.id,
							matricula_curso.idaluno,
							militares.nome,
							cursos.sigla,
							turmas_cursos.turma,
							turmas_cursos.exercicio,
							matricula_curso.matriculado,
							matricula_curso.cursado,
							matricula_curso.motivos,
							matricula_curso.nota,
							matricula_curso.prioridade
							FROM
							matricula_curso
							INNER JOIN militares ON matricula_curso.idaluno = militares.id
							INNER JOIN turmas_cursos ON matricula_curso.idturma = turmas_cursos.id
							INNER JOIN cursos ON turmas_cursos.idcurso = cursos.id
							WHERE
							matricula_curso.idturma = $id";
							var_dump($sql);
				$lista=$this->db->query($sql);
				return ($lista->num_rows() > 0) ? $lista : FALSE ;
			}

}
