<?php
/*
 * Created on Dec 12, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class sms{
	var $user;
	var $pass;
	var $sender;
	var $url;
	var $local;
        var $CI;
	function sms(){
//		parent::Model();
            $this->CI= get_instance();
		$this->CI->load->library('curl');
                $c=new xConfig('sms_config');
		$this->user=$c->getkey('SMSUser');
		$this->pass=$c->getkey('SMSPassword');
		$this->sender = $c->getkey('SENDERID');
		$this->url="http://admin.sammrat.com/messageapi.asp?username=drgmt&password=22140938&sender=DRGMT&mobile=9783807100&message=Hello";
		$this->sendSMS=$c->getkey('SendSMS');
	}
	
	function getCredits(){
		$url="http://admin.sammrat.com/balanceapi.asp?username=".$this->user."&password=". $this->pass;
		return $this->CI->curl->simple_get($url);
	}
	
	function newjoiningsms($no,$id,$pass,$NoOfIDs=1){
		$no=substr(trim($no),-10);
		if(strlen($no) != 10 ) return;
		if($NoOfIDs > 1 ) 
			$idmsg= "from " . $id . " to " . ($id+$NoOfIDs);
		else
			$idmsg = $id;
		$q=urlencode("Welcome to Family Future. You are now our esteemed Member. Your id is $idmsg and password is $pass :: familyfuturebusiness.in");
		$url="http://admin.sammrat.com/messageapi.asp?username=".$this->user."&password=".$this->pass."&sender=".$this->sender."&mobile=$no&message=$q";
		if(!$this->sendSMS)
			echo $url . "<br>";
		else
			return $this->CI->curl->simple_get($url);
	}
	
	function sendsms($no,$q){
		$q=urlencode($q);
		$url="http://admin.sammrat.com/messageapi.asp?username=".$this->user."&password=".$this->pass."&sender=".$this->sender."&mobile=$no&message=$q";
		if(!$this->sendSMS)
			echo $url . "<br>";
		else
			return $this->CI->curl->simple_get($url);
	}
	
	function sendtoall($msg){
		$this->db->where('MobileNo !=' ,'');
		$q=urlencode($msg);
		$result=$this->db->get('personaldetails');
		foreach($result->result() as $res){
			$no=substr(trim($res->MobileNo),-10);
			if(strlen($no) == 10)
			{
				$url="http://admin.sammrat.com/messageapi.asp?username=".$this->user."&password=".$this->pass."&sender=".$this->sender."&mobile=$no&message=$q";
				if(!$this->sendSMS)
					echo $url . "<br>";
				else
					return $this->CI->curl->simple_get($url);
			}
		}
	}

}
?>
