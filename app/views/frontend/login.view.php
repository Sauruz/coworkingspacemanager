<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Bootstrap 101 Template</title>

        <!-- Bootstrap -->
        <link href="<?php echo plugins_url() . '/coworkingspacemanager/dist/css/styles.css'; ?>" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="csm-frontend">
        <div class="bootstrap-wrapper"> 
            <div class="bootstrap-wrapper-fonts">
                
                <div class="container">
                    <div class="row">
                        <div class="panel col-md-4 col-md-offset-4 panel-login">
                            <div class="panel-header">
                                <h4>Login to <?php echo $data['csm_name'];?></h4>
                            </div>
                            <div class="panel-body">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email"><br>
                                
                                 <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password"><br>
                                
                                <button type="submit" class="btn btn-block btn-success">Login</button><br>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>