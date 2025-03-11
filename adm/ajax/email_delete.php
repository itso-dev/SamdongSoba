<?
   include_once('../head.php');

   $id = $_POST['id'];

   $delete_sql = "delete from email_tbl
    where
      id = $id";

   $deleteStmt = $db_conn->prepare($delete_sql);
   $deleteStmt->execute();

   $count = $deleteStmt->rowCount();


   echo "<script type='text/javascript'>";
   echo "alert('발송 이메일이 삭제 되었습니다.'); location.href='../email_form.php?menu=1&'";
   echo "</script>";

?>
