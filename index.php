<?php

/*
Sample Code Done By 
Crescle Group.
www.crescle.com

Informatics Institute of Technology
www.iit.ac.lk

Video Guide : http://goo.gl/2Raen
*/

//Header that says this content is json
header('Content-type: application/json');

//get input content to Variable
$inputJSON = file_get_contents('php://input');

//Convert input content to json object
$input= json_decode( $inputJSON, TRUE );


?>

<?php

//including Recall.php file
include "recall.php";

?>