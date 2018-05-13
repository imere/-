var form = document.getElementsByTagName("form")[0],
user = document.getElementById("user"),
pass = document.getElementById("pass"),
email = document.getElementById("email");
login = document.getElementById("login");
var el = document.createElement("span");
var elt = document.createTextNode("");
el.appendChild(elt);
form.appendChild(el);

angular.module('main', [])
.controller('loginCtrl', function($scope, $http){
	window.onkeyup = function(e){
		if(e.keyCode === 13){
			$scope.auth();
		}
	};
	$scope.auth = function(){
		$(".spinner").css({'display':'block'});
		var userv = encodeURIComponent(user.value);
		var passv = encodeURIComponent(pass.value);
		var emailv = encodeURI(email.value);
		var d = {action:'logreg',user: userv, pass: passv, email: emailv};
		$http({
			method:'POST',
			url:'login.php',
			headers: {"Content-Type":"application/x-www-form-urlencoded"},
			data: d,
			transformRequest: function(data){
				return $.param(data);
			}
		})
		.then(function success(response){
			$(".spinner").css({'display':'none'});
			el.innerText = response.data.msg;
			$("#user").next().next().text(response.data.user);
			$("#pass").next().next().text(response.data.pass);
			$("#email").next().next().text(response.data.email);
			if(response.data.msg === '登录成功'){
				window.location.href = '/';
			}else if(response.data.msg === '注册成功'){
				alert("请于6小时内激活邮件,否则账号无效");
				window.location.href = '/';
			}
		},function error(response){
			console.log(response);
		});
	};
});
