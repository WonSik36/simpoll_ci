<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simpoll</title>
    <style>
  /* navigation bar */
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
}
/* contents */
#index_left {
    height: 700px;
}

input[type=text] {
        width: 360px;
        height: 50px;
        padding: 10px;
        margin: 10px;
        font-size: 18px;
        border-radius: 5px;
        border :1px solid #ccc;
    }

input[type=submit]{
  width: 360px;
        height: 50px;
        padding: 10px;
        margin: 10px;
        font-size: 18px;
        color : white;
        background-color: lightgreen;
        border-radius: 5px;
        border :1px solid #ccc;
}

#index_right {
    background-image: url(https://lh5.googleusercontent.com/proxy/kcpvcO_9W2AkLaAa6_k6QboZMOiSMRckYgFBS2WAr5reAomizUQQwonqD0LABtHjUqselPSRvWGd2x62DIOmLJENeSmTuIvnMaFkb1EUzbNF4wmbFFuigeXJde03ztBKyjmxv3kW);
    height: 700px;
}
    </style>
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
    <!-- navigation -->
    <?php include 'component/head.php';?>

    <!-- contents -->
    <div>
        <!-- main -->
        <div class="col-5 col-m-12 col-s-12 align-center" id="index_left">
            <h1>당신의 방에 참여하세요!</h1>
            <form action="vote_page.html" method="get">
              <input type="text" placeholder="방코드를 입력하세요">
              <input type="submit" value="Search">
            </form>
        </div>

        <!-- img -->
        <div class="col-7 col-m-0 col-s-0" id="index_right"></div>
    </div>

</body>
</html>
