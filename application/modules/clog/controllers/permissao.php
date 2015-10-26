<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Permissao extends MX_Controller {

	#public $path = "clog/os/"; 
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('acesso_model', 'clog_model', 'militares_model'));
		$this->load->library('auth');
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$modulos = $this->clog_model->getAll('modulos')->result();
		$permissao = $this->load->view('permissoes/cadastro', array('modulos'=>$modulos), TRUE);
		$this->load->view('layout/index', array('layout'=>$permissao), FALSE);		 
	}

	public function criarGrupo() {
		$modulos = $this->clog_model->getAll('modulos')->result();
		$grupo = $this->load->view('permissoes/cadastro_grupo', array('modulos'=>$modulos), TRUE);
		$this->load->view('layout/index', array('layout'=>$grupo), FALSE);
	}

	public function listarGrupos() {
		if ($this->clog_model->getGrupos() === FALSE) $listarGrupos = $this->load->view('permissoes/listar_grupos', '', TRUE);
		else {
			$grupos = $this->clog_model->getGrupos()->result();
			$listarGrupos = $this->load->view('permissoes/listar_grupos', array('listarGrupos'=>$grupos), TRUE);
		}
		# Bloco de auditoria
			/*$auditoria = array(
								'auditoria'=>'Listou os grupos de permissões',
								'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo'=>$this->session->userdata['sistema']
							);
			$this->clog_model->audita($auditoria, 'consultar');*/
		# .Bloco de auditoria
		$this->load->view('layout/index', array('layout'=>$listarGrupos), FALSE);
	}

	public function novoGrupo() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/*if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
			} 
			else
			{
				echo "<script>alert('Deu erro');</script>";
				redirect('clog/os/index');
			}*/

			$data = array(
					#'modulos_id'=>$this->input->post('modulos_id'),
					'nome'=>$this->input->post('grupo_nome')
			);
			$query = $this->clog_model->inserir($data, 'grupos_permissoes');
			if ($query === TRUE) {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Incluiu um novo grupo de permissões no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Grupo de permissões cadastrado com sucesso!'));
			}
			else {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Tentativa de incluir um novo grupo de permissões no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar novo grupo de permissões!'));
			}
			redirect('clog/permissao/criarGrupo');
		} 
		else redirect('clog/permissao/criarGrupo'); # Caso não tenha sido enviado nenhum POST.
	}

	public function editarGrupo() {
		$id = $this->input->get('id');
		$permissoes = $this->clog_model->getPermissoes()->result();
		if (! $id) {
			$grupos = $this->clog_model->getGrupos()->result();
			$data = $this->load->view('permissoes/grupo_permissoes', array('permissoes'=>$permissoes, 'grupos'=>$grupos, 'grupos_id'=>$this->input->get('id')), TRUE);
		}
		else {
			$grupos = $this->clog_model->getByID('grupos_permissoes', $id)->row();
			$permissoes = $this->clog_model->getPermissoes($id, 1)->result();
			$permissoes_grupo = $this->clog_model->getPermissoes($id);
			if (FALSE !== $permissoes_grupo) $data = $this->load->view('permissoes/grupo_permissoes', array('permissoes'=>$permissoes, 'grupos'=>$grupos, 'grupos_id'=>$this->input->get('id'), 'permissoes_grupo'=>$permissoes_grupo->result()), TRUE);
			else $data = $this->load->view('permissoes/grupo_permissoes', array('permissoes'=>$permissoes, 'grupos'=>$grupos, 'grupos_id'=>$this->input->get('id')), TRUE);
		}
		$this->load->view('layout/index', array('layout'=>$data), FALSE);
	}

	public function listarPermissoesGrupo($id=NULL) {
		$titulo = "Permissões do Grupo Selecionado";
		$id = $this->input->get('id');
		$json = $this->input->get('json');
		if (FALSE === $id) return FALSE;
		else {
			$grupos = $this->clog_model->getPermissoes($id, $json);
			if (FALSE !== $grupos) {
				if (! $json) $this->load->view('permissoes/listar_permissoes', array('grupos'=>$grupos->result(), 'titulo'=>$titulo), FALSE);
				else {
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode(array('grupos' => $grupos->result())));
				}
			}
		}
	}

	public function permissoesUsuario() {
		$militares = $this->militares_model->getMilitares()->result();
		$modulos = $this->clog_model->getAll('modulos')->result();
		$grupos = $this->clog_model->getAll('grupos_permissoes')->result(); #Depois carregar por módulo
		$data = $this->load->view('permissoes/grupo_usuario', array('militares'=>$militares, 'modulos'=>$modulos, 'grupos'=>$grupos), TRUE);
		$this->load->view('layout/index', array('layout'=>$data), FALSE);
	}

	public function listarPermissoesUsuario($id=NULL) {
		$titulo = "Permissões do Usuário Selecionado";
		$id = $this->input->get('id');
		if (FALSE === $id) return FALSE;
		else {
			$grupos = $this->clog_model->getPermissoesUsuario($id);
			if (FALSE !== $grupos) {
				$this->load->view('permissoes/listar_permissoes', array('grupos'=>$grupos->result(), 'titulo'=>$titulo), FALSE);
			}
			/*$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('grupos' => $grupos)));*/
		}
	}

	public function novaPermissao() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/*if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
			} 
			else
			{
				echo "<script>alert('Deu erro');</script>";
				redirect('clog/os/index');
			}*/

			$data = array(
					'modulos_id'=>$this->input->post('modulos_id'), 
					'nome'=>$this->input->post('permissoes_nome'),
					'pagina'=>$this->input->post('permissoes_pagina'),
			);
			$query = $this->clog_model->inserir($data, 'permissoes');
			if ($query === TRUE) {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Incluiu uma nova permissão no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Permissao cadastrada com sucesso!'));
				redirect('clog/permissao/index');
			}
			else {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Tentativa de incluir uma nova permissão no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar nova permissão!'));
				redirect('clog/permissao/index');
			}
		} 
		else redirect('clog/permissao/index'); # Caso não tenha sido enviado nenhum POST.
	}

	public function darPermissao() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/*if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
			} 
			else
			{
				echo "<script>alert('Deu erro');</script>";
				redirect('clog/os/index');
			}*/
			if ((0 == $this->input->post('militares_id') || "" == $this->input->post('militares_id')) || (0 == $this->input->post('grupos_id') || "" == $this->input->post('grupos_id'))) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Selecione um militar/grupo válido!'));
				redirect('clog/permissao/permissoesUsuario');
			}
			else {
				$data = array(
						'militares_id'=>$this->input->post('militares_id'),
						'grupos_permissoes_id'=>$this->input->post('grupos_id')
				);
				$hasMilitar =  $this->clog_model->grupoHasMilitar($data['grupos_permissoes_id'], $data['militares_id']);
				if (TRUE === $hasMilitar) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário já pertence a este grupo!'));
					redirect('clog/permissao/permissoesUsuario');
				}
				else {
					$query = $this->clog_model->inserir($data, 'militares_grupos_permissoes');
					if ($query === TRUE) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Incluiu o membro ID '.$data['militares_id'].' no grupo ID '.$data['grupos_permissoes_id'],
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Usuário incluído no grupo com sucesso!'));
					}
					else {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Tentativa de incluir o membro ID '.$data['militares_id'].' no grupo ID '.$data['grupos_permissoes_id'],
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao incluir usuário no grupo!'));
					}
					redirect('clog/permissao/permissoesUsuario');
				}
			}
		} 
		else redirect('clog/permissao/index'); # Caso não tenha sido enviado nenhum POST.
	}

	public function gerenciarGrupo() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/*if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
			} 
			else {
				echo "<script>alert('Deu erro');</script>";
				redirect('clog/os/index');
			}*/
			if ((0 == $this->input->post('permissoes_id') || "" == $this->input->post('permissoes_id')) || (0 == $this->input->post('grupos_id') || "" == $this->input->post('grupos_id'))) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Selecione um grupo/permissão válida!'));
				redirect('clog/permissao/editarGrupo');
			}
			else {
				$data = array(
						'grupos_permissoes_id'=>$this->input->post('grupos_id'),
						'permissoes_id'=>$this->input->post('permissoes_id')
					);
				$hasPermission = $this->clog_model->grupoHasPermissao($data['grupos_permissoes_id'], $data['permissoes_id']);
				if (TRUE === $hasPermission) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O grupo já possui esta permissão!'));
					redirect('clog/permissao/editarGrupo');
				}
				else {
					$query = $this->clog_model->inserir($data, 'grupos_permissoes_permissoes');
					if ($query === TRUE) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Associou a permissão ID '.$data['permissoes_id'].' ao grupo ID '.$data['grupos_permissoes_id'],
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Permissão associada ao grupo com sucesso!'));;
					}
					else {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Tentativa de associar a permissão ID '.$data['permissoes_id'].' ao grupo ID '.$data['grupos_permissoes_id'],
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao associar a permissão ao grupo!'));	
					}
					redirect('clog/permissao/listarGrupos');
				}
			}
		} 
		else redirect('clog/permissao/listarGrupos'); # Caso não tenha sido enviado nenhum POST.
	}

	public function excluir_permissao($permissoes_id, $grupos_permissoes_id) {
		#var_dump($permissoes_id); var_dump($grupos_permissoes_id); die();
		if (isset($permissoes_id) && isset($grupos_permissoes_id)) {
			$data = array('permissoes_id' => $permissoes_id, 'grupos_permissoes_id' => $grupos_permissoes_id);
			$hasPermission = $this->clog_model->grupoHasPermissao($data['grupos_permissoes_id'], $data['permissoes_id']);
			if (FALSE === $hasPermission) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O grupo não possui esta permissão!'));
				redirect('clog/permissao/editarGrupo');
			}
			else {
				$permissoes_grupo = $this->clog_model->excluir('grupos_permissoes_permissoes', $data);
				if (! $permissoes_grupo) {
					# Bloco de auditoria
						$auditoria = array(
											'auditoria'=>'Tenatativa de revogar a permissão ID '.$data['permissoes_id'].' do grupo ID '.$data['grupos_permissoes_id'],
											'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
											'idmodulo'=>$this->session->userdata['sistema']
										);
						$this->clog_model->audita($auditoria, 'excluir');
					# .Bloco de auditoria
				}
				else {
					# Bloco de auditoria
						$auditoria = array(
											'auditoria'=>'Revogou a permissão ID '.$data['permissoes_id'].' do grupo ID '.$data['grupos_permissoes_id'],
											'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
											'idmodulo'=>$this->session->userdata['sistema']
										);
						$this->clog_model->audita($auditoria, 'excluir');
					# .Bloco de auditoria
				}		
				redirect("clog/permissao/editarGrupo?id=$grupos_permissoes_id");
			}
		} 
		else die(); #Checar se é a melhor solução
	}

}