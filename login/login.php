<?php
	header('Expires:Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control:no-cache');
	header('Pragma:no-cache');
	header('Content-Type:application/json');

	//mysql
	$dbname = "";
	$dbuser = "";
	$dbpass = "";
	//domain name or ip
	$host = ""

	if(empty($_SERVER['HTTP_REFERER'])){
		die('error');
	}
	function input($d){
		return htmlspecialchars(stripslashes(trim($d)));
	}

	if(input($_POST['action']) == 'logout'){
		foreach($_COOKIE as $k=>$v){
			setcookie($k, '', time()-86400, '/');
		}
		echo json_encode(array('msg'=>'logout'));
	}elseif(input($_POST['action']) == 'logreg'){
		$user = $pass = $email = '';
		$userMsg = $passMsg = $emailMsg = $msg = '';
		if(empty(input($_POST['user']))){
			$userMsg = '5-11位字母开头且只包含字母数字';
		}else{
			$user = input($_POST['user']);
			if(preg_match("/^\b[a-zA-Z][a-zA-Z0-9]{4,10}$/", $user)){
				$userMsg = '';
			}else{
				$userMsg = '5-11位字母开头且只包含字母数字';
			}
		}
		if(empty(input($_POST['pass']))){
			$passMsg = '6-16位且只包含字母数字';
		}else{
			$pass = input($_POST['pass']);
			if(preg_match("/\w{6,16}/", $pass)){
				$passMsg = '';
			}else{
				$passMsg = '6-16位且只包含字母数字';
			}
		}
                if(empty(input($_POST['email']))){
			if($userMsg == '' && $passMsg == ''){
				try{
                                	$conn = new PDO("mysql:host=localhost; dbname=" + dbname, dbuser, dbpass);
                        	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$stmt = $conn->prepare("select user from testtable where user=:user and password=PASSWORD(:pass)");
					$stmt->bindParam(':user', $user);
					$stmt->bindParam(':pass', $pass);
					$stmt->execute();
					if($stmt->fetchAll(PDO::FETCH_ASSOC)){
						$msg = '登录成功';
						setcookie('user', $user, time()+43200, '/');
					}else{
						$msg = '用户或密码不正确';
					}
                                }catch(PDOException $e){
                                        $conn->rollback();
					$msg = 'error';
                                }
				$conn = null;
			}else{
				
			}
		}else{
			$email = input($_POST['email']);
			if(preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)){
				$emailMsg = '';
				if($userMsg == '' && $passMsg == ''){
					try{
						$conn = new PDO("mysql:host=localhost; dbname=" + dbname, dbuser, dbpass);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$conn->exec("delete from testtable where valid=0 and '".date("Y-m-d H:i:s",time()-60*60*6)."' >= token_exp");
						$stmt = $conn->prepare("select count(user) from testtable where user=:user or email!=:email");
						$stmt->bindParam(':user', $user);
						$stmt->bindParam(':email', $email);
						$stmt->execute();
						$res = $stmt->fetchAll(PDO::FETCH_OBJ);
						if(0 == count($res)){
							$stmt = $conn->prepare("insert into testtable (user, password, ip, createtime, email, token, token_exp) values (?,password(?),?,?,?,?,?)");
							$time = date("Y-m-d H-i-s", time());
							$token = md5($user.$pass.time());
							$token_exp = date("Y-m-d H-i-s", time()+60*60*6);
                					$stmt->execute(array($user, $pass, $_SERVER['REMOTE_ADDR'].':'.$_SERVER['REMOTE_PORT'], $time, $email, $token, $token_exp));

require_once "Smtp.class.php";
    $smtpemailto = $email;

    $mailtitle = "网络优选平台邮件验证";

    $mailcontent = "亲爱的".$user."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='" + host  + "/login/active.php?verify=".$token."' target='_blank'>" + host  + "/login/active.php?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接6小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'></p>";

    $smtpserver = "ssl://smtp.qq.com"; //SMTP服务器

    $smtpserverport = 465; //SMTP服务器端口

    $smtpusermail = ""; //SMTP服务器的用户邮箱

    $smtpuser = ""; //SMTP服务器的用户帐号

    $smtppass = ""; //SMTP服务器的用户密码

    //创建$smtp对象 这里面的一个true是表示使用身份验证,否则不使用身份验证.

    $mailtype = "HTML";

    $smtp = new Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); 

    $smtp->debug = false; 

    // sendmail方法

    // 参数1是收件人邮箱

    // 参数2是发件人邮箱

    // 参数3是主题（标题）

    // 参数4是邮件主题（标题）

    // 参数4是邮件内容  参数是内容类型文本:text 网页:HTML

    $rs = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);

    if($rs){

$msg = '注册成功';

}else{

$msg = "注册失败";

}
						}else{
							$msg = '用户已存在';
						}
					}catch(PDOException $e){
						$conn->rollback();
						$msg = 'error';
					}
					$conn = null;
				}
			}else{
				$emailMsg = '格式不正确';
			}
		}
		echo json_encode(array('msg'=>$msg, 'user'=>$userMsg, 'pass'=>$passMsg, 'email'=>$emailMsg));
	}
	
?>
