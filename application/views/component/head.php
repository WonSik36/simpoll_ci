<?php
    if(empty($_SESSION['nickname'])){
?>

<div class="header">
    <span class="title">
        <a href="/index.php/home">Simpoll</a>
    </span>
    <ul class="topnav">
        <li class="right">
            <a href="/index.php/user/login">로그인</a>
        </li>
    </ul>
</div>
<?php
    }else{
        $nickname = $_SESSION['nickname'];
?>
<div class="header">
    <span class="title">
        <a href="/index.php/home">Simpoll</a>
    </span>
    <ul class="topnav">
        <li class="right">
            <a href="/index.php/home/dashboard">대시보드</a>
        </li>
        <li id="icon">
            <i class="fas fa-user-circle"></i>
        </li>
        <li id="info" class="right"><?=$nickname?>
            님</li>
        <li class="right">
            <a href="#">마이페이지</a>
        </li>
        <li class="right">
            <a href="/index.php/user/logout">로그아웃</a>
        </li>
    </ul>
</div>
<?php
    }
    ?>
