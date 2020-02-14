<!-- vote tab -->
<!-- vote header -->
<div class="vote-tab" onclick="toggleVoteContents(<?=$room['sid']?>)">
    <ul class="vote-ul">
        <li class="check_icon">
            <i class="far fa-check-square"></i>
        </li>
        <li class="title"><?=$vote['title']?></li>

        <li class="right">
            ~
<?php
            $time = $vote['deadline'];
            $dateString = date("Y-m-d A h:i", strtotime($time));
            echo $dateString;
?>
        </li>
    </ul>
</div>
<!-- vote contents -->
<div class="vote_contents" id="v_con_<?=$room['sid']?>" style="display:none;">
    <div class="vote">
            <p>투표 결과</p>
            <canvas id="vote_result_<?=$room['sid']?>"></canvas>
    </div>
</div>