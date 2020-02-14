<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
        <title>Simpoll</title>
        <style>
            /* navigation */
            body {
                margin: 0;
            }
            div.header {
                border-bottom: 1px solid #ccc;
            }
            ul.topnav {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                float: right;
            }
            ul.topnav li {
                float: left;
            }
            ul.topnav li a {
                display: block;
                text-align: center;
                padding: 18px 16px;
                text-decoration: none;
            }
            span.title {
                display: inline-block;
                font-size: 20px;
                padding: 16px;
            }
            a:link {
                text-decoration: none;
                color: #595959;
            }
            a:visited {
                text-decoration: none;
                color: #595959;
            }
            i {
                color: #ccc;
                padding: 10px 0;
                font-size: 30px;
            }
            a.nickname {
                float: right;
            }
            ul.topnav li a.nickname {
                padding: 18px 0;
            }
            li#info {
                display: block;
                text-align: center;
                text-decoration: none;
                padding: 18px 5px;
                color: #595959;
            }
            @media screen and (max-width: 600px) {
                span.title {
                    text-align: center;
                    display: block;
                }
                ul.topnav li.right {
                    float: none;
                }
                ul.topnav li {
                    float: none;
                }
                ul.topnav {
                    float: none;
                }
                ul.topnav #icon,
                ul.topnav #info {
                    display: none;
                }
            }

            /* contents */
            /* room title, code, duration, and update button */
            div#room-header {
                font-size: 1.5rem;
                font-weight: bold;
            }
            div#room-title {
                font-size: 2rem;
            }
            div#room-code {
                margin-top: 0.5rem;
            }
            div#room-dur {
                margin-top: 0.5rem;
            }
            div#room-update {
                margin-top: 0.5rem;
            }
            button#update-btn {
                font-size: 1rem;
                background-color: rgb(224, 224, 224);
                border: 1px solid grey;
                border-radius: 0.5rem;
            }
            button#update-btn:hover {
                cursor: pointer;
            }
            button#update-btn:active {
                background-color: grey;
            }

            #roomList {
                text-align: center;
                margin: 0 auto;
                padding-top: 200px;
            }

            /* list of vote */
            .vote-tab {
                background-color: #ff9999;
            }

            .vote_contents{
                background-color: #cccccc;
            }

            ul.vote-ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            ul.vote-ul li {
                float: left;
            }

            ul.vote-ul li {
                display: block;
                text-align: center;
                padding: 18px 16px;
                text-decoration: none;
            }

            ul.vote-ul li.right {
                float: right;
            }

            .fa-check-square {
                font-size: 40px;
            }

            .fa-thumbs-down,
            .fa-thumbs-up {
                font-size: 30px;
            }

            .check_icon {
                margin: 0 20px;
            }

            .title {
                margin: 0 20px;
            }

            #submit {
                border-top: 1px solid #ccc;
                margin: 10px;
            }

            ul.submit-ul li {
                float: left;
            }

            ul.submit-ul li.right {
                float: right;
            }

            ul.submit-ul li a {
                display: block;
                text-align: center;
                padding: 15px 60px;
                text-decoration: none;
            }

            ul.submit-ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .vote-contents {
                background-color: #eee;
                padding-top: 10px;
            }

            .vote {
                padding-left: 20px;
            }

            /* vote add button */
            div#add-button {
                position: absolute;
                bottom: 3rem;
                right: 2rem;
                width: 5rem;
                height: 5rem;
                border-radius: 2.5rem;
                font-size: 3rem;
                font-weight: bold;
                background-color: #aefc9d;
                vertical-align: middle;
                cursor: pointer;
            }
        </style>
        <link rel="stylesheet" href="/static/css/style.css">
    </head>
    <body>
        <!-- navigation -->
        <?php include 'component/head.php';?>

        <!-- room info and vote list -->
        <div>
            <!-- 방 정보 표시창 -->
            <?php include 'component/room_head.php';?>

            <!-- 투표 필터링 -->
            <div class="col-12 col-m-12 col-s-12"  style="border-top: 1px solid black; border-bottom: 1px solid black;">
            <h3>검색</h3>
            <input type="text" placeholder="검색어를 입력해주세요.">

            <br><br><br>

            <h3>정렬</h3>
            <button class="filter">시간순</button>
            <button class="filter">투표제목순</button>
        </div>

            <!-- 투표 정보 표시창 -->

<?php
    // 투표가 없는 경우
    if(empty($list)){
?>
        <?php include 'component/empty_vote.php';?>

<?php
    //투표가 있는 경우
    }else{
        echo "<!-- list of vote -->\n";
        echo "<div class='col-12'>\n";

        $idx = 0;
        foreach($list as $vote){
?>
        <?php include 'component/vote.php';?>
<?php
            $idx++;
        }
        echo "</div>\n";
    }
?>
        </div>
        <!-- room info and vote list end -->
    </body>

    <!-- vote add button -->
    <div id="add-button" class="align-center">
        <span>
            <a href="#">
                <i class="fas fa-plus" style="color:white"></i>
            </a>
        </span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var vList = new Array();

        function toggleVoteContents(sid){
            var voteResult = document.getElementById("v_con_"+sid);
            var dis = voteResult.style.display;
            if(dis=="none"){
                voteResult.style.display = "block";
                getVoteResult(sid);
            }else
                voteResult.style.display = "none";
        }

        class Vote{
            constructor(colArr ,resArr){
                this.columnArray = colArr;
                this.resultArray = resArr;
            }
        }

        function getVoteResult(sid){
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    // let res = JSON.parse(this.responseText);
                    // updateVoteResult(res);           
                }
            };
            xhttp.open("GET", "ajax_info.txt", true);
            xhttp.send();
        }

        function updateVoteResult(res){
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: res.label,
                    datasets: [{
                        label: '# of Votes',
                        data: res.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    </script>
</html>
