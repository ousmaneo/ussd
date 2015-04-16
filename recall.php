<?php
/*
Sample Code Done By
Crescle Group.
www.crescle.com

Informatics Institute of Technology
www.iit.ac.lk

Video Guide : http://goo.gl/2Raen
*/

//For any process, we can generate/display Output message on the phone. It may be a multiple line message output if you wish
$data["message"]='We  Display This in Phone Screen';

//application id. If you need, you can validate it as well. You can also send the same application id as sent by the Simulator
$data["applicationId"]=$input["applicationId"];
$data["password"]="password";
$data["version"]="1.0";
//SessionID to continue session
$data["sessionId"]=$input["sessionId"];
//Continue session
$data["ussdOperation"]="mt-cont";
//Destination phone address
$data["destinationAddress"]=$input["sourceAddress"];
$data["encoding"]="440";
$data["chargingAmount"]="5";


//Encode above $data to json object
$json_string = json_encode($data);


//Simulator USSD address
$json_url = "http://localhost:7000/ussd/send";

//To send Request to simulator, Initilize CURL
$ch = curl_init( $json_url );

//setting CURL options
$options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
    CURLOPT_POSTFIELDS => $json_string
);

curl_setopt_array( $ch, $options );

//Excute request
$result =  curl_exec($ch);



?>