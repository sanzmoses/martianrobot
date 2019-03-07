<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Martian Robot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h1 class="mt-5"><b> Martian Robot </b></h1>
            </div>
            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <div class="row mt-4">

                    <?php if(isset($_SESSION['error'])): ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php 
                                if(isset($_SESSION['error'])) {
                                    echo $_SESSION['error']; 
                                } else {
                                    echo 'Nothing to show.';
                                }
                            ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-sm-6 col-md-6">
                        <form action="/app/Process.php" method="POST">
                            <div class="form-group">

                                <label for="exampleFormControlTextarea1"> <b> Set Input </b></label>
                                <textarea class="form-control" name="inputs" id="exampleFormControlTextarea1" rows="6" required>
<?php if(isset($_SESSION['inputs'])) { echo $_SESSION['inputs']; } ?>
                                </textarea>

                            </div>
                            <button type="submit" name="process" class="btn btn-dark btn-sm btn-block">Submit Input</button>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card text-white bg-dark mt-4" style="max-width: 100%; height: 230px;">
                            <div class="card-header">Results</div>
                            <div class="card-body" style="overflow: auto;">
                                <p class="card-text ml-1">
                                <?php 
                                    if(isset($_SESSION['results'])) {
                                        echo $_SESSION['results']; 
                                    } else {
                                        echo 'Nothing to show.';
                                    }
                                ?>
                                    
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card w-100 mt-3">
                            <div class="card-body">
                                <a class="info" href="/problem.html">Martian Robot Programming Problem</a> <br>
                                <a class="info" href="https://github.com/sanzmoses/martianrobot.git" target="_blank">Code @ https://github.com/sanzmoses/martianrobot.git</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

<style>
    body {
        font-size: 16px;
        font-family: "Courier New", Courier, monospace
    }

    .status {
        color: #f55a5a;
    }

    .info {
        font-size: 12px;
    }

    .alert {
        word-wrap: break-word;
    }

</style>