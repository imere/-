<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="keywords" content="兼职">
  <meta name="viewport" content="width=device-width">
  <title>网络优选平台</title>
  <link rel="stylesheet" href="css/style.css">
  <script src='src/jquery-3.3.1.min.js'></script>
  <script src='https://cdn.bootcss.com/angular.js/1.6.9/angular.min.js'></script>
</head>

<body>
  <div class="wrapper" ng-app="page" ng-controller="ctrl">
  <div class="search-field fixed">
	<select ng-model="type" ng-options="v.name for v in searchType" ng-change="reset()"></select>
	<input id="ssite" type="text" ng-show="type.value=='ssite'" ng-model="ssite" placeholder="{{'搜'+type.name}}">
	<input id="sitem" type="text" ng-show="type.value=='sitem'" ng-model="sitem" placeholder="{{'搜'+type.name}}">
	<button id="search" value="search" ng-show="type.value!=='sitem'" ng-click="search()">搜索</button>
  </div>
  <div class="header">
	<div class="push-field">
		<a href="push/push.html" target="_blank">我要发布</a>
	</div>
	<div class="log-field">
		<?php if($_COOKIE['user']){
			echo "<div class='logged children'>
				<div><a href=''>$_COOKIE[user]</a></div>
				<div><a href='' ng-click='logout()'>退出登录</a></div>
				</div>";
		}else{
			echo '<a href="login/login.html">登录/注册</a>';
		}
		?>
	</div>
  </div>

	<div style="width:100%;text-align:center;background-color:white;font-size:2rem">{{w['请尝试刷新或在浏览器内打开']}}</div>

  <div class="main">
    <div class="main-top">
      <ul>
        <li class="main-left-top" ng-click="setSwitch(0)" ng-class="{active: switch==0}">
          <canvas class="canvas" width="150" height="150"></canvas>
          <div>
            <span>全职</span>
          </div>
        </li>
        <li class="main-right-top" ng-click="setSwitch(1)" ng-class="{active: switch==1}">
          <canvas class="canvas" width="150" height="150"></canvas>
          <div>
            <span>兼职</span>
          </div>
        </li>
      </ul>
    </div>

    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div> 

    <div class="main-content">
      <div class="full-time active" ng-if="switch===0" ng-controller="full">
        <div ng-repeat="v0 in full">
          <div class="title">{{v0.title}}</div>
          <ul>
            <li class="block" ng-repeat="item in v0.items | filter: sitem">
              <a href="{{item.action}}">{{item.title}}</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="part-time active" ng-if="switch===1" ng-controller="part">
        <div ng-repeat="v1 in part">
          <div class="title">{{v1.title}}</div>
          <ul>
            <li class="block" ng-repeat="item in v1.items | filter: sitem">
              <a href="{{item.action}}">{{item.title}}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<footer>
</footer>
</div>
<script async src="js/index.js?<?php echo rand()?>"></script>
</body>

</html>
