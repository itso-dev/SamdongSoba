<?php
include_once('./db/dbconfig.php');
include_once('./mail_lib.php');
$message = $_POST['message'];

mailer_google("ITSO", "jh.oh@itso.co.kr", "jh.oh@itso.co.kr", "잇소 랜딩 문의", $message, 1);
mailer_google("ITSO", "jh.oh@itso.co.kr", "hk.lee@piium.co.kr", "잇소 랜딩 문의", $message, 1);
mailer_google("ITSO", "jh.oh@itso.co.kr", "ceo@itso.co.kr", "잇소 랜딩 문의", $message, 1);
?>
