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
        <h1 class="d-flex justify-content-center m-2">Change Password</h1>
        <div class="container col-lg-6">
            <?php if (isset($success)) { ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php } ?>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
        </div>
        <div class="container col-lg-6">
            <form method="post" action="password-reset-code.php">
                <input type="hidden" name='token' value="<?php if (isset($_GET['token'])) {
                                                echo $_GET['token'];
                                            } ?>">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php if (isset($_GET['email'])) {
                                                                                                                                            echo $_GET['email'];
                                                                                                                                        } ?>" placeholder="Enter Email Address">
                </div>
                <div class="text-danger mb-3">
                    <?php if (isset($email_error)) {
                        echo $email_error;
                    } ?>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">New Password</label>
                    <input type="password" class="form-control" placeholder="Enter New Password" id="exampleInputPassword1" name="npassword">
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
                <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
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