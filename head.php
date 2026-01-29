<?php
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
session_start();

$site_path = $_SERVER["DOCUMENT_ROOT"]."/SamdongSoba";
$site_url = "http://".$_SERVER["HTTP_HOST"]."/SamdongSoba";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once($site_path.'/db/dbconfig.php');

// CSRF 토큰 생성
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

//스팸봇 차단
$bad_agents = ['MJ12bot', 'AhrefsBot', 'SemrushBot', 'DotBot'];
foreach ($bad_agents as $bot) {
    if (stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
        header('HTTP/1.0 403 Forbidden');
        exit;
    }
}

// 현재 URL 가져오기
$current_url = strtolower($_SERVER['REQUEST_URI']);

$site_info_sql = "";
$ab_type = "";
$ab_id = "";
$client_key = "itso";

try {
    if ($current_url === '/' || $current_url === '/index_bak.php') {
        // A 사이트
        $site_info_sql = "SELECT * FROM site_setting_tbl WHERE client_key = '$client_key'";
        $ab_type = 'A';
        $ab_id = 1;
    } elseif (strpos($current_url, '/b/') === 0) {
        // B 사이트
        $site_info_sql = "SELECT * FROM site_setting_tbl WHERE client_key = '$client_key'";
        $ab_type = 'B';
        $ab_id = 2;
    } else {
        $site_info_sql = "SELECT * FROM site_setting_tbl WHERE client_key = '$client_key'";
        $ab_type = 'A';
        $ab_id = 1;
    }

    $site_info_stt = $db_conn->prepare($site_info_sql);
    $site_info_stt->execute();
    $site = $site_info_stt->fetch();
} catch (Exception $e) {}

//신규 광고링크 기능 추가
$ad_category_sql = "select * from ad_type_tbl where client_key = '$client_key' order by regdate desc";
$ad_category_stt = $db_conn->prepare($ad_category_sql);
$ad_category_stt->execute();
$ad_categories = $ad_category_stt->fetchAll();

// 키 전부 소문자로 변환
$getParams = array_change_key_case($_GET, CASE_LOWER);

$ad_type = '';
$adCode = '';
$is_adcode = 0;

foreach ($ad_categories as $category) {
    $key = strtolower($category['eng_name']);

    if (isset($getParams[$key])) {
        $is_adcode = 1;
        $ad_type = $category['id'];
        $adCode = $getParams[$key];
    }
}

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
    opcache_reset();
}


$view_cnt_sql = "SELECT * FROM view_log_tbl WHERE ip = '" . get_client_ip() . "' AND DATE(reg_date) = CURDATE()";
$view_cnt_stt = $db_conn->prepare($view_cnt_sql);
$view_cnt_stt->execute();
$view_chk = $view_cnt_stt->fetch();

$client_ip = get_client_ip();

if (!$view_chk) {
    $today = date("Y-m-d H:i:s");
    $view_sql = "insert into view_log_tbl
                              (view_cnt, ip, client_key, ab_test, reg_date)
                         value
                              (? ,?, ?, ?, ?)";

    $db_conn->prepare($view_sql)->execute(
        [1, $client_ip, $client_key, $ab_type, $today]
    );

    $update_view_sql = "UPDATE ad_link_tbl SET view = view + 1 WHERE link = '$adCode'";
    $update_view_stmt = $db_conn->prepare($update_view_sql);
    $update_view_stmt->execute();

    if($is_adcode){
        $update_view_new_sql = "UPDATE ad_link_tbl SET view = view + 1 WHERE client_key = '$client_key' and type = $ad_type and link = '$adCode'";
        $update_view_new_stmt = $db_conn->prepare($update_view_new_sql);
        $update_view_new_stmt->execute();
    }
}


$ip_sql = "SELECT * FROM ip_block_tbl WHERE client_key = '$client_key' and ip = '$client_ip'";
$ip_stt = $db_conn->prepare($ip_sql);
$ip_stt->execute();
$ip_chk = $ip_stt -> fetch();


if ($ip_chk) {


    $modify_sql = "update ip_block_tbl
    set 
    view = view + 1
    where
    ip = '$client_ip'";

    $updateStmt = $db_conn->prepare($modify_sql);
    $updateStmt->execute();

    // 구글로 강제 이동
    header("Location: https://www.google.com");
    exit;
}

$flow = "";
if(isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    if (strpos($referer, 'search.naver.com') !== false) {
        $flow = "네이버 검색 결과";
    } elseif (strpos($referer, 'brandsearch.naver.com') !== false) {
        $flow = "네이버 브랜드검색광고";
    } elseif (strpos($referer, 'm.place.naver.com') !== false || strpos($referer, 'place.naver.com') !== false) {
        $flow = "네이버 플레이스";
    } elseif (strpos($referer, 'blog.naver.com') !== false || strpos($referer, 'm.blog.naver.com') !== false) {
        $flow = "네이버 블로그";
    } elseif (strpos($referer, 'cafe.naver.com') !== false) {
        $flow = "네이버 카페";
    } elseif (strpos($referer, 'searchad.naver.com') !== false) {
        $flow = "네이버 파워링크 광고";
    } elseif (strpos($referer, 'facebook.com') !== false || strpos($referer, 'lm.facebook.com') !== false) {
        $flow = "메타 (페이스북)";
    } elseif (strpos($referer, 'instagram.com') !== false || strpos($referer, 'l.instagram.com') !== false) {
        $flow = "메타 (인스타그램)";
    } elseif (strpos($referer, 'kakao.com') !== false || strpos($referer, 'pf.kakao.com') !== false) {
        $flow = "카카오톡";
    } elseif (strpos($referer, 'google.com') !== false) {
        $flow = "구글 검색";
    } else {
        $flow = "기타 (" . $referer . ")";
    }
} else {
    $flow = "직접유입";
}
echo "<script>console.log('유입 경로: " . addslashes($flow) . "');</script>";

