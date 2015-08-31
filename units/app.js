var myApp = angular.module('myApp', []);

myApp.controller('mainController', ['$scope','$filter','$log','$timeout', function($scope,$filter,$log,$timeout) {

    function Unit (title,pounds) {
    	this.title = title;
    	this.pounds = pounds;
    }

    var jerk = new Unit ("Lunch special at Jerk Island",3);
    var ps4 = new Unit ("Playstation 4",300);

    $scope.moneyUnits = [jerk,ps4];

    $scope.customMoneyAdd = function() {
    	$log.log("clicked");
    	$scope.moneyUnits.push(new Unit($scope.customMoneyTitle,$scope.customMoneyPounds));
    }

    $scope.removeUnit = function() {
    	$log.log("clicked");
    }

    $scope.calculatePay = function() {
    	var divideBy = 0;

    	if ($scope.payPer === "/hour") {
    		$scope.payPerHour = $scope.pay
    	}

    	else {

	    	if ($scope.payPer === "/day") {
	    		divideBy = 24;
	    	}

	    	if ($scope.payPer === "/week") {
	    		divideBy = 24*7;
	    	}

	    	if ($scope.payPer === "/month") {
	    		divideBy = 24*7*30;
	    	}

	    	if ($scope.payPer === "/year") {
	    		divideBy = 24*7*365;
	    	}

	    	$scope.payPerHour = ($scope.pay/divideBy).toFixed(2);
	    	$scope.truePayPerHour = $scope.payPerHour*$scope.percentWorking;
    	}
    }

    $scope.calculateHours = function() {
    	var divideBy = 0;
    	
    	if ($scope.hoursPer === "/day") {
    		$scope.hoursPerDay = $scope.hours;
    	}
    	else {
	    	if ($scope.hoursPer === "/week") {
	    		divideBy = 7;
	    	}
	    	if ($scope.hoursPer === "/month") {
	    		divideBy = 7*30;
	    	}

	    	$scope.hoursPerDay = ($scope.hours/divideBy).toFixed(2);
    	}
    	
    	$scope.percentWorking = (($scope.hoursPerDay/24)*100).toFixed(2);

    	$scope.yearsRemaining = 79.2-$scope.age;
    	$scope.workYearsRemaining = ((65-$scope.age)*$scope.percentWorking).toFixed(2);
  	}
    
}]);
