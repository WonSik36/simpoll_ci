<!-- room title, code, duration, and update button -->
<div id="room-header" class="col-12 col-m-12 col-s-12">
    <!-- room title -->
    <div id="room-title" class="col-2 col-m-2 col-s-6">
        <?=$room['title']?>
    </div>
    <!-- room code -->
    <div id="room-code" class="col-2 col-m-2 col-s-6">
        #<?=$room['room_id']?>
    </div>
    <!-- room duration -->
    <div id="room-dur" class="col-5 col-m-5 col-s-12">

<?php
    // 마감 날짜가 있는 경우
    if($room['deadline_check'] == 1){
?>

        마감 날짜: ~
<?php
        $time = $room['deadline'];
        $dateString = date("Y-m-d", strtotime($time));
        echo $dateString;
?>

<?php
    }
?>

    </div>
    <!-- room update button -->
    <div id="room-update" class="col-3 col-m-3 col-s-12 align-right">
        <a href="#">
            <button id="update-btn">수정</button>
        </a>
    </div>
    <!-- link to participant page -->
    <div id="room-update" class="col-3 col-m-3 col-s-12 align-right">
        <a href="#">
            <button id="update-btn">Simpoll 하러 가기</button>
        </a>
    </div>
</div>
