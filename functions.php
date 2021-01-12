<?php

function life_project_registrando_taxinomia(){
  register_taxonomy(
    'ferramentas',
    'projetos',
    array(
      'labels' => array('name' => 'Ferramentas'),
      'hierarchical' => true
    )
  );
}
add_action('init', 'life_project_registrando_taxinomia');

function life_project_registrando_post_customizados(){
  register_post_type('projetos',
    array(
      'labels' => array('name' => 'Projetos'),
      'public' => true,
      'menu_position' => 0,
      'supports' => array('title', 'editor', 'thumbnail'),
      'menu_icon' => 'dashicons-admin-site'
    )
  );
}
add_action('init', 'life_project_registrando_post_customizados');

function life_project_adicionando_recursos_ao_tema(){
  add_theme_support('custom-logo');
  add_theme_support('post-thumbnails');
  
}
add_action('after_setup_theme', 'life_project_adicionando_recursos_ao_tema');

function life_project_registrando_menu(){
  register_nav_menu(
   /*location*/ 'menu-navegacao',
   /*description*/ 'Menu navegação'
  );
}
add_action('init', 'life_project_registrando_menu');

function life_project_registrando_post_customizados_banner(){
  register_post_type(
    'banner',
    array(
      'labels' => array('name' => 'Banner'),
      'public' => true,
      'menu_position' => 1,
      'menu_icon' => 'dashicons-format-image',
      'supports' => array('title','thumbnail')
    )
  );
}
add_action('init', 'life_project_registrando_post_customizados_banner');

function life_project_registrando_metabox(){
  add_meta_box(
    'lp_registrando_metabox',
    'Texto para a home',
    'ai_funcao_callback',
    'banner'
  );
}
add_action('add_meta_boxes','life_project_registrando_metabox');

function ai_funcao_callback($post){
  
  $texto_home_1 = get_post_meta($post->ID,'_texto_home_1', true);
  $texto_home_2 = get_post_meta($post->ID,'_texto_home_2', true);
  
  ?>
  <label for="texto_home_1">Texto 1</label>
  <input type="text" name="texto_home_1" style="width: 100%;" value="<?= $texto_home_1 ?>">
  <br><br>
  <label for="texto_home_2">Texto 2</label>
  <input type="text" name="texto_home_2" style="width: 100%;" value="<?= $texto_home_2 ?>">

  <?php
}

function life_project_salvando_dados_metabox($post_id){
  foreach($_POST as $key=>$value){
    if($key !== 'texto_home_1' && $key !== 'texto_home_2'){
      continue;
    }
    update_post_meta(
      $post_id,
      '_'. $key,
      $_POST[$key]
    );
  }
}
add_action('save_post', 'life_project_salvando_dados_metabox');

function pegandoTextoBanner(){
  $args = array(
    'post_type' => 'banner',
    'post_status' => 'publish',
    'post_per_page' => 1
  );

  $query = new WP_Query($args);
  if($query->have_posts()){
    while($query->have_posts()){ $query->the_post();
      $texto1 = get_post_meta(get_the_ID(), '_texto_home_1', true);
      $texto2 = get_post_meta(get_the_ID(), '_texto_home_2', true);
      return array(
        'texto_1' => $texto1,
        'texto_2' => $texto2,
      );

    }
  }
}

function life_project_adicionando_scripts(){
  
  $textosBanner = pegandoTextoBanner();

  if(is_front_page()){
    wp_enqueue_script('typed-js', get_template_directory_uri() . '/js/typed.min.js', array(), false, true);
    wp_enqueue_script('texto-banner-js', get_template_directory_uri() . '/js/texto-banner.js', array('typed-js'), false, true);
    wp_localize_script('texto-banner-js', 'data', $textosBanner);

  }
}
add_action('wp_enqueue_scripts', 'life_project_adicionando_scripts');