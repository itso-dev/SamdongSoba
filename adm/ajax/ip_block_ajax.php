<?php
include_once('../../db/dbconfig.php');

$ip = $_POST['ip'];
$reg_date = date("Y-m-d H:i:s");

// 중복확인
$ip_sql = "SELECT * FROM ip_block_tbl WHERE ip = '$ip'";
$ip_stt = $db_conn->prepare($ip_sql);
$ip_stt->execute();
$chk = $ip_stt -> fetch();




// 중복 여부 확인
if($chk){
    echo "이미 차단된 아이피 주소입니다.";
} else {
    // 중복된 IP가 없는 경우 데이터 삽입
    $insert_sql = "INSERT INTO ip_block_tbl (ip, view, regdate) VALUES (?, ?, ?)";
    $db_conn->prepare($insert_sql)->execute(
        [
            $ip,
            0,
            $reg_date
        ]
    );
    echo "차단되었습니다.";
}
?>
