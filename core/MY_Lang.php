<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Lang extends MX_Lang
{
  var $lang = '';


  function __construct()
  {
    parent::__construct();
    $config =& get_config();

    if(isset($config['languages']) && isset($config['redirect_urls']))
    {
      global $URI, $CFG, $IN;

      // Obtenemos el primer segmento de la URI
      $this->lang = (isset($URI->segments['1']))?$URI->segments['1']:'';
      $uri=$URI->segments;

      // Comprobamos que este formado por dos caracteres y que exista dentro
      // del array de lenguajes que hemos definido en el archivo config.php
      if(strlen($this->lang) == 2 && array_key_exists($this->lang,$config['languages']) == true)
      {
        // Si el idioma existe, cambia al idioma correspondiente
        $config['language']=$config['languages'][$this->lang][0];
      }
      elseif($config['redirect_urls'] == true || strlen($this->lang) == 2 && array_key_exists($this->lang,$config['languages']) == false)
      {
        // Sino está definido ese idioma, lo redirige al idioma por defecto
        $url=$config['base_url'];
        $url.=(empty($config['index_page']))?'':$config['index_page'].'/';
        $url.=array_search($config['language'],$config['languages']).'/';
        if(strlen($this->lang)==2)
        {
          array_shift($uri);
          $url.=implode('/',$uri);
        }
        else
        {
          $url.=implode('/',$uri);
        }
        header("location: $url");
      }
    }
  }

  // Devuelve la abreviación del idioma que se está utilizando
  // ej: devuelve 'es' si el idioma es espanol
  function lang()
  {
    return $this->lang;
  }

  // Cambia el idioma de la página actual
  function switch_uri($lang)
  {
    $CI =& get_instance();

    $uri = $CI->uri->uri_string();
    if ($uri != "")
    {
      $exploded = explode('/', $uri);
      if($exploded[0] == $this->lang)
      {
        $exploded[0] = $lang;
      }
      $uri = implode('/',$exploded);
    }

    return $uri;
  }

  function lang_list($option='flags',$separation=' ')
  {
    $config =& get_config();

    if(isset($config['languages'])){
      $langs = $config['languages'];
      $list = array();

      foreach ($langs as $lang => $folder) {
        $selected = '';

        if ($this->lang == $lang) {$selected = 'selected';}

        switch ($option) {
          case 'flags':
            $class = 'flag '.$lang.' '.$selected;
            $text = ' ';
            break;
          case 'iso':
            $class = $selected;
            $text = $lang;
            break;
          case 'text':
          default:
            $class = $selected;
            $text = $folder[1];
            break;
        }

        $anchor = array(
          'class' => $class,
          'title' => $folder[1]
        );

        array_push($list, anchor($this->switch_uri($lang),$text,$anchor));
      }

      return implode($separation,$list);
    }

    return null;
  }

}