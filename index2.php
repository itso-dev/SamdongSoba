<?php
include_once('head.php');


//팝업 출력하기 위한 sql문
$popup_sql = "select * from popup_tbl where client_key = '$client_key' and `end_date` > NOW() order by id ";
$popup_stt = $db_conn->prepare($popup_sql);
$popup_stt->execute();

$today = date("Y-m-d H:i:s");
$view_sql = "insert into view_log_tbl
                              (view_cnt,  reg_date)
                         value
                              (? ,?)";

$db_conn->prepare($view_sql)->execute(
    [1, $today]
);
?>

<link rel="stylesheet" type="text/css" href="css/index.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/index2.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/reset.css" rel="stylesheet" />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<script src='https://www.google.com/recaptcha/api.js'></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- recapture -->
<script src='https://www.google.com/recaptcha/api.js?render='></script>

<!-- GSAP 라이브러리 추가 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollSmoother.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>

<script type="text/javascript" src="<?= $site_url ?>/js/script.js"></script>

<!-- layer popup -->
<?
$arr = array();
$left_count = 0;
$top = 10;
$top2 = 10;
$z_index = 9999;

if ($popup_stt->rowCount() > 0) {
    ?>
    <div class="popup-space">
        <?
        // 팝업 데이터 반복
        while ($popup = $popup_stt->fetch()) {
            $arr[] = $popup['id'];
            ?>
            <div class="layer-popup pc"
                 style="display: none; width: 80%; max-width: <?= $popup['width'] ?>px; height: <?= $popup['height'] ?>px; top: 10%; left: 5%; z-index: <?= $z_index ?>;">
                <div id="agreePopup<?= $popup['id'] ?>" class="agree-popup-frame">
                    <img src="https://itsoadmin.com/data/<?= $client_key ?>/<?= $popup['file_name'] ?>" style="height:calc(<?= $popup['height'] ?>px - 36px);"
                         alt="<?= $popup['popup_name'] ?>" onclick="handleClick('<?= $popup['link'] ?>')">
                    <div class="show-chk-wrap">
                        <a href="javascript:AllClose()" class="all-close-btn">전체닫기</a>
                        <div class="show-chk-div">
                            <a href="javascript:todayClose('agreePopup<?= $popup['id'] ?>', 1);" class="today-x-btn">오늘하루닫기</a>
                            <a class="close-popup x-btn">닫기</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layer-popup mobile"
                 style="width: 80%; max-width: <?= $popup['width_mobile'] ?>px; height: <?= $popup['height_mobile'] ?>px; top: 10%; left: 10%; z-index: <?= $z_index ?>;">
                <div id="agreePopup_mo<?= $popup['id'] ?>" class="agree-popup-frame">
                    <img src="https://itsoadmin.com/data/<?= $client_key ?>/<?= $popup['file_name_mobile'] ?>" style="height:calc(<?= $popup['height'] ?>px - 36px);"
                         alt="<?= $popup['popup_name'] ?>" onclick="handleClick('<?= $popup['link'] ?>')">
                    <div class="show-chk-wrap">
                        <a href="javascript:AllClose()" class="all-close-btn">전체닫기</a>
                        <div class="show-chk-div">
                            <a href="javascript:todayClose('agreePopup_mo<?= $popup['id'] ?>', 1);" class="today-x-btn">오늘하루닫기</a>
                            <a class="close-popup x-btn">닫기</a>
                        </div>
                    </div>
                </div>
            </div>
            <?
            $z_index -= 1;
            $top += 10;
            $top2 += 15;
        }
        ?>
    </div>
    <?
}
?>

