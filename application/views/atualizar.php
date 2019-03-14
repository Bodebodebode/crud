<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php  $this->load->view('header'); ?>
<script>

  window.onload = function(){
    var elements_produtos = document.getElementsByClassName('id_produto');
    for(var i=0; i<elements_produtos.length; i++){
      elements_produtos[i].value = elements_produtos[i].getAttribute('id') ;
    };
    var elements_grupos = document.getElementsByClassName('id_grupo');
    for(var i=0; i<elements_grupos.length; i++){
      elements_grupos[i].value = elements_grupos[i].getAttribute('id') ;
    };

  }

  function grupo_pega_valor(){
    var id = document.getElementById("select_grupos").value;
    var elements = document.getElementById('grupos_display').getElementsByClassName('caracteristicas_dos_grupos');
    for(var i=0; i<elements.length; i++){
      elements[i].style.display="none";
    };
    document.getElementById('grupo'+id).style.display = "block";
  }

  function produto_pega_valor(){
    var id = document.getElementById("select_produtos").value;
    var elements = document.getElementById('produtos_display').getElementsByClassName('caracteristicas_dos_produtos');
    for(var i=0; i<elements.length; i++){
      elements[i].style.display="none";
    };
    document.getElementById('produto'+id).style.display = "block";
  }

</script>
<style>
  #container_ler{
    text-align: center;
    display:inline-grid;
    width: 100%;
  }

  .select_container {
    display: inline-flex;
    margin:20px;

  }

  .display_box, .select{
    display: inline-block;
    width: 50%;
    height: 250px;
  }
</style>

