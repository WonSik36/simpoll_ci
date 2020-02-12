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
input[type=radio]{
    display: inline;
}

input[type=submit] {
    height: 50px;
    padding: 10px;
    font-size: 18px;
    color : white;
    background-color: lightskyblue;
    border-radius: 5px;
    border :1px solid #ccc;
}

input[type=submit]:hover{
    cursor: pointer;
}

    </style>
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
<!-- navigation -->
<?php include 'head.php';?>

<!-- contents -->
<div class="col-12 col-m-12 col-s-12">
    <form action="register" method="post">
        <h1>새로운 방 개설</h1>

        <!-- poll title -->
        <div>
        <h3>방 제목</h3>
            <label for="title"><input type="text" id="title" name="title" required></label>
        </div>

        <!-- poll create authority -->
        <div>
        <h3>Simpoll 생성 권한</h3>
            <label for="c_auth_0"><input type="radio" id="vote_create_auth_0" name="vote_create_auth" value="0" checked> 방장만</label>
            <label for="c_auth_1"><input type="radio" id="vote_create_auth_1" name="vote_create_auth" value="1"> 방 참여자 모두</label>
        </div>

        <!-- nickname or name check -->
        <div>
        <h3>참여자 실명/닉네임 여부</h3>
            <label for="nick_check_0"><input type="radio" id="user_name_type_0" name="user_name_type" value="0" checked> 실명</label>
            <label for="nick_check_1"><input type="radio" id="user_name_type_1" name="user_name_type" value="1"> 닉네임</label>

        <br>
        </div>

        <!-- deadline check -->
        <div style="margin-block-start: 1em; margin-block-end: 1em;">
        <h3 style="display: inline;">마감 날짜 설정 여부</h3>
        <input type="checkbox" name="deadline_check" value="1" onclick="deadlineChecked(this)">
        </div>

        <!-- deadline -->
        <!-- if deadline is checked than it appears -->
        <div id="dead_div" style="visibility: hidden;">
          <h3>마감 날짜</h3>
          <label for="deadline"><input type="date" id="deadline" name="deadline"></label>
        </div>

        <br><br><br>

        <input class="col-4 col-m-6 col-s-12" type="submit" value="방 생성">
    </form>

    <script>

      function deadlineChecked(checkbox){
        let deadlineDiv = document.getElementById("dead_div");

        if(checkbox.checked)
          deadlineDiv.style.visibility = "visible";
        else
        deadlineDiv.style.visibility = "hidden";
      }

    </script>
</div>
</body>
</html>
