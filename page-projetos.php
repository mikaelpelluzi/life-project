<?php
$estiloPagina = 'projetos.css';
require_once 'header.php';
?>

<form action="#" class="container-alura formulario-pesquisa-paises">
    <h2>Conheça meus projetos</h2>
    <select name="ferramentas" id="paises">
        <option value="">--Selecione--</option>
        <?php
            $ferramentas = get_terms(array('taxonomy' => 'ferramentas'));
            foreach($ferramentas as $ferramenta):?>
                <option value="<?= $ferramenta->name ?>" 
                <?= !empty($_GET['ferramentas']) && $_GET['ferramentas'] === $ferramenta->name ? 'selected' : '' ?> >
                <?= $ferramenta->name ?></option>
            <?php endforeach;
        ?>
    </select>
    <input type="submit" value="Pesquisar">
</form>

<?php

$ferramentaSelecionada = array(array(
  'taxonomy' => 'ferramentas',
  'field' => 'name',
  'terms' => $_GET['ferramentas']
));

$args = array(
  'post_type' => 'projetos',
  'tax_query' => !empty($_GET['ferramentas']) ? $ferramentaSelecionada : ''
);

  $query = new WP_Query($args);

if ($query->have_posts()):
  echo '<main class="page-destinos">';
  echo '<ul class="lista-destinos container-alura">';
  while($query->have_posts()): $query->the_post();
      echo '<li class="col-md-3 destinos">';
        the_post_thumbnail();
        the_title('<p class="titulo-destinos">', '</p>');
        the_content();
      echo '</li>';
  endwhile;
  echo '</ul>';
  echo '</main>';
endif;

require_once 'footer.php';