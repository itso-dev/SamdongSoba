<?php
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
session_start();

$site_path = $_SERVER["DOCUMENT_ROOT"]."/Samdongsoba";
$site_url = "http://".$_SERVER["HTTP_HOST"]."/Samdongsoba";
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


    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '908539868329096');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=908539868329096&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Meta Pixel Code -->

</head>

<body>
    <?= $site['body_script'] ?>

    <div id="preloader">
        <div class="load-wrap">
            <div class="loading-img">
                <p class="loading-text">0%</p>
            </div>
            <div class="load-4">
                <div class="ring-1"></div>
            </div>
        </div>
        <img src="img/head-logo3.png" class="loading-footprint">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let percent = 0;
            let loadingText = document.querySelector(".loading-text");
            let preloader = document.getElementById("preloader");

            function updateLoading() {
                percent += Math.random() * 10; // 0~10%씩 증가
                if (percent > 100) percent = 100;
                loadingText.textContent = Math.floor(percent) + "%";

                if (percent < 100) {
                    setTimeout(updateLoading, 200);
                } else {
                    hidePreloader();
                }
            }

            function hidePreloader() {
                preloader.style.transition = "opacity 1s ease-out";
                preloader.style.opacity = "0";

                setTimeout(() => {
                    preloader.style.display = "none";
                }, 800);
            }

            updateLoading();

            window.onload = function () {
                if (percent >= 100) {
                    hidePreloader();
                }
            };
        });
    </script>
    <div id="header">
        <div class="head-wrap">
            <img src="img/head-logo.png" class="head-logo white" alt="삼동소바">
            <img src="img/head-logo2.png" class="head-logo black" alt="삼동소바">
            <nav>
                <ul>
                    <li class="link" data-target="menu1">브랜드소개</li>
                    <li class="link" data-target="menu2">성공요인</li>
                    <li class="link" data-target="menu">메뉴소개</li>
                    <li class="link" data-target="contact">창업문의</li>
                </ul>
            </nav>
            <div class="header-div">
                <div class="mo-menu-open">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M2.39994 3.84C2.27273 3.8382 2.14643 3.8617 2.02838 3.90914C1.91033 3.95658 1.80289 4.027 1.71229 4.11633C1.6217 4.20565 1.54976 4.31209 1.50066 4.42945C1.45156 4.54682 1.42627 4.67278 1.42627 4.8C1.42627 4.92722 1.45156 5.05318 1.50066 5.17055C1.54976 5.28791 1.6217 5.39435 1.71229 5.48367C1.80289 5.573 1.91033 5.64342 2.02838 5.69086C2.14643 5.7383 2.27273 5.7618 2.39994 5.76H21.5999C21.7272 5.7618 21.8535 5.7383 21.9715 5.69086C22.0896 5.64342 22.197 5.573 22.2876 5.48367C22.3782 5.39435 22.4501 5.28791 22.4992 5.17055C22.5483 5.05318 22.5736 4.92722 22.5736 4.8C22.5736 4.67278 22.5483 4.54682 22.4992 4.42945C22.4501 4.31209 22.3782 4.20565 22.2876 4.11633C22.197 4.027 22.0896 3.95658 21.9715 3.90914C21.8535 3.8617 21.7272 3.8382 21.5999 3.84H2.39994ZM2.39994 11.04C2.27273 11.0382 2.14643 11.0617 2.02838 11.1091C1.91033 11.1566 1.80289 11.227 1.71229 11.3163C1.6217 11.4056 1.54976 11.5121 1.50066 11.6295C1.45156 11.7468 1.42627 11.8728 1.42627 12C1.42627 12.1272 1.45156 12.2532 1.50066 12.3705C1.54976 12.4879 1.6217 12.5944 1.71229 12.6837C1.80289 12.773 1.91033 12.8434 2.02838 12.8909C2.14643 12.9383 2.27273 12.9618 2.39994 12.96H21.5999C21.7272 12.9618 21.8535 12.9383 21.9715 12.8909C22.0896 12.8434 22.197 12.773 22.2876 12.6837C22.3782 12.5944 22.4501 12.4879 22.4992 12.3705C22.5483 12.2532 22.5736 12.1272 22.5736 12C22.5736 11.8728 22.5483 11.7468 22.4992 11.6295C22.4501 11.5121 22.3782 11.4056 22.2876 11.3163C22.197 11.227 22.0896 11.1566 21.9715 11.1091C21.8535 11.0617 21.7272 11.0382 21.5999 11.04H2.39994ZM2.39994 18.24C2.27273 18.2382 2.14643 18.2617 2.02838 18.3091C1.91033 18.3566 1.80289 18.427 1.71229 18.5163C1.6217 18.6056 1.54976 18.7121 1.50066 18.8295C1.45156 18.9468 1.42627 19.0728 1.42627 19.2C1.42627 19.3272 1.45156 19.4532 1.50066 19.5705C1.54976 19.6879 1.6217 19.7944 1.71229 19.8837C1.80289 19.973 1.91033 20.0434 2.02838 20.0909C2.14643 20.1383 2.27273 20.1618 2.39994 20.16H21.5999C21.7272 20.1618 21.8535 20.1383 21.9715 20.0909C22.0896 20.0434 22.197 19.973 22.2876 19.8837C22.3782 19.7944 22.4501 19.6879 22.4992 19.5705C22.5483 19.4532 22.5736 19.3272 22.5736 19.2C22.5736 19.0728 22.5483 18.9468 22.4992 18.8295C22.4501 18.7121 22.3782 18.6056 22.2876 18.5163C22.197 18.427 22.0896 18.3566 21.9715 18.3091C21.8535 18.2617 21.7272 18.2382 21.5999 18.24H2.39994Z" fill="#111"/>
                    </svg>
                </div>
                <div class="mo-menu-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path d="M21 7L7 21M7 7L21 21" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>


    </div>

    <div class="mo-menu">
        <div class="mo-menu-bottom">
            <nav>
                <ul>
                    <li class="link" data-target="menu1">브랜드소개</li>
                    <li class="link" data-target="menu2">성공요인</li>
                    <li class="link" data-target="menu">메뉴소개</li>
                    <li class="link" data-target="contact">창업문의</li>
                </ul>
            </nav>
            <div class="contact-container">
<!--                <img class="call-img" src="--><?//= $site_url ?><!--/img/call-img.png">-->
<!--                <a class="call-txt" href="tel:18008148">1800-8148</a>-->
            </div>
        </div>
    </div>

    <div id="wrapper">
        <div id="container">

<script>

    $(document).ready(function () {

        checkActivemenu();

        $(window).on('scroll', function() {
            checkActivemenu();
        });

        function checkActivemenu() {
            var scrollPosition = $(window).scrollTop();

            menuOffsets = {
                'menu1': $('#menu1').offset().top - 100,
                'menu2': $('#menu2').offset().top - 100,
                'menu': $('#menu').offset().top - 100,
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
        $(this).hide();
        $(".mo-menu-close").show();
        $(".mo-menu").fadeIn(200);
        $("html").css("overflow", "hidden");
    });

    $(".mo-menu-close").click(function () {
        $(this).hide();
        $(".mo-menu-open").show();
        $(".mo-menu").fadeOut(200, function () {
            $("html").css("overflow", "auto");
        });
    });

    (function () {
        const header = document.getElementById("header");
        if (!header) {
            console.error("#header 없음");
            return;
        }

        window.addEventListener("scroll", function () {
            if (window.scrollY > 0) {
                header.classList.add("gnb-blur");
            } else {
                header.classList.remove("gnb-blur");
            }
        });
    })();
</script>
