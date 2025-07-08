<?php
include_once('./db/dbconfig.php');
include_once('./mail_lib.php');
$messageArr = [];
if (isset($_POST['message'])) {
 $messageArr = json_decode($_POST['message'], true);
}
$message = mailForm($messageArr);

 $email_sql = "select * from email_tbl where id = 1";
 $email_stt=$db_conn->prepare($email_sql);
 $email_stt->execute();
 $row = $email_stt -> fetch();

 $email = $row['email'];

while ($email_data = $email_stt->fetch()) {
 mailer_google("ITSO", "jh.oh@itso.co.kr", "jh.oh@itso.co.kr", "잇소 랜딩 문의", $message, 1);
}
?>
