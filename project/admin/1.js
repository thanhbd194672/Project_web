var app =angular.module('myApp', ['ngMaterial']);
app.controller('MyController', function($scope) {
	$scope.hienthi = true;
	$scope.doigiatri = function() {
		$scope.hienthi = !$scope.hienthi;
	}
})