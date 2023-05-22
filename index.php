<?php

require_once 'php_action/db_connect.php';

session_start();

$errors = array();

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        if ($username == "") {
            $errors[] = "Username is required";
        }

        if ($password == "") {
            $errors[] = "Password is required";
        }
    } else {
        $sql = "SELECT *FROM users WHERE user_name = '$username'";
        $result = $connect->query($sql);

        if ($result->num_rows == 1) {
            $password = md5($password); //Encrypting 
            $mainSql = "SELECT * FROM users WHERE user_name = '$username' AND password = '$password'";
            $mainResult = $connect->query($mainSql);

            if ($mainResult->num_rows == 1) {
                $value = $mainResult->fetch_assoc();
                $user_id = $value['user_id'];

                //Set Session
                $_SESSION['userId'] = $user_id;
                header('location: /stock_system/dashboard.php');
            } else {
                $errors[] = "Incorrect Username/Password combination";
            }
        } else {
            $errors[] = "Username does not exists";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Stock Management System</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap theme -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="custom/css/custom.css">
    <!-- jquery -->
    <script type="text/javascript" src="assets/jquery/jquery.min.js"></script>
    <!-- jqueryui -->
    <link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui.min.css">
    <script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
    <!-- bootstrap js -->
    <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="row vertical">
            <div class="col-md-5 col-md-offset-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">Please Sign-In</h4>
                    </div>
                    <div class="panel-body">
                        <div class="messages">
                            <?php
                            if ($errors) {
                                foreach ($errors as $key => $value) {
                                    echo '<div class="alert alert-warning" role="alert">
                                     <i class="glyphicon glyphicon-excalamtion-sign"></i>
                                     ' . $value . '
                                  </div>';
                                }
                            }?>
                        </div>
                        <!-- ... -->
                        <form class="form-horizontal" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" id="loginForm">
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">User Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-log-in"></i>Sign in</button>
                                </div>
                            </div>
                        </form>
                        <!-- ... -->

                    </div>
                </div>
            </div>
            <!-- col-md-5 -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</body>

</html>