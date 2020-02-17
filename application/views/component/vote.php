<!-- vote tab -->
<!-- vote header -->
<div class="vote-tab" onclick="toggleVoteContents(<?=$vote['sid']?>)">
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
<div class="vote_contents" id="v_con_<?=$vote['sid']?>" style="display:none;">
    <div class="vote">
            <p style="margin-top: 0px;">투표 결과</p>
            <canvas id="vote_result_<?=$vote['sid']?>" style="background-color: white;"></canvas>
    </div>
</div>