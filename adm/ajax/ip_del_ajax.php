<?php
include_once('../../db/dbconfig.php');

$id = $_POST['id'];


$delete_sql = "delete from ip_block_tbl
where
   id = $id";

$deleteStmt = $db_conn->prepare($delete_sql);
$deleteStmt->execute();

$count = $deleteStmt->rowCount();



?>
