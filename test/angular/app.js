var myApp = angular.module('myApp', []);

myApp.controller('mainController', ['$scope','$filter','$log','$timeout', function($scope,$filter,$log,$timeout) {

    $scope.handle="";

    $scope.lowercase = function () {
    	return $filter('lowercase')($scope.handle);
    };

    $scope.characters = 5;
    
    var updatesrequest = new XMLHttpRequest();
    var url = "/updates.php";

	updatesrequest.open("POST", url, true);
	updatesrequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	
    updatesrequest.onreadystatechange = function () {
    	$scope.$apply(function() {

	    	if (updatesrequest.readyState == 4 && updatesrequest.status ==200) {
	    		$scope.updates = JSON.parse(updatesrequest.responseText);
	    	}
	    	else $log.log("Failed");

	    	$log.log($scope.updates);
	    })
    }

	updatesrequest.send("get=recent");
    
}]);
