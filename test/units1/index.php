<?php

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include($root."/login.php");

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Unit Converter</title>

    <?php include($root."/head.html"); ?>

<style type="text/css">

html {
  background: radial-gradient(circle, #FFFF00 40%, #FFA500);
  background-size: cover;
  background-repeat: no-repeat;
}

.content {
  margin-top: 70px;
}

</style>
    
</head>

<body>

<?php include($root."/header.html"); ?>

<div class="container">
  <h2>Alternative Unit Converter</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#you">Details</a></li>
    <li><a data-toggle="tab" href="#units">Units</a></li>
    <li><a data-toggle="tab" href="#convert">Convert</a></li>
    <li><a data-toggle="tab" href="#count">Counter</a></li>
  </ul>

  <div class="tab-content">
    <div id="you" class="tab-pane fade in active">
      <h3>You</h3>
      <div id="age" class="form-group">
        <label for="age">How old are you?</label>
        <input name="age" type="text" class="form-control">
      </div>


      <h3>Work</h3>

      <div class="form-group">
        <label for="pay">How much do you get paid?</label>
        <div class="input-group">
          <input id="pay" name="pay" type="text" class="form-control">
          <span class="input-group-btn">
            <select class="btn">
              <option>/hour</option>
              <option>/day</option>
              <option>/week</option>
              <option>/month</option>
            </select>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label for="hours">How many hours do you work?</label>
        <div class="input-group">
          <input id="hours" name="hours" type="text" class="form-control">
          <span class="input-group-btn">
            <select class="btn">
              <option>/day</option>
              <option>/week</option>
              <option>/month</option>
            </select>
          </span>
        </div>
      </div>


      <h3>Save</h3>
      <div class="form-group">
        <label for="save">How much do you save?</label>
        <div class="input-group">
          <input id="save" name="save" type="text" class="form-control">
          <span class="input-group-btn">
            <select class="btn">
              <option>/day</option>
              <option>/week</option>
              <option>/month</option>
            </select>
          </span>
        </div>
        <div class="form-group">
          <label for="saved">How much have you saved already?</label>
          <input id="saved" name="saved" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label for="saveFor">What are you saving for?</label>
          <input id="saveFor" name="saveFor" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label for="saveForCost">How much does it/he/she/they cost?</label>
          <input id="saveForCost" name="saveForCost" type="text" class="form-control">
        </div>
      </div>

    </div>

    <div id="units" class="tab-pane fade">
      <h3>Money</h3>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Unit</th>
            <th>Cost</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Lunch Special at Jerk Island</td>
            <td>£3</td>
          </tr>
          <tr>
            <td>Playstation 4</td>
            <td>£300</td>
          </tr>
          <tr>
            <td>Central London Studio</td>
            <td>£300,000</td>
          </tr>
        </tbody>
      </table>

      <h3>Time</h3>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Unit</th>
            <th>Hours</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Tommy Tank (average male)</td>
            <td>0.4</td>
          </tr>
          <tr>
            <td>Bristol - London by bus</td>
            <td>3</td>
          </tr>
          <tr>
            <td>Crossing the Atlantic by pedalo</td>
            <td>2664</td>
          </tr>
        </tbody>
      </table>
      
    </div>
    <div id="convert" class="tab-pane fade">
      <br/>
      <div class="row">

        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputVal">Value</label>
            <input id="inputVal" name="inputVal" type="text" class="form-control">
          </div> 
        </div>  

        <div class="col-xs-6">
          <div class="form-group">
            <label for="inUnits">Units</label>
            <select class="form-control" id="inUnits">
              <option>£ GBP</option>
              <option>Hours</option>
            </select>
          </div>
        </div> 

      </div>

      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">

          <div class="form-group">
            <label for="outUnits">Convert to</label>
            <div class="input-group">
              <select class="form-control" id="outUnits"></select>
              <span class="input-group-btn">
                <input type="submit" id="convertBtn" value="Convert" class="btn btn-success">
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div id="conOutput" class="col-xs-2 col-xs-offset-5">


        </div>
      </div>
    </div>

    <div id="count" class="tab-pane fade">
      <h3>Counters</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>
  
</div>
    

<script type="text/javascript">

var moneyUnit = [ ["£ GBP",1],
                  ["$ USD",0.64],
                  ["Lunch Special at Jerk Island",3],
                  ["Playstation 4",300],
                  ["Central London Studio",300000]];

var timeUnit = [["Hours",1],
                ["Days",24],
                ["'Tommy Tank' (average male)",0.4],
                ["Bristol-London Coach",3],
                ["Tran-Atlantic Pedalo",2664]];

var age, pay, hours, save, saveFor, saveForCost, rate;

function getData() {
  age = $("#age").val();
  pay = $("#pay").val();
  hours = $("#hours").val();
  save = $("#save").val();
  saveFor = $("#saveFor").val();
  saveForCost = $("#saveForCost").val();
  rate = pay
}

$(document).ready(function() {

  for (i=0; i<moneyUnit.length; i++) {
    $("#outUnits").append("<option>"+moneyUnit[i][0]+"</option>")
  }

  for (i=0; i<timeUnit.length; i++) {
    $("#outUnits").append("<option>"+timeUnit[i][0]+"</option>")
  }
})


$("#convertBtn").click(function() {
  getData();
  var inValue = $("#inputVal").val();
  var outValue=0;
  

  if ($("#inputVal").val()=="Hours") {
    console.log(inValue+" "+moneyUnit[1][1]);

    // Check money array
    for (i=0; i<moneyUnit.length; i++) {
      if ($("#outUnits").val()==moneyUnit[i][0]) {
        outValue = inValue/moneyUnit[i][1];
        console.log(inValue+" "+moneyUnit[i][0])
      }
    }

    // Check time array
    for (i=0; i<timeUnit.length; i++) {
      if ($("#outUnits").val()==timeUnit[i][0]) {
        outValue = inValue/timeUnit[i][1]; 
        console.log(inValue+" "+timeUnit[i][0]) 
      }
    }
  }

  $("#convert").append('<div class="row"><div class="col-xs-6"><div class="form-group"><label for="inputVal">Value</label><input value="'+outValue+'" id="inputVal" name="inputVal" type="text" class="form-control"></div></div><div class="col-xs-6"><div class="form-group"><label for="inUnits">Units</label><select class="form-control" id="inUnits"><option>'+$("#outUnits").val()+'</option></select></div></div></div>')
})




</script>


</body>
</html>