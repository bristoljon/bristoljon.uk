$(document).on('keyup','#newName input', function() {
  validateName();
  validateAll();
});

$(document).on('keyup','#newUser input', function() {
  validateUser();
  validateAll();
})

$(document).on('keyup','#newPass input', function() {
  passMatch();
  validatePass();
  validateAll();
})

$(document).on('keyup','#conPass input', function() {
  passMatch();
  validateAll();
})

$(document).on('keyup','#test input', function() {
  validateTest();
  validateAll();
})

$(document).on('keyup','#newEmail input', function() {
  validateEmail();
  validateAll();
})


// Contact form sender
$("#send").click(function (event) {

  event.preventDefault();

  $("#result").empty();

  $.ajax ({
    url: "/php/email.php",
    type: "POST",
    data: { send:$("#send").val(),
            name:$("#name").val(),
            email:$("#email").val(),
            subject:$("#subject").val(),
            message:$("#textarea").val() },
    success: function (result) {
      $("#result").html(result);
    },
    error: function (jqXHR) {
      alert("there were a error, bruva");
    }
  })
})

// Function to update glyphicons and error message
function updateGlyph(field,status,error) {

  if (status=="tick") {
    console.log("tick");
    field.find("span").removeClass("glyphicon-remove");
    field.find("span").addClass("glyphicon-ok");
    field.find("span").css("color","lightgreen");
    field.find(".pull-right").hide();
  }
  else {
    console.log("cross");
    field.find("span").removeClass("glyphicon-ok");
    field.find("span").addClass("glyphicon-remove");
    field.find("span").css("color","red");
    field.find(".pull-right").css("color","grey");
    field.find(".pull-right").html(error);
    field.find(".pull-right").show();
  }
}


// Function to display error message on cross click
$(".glyphicon-remove").click(function() {
  $(this).parent().find("pull-right").toggle();
})


// Sign up form validation

function validateName () {

  if ($("#newName input").val()!="") {
  
    if ($("#newName input").val().length > 2) {
      if ($("#newName input").val().match(/[^A-Za-z -]/g)) {
        updateGlyph($("#newName"),"cross","That ain't no name I ever heard of");

      }
      else {
        updateGlyph($("#newName"),"tick","");
     
      }
    }
    else updateGlyph($("#newName"),"cross","Must be at least 3 characters");

  }
  else updateGlyph($("#newName"),"cross","*required");
}


function validateUser () {

  if ($("#newUser input").val()!=""){
  
    if ($("#newUser input").val().length > 2) {

      if ($("#newUser input").val().match(/[^a-z0-9]/g)) {
        updateGlyph($("#newUser"),"cross","Lowercase letters and/or numbers only");
      }
      else {
        
        $.ajax ({
          url: "/php/validate.php",
          type: "POST",
          cache: false,
          data: { newUser:$("#newUser input").val() },
          success: function (result) {

            if (result) {
              updateGlyph($("#newUser"),"cross","Username taken");
            }

            else {
              updateGlyph($("#newUser"),"tick");
            }
          },
          error: function (jqXHR) {}
        });
      }
    }
    else updateGlyph($("#newUser"),"cross","Must be at least 3 charcters");
  }
  else updateGlyph($("#newUser"),"cross","*required");
}


function passMatch () {

  if ($("#conPass input").val() == $("#newPass input").val()) {
    updateGlyph($("#conPass"),"tick");
  }
  else {
    updateGlyph($("#conPass"),"cross","Passwords don't match");
  }
}

function validatePass() {

  if ($("#newPass input").val()!=""){

    if ($("#newPass input").val().length > 7) {
      updateGlyph($("#newPass"),"tick");
    }
    else {
      updateGlyph($("#newPass"),"cross","Not long enough (that's what she said..)");
    }
  }
  else updateGlyph($("#newPass"),"cross","*required");
}

function validateEmail() {
  if ($("#newEmail input").val()!=""){
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (re.test($("#newEmail input").val())) {
      updateGlyph($("#newEmail"),"tick");
    }
    else {
      updateGlyph($("#newEmail"),"cross","That ain't no e-mail I ever heard of");
    }
    
  }
  else updateGlyph($("#newEmail"),"cross","*required - I won't spam you!");
}

function validateTest() {

  if ($("#test input").val() !="") {
  
    if ($("#test input").val().length > 2) {
    
      $.ajax ({
        url: "/php/validate.php",
        type: "POST",
        data: { answer:$("#test input").val() },
        success: function (result) {
          if (result) {
            updateGlyph($("#test"),"tick");
            validateAll();
          }
          else {
            updateGlyph($("#test"),"cross","Nope, try again");
            validateAll();
          }
        },
        error: function (jqXHR) {}
      });
    }
    else updateGlyph($("#test"),"cross","Need a longer answer");

  }
  else updateGlyph($("#test"),"cross","Need an answer");
}


function changeRiddle () {
  console.log($("#test label").html());
}


function validateAll () {

 
  if ($("#newName").find("span").hasClass("glyphicon-ok") &&
      $("#newUser").find("span").hasClass("glyphicon-ok") &&
      $("#newPass").find("span").hasClass("glyphicon-ok") &&
      $("#conPass").find("span").hasClass("glyphicon-ok") &&
      $("#test").find("span").hasClass("glyphicon-ok")) {

    $("#signinBtn").removeClass("btn-danger");
    $("#signinBtn").addClass("btn-success");
    return true;
    }

  else {
    $("#signinBtn").removeClass("btn-success");
    $("#signinBtn").addClass("btn-danger");
    return false;
  }

}



