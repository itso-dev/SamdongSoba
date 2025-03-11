<?php
include_once('head.php');
include_once('default.php');

    // 리스트에 출력하기 위한 sql문
    $email_sql = "SELECT * FROM email_tbl ORDER BY id ASC LIMIT 5";
    $email_stt=$db_conn->prepare($email_sql);
    $email_stt->execute();

    $count_sql = "SELECT COUNT(*) AS total_count FROM email_tbl";
    $count_stt=$db_conn->prepare($count_sql);
    $count_stt->execute();
    $count = $count_stt->fetch();

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>/css/config_form.css" rel="stylesheet" />
        <div class="page-header">
            <h4 class="page-title">발송 이메일 관리</h4>
            <form name="config_form" id="config_form" method="post" action="./ajax/email_insert.php">
                <div class="row">
                    <div class="col-md-5 pr-1">
                        <div class="form-group">
                            <label>이메일 추가</label>
                            <input type="email" name="email" value="" id="email" required class="required frm_input form-control" style="width: 400px">
                            <?php if($count['total_count'] < 5){ ?>
                            <input type="submit" value="추가" class="btn_submit btn btn-primary" style="background: #0eb1c9;" >
                            <?php } else { ?>
                            <span id="add_not" class="btn_submit btn btn-primary" style="background: #0eb1c9;" >추가</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small class="description text-xs">이메일은 최대 5개까지 등록 가능합니다.</small>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="email-list-wrap">
                    <?php
                    while($email=$email_stt->fetch()){
                    ?>
                    <div class="item">
                        <input type="hidden" name="id" value="<?= $email['id'] ?>"
                        <span><?= $email['email'] ?></span><span class="del-email" onclick="delEmail(<?= $email['id'] ?>)">삭제</span>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div>
                <a href="./apply_list.php?menu=55" class="btn_submit btn btn-primary">뒤로가기</a>
            </div>
        </div>
        <!-- page-header end -->
    </div>
    <!-- box end -->

</div>

<style>
    .email-list-wrap{
        padding: 10px;
        background: #f2f2f2;
        border-radius: 5px;
        height: 250px;
        margin-bottom: 20px;
        width: 400px;
    }
    .email-list-wrap .item{
        background: #fff;
        padding: 5px;
        box-sizing: border-box;
        font-size: 16px;
        margin-bottom: 10px;
    }
    .email-list-wrap .item .del-email{
        font-size: 13px;
        padding: 3px 6px 2px;
        box-sizing: border-box;
        border: 1px solid;
        border-radius: 5px;
        margin-left: 15px;
        cursor: pointer;
        color: #fff;
        background: #b14040;
    }
</style>

<script>
    function delEmail(index){
        $.ajax({
            type:'post',
            url:'./ajax/email_delete.php',
            data:{id:index},
            success: function(html) {
                alert("해당 문의 이메일이 삭제되었습니다.");
                location.reload(); 
            },
            error: function(xhr, status, error) {
                console.error("이메일 삭제 실패:", error);
            }
        });
    }
</script>

<!-- content-box-wrap end -->
