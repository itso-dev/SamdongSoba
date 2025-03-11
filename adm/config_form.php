<?php
include_once('./head.php');
include_once('./default.php');

// 리스트에 출력하기 위한 sql문
$site_sql1 = "select * from site_setting_tbl where id = 1";
$site_stt1=$db_conn->prepare($site_sql1);
$site_stt1->execute();
$row1 = $site_stt1 -> fetch();

$site_sql2 = "select * from site_setting_tbl where id = 2";
$site_stt2=$db_conn->prepare($site_sql2);
$site_stt2->execute();
$row2 = $site_stt2 -> fetch();

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<link rel="stylesheet" type="text/css" href="./css/config_form.css" rel="stylesheet" />

<div class="page-header">
    <h4 class="page-title">기본 설정</h4>

    <span class="tab tab1 active">A사이트 기본설정</span>
    <span class="tab tab2">B사이트 기본설정</span>

    <!--     A사이트      -->
    <form name="config_form" id="config_form_a" method="post" action="./ajax/site_modify.php">
        <input type="hidden" name="type" value="1">
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>사이트명*</label>
                    <input type="text" name="site_title" value="<?=$row1[1]?>" id="site_title" required class="required frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">사이트명은 Browser Title 로 보이게 됩니다.</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>사이트 소개*</label>
                    <input type="text" name="site_description" value="<?=$row1[2]?>" id="site_description" required class="required frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">meta 태그의 og:description 에 해당됩니다.</small>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>구글 애널리틱스 코드 삽입</label>
                    <input type="text" name="google_analytics" value="<?=$row1[3]?>" id="google_analytics" class="frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">&#60;script async="" src="https://www.googletagmanager.com/gtag/js?id=<strong>[해당 부분의 코드를 입력해주세요]</strong>"&#62;&#60;/script&#62;</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>네이버 웹 마스터 코드 삽입</label>
                    <input type="text" name="naver_webmaster" value="<?=$row1[4]?>" id="naver_webmaster" class="frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">&#60;meta name="naver-site-verification" content="<strong>[해당 부분의 코드를 입력해주세요]</strong>"/&#62;</small>
            </div>
        </div>
        <div>
            <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
        </div>
    </form>

    <!--     B사이트      -->
    <form name="config_form" id="config_form_b" method="post" action="./ajax/site_modify.php">
        <input type="hidden" name="type" value="2">
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>사이트명*</label>
                    <input type="text" name="site_title" value="<?=$row2[1]?>" id="site_title" required class="required frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">사이트명은 Browser Title 로 보이게 됩니다.</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>사이트 소개*</label>
                    <input type="text" name="site_description" value="<?=$row2[2]?>" id="site_description" required class="required frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">meta 태그의 og:description 에 해당됩니다.</small>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>구글 애널리틱스 코드 삽입</label>
                    <input type="text" name="google_analytics" value="<?=$row2[3]?>" id="google_analytics" class="frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">&#60;script async="" src="https://www.googletagmanager.com/gtag/js?id=<strong>[해당 부분의 코드를 입력해주세요]</strong>"&#62;&#60;/script&#62;</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 pr-1">
                <div class="form-group">
                    <label>네이버 웹 마스터 코드 삽입</label>
                    <input type="text" name="naver_webmaster" value="<?=$row2[4]?>" id="naver_webmaster" class="frm_input form-control" size="30">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <small class="description text-xs">&#60;meta name="naver-site-verification" content="<strong>[해당 부분의 코드를 입력해주세요]</strong>"/&#62;</small>
            </div>
        </div>
        <div>
            <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
        </div>
    </form>
</div>
<!-- page-header end -->
</div>
<!-- box end -->

</div>
<!-- content-box-wrap end -->

<script>
    $(".tab1").click(function (){
        $(".tab1").addClass("active");
        $(".tab2").removeClass("active");
        $("#config_form_a").show();
        $("#config_form_b").hide();
    });
    $(".tab2").click(function (){
        $(".tab2").addClass("active");
        $(".tab1").removeClass("active");
        $("#config_form_b").show();
        $("#config_form_a").hide();
    });
</script>
