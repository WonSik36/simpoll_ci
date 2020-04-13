<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
    <title>Simpoll</title>
    <style>
    input[type=text] {
        width: 360px;
        height: 50px;
        padding: 10px;
        font-size: 18px;
        border-radius: 5px;
        border :1px solid #ccc;
    }

    input[type=submit] {
        width: 360px;
        height: 50px;
        padding: 10px;
        font-size: 18px;
        color : white;
        background-color: lightskyblue;
        border-radius: 5px;
        border :1px solid #ccc;
    }

    a {
        color : black;
        text-decoration: none;
    }

    hr {
        width: 360px;
    }

    </style>
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
    <div class="align-center" style="margin-top: 100px;">
        <h1 style="margin-bottom: 100px;"><a href="/index.php/home">Simpoll</a></h1>
        <a href="<?=$authUrl?>"><button>구글 로그인</button></a>
        <form action="login" method="post">
            <p>
                <input type="text" placeholder="아이디" name="email">
            </p>
            <p>
                <input type="password" placeholder="비밀번호" name="password">
            </p>
            <p>
                <input type="submit" value="로그인">
            </p>
            <p>
                <label for="chk">
                    <input type="checkbox" id="chk" value="login_chk"> 로그인 상태 유지
                </label>
            </p>
        </form>
        <hr>
        <div>
            <a href="id_inquiry.php">아이디 찾기</a> | <a href="pw_inquiry.php">비밀번호 찾기</a> | <a href="/index.php/user/signup">회원가입</a>
        </div>
        <?php
				if($this->session->userdata('sess_logged_in')==0){?>
					<a href="/index.php/login/google"class="waves-effect waves-light btn red"><i class="fa fa-google left"></i>Google login</a>
				<?php }else{?>
					<a href="/index.php/home" class="waves-effect waves-light btn red"><i class="fa fa-google left"></i>Google logout</a>
				<?php }
		?>
    </div>
</body>
</html>
