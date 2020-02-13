<!DOCTYPE html>
<html lang="en">
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
            #list_left {
                height: 1000px;
                border-right: 1px solid grey;
            }
            #list_right {
                height: 1000px;
            }
            input[type=text] {
                width: 100%;
                height: 50px;
                margin: 5px;
                padding: 10px;
                font-size: 18px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            button:hover {
                cursor: pointer;
            }

            button.filter {
                width: 80px;
                height: 50px;
                margin: 5px;
                font-size: 15px;
                color: white;
                background-color: grey;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            button.pair-btn {
                position: relative;
                bottom: -3.5rem;
                width: 4rem;
                height: 2rem;
                font-size: 15px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            button.btn-del {
                color: white;
                background-color: rgb(231, 76, 60);
            }
            button.btn-go {
                color: white;
                background-color: rgb(52, 152, 219);
            }
            #nav-bar {
                padding: 0;
                color: #595959;
                font-size: 16px;
                border-bottom: 1px solid #ccc;
            }
            .room {
                background-color: #f0f0f0;
                border-radius: 5px;
                border: 1px solid #ccc;
                margin: 10px;
                height: 150px;
            }
            .title {
                margin: 0;
                font-size: 18px;
                font-weight: 800;
                display: inline;
            }
            .tags {
                float: right;
            }
            .label {
                border-radius: 5px;
                border: 1px solid #ccc;
                margin-right: 1px;
                padding-left: 5px;
                padding-right: 5px;
                float: left;
            }
            .color-code {
                background-color: aquamarine;
            }
            .color-proc {
                background-color: rgb(243, 156, 18);
            }
        </style>
        <link rel="stylesheet" href="/static/css/style.css">
    </head>
    <body>
        <!-- navigation -->
        <?php include 'head.php';?>

        <!-- contents -->
        <!-- left side -->
        <div class="col-4 col-m-3 col-s-0" id="list_left">
            <h3>검색</h3>
            <input type="text" placeholder="검색어를 입력해주세요.">

            <br><br><br>

            <h3>필터</h3>
            <button class="filter">중요</button>
            <button class="filter">참여필요</button>
            <button class="filter">알림</button>
            <button class="filter">진행중</button>
            <button class="filter">종료</button>

            <br><br><br>

            <h3>정렬</h3>
            <button class="filter">시간순</button>
            <button class="filter">이름순</button>
            <button class="filter">좋아요순</button>
        </div>

        <!-- left side : mobile -->
        <div class="col-0 col-m-0 col-s-12" id="nav-bar">
            <div class="col-s-3"></div>
            <div class="col-s-6 align-center">검색</div>
            <div class="col-s-3 align-right">
                <a href="#">V</a>
            </div>
        </div>

        <!-- right side -->
        <div class="col-8 col-m-9 col-s-12" id="list_right">
            <div class="col-1"></div>
            <div class="col-10">

<?php
    foreach($list as $room){
?>
                <!-- top -->
                <div class="col-12 room">
                    <div class="title"><?=$room['title']?></div>
                    <div class="tags">
                        <div class="label color-code">#<?=$room['room_id']?></div>
                    </div>

                    <!-- left -->
                    <div class="col-5 col-m-5 col-s-5" style="clear: both;">
                        <div class="title">
                            방장: <?=$room['master_nickname']?>
                            <br>
                            참여인원: <?=$room['part_num']?>명
                        </div>
                    </div>

                    <!-- mid -->
                    <div class="col-4 col-m-4 col-s-4">
<?php
if($room['deadline_check']==1){
?>
                        <div class="title">
                            마감 날짜:
                            <br>
                            ~
<?php
                            $time = $room['deadline'];
                            $dateString = date("Y-m-d", strtotime($time));
                            echo $dateString;
?>
                        </div>
<?php
}
?>
                    </div>

                    <!-- right -->
                    <div class="col-3 col-m-3 col-s-3 align-right btn-holder" style="height: 100%;">
                        <a href="">
                            <button class="btn-del pair-btn">삭제</button>
                        </a>
                        <a href="list_poll01.html">
                            <button class="btn-go pair-btn">이동</button>
                        </a>
                    </div>
                </div>
<?php
    }
?>

            </div>
            <div class="col-1"></div>
        </div>

    </body>
</html>
