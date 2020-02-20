<form id="frm" action="/index.php/vote/page/<?=$vote['sid']?>" method="post">
<?php
    $type;
    // 단일 선택인 경우
    if($vote['vote_type'] == 0)
    $type = "radio";
    else
    $type = "checkbox";
    $i = 1;
    foreach($contents as $cont){

        echo '<input class="cn_'.$vote['sid'].'" type="'.$type.'" name="cn" value="'.$i.'">';
        echo $cont.'<br>';

        $i++;
    }
?>
    <input type="hidden" name="room_id" value="<?=$vote['room_id']?>">
    <input name="contents_number" type="hidden" id="contents_number_<?=$vote['sid']?>">
    <div id="submit_<?=$vote['sid']?>">
        <ul class="submit">
            <li class="cancel"><input type="button" style="color: #00e6b8;" onclick="goBack()" value="Back"></li>
            <li class="right"><input type="button" style="color: #00e6b8;" onclick="mergeChoice(<?=$vote['sid']?>)" value="Submit"></li>
        </ul>
    </div>
</form>