<script>
    // * today popup close
    $(document).ready(function () {
        <?php for ($i = 0; $i < count($arr); $i++) { ?>
        todayOpen('agreePopup<?= $arr[$i] ?>'); // 항상 실행

        // 900px 이하일 때만 실행
        if (window.innerWidth <= 900) {
            todayOpen('agreePopup_mo<?= $arr[$i] ?>');
        }
        <?php } ?>
        $(".close-popup").click(function () {
            $(this).closest('.layer-popup').hide();
        });
    });

    // 창열기
    function todayOpen(winName) {
        var blnCookie = getCookie(winName);
        var obj = eval("window." + winName);
        console.log(blnCookie);
        if (blnCookie !== "expire") {
            $('#' + winName).closest('.layer-popup').show();
        } else {
            $('#' + winName).closest('.layer-popup').hide();
        }
    }
    // 창닫기
    function todayClose(winName, expiredays) {
        setCookie(winName, "expire", expiredays);
        var obj = eval("window." + winName);
        $('#' + winName).closest('.layer-popup').hide();
    }

    // 쿠키 가져오기
    function getCookie(name) {
        var nameOfCookie = name + "=";
        var x = 0;
        while (x <= document.cookie.length) {
            var y = (x + nameOfCookie.length);
            if (document.cookie.substring(x, y) == nameOfCookie) {
                if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
                    endOfCookie = document.cookie.length;
                return unescape(document.cookie.substring(y, endOfCookie));
            }
            x = document.cookie.indexOf(" ", x) + 1;
            if (x == 0)
                break;
        }
        return "";
    }

    // 24시간 기준 쿠키 설정하기
    // 만료 후 클릭한 시간까지 쿠키 설정
    function setCookie(name, value, expiredays) {
        var todayDate = new Date();
        todayDate.setDate(todayDate.getDate() + expiredays);
        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
    }

    // 전체 팝업 닫기
    function AllClose() {
        $(".layer-popup").each(function () {
            $(this).animate({
                    opacity: 0
                }, 200, function() {
                    $(this).remove();
            });
        });
    }
</script>


