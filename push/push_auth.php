<?php
	header('Expires:Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control:no-cache');
	header('Pragma:no-cache');
	header('Content-Type:application/json');
	if(empty($_SERVER['HTTP_REFERER'])){
		die();
	}
	function input($d){
		return htmlspecialchars(stripslashes(trim($d)));
	}
	
/*function unicode_encode($str, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
    $str = iconv($encoding, 'UCS-2', $str);
    $arrstr = str_split($str, 2);
    $unistr = '';
    for($i = 0, $len = count($arrstr); $i < $len; $i++) {
        $dec = bin2hex($arrstr[$i]);
        $unistr .= $prefix . $dec . $postfix;
    } 
    return $unistr;
}*/

	if(input($_POST['action']) == 'checkid'){
		$user = $id = '';
		$userMsg = $idMsg = $telMsg = $msg = '';
		if(empty($_POST['user'])){
			$userMsg = '必填项';
		}else{
			$user = input($_POST['user']);
			if(preg_match("/^[\x{4e00}-\x{9fa5}]{2,4}$/u", $user)){
				$userMsg = '';
			}else{
				$userMsg = '2-4个汉字';
			}
		}
		if(empty($_POST['id'])){
			$idMsg = '必填项';
		}else{
			$id = input($_POST['id']);
			if(preg_match("/[0-9]{17}[0-9xX]/", $id)){
				$idMsg = '';
			}else{
				$idMsg = '请输入18位中国地区身份证';
			}
		}
		if(empty($_POST['tel'])){
			$telMsg = '必填项';
		}else{
			$tel = input($_POST['tel']);
			if(preg_match("/^[0-9]{5,20}$/", $tel)){
				$telMsg = '';
			}else{
				$telMsg = '5-20位数字';
			}
		}
		if($userMsg == '' && $idMsg == '' && $telMsg == ''){
			$msg = 'success';
		}else{
			$msg = 'faild';
		}
		echo json_encode(array('msg'=>'暂未提供验证', 'user'=>$userMsg, 'id'=>$idMsg, 'tel'=>$telMsg));
	}
?>
