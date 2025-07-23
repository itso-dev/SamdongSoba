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

// 반복문으로 모든 이메일에 메일 발송
while ($row = $email_stt->fetch(PDO::FETCH_ASSOC)) {
    $to_email = $row['email'];
    mailer_google("랜딩페이지명", "dev@itso.co.kr", $to_email, "랜딩페이지명 랜딩 문의", $message, 1);
}
?>
