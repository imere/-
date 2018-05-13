<?php
	header('Cache-Control:no-cache');
	header('Pragma:no-cache');
	header('Content-Type:application/json');

	//mysql
	$dbname = "";
	$dbuser = "";
	$dbpass = "";

	if(empty(htmlspecialchars(stripslashes(trim($_GET['verify']))))){
		die();
	}
	function input($v){
		return htmlspecialchars(stripslashes(trim($v)));
	}
	$msg = '';
	$verify = input($_GET['verify']);
	try{
		$con = new PDO("mysql:host=127.0.0.1; dbname=" + dbname, dbuser, dbpass);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "select id, token_exp from testtable where valid=0 and token='$verify'";
		$stmt = $con->query($sql);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($res){

			if(date("Y-m-d H-i-s", time()-60*60*6)>$res[0]['token_exp']){

				$msg = '激活有效期已过，请重新注册账号.';

			}else{

				$c = $con->exec("update testtable set valid=1 where id=".$res[0]['id']);

				if($c!=1) die(0);

				$msg = '激活成功';

			}

		}else{

			die('error');

		}
	}catch(PDOException $e){
		$msg = '';
	}
	echo $msg;
?>
