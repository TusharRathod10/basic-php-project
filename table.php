<?php

include('config/db.php');

$query = mysqli_query($con, "SELECT * FROM register");

if (isset($_GET['delete_id'])) {
    $id = base64_decode($_GET['delete_id']);
    $delete = mysqli_query($con, "DELETE FROM register WHERE `id`='$id'");
    if ($delete) {
        $success = "Data Deleted";
        header('refresh:0.5;url=table.php');
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
</head>

<body>
    <div class="container mt-5 bg">
        <h1 class='d-flex justify-content-center m-2'>User Table</h1>
        <div class="container col-lg-3">
            <?php if (isset($success)) { ?>
                <div class="alert alert-danger" style="color:red">
                    <?php echo $success . ' 🗑'; ?>
                </div>
            <?php } ?>
        </div>
        <div class="container">
            <div class="row">
                <table class="table table-dark table-striped" id="data">
                    <thead class="table-light p-2">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Password</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="p-2">
                        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['username'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['password'] ?></td>
                                <td><?php echo $row['create'] ?></td>
                                <td><?php echo $row['update'] ?></td>
                                <td><a href="register.php?update_id=<?php echo base64_encode($row['id']) ?>"><button class="btn btn-primary"><i class="fa fa-edit"></i></button></a></td>
                                <td><a href="table.php?delete_id=<?php echo base64_encode($row['id']) ?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/307f49e560.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
        let table = new DataTable('#data', {
            dom: 'Bfrtip',
            buttons: [
                'csv', 'pdf', 'excel', 'copy'
            ]
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#data').DataTable();
        });
    </script>
</body>

</html>