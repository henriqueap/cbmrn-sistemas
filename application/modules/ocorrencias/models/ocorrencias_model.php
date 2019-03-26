<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */

class Ocorrencias_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function salvar($tabela=NULL, $objeto=NULL)
  {
  	if (!is_null($tabela) OR !is_null($objeto)) {
  		if (is_array($objeto)) {
  			$query = $this->db->insert($tabela, $objeto);
        return $query;
  		}
  	}	return 0;
  }

  public function salvar_locais($tabela=NULL, $objeto=NULL)
  {
    $query = $this->db->query("INSERT INTO gbs_locais (cidade, estado, localidade) VALUES ('".$objeto['cidade']."', '".$objeto['estado']."', '".$objeto['localidade']."');");
    return $query;
  }

  public function salvar_ocorrencias($tabela=NULL, $objeto=NULL)
  {
    $query = $this->db->query("INSERT INTO gbs_ocorrencias (domicilio, gbs_locais_id, idade, data, horario, tipo_ocorrencias_id) VALUES ('".$objeto['domicilio']."', '".$objeto['gbs_locais_id']."', '".$objeto['idade']."', '".$objeto['data']."', '".$objeto['horario']."', '".$objeto['tipo_ocorrencias_id']."');");
    return $query;
  }

  public function salvar_ocorrencias_lotes($tabela=NULL, $objeto=NULL)
  {
    $query = $this->db->query("INSERT INTO gbs_ocorrencias (gbs_locais_id, data, tipo_ocorrencias_id) VALUES ('".$objeto['gbs_locais_id']."', '".$objeto['data']."', '".$objeto['tipo_ocorrencias_id']."');");
    return $query;
  }

  public function salvar_tipo_ocorrencias($tabela=NULL, $objeto=NULL)
  {
    $query = $this->db->query("INSERT INTO gbs_tipo_ocorrencias (ocorrencia, codigo) VALUES ('".$objeto['ocorrencia']."', '".$objeto['codigo']."');");
    return $query;
  }

  public function atualizar($tabela=NULL, $objeto=NULL)
  {
    if (!is_null($tabela) OR is_null($objeto)) {
      if (is_array($objeto)) {
        $this->db->where('id', $objeto['id']);
        $query = $this->db->update($tabela, $objeto);
        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
      }
    } else return 0;
  }

  public function excluir($tabela=NULL, $id=NULL)
  {
    if (is_string($tabela)) {
      if (!is_null($tabela) OR !is_null($id)) {
        $this->db->where('id', $id);
        $this->db->delete($tabela);
      }
    } return 0;
  }

  public function listar($tabela, $id=NULL, $field=NULL, $order = 'desc', $limit=NULL, $offset=NULL)
  {
    if (!is_null($id))
      $this->db->where('id', $id);
    if (!is_null($field))
      $this->db->order_by($field, 'asc');

    # $this->db->order_by('id', $order);
    $this->db->where('ativo !=', '0');
    $query = $this->db->get($tabela, $limit, $offset);
    return $query;
  }

  public function listar_tipos($limit=NULL, $offset=NULL)
  {
    $tabela = "gbs_tipo_ocorrencias";
    $this->db->where('ativo > ', '0');
    $this->db->order_by('ocorrencia', 'asc');
    $query = $this->db->get($tabela, $limit, $offset);
    return $query;
  }

  public function consulta_localidades($filter)
  {
    $this->db->select('*');
    $this->db->from('gbs_locais');

    # Não sei porquê existe, mas está ai!
    $this->table_name="";

    if (isset($filter['cidade'])) {
      $this->db->like($this->table_name . 'cidade', $filter['cidade']);
    }

    $this->db->where('ativo > ', '0');
    $this->db->order_by("cidade", "asc");
    $query = $this->db->get();
    return $query;
  }

  public function consulta_ocorrencias($filter)
  {
    $SQLCommand =  "SELECT
      gbs_ocorrencias.id AS ocorrencias_id,
      gbs_ocorrencias.ativo,
      gbs_ocorrencias.domicilio,
      gbs_ocorrencias.idade,
      gbs_ocorrencias.data AS data_ocorrencia,
      gbs_ocorrencias.horario,
      gbs_ocorrencias.gbs_locais_id,
      gbs_ocorrencias.tipo_ocorrencias_id,
      gbs_tipo_ocorrencias.ocorrencia,
      gbs_tipo_ocorrencias.codigo, 
      gbs_locais.localidade
      FROM gbs_ocorrencias
        INNER JOIN gbs_tipo_ocorrencias ON gbs_tipo_ocorrencias.id = tipo_ocorrencias_id
        INNER JOIN gbs_locais ON gbs_locais.id = gbs_ocorrencias.gbs_locais_id
    ";

    if (!empty($filter)) {
      # var_dump($filter);
      # Inicializando variáveis
      $count = count($filter);
      if (isset($filter['data_inicio'])) $count--;
      if (isset($filter['data_fim'])) $count--;
      $contador = 1;
      $filters = '';
      # Filtro de datas inteligente
      if (isset($filter['data_inicio']) && $filter['data_inicio'] != '') {
        $dtIni = $filter['data_inicio'];
        $dtFim = date("Y-m-d", strtotime("now"));
        if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
          $dtFim = $filter['data_fim'];
        }
        $date_filter = "(gbs_ocorrencias.data BETWEEN '$dtIni' AND '$dtFim')";
      } else {
        $dtFim = date("Y-m-d", strtotime("now"));
        if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
          $dtFim = $filter['data_fim'];
        }
        $date_filter = "(gbs_ocorrencias.data BETWEEN '2014-06-01' AND '$dtFim')";
      } # Fim do filtro de datas
      # Outros filtros
      foreach ($filter as $key => $value) {
        #Testando se o índice é de data e criando os LIKEs
        if ($key != 'data_inicio' && $key != 'data_fim') {
          #$filters .= "gbs_ocorrencias.".$key." LIKE '%$value%'";
          $filters .= "gbs_ocorrencias.".$key." = '$value'"; #Tenente pediu
          #Incremetando contador
          $contador++;
          #Testando se inclui o OR
          if ($contador <= $count) {
            $filters .= " AND ";
          }  # Fim do OR
        } # Fim dos LIKEs
      } # Fim dos outros filtros
      # Aplicando filtros
      # $SQLCommand .= "WHERE ativo != 0 ";
      /*if ($filter['gbs_locais_id'] != '') {
        $SQLCommand .= " WHERE  gbs_locais.id = " . $filter['gbs_locais_id']. " "; }
      */

      if ($date_filter != "") {
        $SQLCommand .= " WHERE ".$date_filter;
          if ($filters != "") $SQLCommand .= " AND (".$filters.")";
      } else {
        if ($filters != "") $SQLCommand .= " AND (".$filters.")";
      }
    } # Fim do empty
    # Adicionar filtro caso tenha locais. 
    if ($filter['gbs_locais_id'] != '') { $SQLCommand .= " AND  gbs_locais.id = " . $filter['gbs_locais_id']. " "; }
    # Ordenando a consulta
    $SQLCommand .= " AND gbs_ocorrencias.ativo != 0 ORDER BY gbs_ocorrencias.data DESC, gbs_ocorrencias.horario DESC";
    # $SQLCommand .= " LIMIT 50 OFFSET 0 "; 
    # var_dump($SQLCommand);
    $query = $this->db->query($SQLCommand);
    return $query;
  }

  /*!
   * @param $id
   * Ocultar locais da consulta.
   */
  public function excluir_locais($id)
  {
    # Excluír locais..
    $data = array('ativo'=>'0');
    $this->db->where('id', $id);
    $query = $this->db->update('gbs_locais', $data);
    $query = $this->db->affected_rows();

    return $query;
  }

  /*!
   * @param $id
   * Ocultar ocorrências da consulta.
   */
  public function excluir_ocorrencias($id)
  {
    # Excluír ocorrências..
    $this->db->where('ativo > ', '0');
    $this->db->where('id', $id);
    $query = $this->db->update('gbs_ocorrencias', array('ativo'=>'0'));
    $this->db->affected_rows();
    return $query;
  }

  public function excluir_tipo_ocorrencias($id)
  {
    # Excluír ocorrências..
    $this->db->where('ativo > ', '0');
    $this->db->where('id', $id);
    $query = $this->db->update('gbs_tipo_ocorrencias', array('ativo'=>'0'));
    $this->db->affected_rows();
    return $query;
  }

  /*!
   * @param $id
   * Exibir detalhes das ocorrências que estão sendo criadas.
   */
  public function detalhes_ocorrencias($id)
  {
    # Excluír locais..
    $this->db->where('ativo > ', '0');
    $this->db->where('id', $id);
    $query = $this->db->get('gbs_ocorrencias');
    return $query;
  }

  public function lista_detalhada_ocorrencias($id)
  {
    # $this->db->query("");
  }
  
  public function getOcorrencias() {
    $_data = array();
    $_sql = "SELECT
              gbs_ocorrencias.tipo_ocorrencias_id,
              gbs_tipo_ocorrencias.ocorrencia,
              gbs_tipo_ocorrencias.codigo,
              COUNT(gbs_tipo_ocorrencias.id) AS quantidade
              FROM gbs_ocorrencias 
              INNER JOIN gbs_tipo_ocorrencias ON gbs_ocorrencias.tipo_ocorrencias_id = gbs_tipo_ocorrencias.id
              WHERE gbs_ocorrencias.ativo = 1 AND (gbs_tipo_ocorrencias.id NOT IN (9,13)) 
              GROUP BY gbs_ocorrencias.tipo_ocorrencias_id";
    $_ocorrencias = $this->db->query($_sql);    
    foreach ($_ocorrencias->result() as $tipo_ocorrencia) {
      
      $_data[] =$tipo_ocorrencia;
    }
    /*echo "<pre>";
      var_dump($_data);
    echo "</pre>"; 
	die();*/
    return $_data;
  }

  public function getQuantidade($id) {
    $_sql = "SELECT
              gbs_ocorrencias.tipo_ocorrencias_id,
              gbs_tipo_ocorrencias.ocorrencia,
              gbs_tipo_ocorrencias.codigo,
              COUNT(gbs_tipo_ocorrencias.id) AS quantidade
                FROM gbs_ocorrencias 
                INNER JOIN gbs_tipo_ocorrencias ON gbs_ocorrencias.tipo_ocorrencias_id = gbs_tipo_ocorrencias.id
                WHERE gbs_tipo_ocorrencias.id = $id";
    $_value = $this->db->query($_sql);
    return $_value->row();
  }
}
