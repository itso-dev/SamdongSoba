<?
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
if( isset( $_SESSION[ 'manager_id' ] ) ) {
    $adm_login = TRUE;
    $manager_key = $_SESSION[ 'manager_id' ];
}

if ( !$adm_login ) {
    ?>
    <meta http-equiv="refresh" content="0;url=bbs/login.php" />
    <?
}

// 문의알림
if($manager_key == 1){
    $contact_alert_sql = "select count(*) as today_count from contact_tbl where result_status = '대기'";
} else {
    $contact_alert_sql = "select count(*) as today_count from contact_tbl where result_status = '대기' AND manager_fk = " .$manager_key;
}


$contact_alert_stt=$db_conn->prepare($contact_alert_sql);
$contact_alert_stt->execute();
$contact_alert_result = $contact_alert_stt->fetch(PDO::FETCH_ASSOC);
$contact_alert_count = $contact_alert_result['today_count'];

?>

<script type="text/javascript">

    $( document ).ready(function() {
        $('.navbar-toggler').click(function(){
            $('body').toggleClass('sidebar-open');
        });
        $(".sidebar-wrapper .nav li").click(function (){
            if($(this).hasClass("toggle-open")){
                $(this).find(".submenu").slideUp("300");

                $(this).removeClass("toggle-open");
            } else {
                $(this).find(".submenu").slideDown("300");
                $(this).addClass("toggle-open");
            }
        });
    });
</script>



<body>
<!-- admin menu -->
<div class="gnb-container">
    <div class="sidebar">
        <div class="brand-wrapper">
            <a class="brand" href="index.php">우대포</a>
            <p class="manager-info"><i class="fas fa-user-circle"></i><?= $_SESSION['manager_name'] ?></p>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li <?php if($menu == 1) echo "class='active'" ?> >
                    <a class="menu" href="<?= $site_url ?>/index.php?menu=1">
                        <i class="far fa-address-book"></i>
                        <p class="contact_col">문의 관리 <span><?= $contact_alert_count ?></span></p>
                    </a>
                </li>
                <li <?php if($menu == 44) echo "class='active'" ?> >
                    <a class="menu" href="<?= $site_url ?>/ad/ad_list.php?menu=44">
                        <i class="fas fa-ad"></i>
                        <p>광고 관리</p>
                    </a>
                </li>
                <?php if($_SESSION[ 'manager_id' ] == 1){ ?>
                <li <?php if($menu == 22) echo "class='active'" ?> >
                   <span class="menu" href="<?= $site_url ?>/smo/review_list.php?menu=22">
                        <i class="fas fa-tools"></i>
                        <p>사이트 관리</p>
                        <i class="fas fa-chevron-down toggle"></i>
                    </span>
                    <div class="submenu">
                        <a href="<?= $site_url ?>/smo/log.php?menu=22">방문자 통계</a>
                        <a href="<?= $site_url ?>/smo/config_form.php?menu=22">사이트 기본 설정</a>
                        <a href="<?= $site_url ?>/smo/sale_list.php?menu=22">매장 매출 관리</a>
                        <a href="<?= $site_url ?>/smo/beef_list.php?menu=22">고기 슬라이드 관리</a>
                        <a href="<?= $site_url ?>/smo/video_list.php?menu=22">유튜브 영상 관리</a>
                    </div>
                </li>
                <?php } ?>
                <?php if($_SESSION[ 'manager_id' ] == 1){ ?>
                <li <?php if($menu == 3) echo "class='active'" ?> >
                    <a class="menu" href="<?= $site_url ?>/popup_list.php?menu=3">
                        <i class="far fa-clone"></i>
                        <p>팝업 설정</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($_SESSION[ 'manager_id' ] == 1){ ?>
                <li <?php if($menu == 4) echo "class='active'" ?> >
                    <a class="menu" href="<?= $site_url ?>/manager_list.php?menu=4">
                        <i class="far fa-user"></i>
                        <p>담당자 설정</p>
                    </a>
                </li>
                <?php } ?>
            </ul>
            <div class="service-center-wrap">
                <p class="tit"><i class="fas fa-headphones"></i> 고객센터</p>
                <p class="text">사용 중인 관리서비스에<br>필요한 내용을 확인하세요.</p>
                <a href="service_center.php?menu=10">고객센터</a>
            </div>
        </div>
    </div>
</div>

<!-- 컨텐츠 영역 시작 -->
<div class="main-wrapper" id="wrapper">

    <!-- 상단 레이아웃 -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <!--a class="navbar-brand" href="apply_list.php">예반스</a-->
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/adm/index.php"><i class="fas fa-redo-alt"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="./ajax/logout.php?is_login=<?= $adm_login ?>"> <i class="fas fa-sign-out-alt"></i></a>

                    </li>
                    <li class="nav-item">
                        <a href="/index.php"> <i class="fas fa-home"></i> </a>
                    </li>
                </ul>

            </div>

        </div>
    </nav>


    <div class="panel-header"></div>

    <div id="container">
        <div class="content-box-wrap">
            <div class="box">
                <div class="page-header">
