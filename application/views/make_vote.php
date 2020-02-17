<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
        <title>Simpoll</title>
        <style>
            /* contents */
            #list_left {
                height: 1000px;
            }
            #list_right {
                height: 1000px;
            }
            .roomTitle {
                padding-left: 15px;
                float: left;
            }
            .roomUrl {
                padding: 10px 15px;
                display: inline-block;
                overflow: auto;
            }
            #makeVote {
                text-align: center;
                margin: 0 10%;
                border: 1px solid #ccc;
            }
            #submit {
                border-top: 1px solid #ccc;
                margin: 10px;
            }
            ul.submit li {
                float: left;
            }
            ul.submit li.right {
                float: right;

            }
            input[type=submit], #back {
                display: block;
                text-align: center;
                padding: 15px 60px;
                text-decoration: none;
                color: #00e6b8;
            }
            ul.submit li a {
                display: block;
                text-align: center;
                padding: 15px 60px;
                text-decoration: none;
            }
            ul.submit {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .pollchoice {
                padding-bottom: 200px;
            }
            button {
                font-size: 20px;
                margin: 5px;
                border-radius: 5px;
                background-color: #eee;
            }
            #poll_info {
                padding: 20px 0;
            }
            #poll_info p {
                font-size: 15px;
            }
            input[type=text] {
                font-size: 20px;
                border: 1px solid #fff;
                border-bottom: 1px solid black;
                width: 40%;
            }
            .answer {
                color: #00e6b8;
            }
            .fa-minus,
            .fa-plus {
                font-size: 25px;
                color: black;
                padding: 0;
            }
            p#add_option {
                width: 20%;
                margin: 10px auto;
                text-align: center;
                font-size: 20px;
            }
            table {
                margin: 10px auto;
            }
            input.answer_inputForm {
                border-bottom: 2px solid #00e6b8;
            }
            button {
                background-color: #fff;
            }
            @media screen and (max-width: 600px) {
                ul li.right {
                    float: none;
                }
                ul li {
                    float: none;
                }
                ul {
                    float: none;
                }
            }
        </style>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- navigation -->
        <?php include 'component/head.php';?>

        <!-- contents -->
        <div class="col-12">
            <div class="contents">
                <div id="roomInfo">
                    <span class="roomTitle">
                        <h2><?=$room['title']?></h2>
                    </span>
                    <span class="roomUrl">
                        <h3>URL: <?=$room['title']?></h3>
                    </span>
                </div>
                <div id="makeVote">
                    <div id="poll_info">
                        <form
                            name="myForm"
                            action="list_poll01.html"
                            onsubmit="return onsubmiT()"
                            method="post">
                            <p style="font-size: 25px;">Simpoll 생성</p>
                            <p>Simpoll name</p>
                            <input
                                type="text"
                                name="pollName"
                                placeholder="투표 제목을 입력하세요."
                                equired="equired">
                            <p>question</p>
                            <input type="text" name="question" placeholder="질문을 입력하세요." required="required">
                            <p id="add_option">add option</p>
                            <button type="button" class="addButton" onclick="addOption()">
                                <i class="fas fa-plus"></i>
                            </button><br>
                            <input
                                class="answer_inputForm"
                                type="text"
                                name="Answer01"
                                placeholder="항목을 입력하세요."
                                required="required">
                            <button type="button" class="delButton" onclick="delOption()">
                                <i class="fas fa-minus"></i>
                            </button><br>
                            <input
                                class="answer_inputForm"
                                type="text"
                                name="Answer02"
                                placeholder="항목을 입력하세요."
                                required="required">
                            <button type="button" class="delButton" onclick="delOption()">
                                <i class="fas fa-minus"></i>
                            </button><br>
                            <table>
                                <tr>
                                    <td class="align-left">Comment 생성</td>
                                    <td><input type="checkbox" name="have_comment" value="comment"></td>
                                </tr>
                                <tr>
                                    <td class="align-left">익명 투표</td>
                                    <td><input type="checkbox" name="have_comment" value="comment"></td>
                                </tr>
                                <tr>
                                    <td class="align-left">복수 선택</td>
                                    <td><input type="checkbox" name="have_comment" value="comment"></td>
                                </tr>
                            </table>
                            <p id="add_option">참여 권한</p>
                            <input type="radio" name="participants" value="0" checked="checked">
                            방 참여자만<br>
                            <input type="radio" name="participants" value="1">
                            아무나<br>
                            <p id="add_option">마감시간</p><input type="date" name="vote_end_date" value="vote_end_date">
                            <input type="time" name="vote_end_time" value="vote_end_time"><br>
                            <div id="submit">
                                <ul class="submit">
                                    <li>
                                        <button id="back" onclick="goBack()"></button>
                                        <a href="#">CANCEL</a>
                                    </li>
                                    <li class="right"><input type="submit" value="submit"></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- option 추가 삭제 -->
        <script>
            function goBack(){
                history.back();
            }

        </script>
    </body>
</html>