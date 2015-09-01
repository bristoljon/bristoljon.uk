var myApp = angular.module('myApp', []);

myApp.controller('mainController', ['$scope','$filter','$log','$timeout', function($scope,$filter,$log,$timeout) {

    function moneyUnit (title,pounds) {
    	this.title = title;
    	this.pounds = pounds;
    }

    var quid = new moneyUnit ("£ GBP",1);
    var ps4 = new moneyUnit ("Playstation 4",300);

    $scope.moneyUnits = [quid,ps4];

    function timeUnit (title,hours) {
    	this.title = title;
    	this.hours = hours;
    }

    var hour = new timeUnit ("Hours",1);
    var day = new timeUnit ("Days",24);
    var week = new timeUnit ("Weeks",24*7);
    var month = new timeUnit ("Months",24*30);
    var year = new timeUnit ("Years",24*365);

    var wank = new timeUnit ("Tommy Tank (average male)",0.4);
    var coach = new timeUnit ("Bristol - London Coach",3);

    $scope.timeUnits = [hour,day,week,month,year,wank,coach];

    $scope.customMoneyAdd = function() {
    	$scope.moneyUnits.push(new moneyUnit($scope.customMoneyTitle,$scope.customMoneyPounds));
    }

    $scope.removeUnit = function() {
    	$log.log("clicked");
    }

    $scope.calculatePay = function() {
    	
    	// Convert yearly pay to daily
    	$scope.payPerDay = $scope.pay / 365;

    	// Convert daily to hourly
	    $scope.payPerHour = $scope.payPerDay / 24;

	    // Convert hourly to true hourly rate of pay
	    $scope.truePayPerHour = $scope.payPerHour/$scope.workPerHour;
    	
    }

    $scope.calculateHours = function() {
    	
    	// Convert weekly to daily then hourly
	    $scope.workPerHour = ($scope.hours/7)/24;

	    $scope.workPerDay = $scope.workPerHour * 24;
    	
    	$scope.percentWorking = ($scope.workPerHour/1)*100;

    	$scope.yearsRemaining = 79.2-$scope.age;

    	$scope.workYearsRemaining = (65-$scope.age)*($scope.percentWorking/100);
  	}

  	$scope.convertUnits = function () {

  		var outVal = 0;

  		// Get input units (is there an easier way?)
  		for (unit in $scope.moneyUnits) {

  			if ($scope.moneyUnits[unit].title === $scope.inUnits) {
  				var inType = "Money";
  				var inPounds = $scope.moneyUnits[unit].pounds;
  			}
  		}
  		for (unit in $scope.timeUnits) {
  			if ($scope.timeUnits[unit].title === $scope.inUnits) {
  				var inType = "Time";
  				var inHours = $scope.timeUnits[unit].hours;
  			}
  		}

  		// Get output units
  		for (unit in $scope.moneyUnits) {
  			if ($scope.moneyUnits[unit].title === $scope.outUnits) {
  				var outType = "Money";
  				var outPounds = $scope.moneyUnits[unit].pounds;
  			}
  		}
  		for (unit in $scope.timeUnits) {
  			if ($scope.timeUnits[unit].title === $scope.outUnits) {
  				var outType = "Time";
  				var outHours = $scope.timeUnits[unit].hours;
  			}
  		}

  			
  		// Convert Time to Time and Money
  		if (inType === "Time") {
  			if (outType === "Time") {
  				outVal = ($scope.inVal * inHours) / outHours;
  			}
  			if (outType === "Money") {
  				outVal = (($scope.inVal * inHours) * $scope.truePayPerHour)/outPounds;
  			}
  		}

  		if (inType === "Money") {
  			if (outType === "Money") {
  				outVal = ($scope.inVal * inPounds) / outPounds;
  			}
  			if (outType === "Time") {
  				outVal = (($scope.inVal * inPounds) / $scope.truePayPerHour)*outHours;
  			}
  		}
  		console.log(outVal);
  		$scope.outVal = outVal.toFixed(2);

  		
  	}
    
}]);
