<form id="frm" action="/index.php/vote/page/<?=$vote['sid']?>" method="post">
<?php
    $choices = array();
    foreach($user_choice as $choice){
        array_push($choices, (int)$choice['contents_number']);
    }

    $type;
    // 단일 선택인 경우
    if($vote['vote_type'] == 0)
        $type = "radio";
    else
        $type = "checkbox";

    $i = 1;
    foreach($contents as $cont){
        if(in_array($i, $choices))
            echo '<input class="cn" type="'.$type.'" name="cn" value="'.$i.'" disabled checked>';
        else
            echo '<input class="cn" type="'.$type.'" name="cn" value="'.$i.'" disabled>';
        echo $cont.'<br>';
        $i++;
    }
?>
    <!-- updating vote needs to update -->
    <!--
    <input type="hidden" name="room_id" value="<?=$vote['room_id']?>">
    <input id="contents_number" type="hidden" name="contents_number">
    <input type="hidden" name="_method" value="put">
    <div id="submit">
        <ul class="submit">
            <li class="cancel"><input type="button" style="color: #00e6b8;" onclick="goBack()" value="Back"></li>
            <li class="right"><input type="button" style="color: #00e6b8;" onclick="mergeChoice()" value="Update"></li>
        </ul>
    </div>
    -->
</form>