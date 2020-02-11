<?php
    if(empty($nickname)){
      ?>
<div class="header">
    <span class="title">
        <a href="index.html">Simpoll</a>
    </span>
    <ul class="topnav">
        <li class="right">
            <a href="make_room.html">새로운 방 만들기</a>
        </li>
        <li class="right">
            <a href="list_room.html">참여한 방 목록</a>
        </li>
        <li class="right">
            <a href="list_room.html">개설한 방 목록</a>
        </li>
        <li class="right">
            <a href="login.html">로그인</a>
        </li>
        <li class="right">
            <a href="sign_up.html">회원가입</a>
        </li>
    </ul>
</div>
<?php
    }else{
      ?>
<div class="header">
    <span class="title">
        <a href="index.html">Simpoll</a>
    </span>
    <ul class="topnav">
        <li class="right">
            <a href="make_room.html">새로운 방 만들기</a>
        </li>
        <li class="right">
            <a href="list_room.html">참여한 방 목록</a>
        </li>
        <li class="right">
            <a href="list_room.html">개설한 방 목록</a>
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