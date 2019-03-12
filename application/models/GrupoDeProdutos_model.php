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
    }
  }

}
