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
ul.topnav li a{
  display: block;
  text-align: center;
  padding: 18px 16px;
  text-decoration: none;
}
span.title{
  display: inline-block;
  font-size: 20px;
  padding: 16px 16px;
}
a:link{
  text-decoration: none;
  color: #595959;
}
a:visited{
  text-decoration: none;
  color: #595959;
}
i {
  color: #ccc;
  padding: 10px 0px;
  font-size: 30px;
}
a.nickname {
  float: right;
}
ul.topnav li a.nickname {
  padding: 18px 0px;
}
li#info {
  display: block;
  text-align: center;
  text-decoration: none;
  padding: 18px 5px;
  color: #595959;
}
@media screen and (max-width: 600px) {
span.title {text-align: center; display:block;}
ul.topnav li.right {float: none;}
ul.topnav li {float: none;}
ul.topnav{float: none;}
ul.topnav #info, ul.topnav #icon{display: none;}
}

/* contents */
#list_left{
  height: 1000px;
}
#list_right{
  height: 1000px;
}
.roomTitle {
  padding-left: 15px;
  float: left;
}
.roomCode {
  padding: 10px 15px;
  display: inline-block;
  overflow: auto;
}
#makeVote {
  text-align: center;
  margin: 0px 10%;
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
input[type=submit] {
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
  padding: 20px 0px;
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
.fa-plus, .fa-minus {
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
  ul li.right {float: none;}
  ul li {float: none;}
  ul{float: none;}
}
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- navigation -->
<?php include 'head.php';?>

<!-- contents -->
<div class="col-12">
<div class="contents">
  <div id="roomInfo">
    <span class="roomTitle"> <h2>방 01</h2></span>
    <span class="roomCode"><h3>#ABCD</h3></span>
  </div>
  <div id="makeVote">
    <div id="poll_info">
      <form name="myForm" action="list_poll01.html"
      onsubmit="return onsubmiT()"method="post">
      <p style="font-size: 25px;">Simpoll 생성</p>
      <p>Simpoll name</p>
      <input type="text" name="pollName" placeholder="투표 제목을 입력하세요." equired>
      <p>question</p>
      <input type="text" name="question" placeholder="질문을 입력하세요." required>
      <p id="add_option">add option</p><button type="button" class="addButton" onclick="addOption()"><i class="fas fa-plus"></i></button><br>
      <input class="answer_inputForm" type="text" name="Answer01" placeholder="항목을 입력하세요." required><button type="button" class="delButton" onclick="delOption()"><i class="fas fa-minus"></i></button><br>
      <input class="answer_inputForm" type="text" name="Answer02" placeholder="항목을 입력하세요." required><button type="button" class="delButton" onclick="delOption()"><i class="fas fa-minus"></i></button><br>
      <table>
      <tr><td class="align-left">Comment 생성</td><td><input type="checkbox" name="have_comment" value="comment"></td></tr>
      <tr><td class="align-left">익명 투표</td><td><input type="checkbox" name="have_comment" value="comment"></td></tr>
      <tr><td class="align-left">복수 선택</td><td><input type="checkbox" name="have_comment" value="comment"></td></tr>
      </table>
      <p id="add_option">참여 권한</p>
      <input type="radio" name="participants" value="room_user" checked> 방 참여자만<br>
      <input type="radio" name="participants" value="every_one"> 아무나<br>
      <p id="add_option">마감시간</p><input type="date" name="vote_end_date" value="vote_end_date"> <input type="time" name="vote_end_time" value="vote_end_time"><br>
      <div id="submit">
        <ul class="submit">
          <li><a href="#">CANCEL</a></li>
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
</script>
</body>
</html>
