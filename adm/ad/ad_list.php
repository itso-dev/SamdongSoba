<?php
    include_once('../head.php');
    include_once('../default.php');

    // 리스트에 출력하기 위한 sql문
    $admin_sql = "select * from ad_link_tbl order by id desc";
    $admin_stt=$db_conn->prepare($admin_sql);
    $admin_stt->execute();


?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>/css/board_list.css" rel="stylesheet" />

    <div class="page-header">
        <h4 class="page-title">
            광고 링크 관리
        </h4>
    </div>

    <form name="fmemberlist" id="fmemberlist" action="/setting/ad_delete.php" method="post">
        <input type="hidden" name="link" value="portfolio_list.php"/>
        <input type="hidden" name="type" value="all"/>
        <div class="btn_fixed_top">
            <span onclick="delData()" class="btn btn_02">선택삭제</span>
            <a href="ad_form.php?menu=44&mode=insert" id="member_add" class="btn btn_01">고유코드 추가</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table border-bottom" style="min-width: 800px;">
                    <thead>
                        <tr>
                            <th scope="col" id="mb_list_chk" rowspan="2" width="5%">
                                <label for="chkall" class="d-none">게시글 전체</label>
                                <input type="checkbox" name="chkall" value="1" onclick="check_all(this)">
                            </th>
                            <th scope="col" id="mb_list_join" width="20%" class="text-center">고유코드</th>
                            <th scope="col" id="mb_list_join" width="10%" class="text-center">유입 방문자 수</th>
                            <th scope="col" id="mb_list_join" width="10%" class="text-center">문의 수</th>
                            <th scope="col" id="mb_list_join" width="20%" class="text-center">작성일</th>
                            <th scope="col" rowspan="2" id="mb_list_mng" width="50%" class="text-center">링크</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php
                                while($list_row=$admin_stt->fetch()){
                                    $count_sql = "SELECT COUNT(*) AS total_count FROM contact_tbl WHERE ad_code = '" .$list_row['link'] ."'";
                                    $count_stt = $db_conn->prepare($count_sql);
                                    $count_stt->execute();
                                    $count = $count_stt->fetch();
                            ?>
                            <tr class="bg0">
                                <td headers="mb_list_chk" class="td_chk">
                                    <input type="hidden" name="mb_id[<?=$list_row['id']?>]" value="admin" id="mb_id_<?=$list_row['id']?>">
                                    <input type="checkbox" name="chk[]" class="m_chk" value="<?=$list_row['id']?>" id="chk_<?=$list_row['id']?>">
                                </td>
                                <td headers="mb_list_join" class="td_date text-center"><?=$list_row['link']?></td>
                                <td headers="mb_list_join" class="td_date text-center"><?= number_format($list_row['view'])?></td>
                                <td headers="mb_list_join" class="td_date text-center"><?= number_format($count['total_count'])?></td>
                                <td headers="mb_list_name" class="td_mbname text-center"><?= substr($list_row['regdate'], 0, 10) ?></td>
                                <td headers="mb_list_mng" class="td_mng td_mng_s text-center"
                                    onclick="copyToClipboard('https://woodaepo.com?adCode=<?= $list_row['link'] ?>')" style="cursor: pointer; color: blue; text-decoration: underline;">https://woodaepo.com?adCode=<?= $list_row['link'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <!-- page-header end -->


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