<div id="main">
    <div class="page1">
        <div class="swap-txt-wrap">
            <p class="txt">명실상부 대한민국 1등 소바 브랜드</p>
            <p class="txt">자산을 만드는 부자 창업</p>
            <p class="txt">100년을 이어갈 장인정신</p>
        </div>
        <img class="page-logo" src="<?= $site_url ?>/img/page-logo.png" />
        <div class="video-bg">
            <iframe width="560"
                    height="315"
                    src="https://www.youtube.com/embed/fds7cYPJdVI?si=e9cR3auxycWPbXTQ&autoplay=1&mute=1&loop=1&playlist=fds7cYPJdVI&controls=0&showinfo=0&modestbranding=1&playsinline=1&rel=0"
                    title="YouTube video player"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen>
            </iframe>
        </div>
    </div>
    <div class="page2 p120">
        <div class="flex-wrap">
            <div class="left-wrap">
                <div class="top-wrap">
                    <div class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="58" height="48" viewBox="0 0 58 48" fill="none">
                            <path d="M26.9218 1.12125C27.1013 1.28583 27.191 5.4344 27.6882 5.85268C28.4822 6.53154 33.6263 4.89268 34.517 6.95668C35.8289 10.0081 30.4984 7.9304 29.0001 9.00697C30.3534 9.90526 30.892 11.8938 32.2315 12.655C33.9853 13.6424 37.4929 13.4298 39.0465 14.8013C41.5115 16.9613 40.531 18.7167 37.0994 18.1064C33.0325 17.3795 30.3741 15.2333 27.2601 12.7921L26.2244 17.5853C23.7939 18.2573 23.6558 13.4641 23.1172 13.4641C19.8582 15.5624 16.6199 17.9967 12.4218 17.5784C11.1099 16.4813 19.7408 10.9887 20.0101 10.3784L16.5646 10.0355C16.0951 5.69497 22.406 5.90754 23.3382 5.11211C23.5729 4.91325 24.6984 -0.929032 26.9149 1.12125H26.9218Z" fill="#5B373B"/>
                            <path d="M45.7993 34.8378C42.2433 32.719 41.691 31.1693 38.9912 28.5361C38.4388 27.9944 37.341 27.9327 37.2857 27.8573C34.7033 24.3258 47.9052 27.6241 48.3264 27.1784C48.6579 26.8218 48.3955 24.1407 47.6567 23.3933C45.2331 20.9453 41.0626 23.7636 38.4526 22.9544C36.9474 22.4881 36.8645 20.7053 36.4502 20.4721C32.991 18.559 34.2476 22.6801 33.1774 23.4481C32.4593 23.9624 30.381 23.7293 29.1657 24.223C28.3371 24.5658 27.9505 25.6493 27.6121 25.807C26.901 30.5247 29.1795 27.4527 31.7481 28.2001C30.0288 29.8047 28.3026 36.7921 25.734 32.815C24.284 30.5727 22.7857 30.0104 20.7074 28.2001C20.1688 26.2527 25.1264 26.4515 26.9217 25.807C27.0874 21.9944 20.6798 25.0801 20.0307 24.4218C19.5543 23.935 21.5843 21.679 16.896 22.3304C15.3355 22.5498 15.7567 24.079 14.0167 24.9841C10.8336 26.6504 6.00714 25.279 4.83333 29.9144L13.1121 27.8641C13.5264 36.0653 2.72738 35.1121 0 40.8858C3.23143 42.1613 16.5369 31.8755 17.255 32.6641C17.6279 37.4161 13.7474 43.615 18.2976 47.0504C21.2736 45.247 19.2643 43.4298 19.3955 41.3041C19.5198 39.2813 20.5486 37.0047 20.0307 34.7213L25.5545 36.7853C25.7479 39.3087 21.4807 38.7738 21.4255 39.8573C21.4048 40.2961 23.0757 42.7716 24.2081 42.6618C27.7433 42.3258 30.8781 34.7693 32.9426 32.1567C33.3845 31.6013 32.915 30.9018 34.5238 31.2858V41.2287C34.5238 41.4344 33.9369 41.9487 33.9438 42.5727C33.9576 43.615 34.8069 48.9978 36.5883 47.743C36.3881 47.0641 37.2857 46.303 37.2857 46.0287V34.7144C41.6081 35.9075 42.6783 42.3395 46.0133 44.2253C51.6062 47.3864 56.3981 45.7338 58 39.5213C54.1402 39.199 49.1481 36.8195 45.8062 34.831L45.7993 34.8378Z" fill="#5B373B"/>
                        </svg>
                        <p class="txt">빽빽할 삼</p>
                    </div>
                    <div class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="58" height="48" viewBox="0 0 58 48" fill="none">
                            <path d="M26.2166 29.4062C25.9404 31.0313 21.9495 40.8371 20.3406 40.6999C17.0402 40.4256 22.5433 25.3605 22.7642 23.2348C23.4271 16.9673 22.0461 10.6176 22.0737 4.37762C27.5285 5.60505 32.9833 2.92391 38.8385 3.30791C41.5314 3.48619 50.2175 5.06334 52.6342 5.91362C56.853 7.40162 52.9518 9.88391 52.2821 11.4131C50.3902 15.7125 52.9656 35.0085 52.4892 41.7902C52.434 42.5239 52.4064 44.8348 51.419 44.8279C48.9125 44.8073 49.7964 30.1056 49.7204 28.0142C49.5064 22.0073 48.1737 16.1102 49.6859 9.87705C41.6073 11.6599 33.6254 7.68962 25.5192 10.5696L26.2166 14.6771C29.5654 13.2851 45.688 11.6051 46.0609 16.3776C46.3785 20.3548 40.1987 18.7571 38.3206 18.7502C34.2952 18.7502 29.4687 19.8405 26.2097 18.0988C25.8023 21.5616 26.769 26.1148 26.2097 29.413L26.2166 29.4062Z" fill="#5B373B"/>
                            <path d="M13.0977 16.3776C12.352 13.3879 9.27246 18.9627 8.94794 19.1616C7.7396 19.909 3.25841 18.1536 3.45865 15.6713C3.58294 14.1559 8.21603 11.3376 9.63841 9.52046C11.8548 6.69531 12.4625 0.763884 16.4879 3.40388C18.9115 4.99474 16.9437 5.22788 16.6951 6.91474C15.8596 12.5102 15.5213 20.3342 15.8251 25.9982C16.0667 30.4279 18.656 39.6233 16.8746 43.4427C15.5075 46.3776 13.0908 43.5936 13.0908 41.7422V16.3776H13.0977Z" fill="#5B373B"/>
                            <path d="M42.5049 21.4588C40.109 19.6417 32.3066 21.74 28.9785 20.8348C29.448 25.9983 29.448 30.7571 28.9785 35.9205C31.3745 35.7354 33.1007 34.1308 35.6278 33.9251C37.8649 33.74 39.6119 34.6725 41.0411 34.556C44.6247 34.2611 45.1564 23.4748 42.498 21.4657L42.5049 21.4588ZM41.4002 30.4348C38.7211 29.132 35.8557 29.7148 33.1283 30.4348L32.4309 26.3205L41.414 25.628V30.428L41.4002 30.4348Z" fill="#5B373B"/>
                        </svg>
                        <p class="txt">정성 동</p>
                    </div>
                    <div class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="58" height="48" viewBox="0 0 58 48" fill="none">
                            <path d="M45.8638 43.4417C45.8914 43.3731 46.8028 43.3251 47.0376 42.7766C48.384 39.6497 50.414 33.5126 45.8845 32.5251C39.2766 31.0783 31.6538 33.1148 25.3428 33.7046C21.1724 34.0886 16.8293 33.252 12.6105 34.4314C12.3481 36.6394 13.6807 48.3446 9.55165 47.3434C6.35474 46.5686 9.3238 40.9526 9.11666 38.9091C8.92332 37.0646 6.65165 35.5834 7.05213 34.0817C7.5976 32.0108 17.9202 31.812 19.75 31.5857C28.305 30.5023 42.2802 28.9457 50.7317 30.4474C52.2024 30.708 54.6743 31.5994 54.6812 33.3548C53.1552 35.6177 52.2093 45.9446 50.1102 46.6646C47.6659 47.5011 45.2424 45.0737 45.8569 43.4554L45.8638 43.4417Z" fill="#5B373B"/>
                            <path d="M42.0662 3.38919C40.8993 3.05319 39.4977 1.03033 38.0891 0.488616C32.9381 -1.50681 34.8231 3.23147 33.5527 3.58119C28.3258 5.01433 20.2955 2.01776 15.0203 2.2029C12.9834 4.04747 4.13147 5.50119 3.21314 6.93433C0.271713 11.556 12.6036 10.0886 14.2815 10.404C16.201 10.7743 17.5681 13.6338 20.1574 13.14C20.0677 14.7995 15.4967 13.5172 16.0146 15.5263C16.2217 16.3218 19.2184 15.6703 20.1643 15.876C20.0746 16.4315 20.3024 17.7823 20.1643 17.9263C19.6396 18.4818 10.256 18.0566 9.80028 21.6978C13.2112 21.9172 16.4634 18.0978 20.1574 19.6406C18.0584 22.2943 14.3091 22.3492 11.6922 23.5698C11.0639 23.8646 8.13623 25.6269 8.43314 26.4909C9.35838 29.2063 18.8662 23.556 19.4669 24.0978C20.4198 32.7515 22.2081 29.3778 28.1877 28.3012C29.9277 27.9858 31.7436 28.4589 33.4836 28.0749C35.2374 27.6909 36.3353 25.86 38.4965 25.5103C42.0731 24.9343 45.5739 26.7035 49.1574 26.1549C48.8881 21.3618 42.9708 22.9869 38.9453 21.5606C37.3503 20.9983 35.9003 20.1 34.6643 18.9549L42.9431 19.2978C43.0743 19.1812 42.377 16.6372 42.2527 16.5618C41.2101 15.8623 26.931 17.0898 24.3003 16.5618C24.1346 14.2166 27.6422 15.3618 29.4996 13.8463C30.6803 12.8795 30.9565 10.7606 31.3293 10.5206C31.8817 10.164 34.4848 10.2669 35.776 9.82119C36.7565 9.47833 38.0891 7.56519 40.0224 7.16747C44.4553 6.25547 48.8467 8.28519 53.3003 7.65433C54.7779 0.968616 46.0089 4.52747 42.0524 3.38919H42.0662ZM32.5929 24.1115C31.9646 26.0658 25.0667 26.7103 24.3141 26.1549C25.0115 22.452 29.5893 24.6326 32.5929 24.1115ZM30.4386 18.0223C30.7908 18.2418 31.4467 21.1355 31.2258 21.3549L22.9401 22.0406C22.6293 19.284 28.8022 17.0006 30.4386 18.0223ZM27.221 9.4509C24.8181 10.0818 24.2312 12.756 21.5522 12.4475C21.5522 11.4052 23.161 11.4669 23.4717 10.9183C23.9136 10.1572 23.2093 8.95719 24.0448 8.25776C25.0805 7.39376 32.5446 5.59033 33.2834 6.2829C33.3455 11.2818 29.6722 8.80633 27.221 9.4509Z" fill="#5B373B"/>
                            <path d="M40.8855 35.0761C40.2503 34.5207 26.3855 35.0761 23.9688 35.0761C23.5891 35.0761 19.5498 37.6064 19.5498 38.1618C19.5498 38.3058 20.8962 39.7184 21.2139 40.5549C21.6281 41.6452 22.0562 44.0727 22.5741 44.6898C24.1829 46.6098 34.4158 43.8669 37.3227 44.5664C37.3227 42.4407 41.1962 39.2247 41.4103 38.0727C41.4448 37.8669 40.996 35.1789 40.8855 35.0761ZM34.3467 40.5892C32.9519 42.7355 23.3336 42.6669 24.9977 37.8189C26.4615 38.0727 34.326 37.4761 34.6643 37.8189C34.8507 38.0109 34.7127 40.0201 34.3467 40.5892Z" fill="#5B373B"/>
                        </svg>
                        <p class="txt">메밀 교</p>
                    </div>
                    <div class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="58" height="48" viewBox="0 0 58 48" fill="none">
                            <path d="M56.7506 39.7459C53.2292 41.515 34.4206 38.7036 32.8878 36.3379C30.9614 33.3619 42.2368 26.5048 32.073 24.8248C28.4756 24.2282 23.8564 26.347 24.9818 21.9242C33.7509 20.7448 42.0366 24.4682 50.7159 23.8168L55.3628 21.931C45.1161 19.9768 34.759 18.6876 24.2914 19.1745C23.1038 14.7516 28.0614 16.7539 31.5483 16.4385C39.6959 15.7048 29.4423 11.7002 25.6792 13.003C25.2166 10.2328 30.2709 12.1322 31.9695 11.9333C34.0409 11.6865 36.1261 9.06704 34.1928 8.20304C32.4804 7.43504 25.9761 7.13332 25.6654 6.83847C25.2995 6.49561 26.1418 2.3539 25.5687 1.45561C25.4168 1.22247 23.6423 0.694467 23.1797 0.68761C18.6018 0.571038 21.1842 5.74132 20.0311 6.72875C18.229 8.27847 11.414 5.83047 10.5992 11.4533C9.96397 15.8419 17.3659 10.9116 20.1347 12.331C22.358 14.107 14.4521 14.5459 13.9066 14.7036C12.2978 15.1768 9.37018 16.6922 10.8271 18.5025C12.6085 18.9345 21.9368 15.1219 19.4097 19.1265C18.9126 19.9082 2.36183 22.3905 1.4504 23.755C1.09135 24.2968 0.318033 26.3059 1.16041 26.731C2.61732 25.4419 19.5064 22.1642 19.458 23.6453C19.1059 24.2762 17.4625 27.2385 17.283 27.3619C16.7652 27.7116 15.0735 26.0453 14.2518 27.3893C13.658 28.363 14.3071 29.8305 13.2299 31.1745C11.5797 33.2248 1.33304 37.8396 0.925654 38.491C0.497559 39.1768 0.7047 41.7139 1.1397 42.5162C1.76113 43.6682 2.09945 42.7836 2.63802 42.6122C6.88445 41.2613 10.6614 37.675 13.9757 34.6442C14.6316 34.0476 15.4394 32.1619 15.6466 32.2168C18.3049 32.9093 22.3718 36.2007 25.6654 36.331C27.1154 38.2853 16.8204 43.2293 14.6178 41.8167L16.3371 47.275C19.3337 47.5082 27.288 40.0339 28.1787 39.8625C30.7404 39.3825 34.1445 44.4773 36.209 45.3962C37.6245 46.027 43.0447 47.0762 44.7364 47.2065C49.4523 47.5836 58.2697 45.8968 56.7299 39.7528L56.7506 39.7459ZM30.2433 28.8156C30.1535 29.323 29.2904 32.7448 29.1316 32.8888C28.2409 33.6705 21.8816 29.7413 20.1623 30.139C21.4811 23.7345 22.4685 28.5002 23.304 28.7059C24.4087 28.9802 30.7749 25.8396 30.2433 28.8225V28.8156Z" fill="#5B373B"/>
                        </svg>
                        <p class="txt">밀 맥</p>
                    </div>
                </div>
                <img class="page-logo" src="<?= $site_url ?>/img/page-logo2.png" />
                <p class="txt1 text34 font-style brown">
                    SBS &#60;생활의 달인&#62;에 소개된<br>
                        대한민국 명실상부 1등 소바 브랜드
                </p>
                <p class="text20">
                    광고 없이 100호점까지 성장한 검증된 브랜드가<br>
                    이제 본격적인 가맹 모집을 시작합니다.
                </p>
            </div>
            <div class="right-wrap">
                <img class="video" src="<?= $site_url ?>/img/page2-video.png" />
                <img class="talk" src="<?= $site_url ?>/img/page2-talk.png" />
                <div class="youtube-wrap" onclick="window.open('https://www.youtube.com/@samdong-soba')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="22" viewBox="0 0 32 22" fill="none">
                        <path d="M15.582 0C18.4193 0 26.9316 0.239258 26.9316 0.239258C29.1293 0.239424 30.9287 2.05366 30.9287 4.27148C30.9293 4.28396 31.166 9.31366 31.166 11.001C31.166 12.6848 30.9304 17.694 30.9287 17.7295C30.9287 19.9462 29.1304 21.7616 26.9316 21.7617L26.9326 21.7607C26.9326 21.7607 18.4216 22 15.584 22C12.7468 22 4.23438 21.7607 4.23438 21.7607C2.03673 21.7606 0.237305 19.9463 0.237305 17.7285C0.236696 17.7156 0 12.6817 0 10.999C3.8058e-05 9.31974 0.235635 4.30597 0.237305 4.27051C0.236173 2.05379 2.03455 0.239357 4.2334 0.239258C4.2334 0.239258 12.7444 2.40807e-05 15.582 0ZM12.5977 15.916L20.4727 10.999L12.5977 6.08398V15.916Z" fill="#5B373B"/>
                    </svg>
                    삼동소바 브랜드 유튜브 채널
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 0C18.6274 0 24 5.37258 24 12C24 18.6274 18.6274 24 12 24C5.37258 24 0 18.6274 0 12C0 5.37258 5.37258 0 12 0ZM8.98828 7.41211C8.43631 7.41225 7.98859 7.86018 7.98828 8.41211C7.98828 8.96431 8.43612 9.41197 8.98828 9.41211H13.459L7.13379 15.7373C6.74334 16.1278 6.74349 16.7608 7.13379 17.1514C7.52431 17.5419 8.15733 17.5419 8.54785 17.1514L14.873 10.8262V15.2969C14.873 15.8491 15.3208 16.2968 15.873 16.2969C16.4252 16.2967 16.873 15.8491 16.873 15.2969V8.41211C16.8727 7.86018 16.425 7.41225 15.873 7.41211H8.98828Z" fill="#5B373B"/>
                    </svg>
                </div>
                <img class="back" src="<?= $site_url ?>/img/page2-back.png" />
            </div>
        </div>
    </div>
    <div class="page3 p120 mask">
        <img class="tit-deco" src="<?= $site_url ?>/img/tit-deco.png" />
        <p class="text28 tit1">대한민국 No.1 소바 브랜드가 제안하는 자산 증식의 새로운 기준</p>
        <p class="text72 tit2">
            상위 20% 매장 <span class="red">평균 매출</span> <span class="white line-animation line-animation1">1억 8천</span><br>
            <span class="red">평균 순수익</span> <span class="white line-animation line-animation1">7천만원</span>
        </p>

        <div class="slide-container">
            <div class="store-slide-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img class="img" src="<?= $site_url ?>/img/store-sldie1.png" />
                        <div class="info-box">
                            <span class="txt1">판교점</span>
                            <span class="txt2">테이블 nn개</span>
                            <span class="dv">|</span>
                            <span class="txt2">월매출 1억 n천만원</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="img" src="<?= $site_url ?>/img/store-sldie2.png" />
                        <div class="info-box">
                            <span class="txt1">숙주점</span>
                            <span class="txt2">테이블 nn개</span>
                            <span class="dv">|</span>
                            <span class="txt2">월매출 1억 n천만원</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="img" src="<?= $site_url ?>/img/store-sldie3.png" />
                        <div class="info-box">
                            <span class="txt1">수지점</span>
                            <span class="txt2">테이블 nn개</span>
                            <span class="dv">|</span>
                            <span class="txt2">월매출 1억 n천만원</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="img" src="<?= $site_url ?>/img/store-sldie4.png" />
                        <div class="info-box">
                            <span class="txt1">백운호수점</span>
                            <span class="txt2">테이블 nn개</span>
                            <span class="dv">|</span>
                            <span class="txt2">월매출 1억 n천만원</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navi-wrap">
                <div class="prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0574 7.05752C19.5781 6.53682 20.4224 6.53682 20.9431 7.05752C21.4633 7.57813 21.4634 8.42169 20.9431 8.94228L13.8855 15.9999L20.9431 23.0575L21.034 23.1591C21.4608 23.6826 21.4309 24.4542 20.9431 24.9423C20.4551 25.4304 19.6827 25.461 19.159 25.0341L19.0574 24.9423L11.0574 16.9423C10.5368 16.4216 10.5369 15.5782 11.0574 15.0575L19.0574 7.05752Z" fill="#5B373B" fill-opacity="0.75"/>
                    </svg>
                </div>
                <div class="next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0574 7.05752C11.5781 6.53682 12.4224 6.53682 12.9431 7.05752L20.9431 15.0575C21.4633 15.5781 21.4634 16.4217 20.9431 16.9423L12.9431 24.9423C12.4224 25.463 11.5781 25.463 11.0574 24.9423C10.5368 24.4216 10.5369 23.5782 11.0574 23.0575L18.115 15.9999L11.0574 8.94228C10.5368 8.42162 10.5369 7.5782 11.0574 7.05752Z" fill="#5B373B" fill-opacity="0.75"/>
                    </svg>
                </div>
            </div>
        </div>


    </div>
