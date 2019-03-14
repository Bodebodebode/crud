<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GrupoDeProdutos_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function criar($dados){
    $this->db->where('nome', $dados['nome']);
    $query = $this->db->get('grupos', 1);
    if(!$query->num_rows()==1){
      $dados_grupo = array(
        'nome' => $dados['nome']
      );
      $this->db->insert('grupos', $dados_grupo);
      $id = $this->db->insert_id();
      if(array_key_exists('produtos', $dados)){
        foreach ($dados['produtos'] as $produto_codigo) {
          $this->db->where('codigo', $produto_codigo);
          $produto = $this->db->get('produtos', 1);

          $this->db->where('id', $id);
          $grupo = $this->db->get('grupos', 1);

          $this->db->where('produtos', ((array)$produto->result()[0])['id']);
          $this->db->where('grupos', ((array)$grupo->result()[0])['id']);
          $query = $this->db->get('produtosxgrupos', 1);

          if(!$query->num_rows()==1){
            $dados_produtosxgrupos = array(
                                          'produtos' => ((array)$produto->result()[0])['id'],
                                          'grupos'  => ((array)$grupo->result()[0])['id']
                                        );
            $this->db->insert('produtosxgrupos', $dados_produtosxgrupos);
        }
      }
      return $this->db->insert_id();
    } else{
      return 0;
    }
  }
}

  public function ler($dados){
    if($dados == NULL){
      // retorna todos os valores da table
      $query = $this->db->get('grupos');
      return $query->result();
    } else if(array_key_exists('id', $dados)){
      $this->db->where('id', $dados['id']);
      $query1 = $this->db->get('grupos');
      $grupo = $query1->result()[0];
      $this->db->where('grupos', $dados['id']);
      $query2 = $this->db->get('produtosxgrupos');
      if($query2->num_rows()>=1){
        $produtos_add = new stdClass();
        $count=0;
        foreach ($query2->result() as $produto) {
          $this->db->where('id', $produto->produtos);
          $query3 = $this->db->get('produtos', 1);
          $produtos_add->$count=$query3->result()[0];
          $count=$count+1;
        }
        $grupo->produtos = $produtos_add;
      }
      return $grupo;
    }
  }

  public function deletar($id){
    $id = array_keys($id)[0];
    // deleta primeiro instancias da tabela produto x grupo
    $this->db->where('grupos', $id);
    $this->db->delete('produtosxgrupos');
    $this->db->where('id', $id);
    $this->db->delete('grupos');
    return;
  }

  public function atualizar($dados){
    $count = 0;
    $keys = array_keys($dados);
    foreach ($dados as $value) {
      // remove espacos em branco
      if($value==""){
        unset($dados[$keys[$count]]);
        unset($keys[$count]);
      }
      $count = $count+1;
    }
    $data = array();
    $data_grupos = array(
                        'remover' => array(),
                        'adicionar' => array()
    );
    for ($i=0; $i<count($dados); $i++) {

      if(array_keys($dados)[$i] != 'adicionar' &&  array_keys($dados)[$i] != 'remover' && array_keys($dados)[$i] != 'id'){
        $data[array_keys($dados)[$i]] = $dados[array_keys($dados)[$i]];
      } else if(array_keys($dados)[$i] == 'remover'){
          $remover = $dados[array_keys($dados)[$i]];
          for($j=0; $j<count($remover);$j++){
            array_push($data_grupos['remover'], $remover[$j]);
          }

      } else if(array_keys($dados)[$i] == 'adicionar'){
        $adicionar = $dados[array_keys($dados)[$i]];
        for($j=0; $j<count($adicionar);$j++){
          array_push($data_grupos['adicionar'], $adicionar[$j]);
        }
      }
    }

    // atualiza dados do grupo
    if($data!= array()){
      $this->db->set($data);
      $this->db->where('id', $dados['id']);
      $this->db->update('grupos');
    }
    // remove produtos
    if($data_grupos['remover']!=array()){
      foreach ($data_grupos['remover'] as $produto) {
        $this->db->where('produtos', $produto);
        $this->db->where('grupos', $dados['id']);
        $this->db->delete('produtosxgrupos');
      }
    }
    // adiciona produtos
    if($data_grupos['adicionar'] != array()){
      foreach ($data_grupos['adicionar'] as $produto) {
        $this->db->where('produtos', $produto);
        $this->db->where('grupos', $dados['id']);
        $dados_novo = array(
                            'produtos' =>$produto,
                            'grupos' => $dados['id']
                            );
        $this->db->insert('produtosxgrupos', $dados_novo);
      }
    }

  }
}
