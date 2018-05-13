var ctx = document.getElementsByClassName("canvas");
var ctx1 = ctx[0].getContext('2d');
var ctx2 = ctx[1].getContext('2d');
var path=new Path2D();
path.arc(75, 75, 50, 0, Math.PI*2, true);
path.moveTo(110,75);
path.arc(75, 75, 35, 0, Math.PI, false);
path.moveTo(65, 65);
path.arc(60, 65, 5, 0, Math.PI*2, true);
path.moveTo(95, 65);
path.arc(90, 65, 5, 0, Math.PI*2, true);
ctx1.strokeStyle = '#0b346e';
ctx1.stroke(path);
ctx2.stroke(path);
$('.children').on('mouseenter mouseleave', function(){
	$(this).toggleClass('hover');
});

var app = angular.module('page', []);
app.controller('ctrl', function($scope){
  $scope.reset = function(){
	$scope.ssite = "";
	$scope.sitem = "";
  };

  $scope.search = function(){
	document.getElementById($scope.type.value).value;
  };

  $scope.searchType = [{
	name: "网站",
	value: "ssite"
  },{
	name: "本页",
	value: "sitem"
  }];
  $scope.type = $scope.searchType[0];

  $scope.switch = -1;
  $scope.setSwitch = function(val){
    $scope.switch = val;
  };
  $scope.getSwitch = function(){
    return $scope.switch;
  };
  $scope.logout = function(){
	var d = {action: 'logout'};
  	$.ajax({
		url: 'login/login.php',
		type: 'POST',
		contentType: 'application/x-www-form-urlencoded',
		data: d,
		success(response){
			window.location.reload();
		},
		error(jqXHR, status, errThrown){
			console.log(jqXHR);
			console.log(status);
			console.log(errThrown);
		}
	});
  };
});

app.controller('full', function($scope){
  $scope.full = [{
    title: '热门工作',
    items: [{
      title: '销售',
      action: ''
    }, {
      title: '技工/普工',
      action: ''
    }, {
      title: '餐饮',
      action: ''
    }, {
      title: '营业员/导购',
      action: ''
    }, {
      title: '司机',
      action: ''
    }, {
      title: '人事/行政',
      action: ''
    }, {
      title: '物流/仓储',
      action: ''
    }, {
      title: '淘宝职位',
      action: ''
    }, {
      title: '保洁/安保',
      action: ''
    }, {
      title: '美容/美发',
      action: ''
    }, {
      title: '客服',
      action: ''
    }, {
      title: '房产中介',
      action: ''
    }]
  }];
});

app.controller('part', function($scope){
  $scope.part = [{
    title: '热门兼职',
    items: [{
      title: '促销导购',
      action: ''
    }, {
      title: '传单派发',
      action: ''
    }, {
      title: '问卷调查',
      action: ''
    }, {
      title: '服务员',
      action: ''
    }, {
      title: '家教',
      action: ''
    }]
  }, {
    title: '教育艺术',
    items: [{
      title: '健身教练',
      action: ''
    }, {
      title: '艺术老师',
      action: ''
    }, {
      title: '摄影摄像',
      action: ''
    }, {
      title: '化妆师',
      action: ''
    }, {
      title: '司仪演出',
      action: ''
    }, {
      title: '翻译',
      action: ''
    }, {
      title: '律师',
      action: ''
    }]
  }, {
    title: 'IT设计',
    items: [{
      title: '网站建设',
      action: ''
    }, {
      title: '美工设计',
      action: ''
    }, {
      title: '视频制作',
      action: ''
    }, {
      title: '软件开发',
      action: ''
    }, {
      title: '网络维护',
      action: ''
    }, {
      title: '网络营销',
      action: ''
    }]
  }];
});
$(".spinner").css('display', 'none');
