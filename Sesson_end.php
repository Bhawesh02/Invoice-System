<?php
session_start();
function destroySesson(){
  session_destroy();
  header('Location: index.php');

}
if (isset($_GET['call_function'])) {
  destroySesson();
}
?>