?>

<!doctype html>
<html lang="ko">
<head>
    <?= $site['head_script'] ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">
    <meta name="HandheldFriendly" content="true">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="imagetoolbar" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title><?= $site['site_title'] ?></title>
    <meta name="title" content="<?= $site['site_title'] ?>">
    <meta name="description" content="<?= $site['site_description'] ?>">

    <link rel="shortcut icon" href="<?= $site_url ?>/img/favicon.png">

    <meta property="og:title" content="<?= $og_title ?? $site['site_title'] ?>" />
    <meta property="og:description" content="<?= $og_description ?? $site['site_description'] ?>" />
    <meta property="og:url" content="<?= $og_url ?? $site_url ?>" />
    <meta property="og:image" content="<?= $og_image ?? $site_url . '/img/og.png' ?>" />

    <link rel="stylesheet" type="text/css" href="<?= $site_url ?>/css/reset.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= $site_url ?>/css/common.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script type="text/javascript" src="<?= $site_url ?>/js/jquery-1.12.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>

</head>

<body>
    <?= $site['body_script'] ?>

    <div id="header">
        <div class="head-wrap">
            <img src="img/head-logo.png" class="head-logo white" alt="삼동소바">
            <img src="img/head-logo2.png" class="head-logo black" alt="삼동소바">
            <nav>
                <ul>
                    <li class="link" data-target="main">브랜드소개</li>
                    <li class="link" data-target="section4">성공요인</li>
                    <li class="link" data-target="section5">메뉴소개</li>
                    <li class="link" data-target="contact">창업문의</li>
                </ul>
            </nav>
            <div class="header-div">
                <div class="mo-menu-open">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="29" viewBox="0 0 28 29" fill="none">
                        <path d="M3.5 14.5H24.5M3.5 7.25H24.5M3.5 21.75H24.5" stroke="#393B85" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>


    </div>

    <div class="mo-menu">
        <div class="mo-menu-top">
            <img src="img/logo.svg" class="logo">
            <div class="menu-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M21 7L7 21M7 7L21 21" stroke="#393B85" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="mo-menu-bottom">
            <nav>
                <ul>
                    <li class="link" data-target="main">1등 브랜드</li>
                    <li class="link" data-target="section4">5초의 법칙</li>
                    <li class="link" data-target="section5">품질의 경쟁력</li>
                    <li class="link" data-target="section6">브랜드 메뉴</li>
                    <li class="link" data-target="section8">브랜드 안정성</li>
                    <li class="link" data-target="contact">개설 문의</li>
                </ul>
            </nav>
            <a href="tel:00000000" class="call">
                0000-0000
            </a>
        </div>
    </div>

    <div id="wrapper">
        <div id="container">

<script>

    $(document).ready(function () {

        // checkActivemenu();

        $(window).on('scroll', function() {
            // checkActivemenu();
        });

        function checkActivemenu() {
            var scrollPosition = $(window).scrollTop();

            menuOffsets = {
                'section2': $('#section2').offset().top - 100,
                'section4': $('#section4').offset().top - 100,
                'section10': $('#section10').offset().top - 100,
                'contact': $('#contact').offset().top - 100,
            };

            $.each(menuOffsets, function(menu, offset) {
                if (scrollPosition >= offset && scrollPosition < offset + $('#' + menu).outerHeight()) {
                    $('nav ul li').removeClass('tap');
                    $('nav ul li[data-target="' + menu + '"]').addClass('tap');
                }
            });
        }

        $('nav ul li').on('click', function(){
            var target = $(this).data('target');

            history.pushState(null, null, `#${target}`);

            $('html, body').animate({
                scrollTop: $('#' + target).offset().top
            }, 500);

            // 클릭한 생생 고객메뉴안내 항목에 'tap' 클래스 추가
            $('.link').removeClass('tap');
            $(this).addClass('tap');

            $(".mo-menu").fadeOut(200, function () {
                $("html").css("overflow", "auto");
            });
        });

        $('.logo').on('click', function() {
            $('html, body').animate({
                scrollTop: 0 }, 500);
        });

    });

    $(".mo-menu-open").click(function () {
        $(".mo-menu").fadeIn(200);
        $("html").css("overflow", "hidden");
    });

    $(".menu-close").click(function () {
        $(".mo-menu").fadeOut(200, function () {
            $("html").css("overflow", "auto");
        });
    });

    window.onscroll = function() {

        if (window.innerWidth <= 1000) {
            return;
        }

        var header = document.getElementById("header");

        if (window.scrollY > 0) {
            header.classList.add("gnb-blur");
        } else {
            header.classList.remove("gnb-blur");
        }
    };

</script>
