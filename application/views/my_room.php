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

            .contents {
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
        <?php include 'head.php';?>

        <!-- contents -->
        <!-- 방 정보 표시창 -->
        <div class="contents">
            <!-- room title, code, duration, and update button -->
            <div id="room-header" class="col-12 col-m-12 col-s-12">
                <!-- room title -->
                <div id="room-title" class="col-2 col-m-2 col-s-6">
                    <?=$room['title']?>
                </div>
                <!-- room code -->
                <div id="room-code" class="col-2 col-m-2 col-s-6">
                    <?=$room['room_id']?>
                </div>
                <!-- room duration -->
                <div id="room-dur" class="col-5 col-m-5 col-s-12">
<?php
    // 마감 날짜가 있는 경우
    if($room['deadline_check'] == 1){
?>
                    마감 날짜: ~<?=$room['deadline']?>
                    <?php
    }
?>
                </div>
                <!-- room update button -->
                <div id="room-update" class="col-3 col-m-3 col-s-12 align-right">
                    <a href="#">
                        <button id="update-btn">수정</button>
                    </a>
                </div>
                <!-- link to participant page -->
                <div id="room-update" class="col-3 col-m-3 col-s-12 align-right">
                    <a href="#">
                        <button id="update-btn">Simpoll 하러 가기</button>
                    </a>
                </div>
            </div>
            
            <!-- 투표 정보 표시창 -->
<?php
    if(empty($list)){
?>
            <!-- 아직 방에 투표가 없는 경우 -->
            <div id="roomList">
                <p>아직 simpoll이 없네요. 새로운 simpoll을 만들어보세요~</p>
                <a href="make_vote.html">
                    <i class="far fa-plus-square"></i>
                </a>
            </div>
<?php  
  }
?>

<?php
    foreach($list as $vote){
?>
        <!-- 투표가 있는 경우 -->
        <?php include 'vote.php';?>
<?php
    }
?>
        </div>
        <!-- contents end -->
    </body>

    <!-- vote add button -->
    <div id="add-button" class="align-center">
        <span>
            <a href="make_vote01.html">
                <i class="fas fa-plus" style="color:white"></i>
            </a>
        </span>
    </div>
</html>