</div>

<div id="contact">
    <div class="contact-container">
        <div class="contact-left">
            <div class="contact-left-div">
                <img src="img/head-logo.png" alt="삼동소바" class="contact-logo">
                <p class="text72 w">창업문의</p>
            </div>
            <div class="contact-left-txt">
                부동산 가치 분석이 포함된 삼동소바 창업 컨설팅을 신청하세요.<br>
                영업일 기준 2-3일 내에 삼동소바 창업컨설턴트가 연락을 드립니다.
            </div>
        </div>
        <form class="contact-form" name="contact_form" id="contact_form" method="post" action="contact_write.php" data-aos="fade-up" data-aos-duration="800">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-1">
            <input type="hidden" name="writer_ip" value="<?= get_client_ip() ?>" />
            <input type="hidden" name="adCode" value="<?= $adCode ?>" />
            <input type="hidden" name="flow" value="<?= $flow ?>" />
            <input type="hidden" name="client_key" value="<?= $client_key ?>" />
            <input type="hidden" name="stay_time" id="stay_time" value="0" />

            <div class="contact-inner">
                <div class="flex-input">
                    <div class="item">
                        <div class="label">
                            <label for="name">성함</label>
                        </div>
                        <div class="input">
                            <input type="text" id="name" name="name" placeholder="성함" required>
                        </div>
                    </div>
                    <div class="item">
                        <div class="label">
                            <label for="phone">연락처</label>
                        </div>
                        <div class="input">
                            <input type="tel" name="phone" id="phone-input" placeholder="연락처" required maxlength="11" inputmode="numeric">
                        </div>
                    </div>
                </div>
                <div class="flex-input">
                    <div class="item">
                        <div class="label">
                            <label for="location">창업 희망 지역</label>
                        </div>
                        <div class="input">
                            <input type="text" id="location" name="location" placeholder="창업 희망 지역" required>
                        </div>
                    </div>
                    <div class="item">
                        <div class="label">
                            <label for="sort">창업형태</label>
                        </div>
                        <div class="s-btn-wrap">
                            <input type="hidden" name="sort" value="신규 창업">
                            <div class="form-tab s-tab have">
                                <span>신규 창업</span>
                            </div>
                            <div class="form-tab s-tab">
                                <span>업종 변경</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="label">
                        <label for="phone">문의내용(선택)</label>
                    </div>
                    <div class="input">
                        <textarea name="contact_desc" id="contact_desc" placeholder="문의 내용을 작성해주세요"></textarea>
                    </div>
                </div>
                <div class="form-wrap">
                    <div class="agree-wrap">
                        <label class="checkbox-label">
                            <input class="round-checkbox" type="checkbox" id="agree" name="agree" required>
                        </label>
                        <label for="agree" class="agree"><span class="agree-open">개인정보취급방침(보기)</span> 동의</label>
                    </div>
                    <input type="submit" value="문의하기" class="c-btn">
                </div>
            </div>
        </form>

    </div>
