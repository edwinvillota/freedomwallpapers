<?php

/**
 * Clase para crear la barra de navegacion entre paginas
 */
class Pagnav
{

  private $numResults;
  private $numPages;

  function __construct($numResults,$itemsPerPage = 12, $current = 1)
  {
    $this->numResults = $numResults;
    $this->numPages = ceil($numResults / 12);
    $this->current = $current;
  }

 public function getHTML(){
   echo '<nav aria-label=...>';
   echo '<ul class="pagination justify-content-center">';
   ($this->current <= 1) ? $backDis = 'disabled' : $backDis = '';
   echo "<li class='page-item ". $backDis . "'>";
   echo '<a class="page-link" href="' . $this->getURL($this->current - 1) . '" tabindex="-1">Anterior</a>';
   echo '</li>';
   for ($i=1; $i <= $this->numPages; $i++) {
     ($i == $this->current) ? $active = 'active' : $active = '';
     echo "<li class='page-item {$active}'>";
     echo "<a class='page-link' href=" . $this->getURL($i) . ">{$i} <span class='sr-only'>(current)</span></a>";
     echo '</li>';
   }
   ($this->current >= $this->numPages) ? $nextDis = 'disabled' : $nextDis = '';
   echo '<li class="page-item ' . $nextDis . '">';
   echo '<a class="page-link" href="' . $this->getURL($this->current + 1) . '">Siguiente</a>';
   echo '</li>';
   echo '</ul>';
   echo '</nav>';
 }

 private function getURL($page){
   $url = $_SERVER['REQUEST_URI'];
   $pattern = '/(page=)[0-9]{1,3}/';
   $replace = '${1}' . $page;
   return preg_replace($pattern,$replace,$url);
 }

}


 ?>
