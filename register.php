<?php

include('config/db.php');

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $token = md5(rand());

    if ((isset($username) && empty($username)) || (isset($email) && empty($email)) || (isset($password) && empty($password)) || (isset($cpassword) && empty($cpassword))) {

        if (empty($username)) {
            $username_error = "Username is required";
        }
        if (empty($email)) {
            $email_error = "Email is required";
        }
        if (empty($password)) {
            $password_error = "Password is required";
        }
        if (empty($cpassword)) {
            $cpassword_error = "Confirm Password is required";
        }
    } elseif ((!empty($username)) && (!empty($email)) && (!empty($password)) && (!empty($cpassword))) {

        if (strlen($password) < 8) {
            $password_error = "Password must be atleast 8 characters";
        } elseif ($password != $cpassword) {
            $cpassword_error = "Password and Confirm Password do not match";
        } else {
            $query = mysqli_query($con, "SELECT * FROM register WHERE `email` = '$email'");
            if (mysqli_num_rows($query) > 0) {
                $email_error = "Email id already exist";
            } else {
                $query = mysqli_query($con, "INSERT INTO register (`username`,`email`,`password`,`token`) VALUES ('$username','$email','$password','$token')");
                if ($query) {
                    $success = "Data Registerd";
                    header('refresh:0.5;url=login.php');
                }
            }
        }
    }
}

$select = mysqli_query($con, 'SELECT * FROM register');

if (isset($_GET['update_id'])) {
    $id = base64_decode($_GET['update_id']);
    $query = mysqli_query($con, "SELECT * FROM register WHERE `id` = '$id'");
    $row = mysqli_fetch_array($query);
}

if (isset($_POST['update'])) {
    $id = base64_decode($_GET['update_id']);
    $newname = $_POST['username'] ? $_POST['username'] : $row['username'];
    $update = mysqli_query($con, "UPDATE register SET `username` = '$newname' WHERE `id` = '$id'");
    if ($update) {
        $success = "Data Updated";
        header('refresh:0.5;url=table.php');
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 bg">
        <h1 class="d-flex justify-content-center m-2">Register</h1>
        <div class="container col-lg-6">
            <?php if (isset($success)) { ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php } ?>
        </div>
        <div class="container col-lg-6">
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" value="<?php if (isset($row['username'])) {
                                                                                                        echo $row['username'];
                                                                                                    } ?>">
                </div>
                <div class="text-danger mb-3">
                    <?php if (isset($username_error)) {
                        echo $username_error;
                    } ?>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" placeholder="Enter Email Address" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php if (isset($row['email'])) {
                                                                                                                                            echo $row['email'];
                                                                                                                                        } ?>">
                </div>
                <div class="text-danger mb-3">
                    <?php if (isset($email_error)) {
                        echo $email_error;
                    } ?>
                </div>
                <?php if (!isset($_GET['update_id'])) { ?>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter Password" id="exampleInputPassword1" name="password">
                    </div>
                    <div class="text-danger mb-3">
                        <?php if (isset($password_error)) {
                            echo $password_error;
                        } ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Enter Confirm Password" id="exampleInputPassword2" name="cpassword">
                    </div>
                    <div class="text-danger mb-3">
                        <?php if (isset($cpassword_error)) {
                            echo $cpassword_error;
                        } ?>
                    </div>
                <?php } ?>
                <?php if (!isset($_GET['update_id'])) { ?>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    <span class="float-end">Already account? <a href="login.php" style="font-weight: 600;">Login</a></span>
                <?php } else { ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                <?php } ?>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>