</div>


<script type="text/javascript">

    AOS.init();

    // 팝업 이동 - 새 창
    function handleClick(url) {
        if (url) {
            window.open(url, '_blank');
        }
    }

    var store = new Swiper(".store-slide-container", {
        slidesPerView: '1',
        loop: true,
        spaceBetween: 0,
        observer: true,
        observeParents: true,
        loopAdditionalSlides : 1,
        autoHeight: true,
        autoplay: {
            delay: 4000,
        },
        // centeredSlides: true,
        navigation: {
            nextEl: '.page3 .next',
            prevEl: '.page3 .prev',
        },
    });


    const phoneInput = document.getElementById('phone-input');

    phoneInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // 페이지 진입 시간 저장
    const pageEnterTime = Date.now();

    document.querySelector("#contact_form").addEventListener("submit", function(e) {
        e.preventDefault(); // 기본 제출 방지

        const phone = phoneInput.value.trim();

        if (!/^\d{11}$/.test(phone)) {
            alert('휴대폰 번호는 숫자 11자리로 입력해주세요.');
            e.preventDefault();
            phoneInput.focus();
            return false;
        }

        // 체류 시간 계산 (초 단위)
        const now = Date.now();
        const staySeconds = Math.floor((now - pageEnterTime) / 1000);

        document.getElementById('stay_time').value = staySeconds;

        // grecaptcha.ready(function () {
        //     grecaptcha.execute('', {action: 'contact_form'}).then(function(token) {
        //         document.getElementById('g-recaptcha-response-1').value = token;
        //         e.target.submit();
        //     });
        // });

        e.target.submit();

    });

