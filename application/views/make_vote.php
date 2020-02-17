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
            button.attr-btn {
                font-size: 20px;
                margin: 5px;
                border-radius: 5px;
                background-color: #eee;
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
        <link rel="stylesheet" href="/static/css/style.css">
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
                        <form action="/index.php/vote/make_vote" method="post">
                            <p style="font-size: 25px;">Simpoll 생성</p>
                            <!-- title -->
                            <p>Simpoll name</p>
                            <input type="text" name="title" placeholder="Simpoll 이름을 입력하세요." required>

                            <!-- title -->
                            <p>URL 설정</p>
                            <input type="text" name="url_name" placeholder="URL을 입력하세요" required>

                            <!-- add choice -->
                            <p id="add_option">add option</p>
                            <button type="button" class="attr-btn" id="addButton" onclick="addOption()">
                                <i class="fas fa-plus"></i>
                            </button><br>

                            <!-- choice list -->
                            <div id="choice-list">
                                <div id="cho_div_0">
                                    <input class="answer_inputForm" type="text" name="content_0" placeholder="항목을 입력하세요." required>
                                    <button type="button" class="delButton attr-btn" onclick="delOption(0)">
                                        <i class="fas fa-minus"></i>
                                    </button><br>
                                </div>
                                <div id="cho_div_1">
                                    <input class="answer_inputForm" type="text" name="content_1" placeholder="항목을 입력하세요." required>
                                    <button type="button" class="delButton attr-btn" onclick="delOption(1)">
                                        <i class="fas fa-minus"></i>
                                    </button><br>
                                </div>
                            </div>

                            <table>
                                <!-- comment_check: check comment -->
                                <tr>
                                    <td class="align-left">Comment 생성</td>
                                    <td><input type="checkbox" name="comment_check" value="1"></td>
                                </tr>
                                <!-- anonymous_check: check anonymous -->
                                <tr>
                                    <td class="align-left">익명 투표</td>
                                    <td><input type="checkbox" name="anonymous_check" value="1"></td>
                                </tr>
                                <!-- vote_type: vote type -->
                                <tr>
                                    <td class="align-left">복수 선택</td>
                                    <td><input type="checkbox" name="vote_type" value="1"></td>
                                </tr>
                            </table>

                            <!-- part_auth: participation authority -->
                            <p id="add_option">참여 권한</p>
                            <input type="radio" name="part_auth" value="0" checked="checked"> 방 참여자만<br>
                            <input type="radio" name="part_auth" value="1"> 링크를 가진 누구나<br>

                            <!-- deadline -->
                            <p id="add_option">마감시간</p><input type="date" name="vote_end_date" value="vote_end_date" required>
                            <input type="time" name="vote_end_time" value="vote_end_time" required><br>

                            <!-- room_sid -->
                            <input type="hidden" name="room_id" value="<?=$room['sid']?>">

                            <!-- choice count -->
                            <input type="hidden" id="cho_cnt" name="cho_cnt" value="2">

                            <!-- buttons -->
                            <div id="submit">
                                <ul class="submit">
                                    <!-- go back page button -->
                                    <li>
                                        <button id="back" onclick="goBack()">CANCEL</button>
                                    </li>

                                    <!-- submit button -->
                                    <li class="right">
                                        <input type="submit" value="submit">
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- for copy choice -->
        <!-- div.id, div.style, input.name, button.onclick should be changed-->
        <div id="cho_div_" style="display: none;">
            <input class="answer_inputForm" type="text" name="content_" placeholder="항목을 입력하세요." required>
            <button type="button" class="delButton attr-btn" onclick="delOption()">
                <i class="fas fa-minus"></i>
            </button><br>
        </div>

        <script>
            var numOfChoice = 2;
            var choice_count = document.getElementById("cho_cnt");
            var choice_template = document.getElementById("cho_div_"); 
            var choice_list = document.getElementById("choice-list");

            function addOption(){
                let node = choice_template.cloneNode(true);
                node.style.display = "block";
                node.setAttribute('id','cho_div_'+numOfChoice);
                node.getElementsByClassName("answer_inputForm")[0].setAttribute('name',"content_"+numOfChoice);
                node.getElementsByTagName("button")[0].setAttribute('onclick',"delOption("+numOfChoice+")");

                choice_list.appendChild(node);

                numOfChoice++;
                choice_count.value = String(numOfChoice);
            }

            function delOption(idx){
                document.getElementById('cho_div_'+idx).remove();
            }

            function goBack(){
                history.back();
            }

        </script>
    </body>
</html>