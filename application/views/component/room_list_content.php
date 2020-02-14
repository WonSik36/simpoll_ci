<?php
    foreach($list as $room){
?>
<!-- top -->
<div class="col-12 room">
    <div class="title"><?=$room['title']?></div>
    <div class="tags">
        <div class="label color-code">#<?=$room['room_id']?></div>
    </div>

    <!-- left -->
    <div class="col-5 col-m-5 col-s-5" style="clear: both;">
        <div class="title">
            방장:
            <?=$room['master_nickname']?>
            <br>
            참여인원:
            <?=$room['part_num']?>명
        </div>
    </div>

    <!-- mid -->
    <div class="col-4 col-m-4 col-s-4">
<?php
    if($room['deadline_check']==1){
?>
        <div class="title">
            마감 날짜:
            <br>
            ~
<?php
    $time = $room['deadline'];
    $dateString = date("Y-m-d", strtotime($time));
    echo $dateString;
?>
        </div>
<?php
    }
?>
    </div>

    <!-- right -->
    <div class="col-3 col-m-3 col-s-3 align-right btn-holder" style="height: 100%;">
        <a href="">
            <button class="btn-del pair-btn">삭제</button>
        </a>
        <a href="/index.php/room/speacker_myroom/<?=$room['room_id']?>">
            <button class="btn-go pair-btn">이동</button>
        </a>
    </div>
</div>
<?php
    }
?>