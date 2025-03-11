<?php
    include_once('../head.php');
    include_once('../default.php');

    // A 화면
    $a_sql = "select * from ad_test_tbl where type = 1";
    $a_stt=$db_conn->prepare($a_sql);
    $a_stt->execute();
    $a = $a_stt -> fetch();

    $a_contact_sql = "SELECT COUNT(id) FROM contact_tbl where ab_test = 'A' AND result_status like '%진행%'";
    $a_contact_stt=$db_conn->prepare($a_contact_sql);
    $a_contact_stt->execute();
    $a_contact = $a_contact_stt -> fetch();

    $a_contact_success_sql = "SELECT COUNT(id) FROM contact_tbl where ab_test = 'A' AND result_status like '%완료%'";
    $a_contact_success_stt=$db_conn->prepare($a_contact_success_sql);
    $a_contact_success_stt->execute();
    $a_contact_success = $a_contact_success_stt -> fetch();

    // B 화면
    $b_sql = "select * from ad_test_tbl where type = 2";
    $b_stt=$db_conn->prepare($b_sql);
    $b_stt->execute();
    $b = $b_stt -> fetch();

    $b_contact_sql = "SELECT COUNT(id) FROM contact_tbl where ab_test = 'B' AND result_status like '%진행%'";
    $b_contact_stt=$db_conn->prepare($b_contact_sql);
    $b_contact_stt->execute();
    $b_contact = $b_contact_stt -> fetch();

    $b_contact_success_sql = "SELECT COUNT(id) FROM contact_tbl where ab_test = 'B' AND result_status like '%완료%'";
    $b_contact_success_stt=$db_conn->prepare($b_contact_success_sql);
    $b_contact_success_stt->execute();
    $b_contact_success = $b_contact_success_stt -> fetch();

?>
    <link rel="stylesheet" type="text/css" href="../css/home.css" rel="stylesheet" />
<div class="page-header">
    <h4 class="page-title">A/B 테스트</h4>
    <div class="content-container">
        <div class="content-wrap">
            <p class="tit">A 랜딩페이지</p>
            <div class="view-wrap">
                <div class="item">
                    <p class="name">방문자 수</p>
                    <p class="cnt"><?=number_format($a['view'])?></p>
                </div>
                <div class="item">
                    <p class="name">문의 건수</p>
                    <p class="cnt"><?=number_format($a['contact'])?></p>
                </div>
                <div class="item">
                    <p class="name">상담 진행 수</p>
                    <p class="cnt"><?=number_format($a_contact['0'])?></p>
                </div>
                <div class="item">
                    <p class="name">상담 완료 수<p>
                    <p class="cnt"><?=number_format($a_contact_success['0'])?></p>
                </div>
            </div>
        </div>
        <div class="content-wrap">
            <p class="tit">B 랜딩페이지</p>
            <div class="view-wrap">
                <div class="item">
                    <p class="name">방문자 수</p>
                    <p class="cnt"><?=number_format($b['view'])?></p>
                </div>
                <div class="item">
                    <p class="name">문의 건수</p>
                    <p class="cnt"><?=number_format($b['contact'])?></p>
                </div>
                <div class="item">
                    <p class="name">상담 진행 수</p>
                    <p class="cnt"><?=number_format($b_contact['0'])?></p>
                </div>
                <div class="item">
                    <p class="name">상담 완료 수<p>
                    <p class="cnt"><?=number_format($b_contact_success['0'])?></p>
                </div>
            </div>
        </div>
    </div>
 <!-- box end -->
</div>
<!-- content-box-wrap end -->
<style>
    .list-thumb{
        width: 200px;
    }
</style>

<script type="text/javascript">

function check_all(thisobj) {
	var $this = $(thisobj);

	if($this.prop("checked") == true) {
		$this.closest("#fmemberlist").find("input[type=checkbox]").prop("checked", true);
	} else {
		$this.closest("#fmemberlist").find("input[type=checkbox]").prop("checked", false);
	}
}

function delData(){
    var count = 0;
    var obj = document.getElementsByName("chk[]");

    for(var i=0 ; i < obj.length ; i++){
        if( obj[i].checked == true ){
            count++;
        }
    }
    if( count == 0) {
        alert("삭제하실 대상을 선택해주세요.");
        return false;
    } else {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
        $("#fmemberlist").attr("action", "./setting/ad_delete.php");
        $("#fmemberlist").submit();
        return true;
    }
}
function copyToClipboard(text) {
    // Temporary input to hold the text to copy
    var tempInput = document.createElement("input");
    document.body.appendChild(tempInput);
    tempInput.value = text;
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // For mobile devices

    // Execute copy command
    document.execCommand("copy");

    // Remove temporary input
    document.body.removeChild(tempInput);

    // Optional: Alert or other feedback for successful copy
    alert("해당 링크가 복사되었습니다. \n" + text);
}

</script>
