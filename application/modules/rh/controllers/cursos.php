<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Cursos extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('cursos_model');
		$this->load->helper(array('cbmrn', 'file'));
		//$this->load->library('auth');
		//$this->output->enable_profiler(TRUE);
	}

	public function index() {
		$areas=$this->cursos_model->listarAreas();
		$conteudo = $this->load->view('cursos/cadastro_area', array('listar_areas' => $areas) , TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}
	
	public function areas_cursos() {
	 		$this->index();
	}

	public function salvar_area() {
		# cria o array $params, de parâmetros, que vai ser enviado para o model
		$params= array(
				'area' => $this->input->post('area'),
				'operacional' => $this->input->post('operacional')
			);
		# testa se o campo id está vazio, senão estiver tambem manda pro model no array $params
		if (""!=$this->input->post('id'))  {
			$params['id']=$this->input->post('id');
		}
		# envia o array para o model
		$controle=$this->cursos_model->salvarArea($params);
		# retorno para o usuário
		if ($controle===true) {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Salvo com sucesso!'));
		} else {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao Salvar!'));
						}
		# Abre a página de cadastro de Cursos
		redirect('rh/cursos/areas_cursos');
	}

	public function editar_area() {
		$id=$this->input->get('id');
		$areas=$this->cursos_model->listarAreas();
		$info_area = $this->cursos_model->listarAreas($id)->row();
		#var_dump($info_area); die();
		$conteudo = $this->load->view('cursos/cadastro_area', array('listar_areas' => $areas, 'on_edit'=>$info_area) , TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function excluir_area($id) {
			$data = array('tabela'=>'area_cursos', 'id' => $id);
					
			$this->cursos_model->excluirArea($data);
			redirect('rh/cursos/areas_cursos/');
	}

	public function incluir_cursos() {
		$areas=$this->cursos_model->listarAreas();
		$inc_cursos=$this->cursos_model->listarCursos();
		$conteudo = $this->load->view('cursos/incluir_cursos', array('listar_areas' => $areas, 'listar_cursos' => $inc_cursos) , TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function salvar_curso() {
		if (0==$this->input->post('area')) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Por favor selecione uma área para o curso.'));
			redirect('rh/cursos/incluir_cursos');
		}
		# cria o array $params, de parâmetros, que vai ser enviado para o model
		$params= array(
				'curso' => $this->input->post('curso'), 
				'sigla' => $this->input->post('sigla'),
				'idarea' => $this->input->post('area')
			);
	 #var_dump($params); die();
		# testa se o campo id está vazio, senão estiver tambem manda pro model no array $params
		if (""!=$this->input->post('id'))  {
			$params['id']=$this->input->post('id');
		}
		# envia o array para o model
		$controle=$this->cursos_model->salvarCurso($params);
		# retorno para o usuário
		if ($controle===true) {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Salvo com sucesso!'));
		} else {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao Salvar!'));
						}
		# Abre a página de cadastro de Cursos
		redirect('rh/cursos/incluir_cursos');
	}

	public function editar_curso() {
		$id=$this->input->get('id');
		$areas=$this->cursos_model->listarAreas();
		$inc_cursos=$this->cursos_model->listarCursos();
		$info_curso = $this->cursos_model->listarCursos($id)->row();
		$conteudo = $this->load->view('cursos/incluir_cursos', array('listar_areas' => $areas, 'listar_cursos' => $inc_cursos, 'on_edit'=>$info_curso) , TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function excluir_curso($id) {
			$data = array('tabela'=>'cursos', 'id' => $id);
			$this->cursos_model->excluirCurso($data);
			redirect('rh/cursos/incluir_cursos/');
	}

	public function reativar_cursos() {
		// verifica se o método de requisição do formulário foi via post.
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			// Lê o post e manda o model atualizar o db passando os ids que estão no post.
			$controle = $this->cursos_model->reativarCursos($this->input->post('ativo'));
			// msg customizada ao usuário.
			/// sucesso
			if ($controle !== FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => "$controle curso(s) reativado(s) com sucesso."));
				redirect('rh/cursos/reativar_cursos');
			}
			///erro
			else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao Reativar!'));
				redirect('rh/cursos/reativar_cursos');
			} // fim do bloco de msgs.
		}
		
		$cursos=$this->cursos_model->listarCursosIn();
		$conteudo = $this->load->view('cursos/reativar_cursos', array( 'listar_cursos' => $cursos) , TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function turmas_cursos() {
		$cursos=$this->cursos_model->listarCursos();
		$turmas=$this->cursos_model->turmasCursos();
		$conteudo = $this->load->view('cursos/turmas_cursos', array('listar_cursos' => $cursos, 'turmas_cursos' => $turmas) , TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function salvar_turma() {
			if (0==$this->input->post('curso')) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Por favor selecione um curso.'));
				redirect('rh/cursos/turmas_cursos');
			}
			if ((0==$this->input->post('periodo')) || (0==$this->input->post('inicio')) || (0==$this->input->post('fim'))) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Por favor selecione uma data.'));
				redirect('rh/cursos/turmas_cursos');
			}
			# cria o array $params, de parâmetros, que vai ser enviado para o model
			$params= array(
					'idcurso' => $this->input->post('curso'),
					'inicio_matricula' => $this->input->post('periodo'),
					'periodo_matricula' => $this->input->post('data_fim'),
					'inicio_curso' => $this->input->post('inicio'),
					'fim_curso' => $this->input->post('fim'),
					'instituicao' => $this->input->post('instituicao'),
					'carga_horaria' => $this->input->post('carga_horaria'),
					'local' => $this->input->post('local'),
					'valor' => str_replace(",", ".", str_replace(".", "",$this->input->post('valor'))),
					'turma' => $this->input->post('turma'), 
					'exercicio' => $this->input->post('exercicio'),
					'vagas' => $this->input->post('vagas'),
				);
		 	#var_dump($params); die();
			# testa se o campo id está vazio, senão estiver tambem manda pro model no array $params
			if (""!=$this->input->post('id'))  {
				$params['id']=$this->input->post('id');
			}
			# envia o array para o model
			$controle=$this->cursos_model->salvarTurma($params);
			# retorno para o usuário
			if ($controle===true) {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Salvo com sucesso!'));
			} else {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao Salvar!'));
							}
			# Abre a página de cadastro de Cursos
			redirect('rh/cursos/turmas_cursos');
		}

	public function editar_turma() {
			$id=$this->input->get('id');
			$cursos=$this->cursos_model->listarCursos();
			$turmas=$this->cursos_model->turmasCursos();
			$info_curso = $this->cursos_model->turmasCursos($id)->row();
			$conteudo = $this->load->view('cursos/turmas_cursos', array('turmas_cursos' => $turmas, 'listar_cursos' => $cursos, 'on_edit'=>$info_curso) , TRUE);
			$this->load->view('layout/index', array('layout' => $conteudo), FALSE);

	}

	public function matricula_cursos() {
			#$cursos=$this->cursos_model->listarCursos();
			$turmas=$this->cursos_model->turmasCursos();
			$conteudo = $this->load->view('cursos/matricula', array('turmas_cursos' => $turmas, /*'listar_cursos' => $cursos*/) , TRUE);
			$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function solicitar_matricula()
	{
		echo "<pre>";
		var_dump($this->input->post());
		#$this->input->post();
		echo "</pre>";
	}

	public function listar_solicitacoes() {
		$id=$this->input->get('id');
		$lista=$this->cursos_model->matriculasCursos($id);
		$this->load->view('cursos/lista_turma_curso', array('militares_turma' => $lista), FALSE);
	}


}
