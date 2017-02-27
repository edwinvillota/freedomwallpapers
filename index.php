<?php
require('core/core.php');

if(isset($_GET['view'])){
  if(file_exists('core/controllers/' . strtolower($_GET['view']) . '.Controller.php')) {
    include('core/controllers/' . strtolower($_GET['view']) . '.Controller.php');
  } else {
    include('core/controllers/error.Controller.php');
  }
} else {
  include('core/controllers/index.Controller.php');
}

?>
