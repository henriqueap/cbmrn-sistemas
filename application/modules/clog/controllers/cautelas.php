<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Cautelas extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('acesso_model', 'clog_model', 'militares_model', 'cautelas_model', 'produtos_model'));
		$this->load->library(array('auth'));
		if (FALSE === $this->session->userdata('militar')) {
			$this->session->set_flashdata('msg', array('type' => 'alert-danger', 'msg' => 'O sistema fechou por inatividade!'));
			redirect("acesso");
		}
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		# Index.
		$tipo_saida = (FALSE !== $this->input->get('tp')) ? $this->input->get('tp') : 0;
		$setores = $this->clog_model->getLotacoes()->result();
		$estoques = $this->clog_model->getEstoques();
		$cautelas = $this->load->view('cautelas/index', array('setores' => $setores, 'estoques' => $estoques, 'tipo_saida' => $tipo_saida), TRUE);
		$this->load->view('layout/index', array('layout' => $cautelas), FALSE);
	}

	public function consulta_cautelas() {
		#$produtos = $this->clog_model->getAll('produtos');
		#$cautelas = $this->load->view('cautelas/consulta', array('produtos'=>$produtos), TRUE);
		$setores = $this->clog_model->getLotacoes()->result(); # Alterar banco vazio
		$cautelas = $this->load->view('cautelas/consulta', array('tipo_saida' => 0), TRUE);
		$this->load->view('layout/index', array('layout' => $cautelas), FALSE);
	}

	public function consulta_distros() {
		$setores = $this->clog_model->getLotacoes()->result(); # Alterar banco vazio
		$cautelas = $this->load->view('cautelas/consulta', array('setores' => $setores, 'tipo_saida' => 1), TRUE);
		$this->load->view('layout/index', array('layout' => $cautelas), FALSE);
	}

	public function consulta_transferencias() {
		$sala = (!($this->input->get('sala')))? 0 : 1;
		if ($sala == 1) {
			$salas = $this->clog_model->getSalas()->result(); # Alterar banco vazio
			$cautelas = $this->load->view('cautelas/consulta_transferencias_sala', array('salas' => $salas), TRUE);
		}
		else {
			$setores = ($sala == 1)? $this->clog_model->getSalas()->result() : $this->clog_model->getLotacoes()->result(); # Alterar banco vazio
			$cautelas = $this->load->view('cautelas/consulta', array('setores' => $setores, 'tipo_saida' => 2), TRUE);
		}
		$this->load->view('layout/index', array('layout' => $cautelas), FALSE);
	}

	public function consulta_patrimonio_sala() {
		$salas = $this->clog_model->getSalas();
		$conteudo = $this->load->view('cautelas/consulta_salas', array('salas' => $salas, 'tipo_saida' => 2), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function consulta_tombo() {
		$setores = $this->clog_model->getLotacoes()->result(); # Alterar banco vazio
		$pesquisa_tombo = $this->load->view('cautelas/consulta_tombo', array('setores' => $setores, 'tipo_saida' => 2), TRUE);
		$this->load->view('layout/index', array('layout' => $pesquisa_tombo), FALSE);
	}

	public function transferencia_material() {
		$setores = $this->clog_model->getLotacoes();
		$estoques = $this->clog_model->getEstoques();
		$cautelas = $this->load->view('cautelas/transferencia_material', array('setores' => $setores, 'estoques' => $estoques, 'tipo_saida' => 2), TRUE);
		$this->load->view('layout/index', array('layout' => $cautelas), FALSE);
	}

	public function filtra_cautela() {
		$sala = (FALSE === $this->input->get('sala'))? 0 : 1; 
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			# Aplicando filtro
			if ($this->input->post('distribuicao') < 2) {
				if ($this->input->post('distribuicao') == 1) {
					$filter = array(
						"matricula" => $this->input->post('matricula'),
						"data_inicio" => $this->clog_model->formataData($this->input->post('data_inicio')),
						"data_fim" => $this->clog_model->formataData($this->input->post('data_fim')),
						"uso_distro" => $this->input->post('uso_distro')
					);
					$uso_distro = ($filter['uso_distro'] !== FALSE) ? ' para Militar' : ' para Setor';
					$cautelas = $this->cautelas_model->consulta_distro($filter);
					$lista = $this->load->view('cautelas/material_distribuido', array('cautelas' => $cautelas, 'tp_uso' => $uso_distro), TRUE);
				}
				else {
					$filter = array(
						"matricula" => $this->input->post('matricula'),
						"data_inicio" => $this->clog_model->formataData($this->input->post('data_inicio')),
						"data_fim" => $this->clog_model->formataData($this->input->post('data_fim')),
						"concluida" => $this->input->post('concluida')
					);
					$cautelas = $this->cautelas_model->consulta_cautela($filter);
					$lista = $this->load->view('cautelas/lista_cautelas', array('cautelas' => $cautelas), TRUE);
				}
				# Bloco de auditoria
				/* $auditoria = array(
					'auditoria'=>'Consultou saída de material',
					'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo'=>$this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'consultar'); */
				# .Bloco de auditoria
			}
			else {
				$filter = array(
					"setor_id" => $this->input->post('setor_id'),
					"data_inicio" => $this->input->post('data_inicio'),
					"data_fim" => $this->input->post('data_fim'),
					"sala" => $sala
				);
				$cautelas = $this->cautelas_model->consulta_transferencia($filter);
				$lista = $this->load->view('cautelas/material_transferido', array('cautelas' => $cautelas, 'sala' => $sala), TRUE);
			}
			$this->load->view('layout/index', array('layout' => $lista), FALSE);
		}
	}

	public function saida_retroativa() {
		# Index.
		$setores = $this->clog_model->getLotacoes()->result();
		$saidaRetro = $this->load->view('cautelas/saida_retroativa', array('setores' => $setores), TRUE);
		$this->load->view('layout/index', array('layout' => $saidaRetro), FALSE);
	}

	public function salvar_cautela() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tp = $this->input->post('tipo_saida');
			$data['data_cautela'] = date('Y-m-d');
			$data['militares_id'] = $this->input->post('chefe_militares_id');
			# Tratando se o usuário é do setor
			if (FALSE !== $this->input->post('estoque_origem') && ($this->input->post('estoque_origem') != $this->session->userdata('lotacao_id'))) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "O usuário logado não pertence ao setor!"));
				redirect("clog/cautelas/index?tp=$tp");
			}
			# Tratando se foi selecionado o setor destino
			if (FALSE !== $this->input->post('setor_id') && $this->input->post('setor_id') == "0") {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa selecionar o destino!'));
				redirect("clog/cautelas/index?tp=$tp");
			}
			else {
				$data['setor_id'] = (FALSE === $this->input->post('setor_id'))? NULL : $this->input->post('setor_id');
			}
			# var_dump($data['setor_id']); die();
			# Tratando estoque vazio
			$data['estoques_id'] = (FALSE !== $this->input->post('estoque_origem') && $this->input->post('estoque_origem') != 0) ? $this->input->post('estoque_origem') : 19;
			if (FALSE === $this->cautelas_model->getProdutos(array('estoques_id' => $this->input->post('estoque_origem')))) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Esse estoque não possui produtos!'));
				redirect('clog/cautelas/index?tp=$tp');
			}
			else {
				# Testando se passou um tombo
				if (FALSE !== $this->input->post('tombo')) {
					$data['tombo'] = $this->input->post('tombo');
					# Testando se o tombo existe
					$tombo_info = $this->cautelas_model->validarTombo($data['tombo']);
					//var_dump($tombo_info); die();
					# Tratando o tombo
					if (FALSE !== $tombo_info) {
						# Se associado a cautela não concluída..
						if ($tombo_info->distribuicao < 1) {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Tombo indisponível, associado a uma cautela não concluída'));
							redirect("clog/cautelas/transferencia_patrimonio");
						}
						# Se associado a uma distro...
						if ($tombo_info->distribuicao == 1) {
							# Em distro não concluída, indisponível
							if ($tombo_info->finalizada == 0) {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Tombo indisponível, associado a uma distribuição não concluída'));
								redirect("clog/cautelas/transferencia_patrimonio");
							}
						}
					}
				}
				# Se não passou tombo, será saída de material
				else {
					# Tratando qual será o tipo de saída de material
					if (FALSE !== $this->input->post('data_prevista')) {
						# Testa se é cautela ou distribuição
						if ($this->input->post('data_prevista') != "") {
							$data['data_prevista'] = $this->clog_model->formataData($this->input->post('data_prevista'));
							$data['distribuicao'] = 0;
							$msg = "Cautela iniciada com sucesso!";
						}
						else {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa selecionar a data de devolução!'));
							redirect("clog/cautelas/index?tp=$tp");
						}
					}
					else {
						$data['data_prevista'] = NULL;
						$data['distribuicao'] = 1;
						$msg = "Distribuição iniciada com sucesso!";
					}
					# Salvando a nova saída de material
					$query = $this->clog_model->salvar('cautelas', $data);
					# Gerando o retorno da saída
					if ($query) {
						$id = $this->db->insert_id();
						# echo "<pre>"; var_dump($id); echo "</pre>"; die();
						# Bloco de auditoria
						$info_cautela = $this->cautelas_model->getCautela($id);
						if ($info_cautela !== FALSE) {
							$info_cautela = $this->cautelas_model->getCautela($id)->row();
							switch ($info_cautela->distribuicao) {
								case '0':
									$msg_aud = "Inciou Cautela nº $id do estoque do $info_cautela->estoque_origem para o(a) $info_cautela->militar, com devoução prevista para $info_cautela->data_prevista";
									break;
								
								case '1':
									$recebedor = (is_null($info_cautela->setor)) ? $info_cautela->militar : $info_cautela->setor;
									$msg_aud = "Inciou Distribuição nº $id, do estoque do $info_cautela->estoque_origem para o(a) $recebedor";
									break;
									
								case '2':
									$msg_aud = "Inciou Transferência nº $id, do estoque do $info_cautela->estoque_origem) para o(a) $info_cautela->setor";
									break;

								default:
									$msg_aud = "Inciou Saída de Material, do estoque do $info_cautela->estoque_origem!";
									break;
							}
							$auditoria = array(
								'auditoria' => $msg_aud,
								'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo' => $this->session->userdata['sistema']
							);
						}
						else {
							$msg_aud = "Inciou Saída de Material...";
						}
						$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => $msg));
						redirect("clog/cautelas/criar_cautela/$id");
					}
					else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível concluir sua requisição!'));
						redirect('clog/cautelas/index?tp=$tp');
					}
				}
			}
		} // Method POST.
		else redirect('clog/index');
	}

	public function transferir_material() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			# Tratando se foi selecionado o militar
			if ($this->input->post('chefe_militares_id') == "") {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa digitar a matrícula do solicitante!'));
				redirect('clog/cautelas/transferencia_material');
			}
			else
				$data['militares_id'] = $this->input->post('chefe_militares_id');
			# Tratando se foi selecionado o estoque de origem
			if ($this->input->post('estoque_origem') == "0") {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa selecionar a origem!'));
				redirect('clog/cautelas/transferencia_material');
			}
			else
				# Tratando se o usuário é do setor
				if ($this->input->post('estoque_origem') != $this->session->userdata('lotacao_id')) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não pertence ao setor!'));
					redirect('clog/cautelas/transferencia_material');
				}
				$data['estoques_id'] = $this->input->post('estoque_origem');
				$origem = $this->clog_model->getByID('lotacoes', $data['estoques_id'])->row();
			# Tratando se foi selecionado o estoque destino
			if ($this->input->post('estoque_destino') == "0") {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa selecionar o destino!'));
				redirect('clog/cautelas/transferencia_material');
			}
			else {
				$data['setor_id'] = $this->input->post('estoque_destino');
				$estoque = $this->clog_model->getByID('lotacoes', $data['setor_id'])->row();
			}
			# Tratando se há data de saída
			$data['data_cautela'] = ((FALSE === $this->input->post('data_saida')) || ("" == $this->input->post('data_saida'))) ? date('Y-m-d') : $this->clog_model->formataData($this->input->post('data_saida'));
			# Especificando o tipo de saída
			$data['distribuicao'] = 2;
			# Salvando a nova saída de material
			//var_dump($data); die();
			$query = $this->clog_model->salvar('cautelas', $data);
			# Auditando
			if ($query) {
				$id = $this->db->insert_id();
				# Bloco de auditoria
				$auditoria = array(
					'auditoria' => "Iniciou distribuição de material do(a) $origem->sigla para o estoque do(a) $estoque->sigla, sob o nº " . $id,
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Transferência de material entre estoques iniciada!'));
				redirect("clog/cautelas/criar_cautela/$id");
			}
		}
	}

	public function criar_cautela($id) {
		$tombo_info = array();
		$cautela = $this->cautelas_model->getCautela($id);
		#Testa se existe a cautela
		if ($cautela !== FALSE) {
			# Recupera os dados da cautela
			$info_cautela = $cautela->row();
			if ($info_cautela->ativa == 0) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Esta cautela não pode mais ser alterada!'));
				redirect("clog/index");
			}
			# Tratando se o usuário é do setor
			if ($info_cautela->origem_id != $this->session->userdata('lotacao_id')) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "O usuário logado não pertence ao setor!"));
				redirect("clog/index");
			}
			# Dados para a auditoria
			switch ($info_cautela->distribuicao) {
				case '0':
					$saida = "Cautela nº $id, do estoque do(a) $info_cautela->estoque_origem,";
					break;
				
				case '1':
					$recebedor = (is_null($info_cautela->setor)) ? $info_cautela->militar : $info_cautela->setor;
					$saida = "Distribuição nº $id, do estoque do(a) $info_cautela->estoque_origem para o(a) $recebedor,";
					break;
					
				case '2':
					$saida = "Transferência nº $id, do estoque do(a) $info_cautela->estoque_origem para o(a) $info_cautela->setor,";
					break;

				default:
					$saida = "Saída de Material...";
					break;
			}
			# Recupera os produtos do estoque?
			$tipo = ($info_cautela->distribuicao == 2) ? 1 : 0;
			$produtos = $this->produtos_model->consulta_produtos_estoque(array('lotacoes_id'=>$info_cautela->origem_id, 'tipo'=>$tipo));
			$itens = $this->cautelas_model->getItens($id);
			$patrimonio = $this->cautelas_model->getTombobyCautela($id);
			if ($patrimonio !== FALSE) {
				foreach ($patrimonio->result() as $value) {
					$tombo_info[$value->id] = $value->tombo;
				}
			}
			#Inclui os itens na cautela
			if ($this->input->server('REQUEST_METHOD') == 'POST') {
				# Tratando se o usuário é do setor
				if ($this->input->post('estoques_id') != $this->session->userdata('lotacao_id')) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "O usuário logado não pertence ao setor!"));
					redirect("clog/cautelas/criar_cautela/" . $id);
				}
				# Criando um array com os dados do post
				$data = array(
					'cautelas_id' => $id,
					'produtos_id' => $this->input->post('produtos_cautela'),
					'produtos_qde' => $this->input->post('quantidade_itens'),
					'tipo_produto' => $this->input->post('consumo'),
					'estoques_id' => $this->input->post('estoques_id')
				);
				# Tratando a quantidade
				if (1 > $data['produtos_qde']) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O campo quantidade deve ser maior que zero!'));
					redirect("clog/cautelas/criar_cautela/" . $id);
				}
				# Incluindo o material de consumo
				if (0 == $data['tipo_produto']) {
					$tombos = NULL;
					#Inclui os ítens
					$inclui = $this->cautelas_model->add_itens($id, $data, $tombos);
					# Incluiu...
					if ($inclui !== FALSE) {
						$produto = $this->clog_model->getByID('produtos', $data['produtos_id'])->row();
						# Bloco de auditoria
						$auditoria = array(
							'auditoria' => "Incluiu na $saida $produto->modelo(".$data['produtos_qde']."), material de consumo",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
						);
						$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item incluído com sucesso!'));
						redirect("clog/cautelas/criar_cautela/" . $id);
					}
					# Não incluiu...
					else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível incluir o item! Verifique a quantidade em estoque.'));
						redirect("clog/cautelas/criar_cautela/" . $id);
					}
				}
				# Incluindo o material permanente
				else if (1 == $data['tipo_produto']) {
					if (NULL !== $this->input->post('numero_tombo') && $this->input->post('numero_tombo') != '') {
						# Procura as vírgulas e quebra a string em array
						$tombos = explode(",", $this->input->post('numero_tombo'));
						if (count($tombos) > 0) {
							$t = 0;
							$novo_arr = array();
							for ($i = 0; $i < sizeof($tombos); $i++) {
								# Inclui os tombos de intervalos
								if (substr_count($tombos[$i], "-") > 0) {
									# Encontra as extremidades e preenche se o intervalo está coerente
									$tombos_group = explode("-", trim($tombos[$i]));
									if ($tombos_group[0] < $tombos_group[1]) {
										$n = (int) $tombos_group[0];
										while ($n <= $tombos_group[1]) {
											$novo_arr[$t] = $n;
											$n++;
											$t++;
										}
									} else {
										$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O campo número de tombo não foi preeenchido corretamente!'));
										redirect("clog/cautelas/criar_cautela/" . $id);
										die();
									}
								}
								# Inclui os tombos que não são intervalos
								else {
									$novo_arr[$t] = trim($tombos[$i]);
									$t++;
								}
							}
							# Testa se a quantidade de tombos equivale a de produtos
							if (count($novo_arr) != (int) $data['produtos_qde'])
								return FALSE;
							else {
								#Incluindo os ítens
								$inclui = $this->cautelas_model->add_itens($id, $data, $novo_arr);
								if ($inclui !== FALSE) {
									$produto = $this->clog_model->getByID('produtos', $data['produtos_id'])->row();
									if (is_int($inclui)) {
										if ($inclui == $data['produtos_qde']) {
											# Bloco de auditoria
											$auditoria = array(
													'auditoria' => "Tentativa de inclusão na $saida $produto->modelo(".$data['produtos_qde']."), material permanente",
													'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
													'idmodulo' => $this->session->userdata['sistema']
											);
											$this->clog_model->audita($auditoria, 'inserir');
											# .Bloco de auditoria
											$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Itens não incluídos!'));
										} 
										else 
											$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Alguns itens não foram incluídos!'));
									}
									else {
										# Bloco de auditoria
										$auditoria = array(
												'auditoria' => "Incluiu na $saida $produto->modelo(".$data['produtos_qde']."), material permanente",
												'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo' => $this->session->userdata['sistema']
										);
										$this->clog_model->audita($auditoria, 'inserir');
										# .Bloco de auditoria
										$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Incluído com sucesso!'));
									}
									redirect("clog/cautelas/criar_cautela/" . $id);
								}
							}
						}
					} 
					else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O campo número de tombo não foi preeenchido!'));
						redirect("clog/cautelas/criar_cautela/" . $id);
						die();
					}
				}
				# O usuário não selecionou uma opção válida
				else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Campos prenchidos incorretamente.'));
					redirect("clog/cautelas/criar_cautela/" . $id);
				}
			}
			#Carrega os itens da cautela
			else {
				$adicionar = $this->load->view('cautelas/adicionar', array('id' => $id, 'produtos' => $produtos, 'cautela' => $cautela->row(), 'itens' => $itens, 'tombo_info' => $tombo_info), TRUE);
				$this->load->view('layout/index', array('layout' => $adicionar), FALSE);
			}
		}
		#Se não existir, erro
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não existe cautela com este número!'));
			redirect("clog/index");
		}
		#$adicionar = $this->load->view('cautelas/adicionar', array('id'=>$id, 'produtos'=>$produtos, 'cautela'=>$cautela->row(), 'itens'=>$itens), TRUE);
		#$this->load->view('layout/index', array('layout'=>$adicionar), FALSE);
	}

	public function cautelar() {
		# Cautelar itens.
		$id = $this->input->get('id');
		$cautela = $this->cautelas_model->getCautela($id);
		# var_dump($cautela); die();
		$itens = $this->cautelas_model->getItens($id);
		$tombos = $this->cautelas_model->getTombobyCautela($id);
		if ($itens === FALSE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa incluir um item pelo menos!'));
			redirect("clog/cautelas/criar_cautela/$id");
		}
		else {
			$data = $this->load->view('cautelas/cautela', array('cautela' => $cautela->row(), 'itens' => $itens, 'tombos' => $tombos), TRUE);
			$this->load->view('layout/index', array('layout' => $data), FALSE);
		}
	}

	public function imprimir() {
		# Imprimir cautela.
		$id = $this->input->get('id');
		$cautela = $this->cautelas_model->getCautela($id);
		$itens = $this->cautelas_model->getItens($id);
		$tombos = $this->cautelas_model->getTombobyCautela($id);
		if ($itens === FALSE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa incluir um item pelo menos!'));
			redirect("clog/cautelas/index");
		}
		else {
			if (FALSE !== $tombos)
				$this->load->view('cautelas/termo_entrega', array('cautela' => $cautela->row(), 'itens' => $itens, 'tombos' => $tombos), FALSE);
			else
				$this->load->view('cautelas/termo_entrega', array('cautela' => $cautela->row(), 'itens' => $itens), FALSE);
		}
	}

	public function mostrar() {
		# Cautelar itens.
		$id = $this->input->get('id');
		$cautela = $this->clog_model->getByID('cautelas', $id)->row();
		$itens = $this->cautelas_model->getItens($id);
		if ($itens === FALSE || $cautela->finalizada == 0) {
			# $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Esta cautela não possui itens!'));
			redirect("clog/cautelas/criar_cautela/$id"); # Checar permissões
		}
		else {
			redirect("clog/cautelas/cautelar?id=$id"); # Checar permissões
		}
	}

	public function finalizar_cautela() {
		$id = $this->input->get('id');
		$controle = $this->cautelas_model->getCautela($id);
		#Testa se existe a cautela
		if (!is_bool($controle)) {
			$valor = $controle->num_rows();
			$cautela = $controle->row();
			# Tratando se o usuário é do setor
			if ($cautela->origem_id != $this->session->userdata('lotacao_id')) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não pertence ao setor!'));
				redirect("clog/index");
			}
			# Dados para a auditoria
			switch ($cautela->distribuicao) {
				case '0':
					$saida = "Cautela nº $id do estoque do(a) $cautela->estoque_origem para o(a) $cautela->militar, com devoução prevista para $cautela->data_prevista";
					break;
				
				case '1':
					$recebedor = (is_null($cautela->setor)) ? $cautela->militar : $cautela->setor;
					$saida = "Distribuição nº $id, do estoque do(a) $cautela->estoque_origem, para o(a) $recebedor";
					break;
					
				case '2':
					$saida = "Transferência nº $id, do estoque do(a) $info_cautela->estoque_origem para o(a) $cautela->setor";
					break;

				default:
					$saida = "Saída de Material...";
					break;
			}
			if ($valor > 0) {
				#Testa se o estoque foi alterado
				switch ($cautela->distribuicao) {
					case 2:
						$conclusao = $this->cautelas_model->atualiza_estoques($id);
						break;
					case 1:
						$conclusao = (is_null($cautela->setor))? $this->cautelas_model->retira_material($id) : $this->cautelas_model->atualiza_estoques($id);
						break;
					default:
						$conclusao = $this->cautelas_model->retira_material($id);
						break;
				}
				if ($conclusao !== FALSE) {
					$data = array(
						'id' => $id,
						'finalizada' => 1
					);
					# Tratando distros e trans
					if ($cautela->distribuicao > 0) {
						$data['concluida'] = 1;
						$data['data_conclusao'] = NULL;
						# Tratando transferência entre estoques
						if ($cautela->distribuicao == 2) {
							# Recuperando os IDs dos tombos
							$tombos = $this->cautelas_model->getTombobyCautela($id);
							if (FALSE !== $tombos) {
								# Atualizando as tabelas
								foreach ($tombos->result() as $tombo) {
									# Alterando o estoque_id na tabela patrimônio
									$this->clog_model->atualizar('patrimonio', array('id'=>$tombo->id, 'estoques_id'=>$cautela->setor_id));
									# Inativando o item da distro anterior
									$this->cautelas_model->inativa_item($tombo->id);
								}
							}
						}
					}
					# Fechando a cautela ou distribuição
					$fechaCautela = $this->clog_model->atualizar('cautelas', $data);
					# Sucesso
					if ($fechaCautela == TRUE) {
						# Bloco de auditoria
						$auditoria = array(
							'auditoria' => "Concluiu a $saida",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
						);
						$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-success', 'msg' => "Saída de material concluída com sucesso!");
					}
					# Falha
					else {
						# Bloco de auditoria
						$auditoria = array(
							'auditoria' => "Tentativa de concluir a $saida",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
						);
						$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-danger', 'msg' => 'Não foi possível finalizar o processo!');
					}
				}
				# Mensagem de erro se não foi alterado o estoque
				else
					$msg = array('type' => 'alert-danger', 'msg' => 'Erro! Não tem em estoque ou está abaixo da quantidade mínima');
			}
		}
		#Se não existir
		else
			$msg = array('type' => 'alert-danger', 'msg' => 'Não existe cautela com este número!');
		#Gerando o retorno
		$this->session->set_flashdata('mensagem', $msg);
		redirect("clog/cautelas/index");
	}

	public function cancelar_item() {
		# Cancelar itens.
		$id_item = $this->input->get('id');
		$cautela = $this->clog_model->getByID("cautelas_has_produtos", $id_item)->row();
		$id_cautela = $cautela->cautelas_id;
		# Dados para a auditoria
		$info_cautela = $this->cautelas_model->getCautela($id_cautela);
		if ($info_cautela !== FALSE) {
			$info_cautela = $this->cautelas_model->getCautela($id_cautela)->row();
			# Tratando se o usuário é do setor
			if ($info_cautela->origem_id != $this->session->userdata('lotacao_id')) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não pertence ao setor!'));
				redirect("clog/index");
			}
			switch ($info_cautela->distribuicao) {
				case '0':
					$saida = "Cautela nº $id_cautela";
					break;
				
				case '1':
					$recebedor = (is_null($info_cautela->setor)) ? $info_cautela->militar : $info_cautela->setor;
					$saida = "Distribuição nº $id_cautela, do estoque do(a) $info_cautela->estoque_origem para o(a) $recebedor";
					break;
					
				case '2':
					$saida = "Transferência nº $id_cautela, do estoque do(a) $info_cautela->estoque_origem para o(a) $info_cautela->setor";
					break;

				default:
					$saida = "Saída de Material...";
					break;
			}
		}
		$cancelamento = $this->clog_model->excluir('cautelas_has_produtos', $id_item);
		if ($cancelamento === TRUE) {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Cancelou um item da $saida",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item cancelado com sucesso!'));
		}
		else {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Tentativa de cancelar um item da $saida nº $id_cautela do estoque do(a) $info_cautela->estoque_origem",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível cancelar o item de cautela!'));
		}
		redirect("clog/cautelas/criar_cautela/$id_cautela");
	}

	public function cancelar_cautela() {
		$id = $this->input->get('id');
		$count = 0;
		$data = array(
			'id' => $id,
			'cancelada' => 1,
			'concluida' => 1,
			'ativa' => 0,
			'data_conclusao' => date('Y-m-d H:i:s', strtotime('now'))
		);
		# Testa se existe a cautela
		$cautelaExists = $this->clog_model->getByID("cautelas", $id);
		# Se não existir
		if ($cautelaExists === FALSE) {
			$msg = array('type' => 'alert-danger', 'msg' => 'Não existe cautela com este ID!');
			$this->session->set_flashdata('mensagem', $msg);
			redirect("clog/index");
		}
		# Se existir, testa se tem itens
		else {
			# Dados para a auditoria
			$info_cautela = $this->cautelas_model->getCautela($id)->row();
			# Tratando se o usuário é do setor
			if ($info_cautela->origem_id != $this->session->userdata('lotacao_id')) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não pertence ao setor!'));
				redirect("clog/index");
			}
			switch ($info_cautela->distribuicao) {
				case '0':
					$saida = "Cautela nº $id";
					break;
				
				case '1':
					$recebedor = (is_null($info_cautela->setor)) ? $info_cautela->militar : $info_cautela->setor;
					$saida = "Distribuição nº $id, para o(a) $recebedor";
					break;
					
				case '2':
					$saida = "Transferência do estoque do $info_cautela->estoque_origem";
					break;

				default:
					$saida = "Saída de Material...";
					break;
			}
			$cautela = $cautelaExists->row();
			# Se houver, tenta atualizar o estoque
			if ($cautela !== FALSE) {
				# Testa se a cautela foi finalizada
				if ($cautela->finalizada == 1) {
					$tombos = "";
					# Tenta atualizar o estoque
					switch ($cautela->distribuicao) {
						case 2:
							# Checando se há saída de material de algum item
							foreach ($this->cautelas_model->getItens($id)->result() as $item_cautela) {
								if ($item_cautela->ativo == 0 && ($item_cautela->destino_id != $item_cautela->estoque_id)) {
									$tombos .= $item_cautela->tombo.", ";
								}
							}
							# Em havendo...
							if ($tombos != "") {
								$controle['status'] = FALSE;
								$controle['msg'] = "O sistema não conseguiu atualizar os estoques. O(s) tombo(s) ".rtrim($tombos, ", ")." está(ão) em outro estoque!";
							}
							# Não havendo...
							else {
								$controle = $this->cautelas_model->devolve_estoque($id);
							}
							break;
						case 0:
							if ($cautela->concluida == 0) {
								$controle = $this->cautelas_model->devolve_material($id);
							}
							else {
								$msg = array('type' => 'alert-danger', 'msg' => 'O material constante desta cautela já foi devolvido, não pode ser cancelada!'); # Checar depois
								$this->session->set_flashdata('mensagem', $msg);
								redirect("clog/cautelas/index");
							}
							break;
						default:
							$controle = $this->cautelas_model->devolve_material($id);
							break;
					}
					# $controle = $this->cautelas_model->atualiza_estoque($id); # Melhorar retorno, prever erro de inclusão parcial
					# Não atualizou
					if (is_array($controle) && $controle['status'] === FALSE) {
						$msg = array('type' => 'alert-danger', 'msg' => $controle['msg']);
						$this->session->set_flashdata('mensagem', $msg);
						redirect("clog/cautelas/index");
					}
				}
			}
		}
		# Se não houver outros problemas, tenta dar update na cautela
		$cancela = $this->clog_model->atualizar('cautelas', $data);
		# Conseguiu
		if ($cancela === TRUE) {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Cancelou a $saida, do estoque do(a) $info_cautela->estoque_origem",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$msg = array('type' => 'alert-success', 'msg' => 'Saída de material cancelada com sucesso!');
		}
		# Não conseguiu
		else {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Tentativa de cancelar a $saida nº $id",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$msg = array('type' => 'alert-danger', 'msg' => 'A saída do material não foi cancelada!');
		}
		# Gerando o retorno
		$this->session->set_flashdata('mensagem', $msg);
		redirect("clog/cautelas/index");
	}

	public function concluir_cautela() {
		$id = $this->input->get('id');
		$controle = $this->cautelas_model->getCautela($id);
		# Testa se existe a cautela e se está vazia ou não
		# Vazia
		if ($controle === FALSE) {
			$msg = array('type' => 'alert-danger', 'msg' => 'Não existem itens nesta cautela para devolução, favor adicionar!');
			$this->session->set_flashdata('mensagem', $msg);
			redirect("clog/cautelas/criar_cautela/$id");
		}
		# Se existir
		else {
			$cautela = $controle->row();
			# Tratando se o usuário é do setor
			if ($cautela->origem_id != $this->session->userdata('lotacao_id')) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não pertence ao setor!'));
				redirect("clog/cautelas/criar_cautela/$id");
			}
			# Dados para a auditoria
			switch ($cautela->distribuicao) {
				case '0':
					$saida = "Cautela de Material nº $id";
					break;
				
				case '1':
					$recebedor = (is_null($info_cautela->setor)) ? $info_cautela->militar : $info_cautela->setor;
					$saida = "Distribuição de Material nº $id, para o(a) $recebedor,";
					break;
					
				case '2':
					$saida = "Transferência de Material nº $id";
					break;

				default:
					$saida = "Saída de Material...";
					break;
			}
			# Não finalizada
			if ($cautela->finalizada == 0)
				$msg = array('type' => 'alert-danger', 'msg' => 'A saída não foi finalizada!');
			# Finalizada
			else {
				$data = array(
					'id' => $id,
					'concluida' => 1,
					'data_conclusao' => date('Y-m-d H:i:s', strtotime('now'))
				);
				# Tenta dar update na cautela
				$conclusao = $this->clog_model->atualizar('cautelas', $data);
				# Conseguiu
				if ($conclusao === TRUE) {
					# Tenta atualizar o estoque
					switch ($cautela->distribuicao) {
						case 2:
							$controle = $this->cautelas_model->atualiza_estoques($id);
							break;
						default:
							$controle = $this->cautelas_model->devolve_material($id);
							break;
					}
					# Atualizou
					if ($controle !== FALSE) {
						# Bloco de auditoria
						$auditoria = array(
							'auditoria' => "Devolveu o material constante da $saida ao estoque do(a) $info_cautela->estoque_origem",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
						);
						$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-success', 'msg' => 'Material devolvido com sucesso!'); # Melhorar retorno, prever erro de inclusão parcial
					}
					# Não atualizou
					else {
						# Bloco de auditoria
						$auditoria = array(
							'auditoria' => "Tentativa de atualizar o estoque, após devolução do material constante da $saida",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
						);
						$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-danger', 'msg' => 'O material não foi devolvido e a saída não foi concluída!');
					}
				}
				# Não conseguiu
				else {
					# Bloco de auditoria
					$auditoria = array(
						'auditoria' => "Tentativa de concluir a $saida nº $id",
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'alterar');
					# .Bloco de auditoria
					$msg = array('type' => 'alert-danger', 'msg' => 'A saída de material não foi finalizada!');
				}
			}
		}
		# Gerando o retorno
		$this->session->set_flashdata('mensagem', $msg);
		redirect('clog/cautelas/index');
	}

	public function devolver_material() {
		$id = $this->input->get('id');
		$info_cautela = $this->cautelas_model->getCautela($id);
		if (FALSE === $info_cautela) {
			# Bloco de auditoria
				$auditoria = array(
					'auditoria' => "Tentativa de devolver o material ao estoque de origem. Saída de material nº $id",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$msg = array('type' => 'alert-danger', 'msg' => 'Não existe saída de material com este número!');
		}
		else {
			# Pegando dados da cautela
			$cautela = $info_cautela->row();
			# Tratando se o usuário é do setor
			if ($cautela->origem_id != $this->session->userdata('lotacao_id')) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não pertence ao setor!'));
				redirect("clog/index");
			}
			# Dados para a auditoria
			switch ($cautela->distribuicao) {
				case '0':
					$saida = "Cautela de Material nº $id";
					break;
				
				case '1':
					$recebedor = (is_null($info_cautela->setor)) ? $info_cautela->militar : $info_cautela->setor;
					$saida = "Distribuição de Material nº $id, para o(a) $recebedor,";
					break;
					
				case '2':
					$saida = "Transferência de Material nº $id";
					break;

				default:
					$saida = "Saída de Material";
					break;
			}
			$controle = $this->cautelas_model->devolve_estoque($id);
			if (is_bool($controle)) {
				# Bloco de auditoria
					$auditoria = array(
						'auditoria' => "Devolveu o material constante da $saida",
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$msg = array('type' => 'alert-success', 'msg' => "O material constante da $saida foi devolvido com sucesso!");
			}
			else{
				# Bloco de auditoria
					$auditoria = array(
						'auditoria' => "Tentativa de devolver a $saida",
						'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
						'idmodulo' => $this->session->userdata['sistema']
					);
					$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$msg = array('type' => 'alert-danger', 'msg' => $controle['msg']);
			}
		}
		# Gerando o retorno
		$this->session->set_flashdata('mensagem', $msg);
		redirect('clog/clog');
	}

	public function listar_cautelas() {
		$cautelas = $this->cautelas_model->getCautelas(); # Alterar banco vazio
		$lista = $this->load->view('cautelas/lista_cautelas', array('cautelas' => $cautelas), TRUE);
		$this->load->view('layout/index', array('layout' => $lista), FALSE);
	}

	public function listar_distribuidos() {
		$cautelas = $this->cautelas_model->getDistros(); # Alterar banco vazio
		$lista = $this->load->view('cautelas/material_distribuido', array('cautelas' => $cautelas), TRUE);
		$this->load->view('layout/index', array('layout' => $lista), FALSE);
	}

	public function listar_transferidos() {
		$cautelas = $this->cautelas_model->getTransferidos(); # Alterar banco vazio
		$lista = $this->load->view('cautelas/material_transferido', array('cautelas' => $cautelas), TRUE);
		$this->load->view('layout/index', array('layout' => $lista), FALSE);
	}

	public function listar_patrimonio_sala() {
		$id = $this->input->post('salas_id');
		if ($id == 0) {
			$msg = array('type' => 'alert-danger', 'msg' => 'Precisa selecionar uma sala!');
			$this->session->set_flashdata('mensagem', $msg);
			redirect("clog/index");
		}
		$produtos = $this->clog_model->getPatrimonioSalas($id);
		# $info_sala = $this->clog_model->getSalaInfo($id);
		$info_sala = $this->clog_model->getSalas($id);
		if (! $info_sala) {
			$msg = array('type' => 'alert-danger', 'msg' => 'Não existe sala com este ID!');
			$this->session->set_flashdata('mensagem', $msg);
			redirect("clog/index");
		}
		else {
			$conteudo = $this->load->view('cautelas/lista_patrimonio_sala', array('info_sala' => $info_sala->row(), 'produtos' => $produtos), TRUE);
			$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
		}
	}

	public function patrimonio_salas() {
		$setores = $this->clog_model->getEstoques();
		$salas = FALSE;
		$conteudo = $this->load->view('cautelas/patrimonio_salas', array('setores' => $setores, 'salas' => $salas), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
		# Processando quando tem POST
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			# var_dump($this->cautelas_model->validarTombo($this->input->post('tombo'))); die();
			$tombo_info = $this->cautelas_model->validarTombo($this->input->post('tombo'));
			# var_dump($tombo_info);
			if (! $tombo_info) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Este tombo não existe!'));
				redirect("clog/cautelas/patrimonio_salas");
			} # Checar se tem como melhorar depois: Gerar uma Distribuição para Setor?
			else {
				if (isset($tombo_info->cautelas_id)){
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Este tombo está associado a saída de material nº '.$tombo_info->cautelas_id));
					redirect("clog/cautelas/patrimonio_salas");
				}
				else {
					# Checa estoque para atualizar...
					$whr = array(
						'lotacoes_id' => $this->input->post('salas'),
						'produtos_id' => $tombo_info->produtos_id
					);
					$checa_estoque = $this->db->get_where('estoques', $whr)->row();
					$quantidade = (count($checa_estoque) > 0)? $checa_estoque->quantidade + 1 : 1; # Criar o insert e o update
					$params = array(
						'militares_id' => $this->input->post('militar_id'),
						'estoques_id' => $tombo_info->estoques_id, 
						'setor_id' => $this->input->post('salas'),
						'distribuicao' => 2, 
						'data_cautela' => ($this->input->post('data_lancamento') == '')? date('Y-m-d') : $this->clog_model->formataData($this->input->post('data_lancamento')),
						'data_conclusao' => ($this->input->post('data_lancamento') == '')? date('Y-m-d') : $this->clog_model->formataData($this->input->post('data_lancamento')),
						'finalizada' => 1, 
						'concluida' => 1,
						'tombo' => $tombo_info->tombo
					);
					# Tratando se o usuário é do setor
					if ($tombo_info->estoques_id != $this->session->userdata('lotacao_id')) {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não pertence ao setor!'));
						redirect("clog/cautelas/patrimonio_salas");
					}
					$controle = $this->cautelas_model->transferencia_avulsa($params);
					# Verificando erros na nova transferência
					if (! $controle) {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro! Entre em contato com um administrador do sistema!'));
						redirect("clog/cautelas/patrimonio_salas");
						# Bloco de auditoria
						$auditoria = array(
							'auditoria' => "Tentativa de associar o produto <em>".$tombo_info->modelo."</em>, sob o tombo nº ".$tombo_info->tombo." à sala <em>".$sala->nome."</em>",
							'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
							'idmodulo' => $this->session->userdata['sistema']
						);
						$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
					}
					# Incluindo como carga da sala
					else {
						# Pegando  e tratando os valores do POST para criar o array de inclusão
						$data = array(
							'data_lancamento' => ($this->input->post('data_lancamento') == '')? date('Y-m-d') : $this->clog_model->formataData($this->input->post('data_lancamento')),
							'origem_id'=> $this->input->post('setores'),
							'sala_id'=> $this->input->post('salas'),
							'tombo_id'=> $tombo_info->id,
							'militar_id'=> $this->input->post('militar_id')
						);
						# Pegando o nome da sala
						$sala =  $this->clog_model->getByID('lotacoes', $data['sala_id'])->row();
						# Inserindo no banco
						$this->db->insert('patrimonio_salas', $data);
						# Auditando
						if ($this->db->affected_rows() > 0) {
							/*$data = array(
								'lotacoes_id' => $this->input->post('salas'),
								'produtos_id' => $tombo_info->produtos_id
							);
							$this->db->insert('estoques', $data);*/
							# Bloco de auditoria
							$auditoria = array(
								'auditoria' => "Associou o produto ".$tombo_info->modelo.", sob o tombo nº ".$tombo_info->tombo." à sala <em>".$sala->nome."</em>",
								'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo' => $this->session->userdata['sistema']
							);
							$this->clog_model->audita($auditoria, 'inserir');
							# .Bloco de auditoria
							$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Inclusão do produto '.$tombo_info->modelo.', sob o tombo nº '.$tombo_info->tombo.' concluído com sucesso!'));
							redirect("clog/cautelas/patrimonio_salas");
						}
						else {
							# Bloco de auditoria
							$auditoria = array(
								'auditoria' => "Tentativa de associar o produto ".$tombo_info->modelo.", sob o tombo nº ".$tombo_info->tombo." à sala <em>".$sala->nome."</em>",
								'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo' => $this->session->userdata['sistema']
							);
							$this->clog_model->audita($auditoria, 'inserir');
							# .Bloco de auditoria
							$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro, não foi possível concluir a requisição!'));
							redirect("clog/cautelas/patrimonio_salas");
						}
					}
				}
			}
		}
	}

	public function listaSalas() {
		# Pegando o ID do Almoxarifado Principal
		$almox = $this->clog_model->getAlmox();
		if (! $almox) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Procure o administrador, não existe almoxarifado principal cadastrado!"));
			redirect('clog/index');
		}
		$id = $this->input->get('id');
		if (! $id) $listaSalas = FALSE;
		else $listaSalas = ($id == $almox)? $this->clog_model->getSalas() : $this->clog_model->getSalasSetor($id);
		$lista = $this->load->view('cautelas/lista_salas', array('salas' => $listaSalas), FALSE);
	}

}