<?php
    // parsing vote choices and count
    $choices = explode('|',$vote['contents']);
    $res_cnt;
    $total_part;

    if(!empty($vote['result'])){
        $res_cnt = explode('|',$vote['result']);
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
        <li class="title"><?=$vote['title']?><br><?=$total_part?>명</li>

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
<div class="vote_contents" id="v_con_<?=$vote['sid']?>" style="display:block;">
    <div class="vote">
            <p>투표 결과</p>
            <canvas id="vote_result_<?=$vote['sid']?>"></canvas>
    </div>
</div>
<script>
function vote_view_<?=$vote['sid']?>() {
    <?php
        echo "var ctx_".$vote['sid']." = document.getElementById('vote_result_".$vote['sid']."').getContext('2d');\n";
        echo "var chart_".$vote['sid']." = new Chart(ctx_".$vote['sid'].", {\n";
        echo "type: 'bar',\n";
        echo "data: {\n";

        echo "labels: [\n";
        for($i=0;$i<count($choices);$i++){
            if($i == count($choices)-1)
                echo "'".$choices[$i]."'";
            else
                echo "'".$choices[$i]."', ";
        }
        echo "],\n";

        echo "datasets: [{\n";
        echo "backgroundColor: 'rgb(255,99,132)',\n";
        echo "borderColor: 'rgb(255,99,132)',\n";
        echo "data: [\n";
        for($i=0;$i<count($res_cnt);$i++){
            if($i == count($res_cnt)-1)
                echo "'".$res_cnt[$i]."'";
            else
                echo "'".$res_cnt[$i]."', ";
        }
        //echo var_dump($res_cnt);
        echo "]\n";
        echo "}]\n";

        echo "},\n";
        echo "options: {}\n";
        echo "});\n"
    ?>
}
</script>
