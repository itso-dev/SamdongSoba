<?
    include_once('../head.php');

    $posted = date("Y-m-d H:i:s");
    $email = $_POST['email'];


    $insert_sql = "insert into email_tbl
                      (email, regdate)
                 value
                      (?, ?)";


    $db_conn->prepare($insert_sql)->execute(
        [$email, $posted]);

    echo "<script type='text/javascript'>";
    echo "alert('발송 이메일이 등록 되었습니다.'); location.href='../email_form.php?menu=55'";
    echo "</script>";


?>
