<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Notas extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('clog_model', 'notas_model', 'produtos_model'));
		$this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
		# $this->load->helper('cbmrn');
	}

	public function index() {
		## Index
		# Pegando o ID do Almoxarifado Principal
		$almox = $this->clog_model->getAlmox();
		if (! $almox) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Procure o administrador, não existe almoxarifado principal cadastrado!"));
			redirect('clog/notas/index');
		}
		else {
			$this->cadastro();
		}
	}

	public function cadastro() {
		# Listar empresas cadastradas.
		$empresas = $this->clog_model->listar('empresas')->result();

		$info_notas_fiscais = $this->notas_model->getInfoNotas()->result();

		$notas = $this->load->view('notas/cadastro', array('empresas' => $empresas, 'info_notas_fiscais' => $info_notas_fiscais), TRUE);
		$this->load->view('layout/index', array('layout' => $notas), FALSE);
	}

	public function salvar() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules('numero', 'numero', 'trim|required|xss_clean');
			$this->form_validation->set_rules('data', 'data', 'trim|required|xss_clean');
			$this->form_validation->set_rules('empresas_id', 'empresas', 'trim|required|xss_clean');

			if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
				$id_nota_fiscal = $this->notas_model->dados_notas();
				if (is_int($id_nota_fiscal)) {
					# Bloco de auditoria
					$info_nota = $this->notas_model->dados_notas($id_nota_fiscal);
					$auditoria = array(
							'auditoria' => "Incluiu nova nota fiscal de n° $info_nota->numero, expedida pela $info_nota->empresa, no sistema",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'inserir');
					# .Bloco de auditoria
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
					redirect("clog/notas/itens_nota/$id_nota_fiscal");
				} else {
					# Bloco de auditoria
					$auditoria = array(
							'auditoria' => "Tentativa de incluir uma nova nota fiscal no sistema",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'inserir');
					# .Bloco de auditoria
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro! Não foi possível incluir a nota!'));
					redirect('clog/notas/index');
				}
			} else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao salvar!'));
				redirect('clog/notas/index');
			}
		} else
			redirect('clog/notas/index');# Caso não tenha sido enviado nenhum POST.
	}

	public function itens_nota($id_nota) {
		if (isset($id_nota)) {
			# Listar todos os produtos.
			$produtos = $this->produtos_model->getProdutos();

			# Lista de todos os serviços.
			$tipo_servicos = $this->clog_model->listar('tipo_servicos')->result();

			# Informações da nota fiscal.
			$info_nota = $this->clog_model->listar('notas_fiscais', $id_nota)->row();

			# Listagem de todos os itens já cadastrados na nota fiscasl.
			$itens = $this->notas_model->itens_notas($id_nota)->result();

			$data = $this->load->view('notas/itens_nota', array('id_nota' => $id_nota, 'info_nota' => $info_nota, 'tipo_servicos' => $tipo_servicos, 'produtos' => $produtos, 'itens' => $itens), TRUE);
			$this->load->view('layout/index', array('layout' => $data), FALSE);

			if ($this->input->server('REQUEST_METHOD') == 'POST') {
				# Adicionar item a nota fiscal.
				//$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item adicionado com sucesso!'));
				//var_dump($id_nota);
				$this->add_itens_nota($id_nota);
			}
		} else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao entrar na página, você acabou de ser redirecionado para página de cadastro das notas notas_fiscais!'));
			redirect('clog/notas/index');
		}
	}

	public function add_itens_nota($id_nota) {
		# Adicionar itens a nota fiscal.
		$controle = $this->notas_model->add_item($id_nota);
		if ($controle === FALSE) {
		# Bloco de auditoria
			$auditoria = array(
					'auditoria' => "Tentativa de incluir novo item na nota fiscal ID n° $id_nota",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'inserir');
		# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao adicionar o item a nota, por favor, verifique se o preenchimento do formulário está correto!'));
		}
		else {
			# Bloco de auditoria
			$info_nota = $this->notas_model->dados_notas($id_nota);
			$auditoria = array(
					'auditoria' => "Incluiu novo item($controle->modelo) na nota fiscal de n° $info_nota->numero, expedida pela $info_nota->empresa",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'inserir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item adicionado com sucesso!'));
		}
		redirect("clog/notas/itens_nota/$id_nota");
	}

	public function excluir_itens_nota($id_item_nota, $id_nota) {
		# Dados para a auditoria
		$info_nota = $this->notas_model->getInfoNotas($id_nota)->row();
		$info_item = $this->notas_model->getItemNota($id_item_nota);
		if (isset($id_item_nota)) {
			$exclusao = $this->notas_model->excluir_item_nota($id_item_nota);
			if (! $exclusao) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Erro. O item de ID n° $id_item_nota ($info_item->modelo) não foi excluído!"));
				# Bloco de auditoria
				$auditoria = array(
						'auditoria' => "Tentativa de excluir o item ID n° $id_item_nota ($info_item->modelo), da nota n° $info_nota->numero, expedida pela empresa $info_nota->empresa",
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'excluir');
				# .Bloco de auditoria
			} else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => "O item ID n° $id_item_nota ($info_item->modelo) foi excluído com sucesso!"));
				# Bloco de auditoria
				$auditoria = array(
						'auditoria' => "Excluiu o item ID n° $id_nota($info_item->modelo), da nota n° $info_nota->numero, expedida pela empresa $info_nota->empresa",
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'excluir');
				# .Bloco de auditoria
			}
			redirect("clog/notas/itens_nota/$id_nota");
		} else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Erro. O item ou sua nota não existem no sistema!"));
			redirect('clog/notas/index');
		}
	}

	public function entrada_avulsa() {
		# Pegando o ID do Almoxarifado Principal
		$almox = $this->clog_model->getAlmox();
		if (! $almox) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Procure o administrador, não existe almoxarifado principal cadastrado!"));
			redirect('clog/index');
		}
		# Carregando os selects
		$entradas = $this->notas_model->listarEntradasAvulsas(10);
		$produtos = $this->produtos_model->getProdutos();
		$setores = $this->clog_model->getLotacoes();
		$conteudo = $this->load->view('notas/entrada_avulsa', array('produtos' => $produtos, 'setores'=>$setores, 'entradas'=>$entradas, 'almox'=>$almox), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
		# Processando quando tem POST
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			# Pegando os valores do POST que servem de filtro
			$filter = array(
				'lotacoes_id'=> $this->input->post('setores'),
				'produtos_id'=> $this->input->post('produtos'), 
			);
			# Pegando a quantidade do POST
			$value['quantidade'] = $this->input->post('quantidade');
			# Testando se será atualização ou inserção
			$controle = $this->db->get_where('estoques', $filter);
			$estoque = $controle->row();
			# Para a auditoria
			$qde = $value['quantidade'] + (($controle->num_rows() > 0) ? $estoque->quantidade : 0);
			$setor = $this->clog_model->getByID('lotacoes', $filter['lotacoes_id'])->row();
			$produto = $this->clog_model->getByID('produtos', $filter['produtos_id'])->row();
			$msgAudit = $value['quantidade']." unidade(s) do produto <em>".$produto->modelo."</em> no estoque do ".$setor->sigla;
			$msgAuditIns = "Incluiu, avulso, ".$msgAudit;
			$msgAuditUpd = "Acrescentou, avulso, ".$msgAudit;
			# Pegando a quantidade para incluir/alterar no banco 
			$quant['quantidade'] = $qde;
			# Incluindo em entradas_avulsas
			$_avulsa = array(
				'idproduto' => $filter['produtos_id'], 
				'quantidade' => $value['quantidade'],
				'estoque' => $filter['lotacoes_id'],
				'data_inclusao' => date('Y-m-d H:i:s'),
				'idmilitar' => $this->session->userdata['id_militar']
				);
			$this->clog_model->inserir($_avulsa, 'entradas_avulsas');
			# Incluindo avulsa_id
			$avulsa_id = $this->db->insert_id();
			# Atualização
			if ($controle->num_rows() > 0) {
				$this->db->where($filter);
				$this->db->update('estoques', $quant);
				# Para a auditoria
				$actAudit = "alterar";
				$msgAudit = $msgAuditUpd;
			}
			# Inserção
			else {
				# Somando os arrays
				$data = array_merge($filter, $quant);
				$this->db->insert('estoques', $data);
				# Para a auditoria
				$actAudit = "inserir";
				$msgAudit = $msgAuditIns;
			}
			# Testa se tem tombos e tenta incluir na tabela patrimonio
			if ($this->input->post('numero_tombo') != "") {
				# Somando os arrays
				$data = array_merge($filter, $value);
				# Incluindo os tombos
				$data['tombos'] = $this->input->post('numero_tombo');
				# Incluindo notas_fiscais_id como NULL
				$data['notas_fiscais_id'] = NULL;
				# Incluindo avulsa_id
				$data['avulsa_id'] = $avulsa_id;
				# Incluindo tipo tombo
				$data['tipo_tombo'] = $this->input->post('tipo_tombo');
				$res = $this->notas_model->incluiTombos($data);
				if ($res !== TRUE) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro, produto(s) não incluído(s)!'));
					redirect('clog/notas/entrada_avulsa');
					# Bloco de auditoria
					$auditoria = array(
						'auditoria' => "Tentativa de incluir material permanente: ".$value['quantidade']." unidade(s) do produto <em>".$produto->modelo."</em> no estoque do ".$setor->sigla,
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'inserir');
					# .Bloco de auditoria
					die();
				}
			}
			# Retorno
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Produto(s) incluído(s), estoque atualizado!'));
				# Bloco de auditoria
				$auditoria = array(
					'auditoria' => "$msgAudit!",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, $actAudit);
				# .Bloco de auditoria
			}
			else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro, produto(s) não incluído(s)!'));
				# Bloco de auditoria
				$auditoria = array(
					'auditoria' => "Tentativa de incluir $msgAudit!",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, $actAudit);
				# .Bloco de auditoria
			}
			redirect('clog/notas/entrada_avulsa');
		}
	}

	public function excluir_avulsa() {
		$id = $this->input->get('id');
		# Testando se tem saída de produto permanente
		$hasTombos = $this->db->get_where('patrimonio', array('avulsa_id'=>$id));
		if ($hasTombos->num_rows() > 0) {
			$err_count = 0;
			$info = '';
			foreach ($hasTombos->result() as $row) {
				$teste = $this->produtos_model->tomboHasSaida($row->tombo);
				if ($teste !== FALSE) {
					switch ($teste->distribuicao) {
						case '0':
							$tp = 'Cautela';
							break;
						
						case '1':
							$tp = 'Distribuição';
							break;

						case '2':
							$tp = 'Transferência';
							break;
					}
					$info .= "Tombo ".$row->tombo.", na $tp nº ".$teste->cautelas_id;
					$err_count = $err_count + 1;
				}
			}
			if ($err_count > 0) {
				# Bloco de auditoria
				$auditoria = array(
					'auditoria' => 'Tentativa de excluir os produtos da entrada avulsa n° ' . $id,
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'excluir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Existem pendências: '.$info));
				redirect('clog/notas/listar_avulsas');
			}
		}
		$avulsa = $this->notas_model->getEntradaAvulsa($id)->row();
		$controle = $this->notas_model->excluir_entrada_avulsa($id);
		if (! $controle) {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => 'Tentativa de excluir os produtos da entrada avulsa n° ' . $id,
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'A entrada avulsa não foi excluída com sucesso!'));
		}
		else {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => 'Excluída a entrada avulsa n° '.$id.' e o(s) produto(s), <em>'.$avulsa->produto.'</em>, do estoque do(a) '.$avulsa->estoque,
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'A entrada avulsa foi excluída com sucesso!'));
		}
		redirect('clog/notas/listar_avulsas');
	}

	public function listar_avulsas() {
		$entradas = $this->notas_model->listarEntradasAvulsas();
		$conteudo = $this->load->view('notas/listar_entradas_avulsas', array('entradas'=>$entradas), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	/**
	 * @param $id int
	 *
	 */
	public function excluir_nota($id) {
		# Dados para a auditoria
		$info_nota = $this->notas_model->dados_notas($id);
		# Excluir nota fiscal caso ainda não tenha sido concluída.
		if ($this->notas_model->excluir_nota($id) >= 1) {
			# Bloco de auditoria
			$auditoria = array(
					'auditoria' => "Excluiu a nota fiscal de n° $info_nota->numero, expedida pela $info_nota->empresa",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Nota Fiscal excluída com sucesso!'));
		} else {
			# Bloco de auditoria
			$auditoria = array(
					'auditoria' => 'Tentativa de excluir a nota fiscal ID n° ' . $id,
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Nota Fiscal não foi excluída com sucesso!'));
		}
		redirect('clog/notas/index');
	}

	public function excluir_nota_concluida($id) {
		$excluir = $this->notas_model->excluir_nota_concluida($id);
		# Excluindo a nota
		if ($excluir === TRUE) {
			# Bloco de auditoria
			$auditoria = array(
					'auditoria' => 'Excluiu a nota fiscal ID n° ' . $id,
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Nota Fiscal excluída com sucesso!'));
		} 
		else {
			# Bloco de auditoria
			$auditoria = array(
					'auditoria' => 'Tentativa de excluir a nota fiscal ID n° ' . $id,
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			# Retorno para o usuário
			$msg = (is_array($excluir) && $excluir['status'] === FALSE)? $excluir['msg'] : "O sistema não conseguiu excluir a nota!";
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => $msg));
		}
		redirect('clog/notas/consulta');
	}

	public function consulta() {
		# Listar Empresas.
		$listar_empresas = $this->clog_model->listar('empresas')->result();
		//var_dump($listar_empresas);
		# Views de consulta de notas fiscais.
		$notas = $this->load->view('notas/consulta', array('empresas' => $listar_empresas), TRUE);
		$this->load->view('layout/index', array('layout' => $notas), FALSE);
	}

	/**
	 * @param empty
	 * Consultar nota fiscal.
	 */
	public function consulta_notas_fiscais() {
		# Inicialização de array.
		$filter = array();

		if ($this->input->get("nota_fiscal") != "") {
			$filter['nota_fiscal'] = $this->input->get("nota_fiscal");
		}

		if ($this->input->get("data") != "") {
			$filter['data'] = $this->input->get("data");
		}

		if ($this->input->get("empresas_id") != 0) {
			$filter['empresas_id'] = $this->input->get("empresas_id");
		}

		$consulta = $this->notas_model->consulta_notas_fiscais($filter)->result();
		# Bloco de auditoria
				/* $auditoria = array(
					'auditoria'=>'Consultou notas fiscais',
					'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo'=>$this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'consultar'); */
		# .Bloco de auditoria
		$this->load->view('notas/resultado_consulta', array('consulta' => $consulta), FALSE);
	}

	/**
	 * @param empty
	 * Concluir notas fiscais, pegando pelo method GET dados da nota!
	 */
	public function concluir_notas_fiscais() {
		# GETs
		$data = array(
				'valor_final' => $this->input->get('valor'),
				'id_nota_fiscal' => $this->input->get('id')
		);
		# Tentativa de atualizar o estoque...
		$estoque = $this->notas_model->concluir_atualizar_estoque($data['id_nota_fiscal']);
		# Se atualizou...
		if ($estoque === TRUE) {
			# Bloco de auditoria
			$auditoria = array(
					'auditoria' => 'Atualizou o estoque incluindo os itens da nota ID nº ' . $data['id_nota_fiscal'],
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			# Concluindo a nota...
			$concluir = $this->notas_model->concluir_notas_fiscais($data);
			# Se concluiu...
			if ($concluir === TRUE) {
				# Bloco de auditoria
				$auditoria = array(
						'auditoria' => 'Concluiu a nota ID nº ' . $data['id_nota_fiscal'],
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Nota fiscal concluída com sucesso!'));
				redirect('clog/notas/index');
			} 
			# Se não...
			else {
				# Bloco de auditoria
				$auditoria = array(
						'auditoria' => 'Tentativa de conclusão da nota ID nº ' . $data['id_nota_fiscal'],
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Estoque atualizado, mas houve um erro na conclusão da nota fiscal!'));
			}
		}
		# Se não...
		else {
			# Bloco de auditoria
			$auditoria = array(
					'auditoria' => 'Tentativa de atualizar o estoque incluindo os itens da nota ID nº ' . $data['id_nota_fiscal'],
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao concluír nota fiscal, estoque inalterado!'));
			redirect('clog/notas/index');
		}
	}

}
