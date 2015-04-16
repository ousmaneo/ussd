<?php

ini_set('error_log', 'ussd-app-error.log');

require 'libs/MoUssdReceiver.php';
require 'libs/MtUssdSender.php';
require 'class/operationsClass.php';
//require 'log.php';
require 'db.php';


$production=false;

	if($production==false){
		$ussdserverurl ='http://localhost:7000/ussd/send';
	}
	else{
		$ussdserverurl= 'https://api.dialog.lk/ussd/send';
	}


$receiver 	= new UssdReceiver();
$sender 	= new UssdSender($ussdserverurl,'APP_000001','password');
$operations = new Operations();

$receiverSessionId = $receiver->getSessionId();
$content 			= 	$receiver->getMessage(); // get the message content
$address 			= 	$receiver->getAddress(); // get the sender's address
$requestId 			= 	$receiver->getRequestID(); // get the request ID
$applicationId 		= 	$receiver->getApplicationId(); // get application ID
$encoding 			=	$receiver->getEncoding(); // get the encoding value
$version 			= 	$receiver->getVersion(); // get the version
$sessionId 			= 	$receiver->getSessionId(); // get the session ID;
$ussdOperation 		= 	$receiver->getUssdOperation(); // get the ussd operation


$responseMsg = array(
    "main" =>  
    "Wecome! Choose language:
1. አማርኛ
2. English
3. IVR

0. Exit",
    "amharic" =>
        "ሥራ ዘርፍ:
1. ግንባታ
2. ቴክኖዎሎጂ መረጃ
3. ግብርና
4. የተሰራበት
5. ሆቴል
6. ሒሳብ

0. Exit",
    "english"=>
    "Job Sector:
1.Construction
2.Information Technology
3.Agriculture
4.Manufacturing
5.Hotel
6.Accounting",
 "aList1"=>
    "ግንባታ:
1. ከያኒ ንድፍ
2. የቅርፀት መሃንዲስ
3. የአቋም መሃንዲስ
4. ግምበኛ
5. ሠዓሊ
6. አናፂ",
 "eList1"=>
    "Construction:
1. Architect
2. architectural engineer
3. structural engineer
4. construction worker
5. Painter
6.  carpenter",
"aList2"=>
    "ቴክኖዎሎጂ መረጃ:
1. ኮምፒውተር መሃንዲስ
2. መረብ መሃንዲስ
3. ምእላድ አስተዳዳሪ
    ",
    "eList2"=>
    "Information technology:
1. Developer
2. Database manager
3. Network specialist
",
"aList3"=>
    "ግብርና :
1. ገበሬ
2. ዐጃቢ
3. ደንገጥር",
"eList3"=>
    "Agriculture :
1. Farmer
2. poultry worker
3. livestock",
"eList4"=>
    "Manufacturing:
 No job.
",
"aList5"=>
    "ሆቴል:
    አይ ሥራ
        ",
"eList5"=>
    "Hotel:
 No job.
",
"aList6"=>
    "ሒሳብ:
    አይ ሥራ
    ",
"eList6"=>
    "Accounting:
 No job.
"


);





if ($ussdOperation  == "mo-init") {

	try {
		
		$sessionArrary=array( "sessionid"=>$sessionId,"tel"=>$address,"menu"=>"main","pg"=>"","others"=>"");
  		$operations->setSessions($sessionArrary,$db);
		$sender->ussd($sessionId, $responseMsg["main"],$address );
	} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again',$address );
	}
	
}else {

	$flag=0;

  	$sessiondetails=  $operations->getSession($sessionId,$db);
  	$cuch_menu=$sessiondetails['menu'];
  	$operations->session_id=$sessiondetails['sessionsid'];

		switch($cuch_menu ){
		
			case "main": 	// Following is the main menu
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="amharic";
							$operations->saveSesssion($db);
							$sender->ussd($sessionId,$responseMsg["amharic"],$address );
							break;
						case "2":
							$operations->session_menu="english";
							$operations->saveSesssion($db);
							$sender->ussd($sessionId,$responseMsg["english"],$address );
							break;
						case "3":
							$operations->session_menu="ivr";
							$operations->saveSesssion($db);
							$sender->ussd($sessionId,'Enter Your ID',$address );
							break;
						default:
							$operations->session_menu="main";
							$operations->saveSesssion($db);
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
			case "amharic":
                switch ($receiver->getMessage()) {
                    case "1":
                        $operations->session_menu="aList1";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["aList1"],$address );
                        break;
                    case "2":
                        $operations->session_menu="aList2";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["aList2"],$address );
                        break;
                    case "3":
                        $operations->session_menu="aList3";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["aList3"],$address );
                        break;
                    case "4":
                        $operations->session_menu="aList4";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["aList4"],$address );
                        break;
                    case "5":
                        $operations->session_menu="aList5";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["aList5"],$address );
                        break;
                    case "6":
                        $operations->session_menu="aList6";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["aList6"],$address );
                        break;
                    default:
                        $operations->session_menu="amharic";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId, $responseMsg["amharic"],$address );
                        break;
                }
				break;
			case "english":
                switch ($receiver->getMessage()) {
                    case "1":
                        $operations->session_menu="eList1";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["eList1"],$address );
                        break;
                    case "2":
                        $operations->session_menu="eList2";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["eList2"],$address );
                        break;
                    case "3":
                        $operations->session_menu="eList3";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["eList3"],$address );
                        break;
                    case "4":
                        $operations->session_menu="eList4";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["eList4"],$address );
                        break;
                    case "5":
                        $operations->session_menu="eList5";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["eList5"],$address );
                        break;
                    case "6":
                        $operations->session_menu="eList6";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId,$responseMsg["eList6"],$address );
                        break;
                    default:
                        $operations->session_menu="english";
                        $operations->saveSesssion($db);
                        $sender->ussd($sessionId, $responseMsg["amharic"],$address );
                        break;
                }
                break;
			case "ivr":
				$sender->ussd($sessionId,'You Purchased a large T-Shirt Your ID '.$receiver->getMessage(),$address ,'mt-fin');
				break;
			default:
				$operations->session_menu="main";
				$operations->saveSesssion($db);
				$sender->ussd($sessionId,'Incorrect option',$address );
				break;
		}
	
}