function timeSince(date) {

  var seconds = Math.floor((new Date() - date) / 1000);

  var interval = Math.floor(seconds / 31536000);

  if (interval > 1) {
      return interval + " years ago";
  }
  interval = Math.floor(seconds / 2592000);
  if (interval > 1) {
      return interval + " months ago";
  }
  interval = Math.floor(seconds / 86400);
  if (interval > 1) {
      return interval + " days ago";
  }
  interval = Math.floor(seconds / 3600);
  if (interval > 1) {
      return interval + " hours ago";
  }
  interval = Math.floor(seconds / 60);
  if (interval > 1) {
      return interval + " minutes ago";
  }
  return Math.floor(seconds) + " seconds ago";
}


function addComment(){

  $.ajax({
    url:"/comment.php",
    type:"POST",
    data: { reference:results.id,
            type:results.type,
            comment:$("#comment").val()},
    success:function(result) {
      console.log(result);
      getComments();

      $.ajax ({
        url: "/email.php",
        type: "POST",
        data: { send:"Send",
                name:result,
                email:"comments@bristoljon.uk",
                subject:results.title,
                message:$("#comment").val() },
        success: function (result) {
          console.log(result);
          $("#comment").val("");
        },
        error: function (jqXHR) {
          console.log("E-mail failed");
        }
      })
    },
    error: function (jqXHR) {
      console.log("Add comment failed");
    }
  });
}

function getComments(){


    $.ajax({
      url:"/comment.php",
      type:"POST",
      data: { reference:results.id,
              type:results.type,
              grab:1},
      success:function(result) {

        // Remove existing comments from DOM
        $(".comment").remove();

        // Convert JSON to array
        var comment = JSON.parse(result);
        var date;

        // If logged in show delete button on own comments
        var spanner ="";
        for (var i=0; i<comment.length; i++){
          date = new Date(comment[i]['date']);

          if (results.userid==="jon") {
            spanner = "<a href='"+comment[i]['id']+"'><span class='glyphicon glyphicon-trash pull-right'></span></a>";
          }
          else {
            if (comment[i]['name']===results.userid) {
              spanner = "<a href='"+comment[i]['id']+"'><span class='glyphicon glyphicon-trash pull-right'></span></a>";
            }
            /*
            else {
              spanner = "<span class='glyphicon glyphicon-comment pull-right'></span>";
            }
            */
          }

          $("#comments").before("<div class='panel panel-primary comment'><div class='panel-heading'><strong>"+comment[i]['name']+"</strong> <span class='glyphicon glyphicon-user'></span> - "+timeSince(date)+spanner+"</div><div class='panel-body'><p>"+comment[i]['content']+"</p></div></div>");
        }

        // Add event listener for delete buttons
        $(".comment a").click(function(event) {
          event.preventDefault();
    
          $.ajax({
            url:"/comment.php",
            type:"POST",
            data: { deleteComment:$(this).attr("href")},
            success:function(result) {
              console.log(result);
              getComments();
            },
            error: function (jqXHR) {
              console.log("Delete failed");
            }
          });
        })
      },

      error: function (jqXHR) {
        console.log("Get comments failed");
      }
    });
}

function getTags(){

  $.ajax({
    url:"/tagger.php",
    type:"POST",
    data: { reference:results.id,
            type:results.type},
    success:function(result) {
      var tags = JSON.parse(result);

      for (var i=0; i<tags.length; i++){
        $("#tagcloud").append("<a href='#'>"+tags[i]['name']+"</a>, ");
      }

      $("#tags").show();

    },
    error: function (jqXHR) {
      console.log("getTags failed");
    }
  });
}

function getImages() {
  $.ajax({
    url:"/image.php",
    type:"POST",
    data: { reference:results.id,
            type:results.type},
    success:function(result) {
      var images = JSON.parse(result);

      for (var i=0; i<images.length; i++){
        $("#imageCloud").append("<li class='col-xs-4 col-md-12 col-lg-12' ><img src='"+images[i]['url']+"' class='img-thumbnail img-responsive'></li>");
      }

      if (images.length == 0) {
        $("#imageCloud").append("<li>No images added yet, have a cat instead</li><li class='col-xs-12 col-md-12 col-lg-12' ><img src='/uploads/0-u-555H.jpg' class='img-thumbnail img-responsive'></li>");
      }

      $("#images").show();

      $('.img-thumbnail').on("click",function(){
        var src = $(this).attr('src');
        var img = '<img src="' + src + '" class="img-responsive"/>';
        
        $('#myModal').modal();

        $('#myModal').on('shown.bs.modal', function(){
            $('#myModal .modal-body').html(img);
        });

        $('#myModal').on('hidden.bs.modal', function(){
            $('#myModal .modal-body').html('');
        });
      });

    },
    error: function (jqXHR) {
      console.log("getImages failed");
    }
  });
}