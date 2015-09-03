Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    console.log(local.toJSON().slice(0,16));
    return local.toJSON().slice(0,16);
});

// Add method to remove object from array based on unit title
Array.prototype.remove = function(title) {
    for (i=0; i<this.length; i++) {
    	console.log(this[i].title);
      if (this[i].title === title) this.splice(i,1);
    }
    return this;
};

var myApp = angular.module('myApp', []);

myApp.controller('mainController', ['$scope','$filter','$log','$timeout', function($scope,$filter,$log,$timeout) {

  // Needed to prevent 'Life Hours' being calculated and entered into array more than once
	$scope.percentWorking =0;
	var initialised=0;

	// Set up array of money unit objects
    function moneyUnit (title,pounds) {
    	this.title = title;
    	this.pounds = pounds;
    }

    $scope.moneyUnits =[];
    $scope.moneyUnits.push(new moneyUnit("£ GBP",1));
    $scope.moneyUnits.push(new moneyUnit("Jerk Island Lunch Special",3));
    $scope.moneyUnits.push(new moneyUnit("Playstation 4",300));
    $scope.moneyUnits.push(new moneyUnit("London Studio Flat",300000));


    // Set up array of time unit objects
    function timeUnit (title,hours) {
    	this.title = title;
    	this.hours = hours;
    }

    $scope.timeUnits =[];
    $scope.timeUnits.push(new timeUnit("Hours",1));
    $scope.timeUnits.push(new timeUnit("Days",24));
    $scope.timeUnits.push(new timeUnit("Weeks",24*7));
    $scope.timeUnits.push(new timeUnit("Months",24*30));
    $scope.timeUnits.push(new timeUnit("Years",24*365));
    $scope.timeUnits.push(new timeUnit("Wank (average male)",0.4));
    $scope.timeUnits.push(new timeUnit("London - Bristol Coach Trip",3));
    $scope.timeUnits.push(new timeUnit("Atlantic Crossing by Pedalo",2664));


    $scope.customMoneyAdd = function() {
    	$scope.moneyUnits.push(new moneyUnit($scope.customMoneyTitle,$scope.customMoneyPounds));
    }

    $scope.customTimeAdd = function() {
    	$scope.timeUnits.push(new timeUnit($scope.customMoneyTitle,$scope.customMoneyPounds));
    }

    $scope.removeMoneyUnit = function(unit) {
    	$scope.moneyUnits.remove(unit);
    }

    $scope.removeTimeUnit = function(unit) {
    	console.log("remove time");
    	$scope.timeUnits.remove(unit);
    }

    $scope.sortTimeBy = function (what) {
    	if (what === "Hours") {
    		$scope.timeUnits.sort(function(a,b) {return a.hours - b.hours});
    	}
    	else {
    		$scope.timeUnits.sort(function(a,b) {return a.title > b.title});
    	}
    }

    $scope.sortMoneyBy = function (what) {
    	if (what === "Pounds") {
    		$scope.moneyUnits.sort(function(a,b) {return a.pounds - b.pounds});
    	}
    	else {
    		$scope.moneyUnits.sort(function(a,b) {return a.title > b.title});
    	}
    }

    $scope.calculatePay = function() {
    	
    	// Convert yearly pay to daily
    	$scope.payPerDay = $scope.pay / 365;

    	// Convert daily to hourly
	    $scope.payPerHour = $scope.payPerDay / 24;

	    // Convert hourly to true hourly rate of pay
	    $scope.truePayPerHour = $scope.payPerHour/$scope.workPerHour;

	    // If we have all information calculate 'Life Hour' units and push to array
	    /*
	    if ($scope.percentWorking != 0 && initialised==0) {
		    $scope.timeUnits.push(new timeUnit("Life Hours",1*($scope.percentWorking/100)));
		    $scope.timeUnits.push(new timeUnit("Life Days",24*($scope.percentWorking/100)));
		    $scope.timeUnits.push(new timeUnit("Life Weeks",24*7*($scope.percentWorking/100)));
		    $scope.timeUnits.push(new timeUnit("Life Months",24*30*($scope.percentWorking/100)));
		    $scope.timeUnits.push(new timeUnit("Life Years",24*365*($scope.percentWorking/100)));
    		initialised =1;
    	}
    	*/
    }

    $scope.calculateHours = function() {   	
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
  		$scope.outVal = numberFormatter(outVal);
  	}


  	function numberFormatter(inVal) {

  		function toSignificantFigures(inVal,sf) {

 			var fracPart, chopPoint=0;
  			inVal = inVal.toString();

  			for (i=0; i<inVal.length; i++) {
  				if (fracPart === 1 && chopPoint === 0) {
  					if (inVal.charAt(i) != 0) {
  						chopPoint = i+sf;
  						break;
  					}
  				}
  				else if (inVal.charAt(i) === ".") fracPart = 1;	
  			}
  			return inVal.substr(0,chopPoint);
  		}

  		var test, outVal;

  		// If NaN i.e no out unit defined
  		if (isNaN(parseFloat(inVal))) {
  			outVal = 0;
  		}

  		// If zero display zero
  		else if (inVal === 0) {
  			outVal = 0;
  		}

  		// If greater than one..
  		else if (inVal>=1) {
  			test = inVal % inVal.toFixed(0);
          	if (test === 0) {
            	outVal = inVal.toFixed(0);
          	}
			else {
				outVal = toSignificantFigures(inVal,2);
			}	
		}

  		else {
	  		// Less than 1 display as percentage
	  		inVal *= 100;
			test = inVal % inVal.toFixed(0);
			if (test === 0) {
				$log.log("Round number percentage < 1 ");
				outVal = inVal.toFixed(0)+"%";
			}
			else {
				$log.log("Fracional percentage < 1");
				outVal = toSignificantFigures(inVal,2)+"%";
			}
  		}
  		return outVal;
  	}
    

    function counterUpper (type,name,start,unit) {
    	this.name = name;
    	this.type = type;
    	this.startTime = start || Date.now();
    	this.unit = unit;
    	this.elapsedSeconds = 0;
    	this.elapsedUnits = 0;

    	this.secondsSinceStart = function () {
    		this.elapsedSeconds = Date.now() - this.startTime;
  		}
  		this.unitsSinceStart = function () {
  			
  		}
    }

}]);
