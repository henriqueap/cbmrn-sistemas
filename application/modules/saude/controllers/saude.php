<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Saude extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('acesso_model', '../modules/permutas/models/saude_model'));
		if (FALSE === $this->session->userdata('militar')) {
			$this->session->set_flashdata('msg', array('type' => 'alert-danger', 'msg' => 'O sistema fechou por inatividade!'));
			redirect("acesso");
		}
		# $this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$conteudo = $this->load->view('welcome/index', '', TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}
	
	public function link_pesquisa() {
		$conteudo = $this->load->view('saude/saude/link_pesquisa', '', TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function carregar_csv($setor_in=null) {
		
		//$input = fopen ('http://sistemascbm.rn.gov.br/sistemas/uploads/1sb.csv', 'r');
		$input = fopen ('https://docs.google.com/spreadsheets/d/e/2PACX-1vTQI2d-3N45SlOnqGBhmcDuC7-MO-P57k5oqbE5U2p48rz3QXvTRa1Xb5vCqAGQWAJDmjoPkBVbmOy2/pub?output=csv', 'r');
		//print_r($input);
		//die('teste csv');
		$linha = 1; //variável de controle
		$cont = 0;//monta o vetor do grafico
		$dados = array();
		$setor = '';
		#Indicadores
		$grafico['saude_geral']['ocorrencia']='Saúde Geral';
		$grafico['saude_geral']['quantidade']=0;
		$grafico['endodontia']['ocorrencia']='Endodontia';
		$grafico['endodontia']['quantidade']=0;
		$grafico['protese']['ocorrencia']='Prótese';
		$grafico['protese']['quantidade']=0;
		$grafico['periodontia']['ocorrencia']='Periodontia';
		$grafico['periodontia']['quantidade']=0;
		$grafico['placa']['ocorrencia']='Placa';
		$grafico['placa']['quantidade']=0;
		$grafico['estetica']['ocorrencia']='Estetica';
		$grafico['estetica']['quantidade']=0;
		$grafico['cancer']['ocorrencia']='Câncer';
		$grafico['cancer']['quantidade']=0;
		#End Indicadores
		while (($data = fgetcsv($input, 1000, ",")) !== FALSE) { //este while vai percorrer o arquivo aberto linha por linha e a cada linha lida, executa o código abaixo
 
			if ($linha++ == 1) //este IF tem como função pular a primeira linha do arquivo .CSV, pois ali constam os nomes dos campos, que não nos interessam.
			continue;
			//Aqui a montagem da SQL. Como o WHILE move o ponteiro para cada linha, e como temos somente 2 campos, podemos acessar o primeiro campo daquela linha lida como $data[0], e o segundo campo como $data[1], que correspondem ao campo nome e email. 
			
			if ($setor_in == null || $setor_in == '0')
			{
				$array = array(
				"nome" => $data[1],
				"telefone" => $data[2],
				"patente" => $data[3],
				"setor" => $data[4],
				"01" => $data[5],
				"02" => $data[7],
				"03" => $data[9],
				"04" => $data[10],
				"05" => $data[11],
				"06" => $data[12],
				"07" => $data[13],
				"08" => $data[14],
				"09" => $data[15],
				"10" => $data[16],
				"11" => $data[17],
				"12" => $data[18],
				"13" => $data[19],
				"14" => $data[20],
				"15" => $data[21],
				"16" => $data[22],
				"17" => $data[23]
				);
				if ($data[5] == 'Yes' || $data[7] == 'Yes')
					$grafico['saude_geral']['quantidade']++;
				if ($data[9] == 'Yes')
					$grafico['endodontia']['quantidade']++;
				if ($data[10] == 'No' || $data[11] == 'Yes')
					$grafico['protese']['quantidade']++;
				if ($data[12] == 'Yes' || $data[13] == 'Yes' || $data[14] == 'No' || $data[15] == 'Yes' || ($data[16] == 1 || $data[16] == 2))
				{
					$grafico['periodontia']['quantidade']++;
					//echo '<pre>'.var_dump($data).'</pre>';
				}
				if ($data[17] == 'No' || $data[18] == 'No' || $data[19] == 'Yes')
					$grafico['estetica']['quantidade']++;
				if ($data[20] == 'Yes' || $data[21] == 'Yes' || $data[22] == 'Yes')
					$grafico['placa']['quantidade']++;
				if ($data[23] == 'Yes')
					$grafico['cancer']['quantidade']++;
					
				
				//echo '<pre>'.var_dump($data).'</pre>';
				array_push($dados,$array);
				$cont++;
				//$this->db->insert("cad_clientes", $dados); //agora, basta inserirmos o conteúdo no banco de dados. Ele vai executar isto para cada linha lida do arquivo .csv.
			}
			else
			{
				$setor = $data[4];
				if ($setor == $setor_in)
				{
					$array = array(
					"nome" => $data[1],
					"telefone" => $data[2],
					"patente" => $data[3],
					"setor" => $data[4],
					"01" => $data[5],
					"02" => $data[7],
					"03" => $data[9],
					"04" => $data[10],
					"05" => $data[11],
					"06" => $data[12],
					"07" => $data[13],
					"08" => $data[14],
					"09" => $data[15],
					"10" => $data[16],
					"11" => $data[17],
					"12" => $data[18],
					"13" => $data[19],
					"14" => $data[20],
					"15" => $data[21],
					"16" => $data[22],
					"17" => $data[23]
					);
					if ($data[5] == 'Yes' || $data[7] == 'Yes')
						$grafico['saude_geral']['quantidade']++;
					if ($data[9] == 'Yes')
						$grafico['endodontia']['quantidade']++;
					if ($data[10] == 'No' || $data[11] == 'Yes')
						$grafico['protese']['quantidade']++;
					if ($data[12] == 'Yes' || $data[13] == 'Yes' || $data[14] == 'No' || $data[15] == 'Yes' || ($data[16] == 1 || $data[16] == 2))
					{
						$grafico['periodontia']['quantidade']++;
						//echo '<pre>'.var_dump($data).'</pre>';
					}
					if ($data[17] == 'No' || $data[18] == 'No' || $data[19] == 'Yes')
						$grafico['estetica']['quantidade']++;
					if ($data[20] == 'Yes' || $data[21] == 'Yes' || $data[22] == 'Yes')
						$grafico['placa']['quantidade']++;
					if ($data[23] == 'Yes')
						$grafico['cancer']['quantidade']++;
						
					
					//echo '<pre>'.var_dump($data).'</pre>';
					array_push($dados,$array);
				}
			}
			
		}
		/*echo $setor;
		echo '<br><br>';
		echo "Saude Geral: ".$grafico['saude_geral']."<br>";
		echo "Endodontia: ".$grafico['endodontia']."<br>";
		echo "Protese: ".$grafico['protese']."<br>";
		echo "Periodontia: ".$grafico['periodontia']."<br>";
		echo "Placa: ".$grafico['placa']."<br>";
		echo "Estetica: ".$grafico['estetica']."<br>";
		echo "Cancer: ".$grafico['cancer']."<br>";
		var_dump($grafico);*/
		$retorno=array();
		foreach ($grafico as $graf)
			array_push($retorno, $graf);
		//var_dump($retorno);
		//die();
		return $retorno;
	}	

	public function carregar_setores() {
		
		//$input = fopen ('http://sistemascbm.rn.gov.br/sistemas/uploads/1sb.csv', 'r');
		$input = fopen ('https://docs.google.com/spreadsheets/d/e/2PACX-1vTQI2d-3N45SlOnqGBhmcDuC7-MO-P57k5oqbE5U2p48rz3QXvTRa1Xb5vCqAGQWAJDmjoPkBVbmOy2/pub?output=csv', 'r');
		//print_r($input);
		//die('teste csv');
		$linha = 1; //variável de controle
		$cont = 0;//monta o vetor do grafico
		$dados = array();
		//$qtd = 0;
		#Indicadores
		
		$retorno['setores']['nomes']=array();
		#End Indicadores
		while (($data = fgetcsv($input, 1000, ",")) !== FALSE) { //este while vai percorrer o arquivo aberto linha por linha e a cada linha lida, executa o código abaixo
 
			if ($linha++ == 1) //este IF tem como função pular a primeira linha do arquivo .CSV, pois ali constam os nomes dos campos, que não nos interessam.
			continue;
			//Aqui a montagem da SQL. Como o WHILE move o ponteiro para cada linha, e como temos somente 2 campos, podemos acessar o primeiro campo daquela linha lida como $data[0], e o segundo campo como $data[1], que correspondem ao campo nome e email. 
			
			$array = array(
			"nome" => $data[1],
			"telefone" => $data[2],
			"patente" => $data[3],
			"setor" => $data[4]
			);
			if ($cont==0)
			{
				array_push($retorno['setores']['nomes'],$data[4]);
				$retorno['setores']['qtd'][$data[4]]=array();
				$retorno['setores']['qtd'][$data[4]]=1;
			}
			else
			{
				
				if ($this->search($retorno['setores']['nomes'], $data[4]) != -1) //Se não achou o setor
					$retorno['setores']['qtd'][$data[4]]++;
				else
					$retorno['setores']['qtd'][$data[4]]=1;
				
				foreach ($retorno['setores']['nomes'] as $ret)
				{
					if ($this->search($retorno['setores']['nomes'], $data[4]) == -1) //Se não achou o setor
					{
						
						array_push($retorno['setores']['nomes'],$data[4]);
						//$retorno['setores'][$data[4]]=array();
						//$retorno['setores'][$data[4]]=1;
					}
					//else
					//{
						//$retorno['setores'][$data[4]]=array();
						//$retorno['setores'][$data[4]]++;
					//}
				}
			}
			
			
				
			$cont++;
			//$retorno['setores'][$data[4]]['qtd']++;
		}
		//print("<pre>".print_r($retorno,true)."</pre>");
		//die();
		return $retorno['setores'];
	}	
	
	public function excluirLinha($id = NULL, $tbl = NULL) {
		$id = (! is_null($id))? $id: $this->input->get('id');
		$tbl = (! is_null($tbl))? $tbl: $this->input->get('tbl'); 
		$controle = (!($tbl) || !($id))? FALSE : $this->clog_model->excluir($tbl, $id);
		if (! $controle) {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Interno: Tentativa de excluir o ID nº $id da Tabela <em>".strtoupper($tbl)."</em>",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Houve um erro, não foi possível concluir a exclusão!"));
			redirect($this->session->flashdata('return_to')); # Pegando a página de retorno da sessão
		}
		else{
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Interno: Excluiu o ID $id da Tabela <em>strtoupper($tbl)</em>",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => "Exclusão concluída com sucesso!"));
			redirect($this->session->flashdata('return_to')); # Pegando a página de retorno da sessão
		}
	}

	public function auditoria() {
		#$dtIni = (date('Y'))."-01-01";
		$dtIni = (date('Y')-1)."-01-01"; #Temp
		$linhas = 20;
		# Carregando os selects
		$acoes = $this->clog_model->getAll('tipo_auditoria')->result();
		$militares = $this->militares_model->getMilitares()->result();
		# Contando os registros
		# Aplicando filtro
		$filter = array('data_inicial' => $dtIni);
		$regs = $this->clog_model->getAuditoria($filter);
		if (!is_bool($regs)) {
			$num_regs = $regs->num_rows();
			$lista = $this->clog_model->getAuditoria($filter, 0, $linhas);
			$filter = array('data_inicial' => $this->clog_model->formataData($dtIni));
			$auditoria = $this->load->view('auditoria/lista', array('acoes' => $acoes, 'militares' => $militares, 'lista' => $lista->result(), 'linhas' => $linhas, 'num_regs' => $num_regs, 'filters' => $filter), TRUE);
		}
		else $auditoria = $this->load->view('auditoria/lista', array('acoes' => $acoes, 'militares' => $militares, 'filters' => $filter), TRUE);
		$this->load->view('layout/index', array('layout' => $auditoria), FALSE);
	}

	public function filtrar_auditoria() {
		$pg = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$linhas = (!$this->input->post('linhas')) ? 20 : $this->input->post('linhas');
		# Carregando os selects
		$acoes = $this->clog_model->getAll('tipo_auditoria')->result();
		$militares = $this->militares_model->getMilitares()->result();
		# Recebendo os POSTs
		$data_inicial = $this->input->post('data_inicial');
		$data_final = $this->input->post('data_final');
		$idtipo = $this->input->post('tipo_auditoria');
		$idmilitar = $this->input->post('militares_id');
		$auditoria = $this->input->post('auditoria');
		# Aplicando filtro
		$filter = array('data_inicial' => $data_inicial,
			'data_final' => $data_final,
			'idtipo' => $idtipo,
			'idmilitar' => $idmilitar,
			'auditoria' => $auditoria
		);
		#echo "<pre>"; var_dump($filter); echo "</pre>"; die();
		$regs = $this->clog_model->getAuditoria($filter);
		if (!is_bool($regs))
			$num_regs = $regs->num_rows();
		$lista = $this->clog_model->getAuditoria($filter, ($pg - 1) * $linhas, $linhas);
		if (!is_bool($lista))
			$this->load->view('auditoria/resultado_consulta', array('lista' => $lista->result(), 'linhas' => $linhas, 'num_regs' => $num_regs, 'filters' => $filter), FALSE);
		/*if (! is_bool($lista)) $auditoria = $this->load->view('auditoria/lista', array('acoes'=>$acoes, 'militares'=>$militares, 'lista'=>$lista->result(), 'linhas'=>$linhas, 'num_regs'=>$regs->num_rows(), 'filters'=>$filter), TRUE);
		$this->load->view('layout/index', array('layout' => $auditoria), FALSE);*/
	}

	public function msgSystemAjax() {
		$msg = $this->input->get('msg');
		$msgTp = $this->input->get('msgTp');
		$pg = $this->input->get('pg');
		$this->session->set_flashdata('mensagem', array('type' => 'alert-'.$msgTp, 'msg' => $msg));
		redirect($pg);
	}
	
	public function dados_grafico($setor_in=null) {
		
		if ($setor_in != null) 
			$ocorrencias = $this->carregar_csv($setor_in);
		else
			$ocorrencias = $this->carregar_csv();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('ocorrencias' => $ocorrencias)));
	}
	
	public function mostra_grafico($setor_in=null) {
		$setores = $this->carregar_setores();
		//var_dump($setores); die();
		if ($setor_in != null) 
			$layout = $this->load->view('saude/saude/grafico_odonto', array('setor_in'=>$setor_in, 'setores'=>$setores), TRUE );
		else
			$layout = $this->load->view('saude/saude/grafico_odonto', array('setores'=>$setores), TRUE );
		$this->load->view('layout/index', array('layout'=>$layout), FALSE);
	}


	/**
	 * Searches value inside a multidimensional array, returning its index
	 *
	 * Original function by "giulio provasi" (link below)
	 *
	 * @param mixed|array $haystack
	 *   The haystack to search
	 *
	 * @param mixed $needle
	 *   The needle we are looking for
	 *
	 * @param mixed|optional $index
	 *   Allow to define a specific index where the data will be searched
	 *
	 * @return integer|string
	 *   If given needle can be found in given haystack, its index will
	 *   be returned. Otherwise, -1 will
	 *
	 * @see http://www.php.net/manual/en/function.array-search.php#97645
	*/
	public function search( $haystack, $needle, $index = NULL ) {

		if( is_null( $haystack ) ) {
			return -1;
		}

		$arrayIterator = new \RecursiveArrayIterator( $haystack );

		$iterator = new \RecursiveIteratorIterator( $arrayIterator );

		while( $iterator -> valid() ) {

			if( ( ( isset( $index ) and ( $iterator -> key() == $index ) ) or
				( ! isset( $index ) ) ) and ( $iterator -> current() == $needle ) ) {

				return $arrayIterator -> key();
			}

			$iterator -> next();
		}

		return -1;
	}
	
}
