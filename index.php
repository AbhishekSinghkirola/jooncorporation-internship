<?php
require_once "includes/db-config.inc.php";
require_once "functions/function.inc.php";

$sql = "SELECT * FROM review ORDER BY id DESC";
$res = mysqli_query($con, $sql);

$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Rating System</title>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/datatables.min.css">
    <link rel="stylesheet" href="./assets/css/dataTables.checkboxes.css">

</head>

<body>
    <div class="container">
        <h1 class="text-center py-4"> Review Rating System</h1>
        <button type="button" id="create" class="btn btn-primary my-3">Create New Review</button>
        <button type="button" id="delete-all" class="btn btn-danger my-3">Delete All Records</button>
        <table id="myTable" class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all"></th>
                    <th>S. No.</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Rating</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            <tbody>
                <?php foreach ($data as $row) : ?>
                    <?php extract(json_decode($row['contact_info'], true)); ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $email ?></td>
                        <td><?= $mobile ?></td>
                        <td><?= $row['rating'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td> <a href="#" class="edit-review" data-eid="<?= $row['id'] ?>">Edit</a> &nbsp; &nbsp; <a href="#" class="delete-review" data-id="<?= $row['id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            </thead>

        </table>
    </div>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/datatables.min.js"></script>
    <script src="./assets/js/dataTables.checkboxes.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        let table = new DataTable('#myTable', {
            columnDefs: [{
                'targets': [0],
                'checkboxes': {
                    'selectRow': false,
                    selectAllPages: false
                }
            }],
        });
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>