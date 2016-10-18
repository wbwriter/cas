<?php
/**
 * Created by PhpStorm.
 * User: gueny_000
 * Date: 18/10/2016
 * Time: 11:11
 */
include_once ROOT_DIR.'views/header.inc';

$sending_errors = $this->vars['sending_errors'];
var_dump($sending_errors);

$success = $this->vars['sending_success'];
var_dump($success);

?>

<h1>Newsletter sent !</h1>

<?php include_once ROOT_DIR.'views/footer.inc'; ?>