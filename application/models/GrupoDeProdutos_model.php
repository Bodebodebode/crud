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
}
