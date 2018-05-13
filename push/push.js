alert('暂未提供完全验证');
var form = document.getElementsByTagName("form")[0];
var el = document.createElement("span");
var elt = document.createTextNode("");
el.appendChild(elt);
form.appendChild(el);

angular.module('main', [])
.controller('pushCtrl', function($scope, $http){
	$scope.userMsg = '';
	$scope.idMsg = '';
	window.onkeyup = function(e){
		if(e.keyCode === 13){
			$scope.check();
		}
	};
	$scope.check = function(){
		$(".spinner").css('display', 'block');
		var userv = $("#user").val();
		var idv = $("#id").val();
		var telv = $("#tel").val();
		var d = {action:'checkid',user: userv, id: idv, tel: telv};
		$.ajax({
			url: 'push_auth.php',
			type: 'POST',
			data: d,
			success(response){
				el.innerText = response.msg;
				$(".spinner").css('display', 'none');
				$("#user").next().next().text(response.user);
				$("#id").next().next().text(response.id);
				$("#tel").next().next().text(response.tel);
				if(response.msg === "success"){
					alert("登记成功,请等待工作人员验证");
				}else if(response.msg){
					alert("登记失败,请确认信息真实性");
				}
			},
			error(jqXHR, status, errThrown){
				console.log([jqXHR, status, errThrown]);
			}
		});
	};
});
