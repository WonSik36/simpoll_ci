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
/* room title, code, duration, and update button */
div#room-header{
    font-size: 1.5rem;
    font-weight: bold;
}
div#room-title{
    font-size: 2rem;
}
div#room-code{
    margin-top: 0.5rem;
}
div#room-dur{
    margin-top: 0.5rem;
}
div#room-update{
    margin-top: 0.5rem;
}
button#update-btn{
    font-size: 1rem;
    background-color: rgb(224, 224, 224);
    border: 1px solid grey;
    border-radius: 0.5rem;
}
button#update-btn:hover{
    cursor: pointer;
}
button#update-btn:active{
    background-color: grey;
}




#roomList {
  text-align: center;
  margin: 0px auto;
  padding-top: 200px;
}
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- navigation -->
<?php include 'head.php';?>

<!-- contents -->
<div class="contents">
  <!-- room title, code, duration, and update button -->
  <div id="room-header" class="col-12 col-m-12 col-s-12">
      <!-- room title -->
      <div id="room-title" class="col-2 col-m-2 col-s-6">
        방01
      </div>
      <!-- room code -->
      <div id="room-code" class="col-2 col-m-2 col-s-6">
        #ABCD
      </div>
      <!-- room duration -->
      <div id="room-dur" class="col-5 col-m-5 col-s-12">
        기간: 2020.02.04~2020.02.06
      </div>
      <!-- room update button -->
      <div id="room-update" class="col-3 col-m-3 col-s-12 align-right">
          <a href="room_edit.html"><button id="update-btn">수정</button></a>
      </div>
  </div>


  <div id="roomList">
    <p>아직 simpoll이 없네요. 새로운 simpoll을 만들어보세요~</p>
    <a href="make_vote.html"><i class="far fa-plus-square"></i></a>
  </div>
</div>
</body>
</html>
