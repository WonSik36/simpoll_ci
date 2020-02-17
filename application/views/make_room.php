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
<?php include 'component/head.php';?>

<!-- contents -->
<div class="col-12 col-m-12 col-s-12">
    <form action="register" method="post">
        <h1>새로운 방 개설</h1>

        <!-- poll title -->
        <div>
        <h3>방 제목</h3>
            <label for="title"><input type="text" id="title" name="title" required></label>
        </div>

        <!-- poll url_name -->
        <div>
        <h3>방 url_name</h3>
            <label for="url_name"><input type="text" id="url_name" name="url_name"></label>
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
        <br><br><br>

        <input class="col-4 col-m-6 col-s-12" type="submit" value="방 생성">
    </form>

    <script>
/*
      function deadlineChecked(checkbox){
        let deadlineDiv = document.getElementById("dead_div");

        if(checkbox.checked)
          deadlineDiv.style.visibility = "visible";
        else
        deadlineDiv.style.visibility = "hidden";
      }
*/
    </script>
</div>
</body>
</html>
