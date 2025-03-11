<?php
include_once('./head.php');
include_once('./default.php');



// 전체 조회수
$total_view_sql = "SELECT COUNT(view_cnt) FROM view_log_tbl";
$total_view_stt=$db_conn->prepare($total_view_sql);
$total_view_stt->execute();
$total_view = $total_view_stt -> fetch();
// 전체 문의건수
$total_contact_sql = "SELECT COUNT(contact_cnt) FROM contact_log_tbl";
$total_contact_stt=$db_conn->prepare($total_contact_sql);
$total_contact_stt->execute();
$total_contact = $total_contact_stt -> fetch();
// 전체 진행자 수
$total_processing_sql = "SELECT COUNT(id) FROM contact_tbl where result_status like '%진행%'";
$total_processing_stt=$db_conn->prepare($total_processing_sql);
$total_processing_stt->execute();
$total_processing = $total_processing_stt -> fetch();
// 전체 완료자 수
$total_finish_sql = "SELECT COUNT(id) FROM contact_tbl where result_status like '%완료%'";
$total_finish_stt=$db_conn->prepare($total_finish_sql);
$total_finish_stt->execute();
$total_finish = $total_finish_stt -> fetch();
// 오늘 조회수
$today_view_sql = "SELECT COUNT(view_cnt) FROM view_log_tbl WHERE DATE(reg_date) = DATE(NOW());";
$today_view_stt=$db_conn->prepare($today_view_sql);
$today_view_stt->execute();
$today_view = $today_view_stt -> fetch();
// 오늘 문의건수
$today_contact_sql = "SELECT COUNT(contact_cnt) FROM contact_log_tbl WHERE DATE(reg_date) = DATE(NOW())";
$today_contact_stt=$db_conn->prepare($today_contact_sql);
$today_contact_stt->execute();
$today_contact = $today_contact_stt -> fetch();
// 오늘 진행자 수
$today_processing_sql = "SELECT COUNT(id) FROM contact_tbl where result_status like '%진행%' AND DATE(write_date) = DATE(NOW())";
$today_processing_stt=$db_conn->prepare($today_processing_sql);
$today_processing_stt->execute();
$today_processing = $today_processing_stt -> fetch();
// 오늘 완료자 수
$today_finish_sql = "SELECT COUNT(id) FROM contact_tbl where result_status like '%완료%' AND DATE(write_date) = DATE(NOW())";
$today_finish_stt=$db_conn->prepare($today_finish_sql);
$today_finish_stt->execute();
$today_finish = $today_finish_stt -> fetch();



//차트 관련
$stChart = date('Y-m-d', strtotime('-5 days'));
$edChart = date('Y-m-d');
$result = [];
foreach (range(strtotime($stChart), strtotime($edChart), 86400) as $timestamp) {
    $date = date('Y-m-d', $timestamp);
    $result[$date] = [
        'contact_count' => 0,
        'view_count' => 0
    ];
}

// 문의 건수 SQL
$search_contact_sql = "
    SELECT DATE(reg_date) AS log_date, COUNT(contact_cnt) AS contact_count
    FROM contact_log_tbl
    WHERE reg_date BETWEEN ? AND ?
    GROUP BY log_date
    ORDER BY log_date";
$search_contact_stt = $db_conn->prepare($search_contact_sql);
$search_contact_stt->execute([$stChart, $edChart]);
$contact_data = $search_contact_stt->fetchAll(PDO::FETCH_ASSOC);

// 조회수 SQL
$search_view_sql = "
    SELECT DATE(reg_date) AS log_date, COUNT(view_cnt) AS view_count
    FROM view_log_tbl
    WHERE reg_date BETWEEN ? AND ?
    GROUP BY log_date
    ORDER BY log_date";
$search_view_stt = $db_conn->prepare($search_view_sql);
$search_view_stt->execute([$stChart, $edChart]);
$view_data = $search_view_stt->fetchAll(PDO::FETCH_ASSOC);