<div id="container">
  <h1 id="page_title"><?php echo $titulo; ?></h1>
		<nav id="nav_bar" class="nav_bar" style="display : inline-block">
      <a class="nav_bar" href="criar"><p>Create</p></a>
      <a class="nav_bar" href="ler"><p>Read</p></a>
      <a class="nav_bar" href="atualizar"><p>Update</p></a>
      <a class="nav_bar" href="deletar"><p>Delete</p></a>
    </nav>
    <h2 class="subtitulo"><?php echo $subtitulo; ?></h2>
    <div id="container_ler">
      <!--
      <div class="form" id="pesquisar_container">
        <div class="form" id="pesquisar_produtos">

        </div>
        <div class="form" id="pesquisar_grupos">

        </div>
      </div>
      -->

      <div class="select_container" id="select_container_produtos">
        <div id="esquerda_produtos" class="select">
          <div class="select" id="escolher_produtos_da_lista">
            <h3> Escolha um produto da lista para atualizar seus detalhes</h3>
            <?php
              echo form_open('main/mostrar_produto');
              $produtos_option = array();
              foreach ($produtos as $produto) {
                $produtos_option[$produto->id] = $produto->nome;
              }
              $options = array(
                              'onChange' => 'produto_pega_valor();',
                              'id' => 'select_produtos'
                              );
              echo form_dropdown('id', $produtos_option, "", $options);
              echo form_close();

            ?>

          </div>
        </div>
        <div class="display_box" id="direita_produtos">
          <div id="produtos_display" >
            <?php foreach ($produtos as $produto) {
              $grupos_p = '';
              if(property_exists($produto, 'grupos')){
                foreach ($produto->grupos as $grupo) {
                  $grupos_p = $grupos_p.' '.$grupo->nome;
                }
              }
              if($grupos_p == ''){
                $grupos_p = '<span style="color:gray"> Não possui nenhum grupo</span>';
              }
              echo '<div class="caracteristicas_dos_produtos" id="produto'.$produto->id.'" style="display:none">';
              echo form_open('main/atualizar_produto');
              echo '<p><span>Nome: '.$produto->nome;
              echo form_input('nome', set_value('nome'), array('autofocus' => 'autofocus')).'</span></p>';
              echo '<p>Código: '.$produto->codigo.'</p>
                    <p>Id: '.$produto->id;
              echo form_input('id', set_value('id'), array(
                                                          'id' => $produto->id,
                                                          'class' => 'id_produto',
                                                          'hidden' => 'true'
                                                          )
                              );
              echo  '</p>';
              echo  '<p><span>Fabricante: '.$produto->fabricante;
              echo form_input('fabricante', set_value('fabricante')).'</span></p>
                    <p><span>Tipo: '.$produto->tipo;
              $options_tipo = array (
                        'Comprimido'=> 'Comprimido',
                        'Cápsula'   => 'Cápsula',
                        'Drágea'    => 'Drágea',
                        'Solução'   => 'Solução',
                        'Suspensão' => 'Suspensão',
                        'Xarope'    => 'Xarope',
                        'Pílula'    => 'Pílula',
                        'Pomada'    => 'Pomada',
                        'Creme'     => 'Creme',
                        'Aerosol'   => 'Aerosol',
                        'Injetável' => 'Injetável',
                        'Colírio'   => 'Colírio'
                      );
              echo form_dropdown('tipo', $options_tipo).'</span></p>
                    <p><span>Grupos a que pertence: '.$grupos_p;
              echo '<p><span> Adicionar grupos: ';
              $grupos_nomes = array();
              foreach ($grupos as $grupo) {
                $grupos_nomes[$grupo->id] = $grupo->nome;
              }
              echo form_multiselect('adicionar[]', $grupos_nomes, $grupos_nomes,array('style' =>'max-height: 15em;; overflow:scroll;'));
              if($grupos_p != '<span style="color:gray"> Não possui nenhum grupo</span>'){
                      echo 'Deletar grupos: ';
                      $grupos_do_produto_para_remover = array();
                      foreach ($produto->grupos as $grupo) {
                          $grupos_do_produto_para_remover[$grupo->id] = $grupo->nome ;

                      }
                      echo form_multiselect('remover[]', $grupos_do_produto_para_remover, $grupos_do_produto_para_remover,array('style' =>'max-height: 15em;; overflow:scroll;'));
                    }
                    echo form_submit('', 'Enviar');
                    echo form_close();
                    echo '</span></p></div>';

                        }
            ?>
          </div>
          </div>
      </div>




      <div class="select_container" id="select_container_grupos">
        <div id="esquerda_grupos" class="select">


        <div class="select" id="escolher_grupos_da_lista">
          <h3> Escolha um grupo da lista para atualizar seus detalhes</h3>
          <?php
            echo form_open('main/mostrar_grupo');
            $grupos_option = array();
            foreach ($grupos as $grupo) {
              $grupos_option[$grupo->id] = $grupo->nome;
            }
            $options = array(
                            'onChange' => 'grupo_pega_valor();',
                            'id' => 'select_grupos'
                            );
            echo form_dropdown('id', $grupos_option, "" , $options);
            echo form_close();

          ?>
        </div>
      </div>
        <div class="display_box" id="direita_grupos">
          <div id="grupos_display">
            <?php foreach ($grupos as $grupo) {
              $produtos_p = '';
              if(property_exists($grupo, 'produtos')){
                foreach ($grupo->produtos as $produto) {
                  $produtos_p = $produtos_p.' '.$produto->nome;
                }
              }
              if($produtos_p == ''){
                $produtos_p = '<span style="color:gray"> Não possui nenhum produto</span>';
              }
              echo '<div class="caracteristicas_dos_grupos" id="grupo'.$grupo->id.'" style="display:none">';
              echo form_open('main/atualizar_grupo');
              echo '<p><span>Nome: '.$grupo->nome;
              echo form_input('nome', set_value('nome'), array('autofocus' => 'autofocus')).'</span></p>';

              echo '<p>Id: '.$grupo->id;
              echo form_input('id', set_value('id'), array(
                                                          'id' => $grupo->id,
                                                          'class' => 'id_grupo',
                                                          'hidden' => 'true'
                                                          )
                              );
              echo  '</p>';
              echo  '<p><span>Produtos do grupo: '.$produtos_p.'</span></p>';
              echo '<p><span> Adicionar produtos: ';
              $produtos_nomes = array();
              foreach ($produtos as $produto) {
                $produtos_nomes[$produto->id] = $produto->nome;
              }
              echo form_multiselect('adicionar[]', $produtos_nomes, $produtos_nomes,array('style' =>'max-height: 15em;; overflow:scroll;'));
              if($produtos_p != '<span style="color:gray"> Não possui nenhum produto</span>'){
                      echo 'Deletar produtos: ';
                      $produtos_do_grupo_para_remover = array();
                      foreach ($grupo->produtos as $produto) {
                          $produtos_do_grupo_para_remover[$produto->id] = $produto->nome ;

                      }
                      echo form_multiselect('remover[]', $produtos_do_grupo_para_remover, $produtos_do_grupo_para_remover,array('style' =>'max-height: 15em;; overflow:scroll;'));
                    }
                    echo form_submit('', 'Enviar');
                    echo form_close();
                    echo '</span></p></div>';

                        }


            ?>
          </div>
        </div>
      </div>
  </div>

<?php $this->load->view('footer'); ?>
