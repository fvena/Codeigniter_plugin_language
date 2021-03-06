[Codeigniter Plugin Language](http://www.fvena.com)
=================

Plugin sencillo para CI, que permite hacer que nuestro sitio se vea en varios idiomas. Las url se modificarán mostrando el código del idioma seleccionado actualmente.

```
http://www.mi_sitio.com/es/mi_controlador

http://www.mi_sitio.com/en/mi_controlador
```


Instalación
-----------
Copiamos los archivos en sus respectivas carpetas, manteniendo el sistema de directorios acutal.


Configuración
-------------
Debe completar el array `languages` con los idiomas soportados, indicando el código del idioma que se mostrará en la url, la carpeta que contiene los archivos del idioma y como queremos que se muestre el nombre del idioma, al hacer hover sobre los enlaces, o al listar con la opción `text` todos los idiomas soportados.

La variable `redirect_urls` indica si queremos que se redirija automaticamente a la url del idioma por defecto, cuando no se especifica ninguno.

`http://www.mi_sitio.com/` -> `http://www.mi_sition.com/es/`

```
// aplication/config/config.php

$config['languages'] = array(
  "es" => array("spanish","español"),
  "en" => array("english","english")
);

$config['redirect_urls']=TRUE;
```


Crear nuestros propios archivos de idiomas
------------------------------------------
Puede definir tus propios archivos de idiomas y guardarlos en la carpeta `aplication/language/carpeta_idioma/`.


```
// aplication/language/spanish/test_lang.php

<?php
$lang['test_hello'] = 'hola';
?>
```


```
// aplication/language/english/test_lang.php

<?php
$lang['test_hello'] = 'hello';
?>
```


Cargar los archivos de idiomas
------------------------------
Debes cargar los archivos de idiomas para poder utilizarlos, tienes dos opciones:

* **Cargarlos con autoload** - Se podrán utilizar en todo el sitio

  ```
  // aplication/config/autoload.php

  $autoload['language'] = array('test');
  ```

* **Cargarlos en el controlador** - Los cargamos en el controlador de la vista en la que queramos utilizarlos:

  ```
  // aplication/controller/welcome.php

  public function index () {
    $this->lang->load(‘test’);
    $this->load->view(‘welcome_message’);
  }
  ```


Funciones
---------
* `switch_uri('code_language')` - Devuelve la URI actual con el código del idioma que le indiquemos, es útil para crear enlaces que cambien el idioma.

* `lang()` - Devuelve el código del idioma del páis seleccionado actualmente.

* `lang_list(option,separation)` - Función que devuelve una lista de enlaces para cambiar de idioma, con los idiomas definidos por el usuario en el config. Además le añade la clase `selected` al idioma seleccionado

  Existen tres tipos de listas devueltas, según la opcion elegida:

    + **flags** - Devuelve una lista de enlaces con la clase `flag es` o el código de cada idioma. Permite con css, mostrar la bandera de cada país.

    + **iso** - Devuelve una lista de enlaces formados por los códigos iso de cada idioma: ES | EN | FR

    + **text** - Devuelve una lista de enlaces formados por los nombres completos de los idiomas que definimos en el config: english | español

  El **separador** indica que caracter o caracteres servirán para separar cada enlace.

  Por defecto la opción es flags y la separación es un espacion en blanco.


Modo de uso
-----------
```
// Escribe el contenido de la variable test_hello que definimos en los archivos de idiomas, en el idioma que esté seleccionado actualmente

<?= lang('test_hello') ?>
```

```
// Crear enlaces para cambiar el idioma de la página

<?= anchor($this->lang->switch_uri('en'),'English'); ?>
<?= anchor($this->lang->switch_uri('es'),'Spanish'); ?>
```

```
// Si queremos obtener el código del idioma que estamos utilizando

<?= $this->lang->lang(); ?>
```

```
// Redirect, anchors, ...

<?= anchor('/'.$this->lang->lang().'/module/controller/method') ?>
```


Autor
-----
Francisco Vena

[paco@fvena.com](mailto:paco@fvena.com)


Bug Reporting
-------------
Si encontraís errores, ideas para mejorarlo o nuevas funcionalidades, escribidme a [paco@fvena.com](mailto:paco@fvena.com).


Versión
--------
+ v1.1