// 데이터 병합
foreach ($contact_data as $row) {
    $result[$row['log_date']]['contact_count'] = $row['contact_count'];
}
foreach ($view_data as $row) {
    $result[$row['log_date']]['view_count'] = $row['view_count'];
}

// 차트에 사용할 데이터 준비
$dates = array_keys($result); // 날짜 리스트
$contact_counts = array_column($result, 'contact_count'); // 문의 건수 리스트
$view_counts = array_column($result, 'view_count'); // 조회수 리스트

?>

<link rel="stylesheet" type="text/css" href="<?= $site_url ?>/css/board_list.css" rel="stylesheet" />

<div class="page-header">
    <h4 class="page-title">
        홈
    </h4>
</div>

<div class="log-container">
    <span class="tit">Today</span>
    <div class="status-wrap first">
        <div class="item">
            <p class="label">방문자 수</p>
            <p class="val"><?=number_format($today_view[0])?></p>
        </div>
        <div class="item">
            <p class="label">문의건 수</p>
            <p class="val"><?=number_format($today_contact[0])?></p>
        </div>
        <div class="item">
            <p class="label">상담 진행 수</p>
            <p class="val"><?=number_format($today_processing[0])?></p>
        </div>
        <div class="item">
            <p class="label">상담 완료 수</p>
            <p class="val"><?=number_format($today_finish[0])?></p>
        </div>
    </div>

    <span class="tit" style="color: #999">Total</span>
    <div class="status-wrap second">
        <div class="item">
            <p class="label">방문자 수</p>
            <p class="val"><?=number_format($total_view[0])?></p>
        </div>
        <div class="item">
            <p class="label">문의건 수</p>
            <p class="val"><?=number_format($total_contact[0])?></p>
        </div>
        <div class="item">
            <p class="label">상담 진행 수</p>
            <p class="val"><?=number_format($total_processing[0])?></p>
        </div>
        <div class="item">
            <p class="label">상담 완료 수</p>
            <p class="val"><?=number_format($total_finish[0])?></p>
        </div>
    </div>
    <hr class="log-hr">
    <div class="chart-container">
        <span class="label">방문자 현황</span>
        <div id="chart"></div>
    </div>
    <span class="tit">선택조회</span>
    <div class="date-picker-container">
        <div class="date-picker">
            <input type="date" id="stDate" name="stDate" class="date-input">
            <span class="placeholder">시작일</span>
            <span class="calendar-icon"><i></i></span>
        </div>
        <div class="date-picker">
            <input type="date" id="endDate" name="endDate" class="date-input">
            <span class="placeholder">종료일</span>
            <span class="calendar-icon"><i></i></span>
        </div>
        <span id="search" class="search-btn">검색</span>
    </div>

    <div id="search-result">

    </div>
</div>
<!-- page-header end -->

<!-- box end -->
</div>
<!-- content-box-wrap end -->
<style>
    .list-thumb{
        width: 200px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>


    //차트 관련
    const categories = <?= json_encode($dates) ?>; // x축 날짜
    const contactData = <?= json_encode($contact_counts) ?>; // 문의 건수
    const viewData = <?= json_encode($view_counts) ?>; // 조회수

    // ApexCharts 옵션 설정
    var options = {
        chart: {
            type: 'area',
            height: 350
        },
        series: [
            {
                name: '문의 건수',
                data: contactData
            },
            {
                name: '조회수',
                data: viewData
            }
        ],
        xaxis: {
            categories: categories
        },
        colors: ['#85A6FA', '#4347F0'],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "vertical",
                opacityFrom: 0.4,
                opacityTo: 0
            }
        },
        dataLabels: {
            enabled: false
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();


    //선택조회
    $("#search").click(function (){
        var stDate = $("#stDate").val();
        var endDate = $("#endDate").val();
        $.ajax({
            type:'post',
            url:'./ajax/log_search_ajax.php',
            data:{stDate:stDate, endDate:endDate},
            success:function(html){
                $('#search-result').empty();
                $('#search-result').html(html);
            }
        });
    });
</script>

