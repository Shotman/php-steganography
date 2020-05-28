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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
    html,
    body {
        height: 100%;
    }

    .form {
        width: 90%;
        max-width: 600px;
        padding: 15px;
        margin: 0 auto;
    }

    .form .checkbox {
        font-weight: 400;
    }

    .form .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form .form-control:focus {
        z-index: 2;
    }

    .form input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .custom-file-label::after {
        left: 0;
        right: auto;
        border-left-width: 0;
        border-right: inherit;
    }

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
        /* background: white; */
        cursor: inherit;
        display: block;
    }

    #img-upload {
        width: 100%;
    }
    </style>
</head>

<body class="text-left">
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
    <?php
        if(isset($original_plaintext)){
            echo "<h1>Secret message : $original_plaintext</h1>";
        }
    ?>
    <form class="form" id="imageencode" action="decode.php" method="POST" target="_blank" enctype="multipart/form-data">
        <fieldset class="form-group row">
            <legend class="col-form-legend col-sm-1-12">Get the message hidden inside an image</legend>
            <div class="col-sm-1-12">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder=""
                        aria-describedby="passwordhelp">
                    <small id="passwordhelp" class="text-muted">Password you used to crypt the message</small>
                </div>
                <div class="form-group">
                    <label>Upload Image</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-primary btn-default btn-file"
                                style="cursor:pointer;height:100%;line-height:100%;padding-top:16%;">
                                Browse… <input type="file" id="imgInp" name="image">
                            </span>
                        </span>
                        <input type="text" class="form-control" style="cursor:none" readonly>
                    </div>
                    <small id="photohelp" class="text-muted">Image you want to get the hidden text from</small>
                    <img id='img-upload' />
                </div>
                <div class="btn-group" role="group" aria-label="Submit and cancel buttons">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </fieldset>
    </form>
    <div class="col-md-12 text-center"> 
   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId">
     About steganograpy
   </button>
</div>
   
   <!-- Modal -->
   <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Steganography</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
               </div>
               <div class="modal-body">
                   <p>
                   Steganography is the technique of hiding secret data within an ordinary, non-secret, file or message in order to avoid detection; the secret data is then extracted at its destination. The use of steganography can be combined with encryption as an extra step for hiding or protecting data. The word steganography is derived from the Greek words steganos (meaning hidden or covered) and the Greek root graph (meaning to write).
                   </p><a href="https://en.wikipedia.org/wiki/Steganography" target="_blank">Read mode about steganography(Wikipedia)</a>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
           </div>
       </div>
   </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
    $(document).ready(function() {
      $('#imageencode').on('submit', function() {
            $("#img-upload").attr("src", "")
            // $(this).get(0).reset();
        }).on("reset",function(){
          $("#img-upload").attr("src", "")
        });
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
    });
    </script>
</body>

</html>