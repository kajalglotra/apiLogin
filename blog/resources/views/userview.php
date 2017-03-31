<html>
 <head>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
 </head>
 <body>
        <div class="container">
            <h1>
                <center>data from db</center>
            </h1>
              <form  action ="" method="post">
               <input type = "hidden"  name = "_token" value = "<?php echo csrf_token() ?>">
               username:<input type="text" name="username"><br>
               password:<input type="text" name="password"><br>
               status: <input type="text"  name="status"><br>
               <input type="submit" value="save" id="submit">
        </div>
  </body>
  <script>
     function explode(){
            var response = '';
            $.ajax({
                type: "post",
                data: {"id" : 2},
                url: "/login",
                async: false,
                success: function(text) {
                    response = text;
                    console.log(response);
                },
                
    });

    }
   
    $('document').ready(function(){
      
        setInterval(explode, 3000);
    });
  </script>

</html>