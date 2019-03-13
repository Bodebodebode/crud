<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php  $this->load->view('header'); ?>
<style>




</style>
<script>
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
        <h3> Escolha um produto da lista para ver seus detalhes</h3>
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
          echo '<div class="caracteristicas_dos_produtos" id="produto'.$produto->id.'" style="display:none">
                  <p>Nome: '.$produto->nome.'</p>
                  <p>Código: '.$produto->codigo.'</p>
                  <p>Id: '.$produto->id.'</p>
                  <p>Fabricante: '.$produto->fabricante.'</p>
                  <p>Tipo: '.$produto->tipo.'</p>
                  <p>Grupos a que pertence: '.$grupos_p.'</p>
          </div>';
        }
        ?>
      </div>
      </div>
  </div>




  <div class="select_container" id="select_container_grupos">
    <div id="esquerda_grupos" class="select">


    <div class="select" id="escolher_grupos_da_lista">
      <h3> Escolha um grupo da lista para ver seus detalhes</h3>
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
          $produtos_p = $produtos_p.'';
          if($produtos_p == ''){
            $produtos_p = '<span style="color:gray"> Não possui nenhum grupo</span>';
          }
          echo '<div class="caracteristicas_dos_grupos" id="grupo'.$grupo->id.'" style="display:none">
                  <p>Nome: '.$grupo->nome.'</p>
                  <p>Id: '.$grupo->id.'</p>
                  <p>Produtos do grupo: '.$produtos_p.'</p>
          </div>';
        }
        ?>
      </div>
    </div>
  </div>
  </div>

<?php $this->load->view('footer'); ?>
