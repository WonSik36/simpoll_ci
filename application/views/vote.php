<?php
    // parsing vote choices and count
    $choices = explode('|',$vote['contents']);
    $res_cnt;
    $total_part;

    if(!empty($vote['result'])){
        $res_cnt = explode('|',$vote['result']);;
        $total_part = 0;
        for($i=0;$i<count($res_cnt);$i++){
            $total_part += $res_cnt[$i];
        }
    }else{
        $res_cnt = array();
        for($i=0;$i<count($choices);$i++){
            $res_cnt[$i] = 0;
        }
        $total_part = 0;
    }

?>
<!-- vote tab -->
<!-- vote header -->
<div class="vote-tab" id="v_head_<?=$vote['sid']?>" onclick="toggleVoteContents(<?=$vote['sid']?>)">
    <ul class="vote-ul">
        <li class="check_icon">
            <i class="far fa-check-square"></i>
        </li>
        <li class="title"><?=$vote['title']?><br><?=$total_part?></li>
        
        <li class="right"><?=$vote['deadline']?></li>
    </ul>
</div>
<!-- vote contents -->
<div class="contents" id="v_con_<?=$vote['sid']?>">
    <div class="vote">
            <p>투표 결과</p>
            <canvas id="vote_result_<?=$vote['sid']?>"></canvas>
    </div>
</div>
<script>
<?php
    echo "var ctx_".$vote['sid']." = document.getElementById('vote_result_".$vote['sid']."').getContext('2d');";
    echo "var chart_".$vote['sid']." = new Chart(ctx_".$vote['sid'].", {";
    echo "type: 'bar,'";
    echo "data: {";

    echo "labels: [";
    for($i=0;$i<count($choices);$i++){
        if($i == count($choices)-1)
            echo $choices[$i];
        else
            echo $choices[$i].", ";
    }
    echo "]";

    echo "datasets: [{";
    echo "backgroundColor: 'rgb(255,99,132)',";
    echo "borderColor: 'rgb(255,99,132)',";
    echo "data: [";
    for($i=0;$i<count($res_cnt);$i++){
        if($i == count($res_cnt)-1)
            echo $$res_cnt[$i];
        else
            echo $$res_cnt[$i].", ";
    }
    echo "]";
    echo "}]";

    echo "}";
    echo "options: {}";
    echo "});"
?>
</script>