</script>

<!--문자 알림-->
<script type="text/javascript">
    function setPhoneNumber(val) {
        var numList = val.split("-");
        document.smsForm.sphone1.value = numList[0];
        document.smsForm.sphone2.value = numList[1];
        if (numList[2] != undefined) {
            document.smsForm.sphone3.value = numList[2];
        }
    }
    function loadJSON() {
        var data_file = "message_send2.php";
        var http_request = new XMLHttpRequest();
        try {
            // Opera 8.0+, Firefox, Chrome, Safari
            http_request = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");

            } catch (e) {

                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Eror
                    alert("지원하지 않는브라우저!");
                    return false;
                }

            }
        }
        http_request.onreadystatechange = function () {
            if (http_request.readyState == 4) {
                // Javascript function JSON.parse to parse JSON data
                var jsonObj = JSON.parse(http_request.responseText);
                if (jsonObj['result'] == "Success") {
                    var aList = jsonObj['list'];
                    var selectHtml = "<select name=\"sendPhone\" onchange=\"setPhoneNumber(this.value)\">";
                    selectHtml += "<option value='' selected>발신번호를 선택해주세요</option>";
                    for (var i = 0; i < aList.length; i++) {
                        selectHtml += "<option value=\"" + aList[i] + "\">";
                        selectHtml += aList[i];
                        selectHtml += "</option>";
                    }
                    selectHtml += "</select>";
                    document.getElementById("sendPhoneList").innerHTML = selectHtml;
                }
            }
        }

        http_request.open("GET", data_file, true);
        http_request.send();
    }

</script>
<?php
include_once('tale.php');
?>
