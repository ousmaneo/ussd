<?php

class Operations
{
	
	public $session_id='';
	public $session_menu='';
	public $session_pg=0;
	public $session_tel='';
	public $session_others='';

	public function setSessions($sessions,$db){

		$sql_sessions=mysqli_prepare($db,'INSERT INTO sessions (sessionsid, tel, menu, pg, created_at,others) VALUES (?,?,?,?,?,?)');
        $sessionid = $sessions['sessionid'];
        $tel = $sessions['tel'];
        $menu = $sessions['menu'];
        $pg = $sessions['pg'];
        $date = CURRENT_TIMESTAMP;
        $others = $sessions['others'];
        mysqli_stmt_bind_param($sql_sessions,"ssssds" ,$sessionid ,$tel, $menu,$pg,$date,$others);
		$quy_sessions=mysqli_stmt_execute($sql_sessions);

	}

	public function getSession($sessionid,$db){

		$sql_session="SELECT *  FROM  sessions WHERE  sessionsid='". $sessionid."'";
		$quy_sessions=mysqli_query($db,$sql_session);
		$fet_sessions=mysqli_fetch_array($quy_sessions);
		$this->session_others=$fet_sessions['others'];
		return $fet_sessions;	
	}


	public function saveSesssion($db)
	{
		$sql_session="UPDATE  sessions SET
									menu =  '".$this->session_menu."',
									pg =  '".$this->session_pg."',
									others =  '".$this->session_others."'
									WHERE sessionsid =  '".$this->session_id."'";
		$quy_sessions=mysqli_query($db,$sql_session);
	}



}

?>