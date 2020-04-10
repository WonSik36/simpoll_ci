<?php
    // ascending order by option id
    function compareOptions($i, $j){
        $a = (int)$i['option_id'];
        $b = (int)$j['option_id'];

        if($a < $b)
            return -1;
        else
            return 1;
    }

    usort($simpoll,"compareOptions");

    $questions = array();
    for($i=0;$i<count($simpoll);$i++){
        $option = array(
            'sid'=> $simpoll[$i]['option_id'],
            'name'=> $simpoll[$i]['option_name']
        );

        if(array_key_exists($simpoll[$i]['question_id'], $questions)){
            array_push($questions[$simpoll[$i]['question_id']]['options'],$option);

        }else{
            $questions[$simpoll[$i]['question_id']] = array(
                'sid'=> $simpoll[$i]['question_id'],
                'title'=> $simpoll[$i]['question_title'],
                'question_type'=> $simpoll[$i]['question_type'],
                'options' => array()
            );
            
            array_push($questions[$simpoll[$i]['question_id']]['options'],$option);
        }
    }

    $simpoll['title'] = $simpoll[0]['simpoll_title'];
    $simpoll['url_name'] = $simpoll[0]['url_name'];
    $simpoll['deadline'] = $simpoll[0]['deadline'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpoll</title>
    
    <!-- bootstrap4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <!-- title -->
    <div class="jumbotron">
        <h1 class="display-4"><?=$simpoll['title']?></h1>
        <p class="lead">URL: <?=$simpoll['url_name']?></p>
        <p class="lead">마감기한: <?=$simpoll['deadline']?></p>
    </div>
    <form>
<?php
    $id = 0;

    foreach($questions as $key => $question){
        $checkType = $question['question_type']=='0'?'radio':'checkbox';

        echo "<p class='h5'>".$question['title']."</p>";
        for($j=0;$j<count($question['options']);$j++){
            $option = $question['options'][$j];

            echo "<div class='form-check form-check-inline'>";
            echo "<input class='form-check-input' type='".$checkType."' name='question-".$question['sid']."' id='".$id."' value='".$option['sid']."'>";
            echo "<label class='form-check-label' for='".($id++)."'>".$option['name']."</label>";
            echo "</div>";
        }   
        echo "<br><br>";
    }
?>
        
        <input id="submit-btn" class="btn btn-success" type='button' onclick='submitVote()' value="Simpoll it!"/> 
    </form>
    <button id="home-btn" class="btn btn-link d-none" onclick = "location.href = '/index.php/home'">홈페이지로</button> 
</div>
    

<script>
    var optionId = <?=$id?>;

    function submitVote(){
        var selectedOptions = [];
        for(let i=0;i<optionId;i++){
            let option = document.getElementById(""+i);
            if(option.checked)
                selectedOptions.push(option.value);
        }

        fetch('/index.php/api/option',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({option_id: selectedOptions})
        }).then(
            response => response.json()
        ).then((json)=>{
            return new Promise((resolve, reject)=>{
                if(json.result == "success"){
                    alert(json.message);
                    resolve(json.data);
                }else{
                    reject(new Error(json.message));
                }
            });
        }).then((data)=>{
            document.getElementById("submit-btn").disabled = true;
            document.getElementById("home-btn").setAttribute('class', 'btn btn-link');
        }).catch(function(err){
            alert(err.message);
        });
    }
</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>