<?php
require_once "includes/db-config.inc.php";
require_once "functions/function.inc.php";

if ($_POST['type'] === 'add' || $_POST['type'] === 'update') {
    $name = get_safe_value($con, $_POST['name']);
    $email = get_safe_value($con, $_POST['email']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $rating = get_safe_value($con, $_POST['rating']);
    $description = get_safe_value($con, $_POST['description']);
    $contact_info = json_encode(["email" => $email, "mobile" => $mobile]);

    if (isset($_POST['type']) && $_POST['type'] === 'add') {
        $sql = "INSERT INTO review (name, contact_info, rating, description) VALUES ('$name', '$contact_info', $rating, '$description')";
        $res = mysqli_query($con, $sql) or die("Query Failed");
    }

    if (isset($_POST['type']) && $_POST['type'] === 'update') {
        $id = get_safe_value($con, $_POST['id']);
        $last_update = date('Y-m-d h:i:s');
        $sql = "UPDATE review SET name = '$name' , contact_info = '$contact_info', rating = $rating, description = '$description', last_update = '$last_update' WHERE id = $id";
        $res = mysqli_query($con, $sql) or die("Query Failed");
    }
}

if (isset($_POST['type']) && $_POST['type'] === 'delete') {
    $id = get_safe_value($con, $_POST['id']);
    $sql = "DELETE FROM review WHERE id = $id";
    $res = mysqli_query($con, $sql) or die("Query Failed");
    if ($res) {
        echo true;
    }
}

if (isset($_POST['type']) && $_POST['type'] === 'deleteall') {

    foreach ($_POST['id'] as $value) {
        $id = get_safe_value($con, $value);
        $sql = "DELETE FROM review WHERE id = $id";
        $res = mysqli_query($con, $sql) or die("Query Failed");
    }
}
