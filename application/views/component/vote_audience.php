<?php
    $contents = explode("|",$vote['contents']);
    $user_choice = null;
    // for($i=0;$i<count($user_choices);$i++){
    //     for($j=0;$j<count($user_choices[$i]);$j++){

    //         if($user_choices[$i][$j]['vote_id'] == $vote['sid']){
    //             $user_choice = $user_choices[$i][$j];
    //             break;
    //         }
    //     }

    // }
?>
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
        <!-- vote contents -->
        <div class="vote_contents" id="v_con_<?=$vote['sid']?>">
            <div class="vote">
<?php
    // 이미 선택을 한경우
    if(empty($user_choice))
        include 'vote_page_process.php';
    else
        include 'vote_page_result.php';
?>
            </div>
        </div>
    </div>
</div>
