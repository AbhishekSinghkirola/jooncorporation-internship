<?php
require_once "includes/db-config.inc.php";
require_once "functions/function.inc.php";

$id = get_safe_value($con, $_POST['id']);
$sql = "SELECT * FROM review where id = $id";
$res = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($res);

echo json_encode($data);
