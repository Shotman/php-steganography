<?php
if(isset($_FILES["image"])){
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__. '/include/crypt.php';
    
    $password = $_POST["password"];
    $image = $_FILES["image"];
    if(PHP_OS === "Linux"){
        $command = "/var/www/html/jsteg reveal {$image["tmp_name"]}";
    }
    else{
        $command = "jsteg.exe reveal {$image["tmp_name"]}";
    }
    $cipherText = exec($command);    
    $original_plaintext = Crypt::decrypt($cipherText,$password);
}
?>
<!doctype html>
<html lang="en">
<head>
  <title>Image steganography - decode</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    .btn-file {
      position: relative;
      overflow: hidden;
    }
    .btn-file input[type=file] {
      position: absolute;
      top: 0;
      right: 0;
      min-width: 100%;
      min-height: 100%;
      font-size: 100px;
      text-align: right;
      filter: alpha(opacity=0);
      opacity: 0;
      outline: none;
      background: white;
      cursor: pointer;
      display: block;
    }
    
    #img-upload{
      width: 100%;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand navbar-light bg-light">
      <ul class="nav navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="/">Encode an image </a>
          </li>
          <li class="nav-item active">
              <a class="nav-link" href="/decode.php">Decode an image <span class="sr-only">(current)</span></a>
          </li>
      </ul>
  </nav>
  <div class="row">
    <div class="container">
        <?php
        if(isset($original_plaintext)){
            echo "<h1>Secret message : $original_plaintext</h1>";
        }
        ?>
      <form method="POST" action="decode.php" enctype="multipart/form-data">
        <fieldset class="form-group row">
          <legend class="col-form-legend col-sm-1-12">Get the message hidden inside an image</legend>
          <div class="col-sm-1-12">
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="" aria-describedby="passwordhelp">
              <small id="passwordhelp" class="text-muted">Password you used to crypt the message</small>
            </div>
            <div class="form-group">
              <label>Upload Image</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <span class="btn btn-primary btn-file">
                    Browse… <input type="file" id="imgInp" name="image" aria-describedby="photohelp">
                  </span>
                </span>
                <input type="text" class="form-control" readonly>
              </div>
              <small id="photohelp" class="text-muted">Image you want to get the hidden text from</small>
              <img id='img-upload'/>
            </div>
            <div class="btn-group" role="group" aria-label="Submit and cancel buttons">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-danger">Cancel</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script>
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
      });
      
      $('.btn-file :file').on('fileselect', function(event, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
        log = label;
        
        if( input.length ) {
          input.val(log);
        } else {
          if( log ) alert(log);
        }
        
      });
      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function (e) {
            $('#img-upload').attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]);
        }
      }
      
      $("#imgInp").change(function(){
        readURL(this);
      }); 	
    });
  </script>
</body>
</html>