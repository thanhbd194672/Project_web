<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	 <script src="../admin/1.js" defer></script>
</head>
<body ng-app="myApp" ng-controller="MyController">
	<div class="card" ng-show="hienthi">
		<b>sadasdasasdasdas</b>
		<button ng-click="doigiatri()">sửa</button>
	</div>
	<div class="card" ng-show="!hienthi">
		<input type="text" value="dsadsadasasdsadsa">
		<button ng-click="doigiatri()">sửa</button>
	</div>
</body>
</html>