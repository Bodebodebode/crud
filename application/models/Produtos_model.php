<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function criar($dados){
    $this->db->where('codigo', $dados['codigo']);
    $query = $this->db->get('produtos', 1);
    if(!$query->num_rows()==1){
      $dados_produto = array(
        'nome' => $dados['nome'],
        'codigo' => $dados['codigo'],
        'fabricante' => $dados['fabricante'],
        'tipo' => $dados['tipo']
      );
      $this->db->insert('produtos', $dados_produto);
      if(array_key_exists('grupos', $dados)){
        foreach ($dados['grupos'] as $grupo_id) {
          $this->db->where('id', $grupo_id);
          $grupo = $this->db->get('grupos', 1);

          $this->db->where('codigo', $dados['codigo']);
          $produto = $this->db->get('produtos', 1);

          $this->db->where('produtos', ((array)$produto->result()[0])['id']);
          $this->db->where('grupos', ((array)$grupo->result()[0])['id']);
          $query = $this->db->get('produtosxgrupos', 1);

          if(!$query->num_rows()==1){
            print_r("4");
            $dados_produtoxgrupos = array(
                                          'produtos' => ((array)$produto->result()[0])['id'],
                                          'grupos'  => ((array)$grupo->result()[0])['id']
                                        );
            $this->db->insert('produtosxgrupos', $dados_produtoxgrupos);
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
      $query = $this->db->get('produtos');
      return $query->result();
    } else if(array_key_exists('id', $dados)){
      $this->db->where('id', $dados['id']);
      $query1 = $this->db->get('produtos');
      $produto = $query1->result()[0];
      $this->db->where('produtos', $dados['id']);
      $query2 = $this->db->get('produtosxgrupos');
      if($query2->num_rows()>=1){
        $grupos_add = new stdClass();
        $count=0;
        foreach ($query2->result() as $grupo) {
          $this->db->where('id', $grupo->grupos);
          $query3 = $this->db->get('grupos', 1);
          $grupos_add->$count=$query3->result()[0];
          $count=$count+1;
        }
        $produto->grupos = $grupos_add;
      }
      return $produto;
    }
  }

  /*else if(array_key_exists('nome', $dados)){
    $this->db->where('nome', $dados['nome']);
    $query = $this->db->get('produtos');
    return $query->result();

  } else if(array_key_exists('codigo', $dados)){
  $this->db->where('codigo', $dados['codigo']);
  $query = $this->db->get('produtos');
  return $query->result();


  } else if(array_key_exists('fabricante', $dados)){
  $this->db->where('fabricante', $dados['fabricante']);
  $query = $this->db->get('produtos');
  return $query->result();

  } else if(array_key_exists('tipo', $dados)){
  $this->db->where('tipo', $dados['tipo']);
  $query = $this->db->get('produtos');
  return $query->result();
  }*/

  public function deletar($id){
    $id = array_keys($id)[0];
    // deleta primeiro instancias da tabela produto x grupo
    $this->db->where('produtos', $id);
    $this->db->delete('produtosxgrupos');
    $this->db->where('id', $id);
    $this->db->delete('produtos');
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

    // atualiza dados do produto
    if($data != array()){
      $this->db->set($data);
      $this->db->where('id', $dados['id']);
      $this->db->update('produtos');
    }
    // remove grupos
    if($data_grupos['remover'] != array()){
      foreach ($data_grupos['remover'] as $grupo) {
        $this->db->where('grupos', $grupo);
        $this->db->where('produtos', $dados['id']);
        $this->db->delete('produtosxgrupos');

      }
    }
    // adiciona grupos
    if($data_grupos['adicionar'] != array()){
      foreach ($data_grupos['adicionar'] as $grupo) {
        $this->db->where('grupos', $grupo);
        $this->db->where('produtos', $dados['id']);
        $dados_novo = array(
                            'produtos' =>$dados['id'],
                            'grupos' => $grupo
                            );
        $this->db->insert('produtosxgrupos', $dados_novo);
      }
  }

  }

}
