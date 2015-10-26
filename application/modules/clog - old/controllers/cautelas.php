<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

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
		$setores = $this->clog_model->getLotacoes()->result();
		$estoques = $this->clog_model->getEstoques()->result();
		$cautelas = $this->load->view('cautelas/index', array('setores'=>$setores, 'estoques'=>$estoques), TRUE);
		$this->load->view('layout/index', array('layout'=>$cautelas), FALSE);
	}

	public function consulta_cautelas() {
		#$produtos = $this->clog_model->getAll('produtos');
		#$cautelas = $this->load->view('cautelas/consulta', array('produtos'=>$produtos), TRUE);
		$setores = $this->clog_model->getLotacoes()->result();
		$cautelas = $this->load->view('cautelas/consulta', array('tipo_saida'=>0), TRUE);
		$this->load->view('layout/index', array('layout'=>$cautelas), FALSE);
	}

	public function consulta_distros() {
		#$produtos = $this->clog_model->getAll('produtos');
		#$cautelas = $this->load->view('cautelas/consulta', array('produtos'=>$produtos), TRUE);
		$setores = $this->clog_model->getLotacoes()->result();
		#echo "<pre>"; var_dump($setores); echo "</pre>"; die();
		$cautelas = $this->load->view('cautelas/consulta', array('setores'=>$setores, 'tipo_saida'=>1), TRUE);
		$this->load->view('layout/index', array('layout'=>$cautelas), FALSE);
	}

	public function transferencia_patrimonio() {
		#$produtos = $this->clog_model->getAll('produtos');
		#$cautelas = $this->load->view('cautelas/consulta', array('produtos'=>$produtos), TRUE);
		$setores = $this->clog_model->getLotacoes()->result();
		#echo "<pre>"; var_dump($setores); echo "</pre>"; die();
		$cautelas = $this->load->view('cautelas/transferencia_patrimonio', array('setores'=>$setores, 'tipo_saida'=>2), TRUE);
		$this->load->view('layout/index', array('layout'=>$cautelas), FALSE);
	}

	public function transferencia_material() {
		$setores = $this->clog_model->getLotacoes()->result();
		$estoques = $this->clog_model->getEstoques()->result();
		$cautelas = $this->load->view('cautelas/transferencia_material', array('setores'=>$setores, 'estoques'=>$estoques, 'tipo_saida'=>2), TRUE);
		$this->load->view('layout/index', array('layout'=>$cautelas), FALSE);
	}

	public function filtra_cautela() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			# Aplicando filtro
			if ($this->input->post('distribuicao') == 0) {
				$filter = array(
									"matricula"=>$this->input->post('matricula'),
									"data_inicio"=>$this->clog_model->formataData($this->input->post('data_inicio')),
									"data_fim"=>$this->clog_model->formataData($this->input->post('data_fim')),
									"concluida"=>$this->input->post('concluida')
								);
				$cautelas = $this->cautelas_model->consulta_cautela($filter);
				$lista = $this->load->view('cautelas/lista_cautelas', array('cautelas'=>$cautelas), TRUE);
				# Bloco de auditoria
					/*$auditoria = array(
										'auditoria'=>'Consultou saída de material',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'consultar');*/
				# .Bloco de auditoria
			}
			if ($this->input->post('distribuicao') > 0) {
				$filter = array(
									"data_inicio"=>$this->input->post('data_inicio'),
									"data_fim"=>$this->input->post('data_fim'),
									"setor_id"=>$this->input->post('setor_id')
								);
				$cautelas = $this->cautelas_model->consulta_distro($filter);
				$lista = $this->load->view('cautelas/material_distribuido', array('cautelas'=>$cautelas), TRUE);
			}
			$this->load->view('layout/index', array('layout'=>$lista), FALSE);
		}
	}

	public function saida_retroativa() {
		# Index.
		$setores = $this->clog_model->getLotacoes()->result();
		$saidaRetro = $this->load->view('cautelas/saida_retroativa', array('setores'=>$setores), TRUE);
		$this->load->view('layout/index', array('layout'=>$saidaRetro), FALSE);
	}

	public function salvar_cautela() {
		if($this->input->server('REQUEST_METHOD') == 'POST') {
			# Tratando se o material foi distribuído
			if ($this->input->post('distro_id') !== FALSE && $this->input->post('distro_id') == "") {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Este tombo não pode ser transferido!'));
				redirect('clog/cautelas/transferencia_material');
			}
			# Tratando se há data de saída
			$data_saida = ((FALSE !== $this->input->post('data_saida')) || ("" != $this->input->post('data_saida'))) ? $this->clog_model->formataData($this->input->post('data_saida')) : date('Y-m-d') ;
			$data = array(
				'militares_id'=>$this->input->post('chefe_militares_id'),
				'data_cautela'=>$data_saida
			);
			# Tratando se foi selecionado o setor
			if ($this->input->post('setor_id') == "0") {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa selecionar o setor!'));
				if ($this->input->post('distro_id') !== FALSE) redirect('clog/cautelas/transferencia_material');
				else redirect('clog/cautelas/index');
			}
			else $data['setor_id'] = $this->input->post('setor_id');
			# Tratando se é transferência ou saída de material
			if ($this->input->post('data_prevista') !== FALSE) {
				# Se saída, testa se é cautela ou distribuição
				if ($this->input->post('data_prevista') != "") {
					$data['data_prevista'] = $this->clog_model->formataData($this->input->post('data_prevista'));
					$data['estoques_id'] = ($this->input->post('estoque_origem') != 0) ? $this->input->post('estoque_origem') : 23;
					$msg = "Cautela criada com sucesso!";
				}
				else {
					$data['data_prevista'] = NULL;
					$data['distribuicao'] = 1;
					$data['estoques_id'] = ($this->input->post('estoque_origem') != 0) ? $this->input->post('estoque_origem') : 23;
					$msg = "Distribuicao iniciada com sucesso!";
				}
				# Salvando a nova saída de material
				$query = $this->clog_model->salvar('cautelas', $data);
				# Gerando o retorno da saída
				if ($query) {
					$id = $this->db->insert_id();
					# echo "<pre>"; var_dump($id); echo "</pre>"; die();
					# Bloco de auditoria
						$auditoria = array(
											'auditoria'=>'Iniciou a saída de material nº '.$id,
											'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
											'idmodulo'=>$this->session->userdata['sistema']
										);
						$this->clog_model->audita($auditoria, 'inserir');
					# .Bloco de auditoria
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => $msg));			
					redirect("clog/cautelas/criar_cautela/$id");
				} 
				else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível concluir sua requisição!'));
					redirect('clog/cautelas/index');
				}
			}
			# Se transferência...
			else {
				if ($this->input->post('tombo') !== FALSE) {
					$tombo = $this->input->post('tombo');
					$controle = $this->cautelas_model->validarTombo($tombo);
					# Valida o tombo e inativa o item
					if ($controle !== FALSE) {
						$new_data = array('ativo'=> 0, 'id'=> $controle->item_id, 'destino_id'=> $this->input->post('setor_id'));
						$inativar = $this->clog_model->atualizar("cautelas_has_produtos", $new_data);
						# Criando nova cautela
						$data['distribuicao'] = 1;
						$data['finalizada'] = 1;
						$nova_cautela = $this->clog_model->salvar('cautelas', $data);
						if ($nova_cautela) {
							# Recuperando o id da nova cautela e gerando a mensagem de sucesso
							$cautela_id = $this->db->insert_id();
							# Bloco de auditoria
								$auditoria = array(
													'auditoria'=>'Transferiu o tombo nº '.$tombo.', através da distribuição nº '.$cautela_id,
													'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
													'idmodulo'=>$this->session->userdata['sistema']
												);
								$this->clog_model->audita($auditoria, 'inserir');
							# .Bloco de auditoria
							$msg = "O produto ".$controle->modelo.", tombo nº $tombo, foi transferido através da distribuição nº $cautela_id";
							# incluindo o item na nova cautela
							$new_item = array('ativo' => 1, 
																'tombo_id' => $controle->id, 
																'produtos_qde' => 1,
																'produtos_id' => $controle->produtos_id,
																'cautelas_id' => $cautela_id
													);
							$novo_item = $this->clog_model->salvar('cautelas_has_produtos', $new_item);
							# Gerando o resultado
							if ($novo_item !== FALSE) {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => $msg));			
								redirect("clog/cautelas/transferencia_material");
							}
							else {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível concluir sa transferência!'));
								redirect('clog/cautelas/transferencia_material');
							}
						}
					}
					else return FALSE;	
				}
				else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível concluir sua requisição!'));
					redirect('clog/cautelas/index');
				}
			}	
		} // Method POST.
	}

	public function transferir_material() {
		$data['distribuicao'] = 2;
		if($this->input->server('REQUEST_METHOD') == 'POST') {
			# Tratando se foi selecionado o militar
			if ($this->input->post('chefe_militares_id') == "") $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa digitar a matrícula do solicitante!'));
			else $data['militares_id'] = $this->input->post('chefe_militares_id');
			# Tratando se foi selecionado o estoque de origem
			if ($this->input->post('estoque_origem') == "0") $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa selecionar a origem!'));
			else $data['estoques_id'] = $this->input->post('estoque_origem');
			# Tratando se foi selecionado o estoque destino
			if ($this->input->post('estoque_destino') == "0") $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa selecionar o destino!'));
			else $data['setor_id'] = $this->input->post('estoque_destino');
			# Tratando se há data de saída
			$data['data_cautela'] = ((FALSE !== $this->input->post('data_saida')) || ("" != $this->input->post('data_saida'))) ? $this->clog_model->formataData($this->input->post('data_saida')) : date('Y-m-d');
			# Salvando a nova saída de material
			$query = $this->clog_model->salvar('cautelas', $data);
			# Auditando
			if ($query) {
				$id = $this->db->insert_id();
				# Bloco de auditoria
					$auditoria = array(
												'auditoria'=>'Iniciou a distribuição de material para outro estoque sob o nº '.$id,
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Transferência de material entre estoques iniciada!'));			
				redirect("clog/cautelas/criar_cautela/$id");
			} 
		}
	}

	/*public function criar_cautela($id) {
		$tombo_info = array();
		$cautela = $this->clog_model->getByID('cautelas', $id);
		$produtos = $this->clog_model->getAll('produtos');
		$itens = $this->cautelas_model->getItens($id);
		$patrimonio = $this->cautelas_model->getTombobyCautela($id);
		if ($patrimonio !== FALSE) {
			foreach ($patrimonio->result() as $value) {
				$tombo_info[$value->id] = $value->tombo;
			}
		}
		#var_dump($tombo_info); die();
		#Testa se existe a cautela
		if ($cautela !== FALSE) {
			#Inclui os itens na cautela
			if ($this->input->server('REQUEST_METHOD') == 'POST') {
				if ($this->input->post('consumo') == 1) {
					$contador = $this->input->post('quantidade_itens');
					$contador2 = 1;
					$tombos = array();
					while ($contador > 0) { 
						$tombos['tombo'.$contador] = $this->input->post('numero_tombo'.$contador);					
						$contador--;
					}
					if (! is_null($tombos)) {
						//echo " entrou";
						$data = array(
							'cautelas_id'=>$id,
							'produtos_id'=>$this->input->post('produtos_cautela'),					
							'produtos_qde'=>$this->input->post('quantidade_itens'),
							'tipo_produto'=>$this->input->post('consumo')
						);
						#Inclui os ítens
						$inclui = $this->cautelas_model->add_itens($id, $data, $tombos);
						if ($inclui !== FALSE) {
							if (is_int($inclui)) {
								if ($inclui == $data['produtos_qde']) $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Itens não incluídos!'));
								else $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Alguns itens não foram incluídos!'));
							} 
							else $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Incluído com sucesso!'));
							redirect("clog/cautelas/criar_cautela/".$id);
						}
						else {
						 $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível incluir!'));
						 redirect("clog/cautelas/criar_cautela/".$id);
						}
					}
					else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não se pode cadastrar itens de mesmo tombo!'));
						redirect("clog/cautelas/criar_cautela/".$id);
					}
				}
				else if ($this->input->post('consumo') == 2) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Campos prenchidos incorretamente.'));
					redirect("clog/cautelas/criar_cautela/".$id);
				}
				else {
					$tombos = NULL;
					$data = array(
							'cautelas_id'=>$id,
							'produtos_id'=>$this->input->post('produtos_cautela'),					
							'produtos_qde'=>$this->input->post('quantidade_itens'),
							'tipo_produto'=>$this->input->post('consumo')
						);
					#Inclui os ítens
					$inclui = $this->cautelas_model->add_itens($id, $data, $tombos);
					if ($inclui !== FALSE) {
						$itens = $this->cautelas_model->getItens($id);
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item incluído com sucesso!'));
						$adicionar = $this->load->view('cautelas/adicionar', array('id'=>$id, 'produtos'=>$produtos, 'cautela'=>$cautela->row(), 'itens'=>$itens, 'tombo_info'=>$tombo_info), TRUE);
						$this->load->view('layout/index', array('layout'=>$adicionar), FALSE);
					}
					else {
					 $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível incluir o item!'));
					 $this->load->view('layout/index', array('layout'=>$adicionar), FALSE);
					}
				}
			}
			#Carrega os itens da cautela
			else {
				$adicionar = $this->load->view('cautelas/adicionar', array('id'=>$id, 'produtos'=>$produtos, 'cautela'=>$cautela->row(), 'itens'=>$itens, 'tombo_info'=>$tombo_info), TRUE);
				$this->load->view('layout/index', array('layout'=>$adicionar), FALSE);
			}
		}
		#Se não existir, erro
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não existe cautela com este número!'));
			redirect("clog/cautelas/index");
		}
		#$adicionar = $this->load->view('cautelas/adicionar', array('id'=>$id, 'produtos'=>$produtos, 'cautela'=>$cautela->row(), 'itens'=>$itens), TRUE);
		#$this->load->view('layout/index', array('layout'=>$adicionar), FALSE); 
	}*/

	public function criar_cautela($id) {
		$tombo_info = array();
		$cautela = $this->cautelas_model->getCautela($id);
		$itens = $this->cautelas_model->getItens($id);
		$patrimonio = $this->cautelas_model->getTombobyCautela($id);
		# Criando um array com os dados do post
		$data = array(
							'cautelas_id'=>$id,
							'produtos_id'=>$this->input->post('produtos_cautela'),					
							'produtos_qde'=>$this->input->post('quantidade_itens'),
							'tipo_produto'=>$this->input->post('consumo')
		);
		if ($patrimonio !== FALSE) {
			foreach ($patrimonio->result() as $value) {
				$tombo_info[$value->id] = $value->tombo;
			}
		}
		#Testa se existe a cautela
		if ($cautela !== FALSE) {
			$info_cautela = $cautela->row();
			$produtos = $this->clog_model->getEstoque($info_cautela->origem_id);
			#Inclui os itens na cautela
			if ($this->input->server('REQUEST_METHOD') == 'POST') {
				if (0 == $this->input->post('quantidade_itens')) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O campo quantidade deve ser maior que zero!'));
					redirect("clog/cautelas/criar_cautela/".$id);
				}

				# Inclui material de consumo
				if ($this->input->post('consumo') == 0) {
					$tombos = NULL;
					#Inclui os ítens
					$inclui = $this->cautelas_model->add_itens($id, $data, $tombos);
					if ($inclui !== FALSE) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Incluiu material de consumo em saída de material nº '.$id,
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$itens = $this->cautelas_model->getItens($id);
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item incluído com sucesso!'));
						$adicionar = $this->load->view('cautelas/adicionar', array('id'=>$id, 'produtos'=>$produtos, 'cautela'=>$cautela->row(), 'itens'=>$itens, 'tombo_info'=>$tombo_info), TRUE);
						$this->load->view('layout/index', array('layout'=>$adicionar), FALSE);
					}
					else {
					 $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível incluir o item!'));
					 $this->load->view('layout/index', array('layout'=>$adicionar), FALSE);
					}
				}
				# Inclui o material permanente
				else if ($this->input->post('consumo') == 1) {
					if (null !== $this->input->post('numero_tombo') && $this->input->post('numero_tombo') != '') {
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
											$novo_arr[$t] = $n ;
											$n++;
											$t++; 
										}
									}
									else {
										$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O campo número de tombo não foi preeenchido corretamente!'));
										redirect("clog/cautelas/criar_cautela/".$id);
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
							if (count($novo_arr) != (int) $data['produtos_qde']) return FALSE;
							else {
								#Inclui os ítens
								$inclui = $this->cautelas_model->add_itens($id, $data, $novo_arr);
								if ($inclui !== FALSE) {
									if (is_int($inclui)) {
										if ($inclui == $data['produtos_qde']) {
											# Bloco de auditoria
												$auditoria = array(
													'auditoria'=>'Tentativa de inclusão material permanente em saída de material nº '.$id,
													'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
													'idmodulo'=>$this->session->userdata['sistema']
												);
												$this->clog_model->audita($auditoria, 'inserir');
											# .Bloco de auditoria
											$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Itens não incluídos!'));
										}
										else $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Alguns itens não foram incluídos!'));
									} 
									else {
										# Bloco de auditoria
											$auditoria = array(
												'auditoria'=>'Incluiu material permanente em saída de material nº '.$id,
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
											$this->clog_model->audita($auditoria, 'inserir');
										# .Bloco de auditoria
										$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Incluído com sucesso!'));
									}
									redirect("clog/cautelas/criar_cautela/".$id);
								}
							} 
						}
					}
					else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O campo número de tombo não foi preeenchido!'));
						redirect("clog/cautelas/criar_cautela/".$id);
						die();
					}
				}
				# O usuário não selecionou uma opção válida
				else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Campos prenchidos incorretamente.'));
					redirect("clog/cautelas/criar_cautela/".$id);
				}
			}
			#Carrega os itens da cautela
			else {
				$adicionar = $this->load->view('cautelas/adicionar', array('id'=>$id, 'produtos'=>$produtos, 'cautela'=>$cautela->row(), 'itens'=>$itens, 'tombo_info'=>$tombo_info), TRUE);
				$this->load->view('layout/index', array('layout'=>$adicionar), FALSE);
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

	/**
	 * 
	 */
	
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
			$data = $this->load->view('cautelas/cautela', array('cautela'=>$cautela->row(), 'itens'=>$itens, 'tombos' => $tombos), TRUE);
			$this->load->view('layout/index', array('layout'=>$data), FALSE);
		}
	}

	public function imprimir() {
		# Imprimir cautela.
		$id = $this->input->get('id');
		$cautela = $this->cautelas_model->getCautela($id);
		$itens = $this->cautelas_model->getCautelas($id);
		$tombos = $this->cautelas_model->getTombobyCautela($id);
		if ($itens === FALSE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Precisa incluir um item pelo menos!'));
			redirect("clog/cautelas/index");
		}
		else {
			if (FALSE !== $tombos) $this->load->view('cautelas/termo_entrega', array('cautela'=>$cautela->row(), 'itens'=>$itens, 'tombos' => $tombos), FALSE);
			else $this->load->view('cautelas/termo_entrega', array('cautela'=>$cautela->row(), 'itens'=>$itens), FALSE);
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
		#$msg =  array('type' => 'alert-danger', 'msg' => 'Houve um erro durante o processo!');
		$id = $this->input->get('id');
		#var_dump($id);
		$controle = $this->cautelas_model->getCautela($id);
		#var_dump($controle); #die();
		#Testa se existe a cautela
		if (! is_bool($controle)) {
			$valor = $controle->num_rows();
			$cautela = $controle->row();
			if ($valor > 0 ) {			
				#Testa se o estoque foi alterado
				$conclusao = $this->cautelas_model->concluir_saida($id);
				//var_dump($conclusao); die();
				if ($conclusao > 0 && $conclusao !== FALSE) {
					$data = array(
										'id' => $id, 
										'finalizada' => 1
									);
					# Tratando distros e cautelas
					if ($cautela->distribuicao > 0) {
						$data['concluida'] = 1;
						$data['data_conclusao'] = date('Y-m-d H:i:s');
					}
					# Fechando a cautela ou distribuição
					$fechaCautela = $this->clog_model->atualizar('cautelas', $data);
					# Sucesso
					if ($fechaCautela == TRUE) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Concluiu a saída de material nº '.$id,
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-success', 'msg' => "Saída de material concluída com sucesso!");
					}
					# Falha
					else {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Tentativa de concluir a saída de material nº '.$id,
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-danger', 'msg' => 'Não foi possível finalizar o processo!');
					}
				}
				# Mensagem de erro se não foi alterado o estoque
				else $msg = array('type' => 'alert-danger', 'msg' => 'Erro! Não tem em estoque ou está abaixo da quantidade mínima');
			}
		}
		#Se não existir
		else $msg = array('type' => 'alert-danger', 'msg' => 'Não existe cautela com este número!');
		#Gerando o retorno
		$this->session->set_flashdata('mensagem', $msg);
		redirect("clog/cautelas/index");
	}

	public function cancelar_item() {
		# Cancelar itens.
		$id_item = $this->input->get('id');
		$cautela = $this->clog_model->getByID("cautelas_has_produtos", $id_item)->row();	
		$id_cautela = $cautela->cautelas_id;
		$cancelamento = $this->clog_model->excluir('cautelas_has_produtos', $id_item);
		if ($cancelamento === TRUE) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Cancelou um item da saída de material nº '.$id_cautela,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item cancelado com sucesso!'));
		} 
		else {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de cancelar um item da saída de material nº '.$id_cautela,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível cancelar o item de cautela!'));
		} 
		redirect("clog/cautelas/criar_cautela/$id_cautela");
	}

	public function cancelar_cautela() {
		$id = $this->input->get('id');
		$data = array(
										'id' => $id, 
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
			redirect("clog/cautelas/index");
		}
		# Se existir, testa se tem itens
		else {
			$cautela = $this->cautelas_model->getCautelas($id);
			# Se houver, tenta atualizar o estoque
			if ($cautela !== FALSE) {
				$controle = $this->cautelas_model->atualiza_estoque($id); # Melhorar retorno, prever erro de inclusão parcial
				# Não atualizou
				if ($controle === FALSE) {
					$msg = array('type' => 'alert-danger', 'msg' => 'Houve um erro! A cautela não será cancelada!');
					$this->session->set_flashdata('mensagem', $msg);
					redirect("clog/cautelas/index");
				}
			}
		}
		# Se não houver outros problemas, tenta dar update na cautela
		$cancela = $this->clog_model->atualizar('cautelas', $data);
		# Conseguiu
		if ($cancela === TRUE) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Cancelou a saída de material nº '.$id,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$msg = array('type' => 'alert-success', 'msg' => 'Cautela cancelada com sucesso!'); 
		}
		# Não conseguiu
		else {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de cancelar a saída de material nº '.$id,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$msg = array('type' => 'alert-danger', 'msg' => 'A cautela não foi cancelada!');
		}
		# Gerando o retorno
		$this->session->set_flashdata('mensagem', $msg);
		redirect("clog/cautelas/index");
	}

	public function concluir_cautela() {
		$id = $this->input->get('id');
		$controle = $this->cautelas_model->getCautelas($id);
		# Testa se existe a cautela e se está vazia ou não
		# Vazia
		if ($controle === FALSE){
			$msg = array('type' => 'alert-danger', 'msg' => 'Não existem itens nesta cautela para devolução, favor adicionar!');
			$this->session->set_flashdata('mensagem', $msg);
			redirect("clog/cautelas/criar_cautela/$id");
		} 
		# Se existir
		else {
			$cautela = $controle->row();
			# Não finalizada
			if ($cautela->finalizada == 0) $msg = array('type' => 'alert-danger', 'msg' => 'A cautela não foi finalizada!');
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
					$controle = $this->cautelas_model->atualiza_estoque($id);
					# Atualizou
					if ($controle !== FALSE) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Devolveu o material constante da saída de material nº '.$id,
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-success', 'msg' => 'Material devolvido com sucesso!'); # Melhorar retorno, prever erro de inclusão parcial
					}
					# Não atualizou
					else {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Tentativa de devolver o material constante da saída de material nº '.$id,
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$msg = array('type' => 'alert-danger', 'msg' => 'O material não foi devolvido e a cautela não foi finalizada!');
					}
				}
				# Não conseguiu
				else {
					# Bloco de auditoria
						$auditoria = array(
											'auditoria'=>'Tentativa de devolver o material constante da saída de material nº '.$id,
											'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
											'idmodulo'=>$this->session->userdata['sistema']
										);
						$this->clog_model->audita($auditoria, 'alterar');
					# .Bloco de auditoria
					$msg = array('type' => 'alert-danger', 'msg' => 'A cautela não foi finalizada!');
				}
			}
		}	
		# Gerando o retorno
		$this->session->set_flashdata('mensagem', $msg);	
		redirect('clog/cautelas/index');
	}

	public function listar_cautelas() {
		$cautelas = $this->cautelas_model->getCautelas();
		$lista = $this->load->view('cautelas/lista_cautelas', array('cautelas'=>$cautelas), TRUE);
		$this->load->view('layout/index', array('layout'=>$lista), FALSE);
	}

	public function listar_distribuidos() {
		$cautelas = $this->cautelas_model->getDistros();
		$lista = $this->load->view('cautelas/material_distribuido', array('cautelas'=>$cautelas), TRUE);
		$this->load->view('layout/index', array('layout'=>$lista), FALSE);
	}
}