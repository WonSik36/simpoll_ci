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

        echo '<input class="cn" type="'.$type.'" name="cn" value="'.$i.'">';
        echo $cont.'<br>';

        $i++;
    }
?>
    <input type="hidden" name="room_id" value="<?=$vote['room_id']?>">
    <input id="contents_number" type="hidden" name="contents_number">
    <div id="submit">
        <ul class="submit">
            <li class="cancel"><input type="button" style="color: #00e6b8;" onclick="goBack()" value="Back"></li>
            <li class="right"><input type="button" style="color: #00e6b8;" onclick="mergeChoice()" value="Submit"></li>
        </ul>
    </div>
</form>
