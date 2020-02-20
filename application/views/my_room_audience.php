<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
        <title>Simpoll</title>
        <style>
            /* contents */
            /* room title, code, duration, and update button */
            div#room-header {
                font-size: 1.5rem;
                font-weight: bold;
            }
            div#room-title {
                font-size: 2rem;
            }
            div#room-code {
                margin-top: 0.5rem;
            }
            div#room-dur {
                margin-top: 0.5rem;
            }
            div#room-update {
                margin-top: 0.5rem;
            }
            button#update-btn {
                font-size: 1rem;
                background-color: rgb(224, 224, 224);
                border: 1px solid grey;
                border-radius: 0.5rem;
            }
            button#update-btn:hover {
                cursor: pointer;
            }
            button#update-btn:active {
                background-color: grey;
            }

            #roomList {
                text-align: center;
                margin: 0 auto;
                padding-top: 200px;
            }

            /* list of vote */
            .vote-tab {
                background-color: #ff9999;
            }

            .vote_contents{
                background-color: #cccccc;
            }

            ul.vote-ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            ul.vote-ul li {
                float: left;
            }

            ul.vote-ul li {
                display: block;
                text-align: center;
                padding: 18px 16px;
                text-decoration: none;
            }

            ul.vote-ul li.right {
                float: right;
            }

            .fa-check-square {
                font-size: 40px;
            }

            .fa-thumbs-down,
            .fa-thumbs-up {
                font-size: 30px;
            }

            .check_icon {
                margin: 0 20px;
            }

            .title {
                margin: 0 20px;
            }

            #submit {
                border-top: 1px solid #ccc;
                margin: 10px;
            }

            ul.submit li {
                float: left;
            }
            ul.submit li.right {
                float: right;
            }
            ul.submit li a {
                display: block;
                text-align: center;
                padding: 15px 60px;
                text-decoration: none;
            }
            ul.submit {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .vote-contents {
                background-color: #eee;
                padding-top: 10px;
            }

            .vote {
                padding-left: 20px;
            }
        </style>
        <link rel="stylesheet" href="/static/css/style.css">
    </head>
    <body>

        <!-- navigation -->
        <?php include 'component/head.php';?>

        <!-- room info and vote list -->
        <div>
            <!-- 방 정보 표시창 -->
            <?php include 'component/room_head.php';?>

            <!-- 투표 필터링 -->
            <div class="col-12 col-m-12 col-s-12"  style="border-top: 1px solid black; border-bottom: 1px solid black;">
            <h3>검색</h3>
            <input type="text" placeholder="검색어를 입력해주세요.">

            <br><br><br>

            <h3>정렬</h3>
            <button class="filter">시간순</button>
            <button class="filter">투표제목순</button>
        </div>

            <!-- 투표 정보 표시창 -->

<?php
    // 투표가 없는 경우
    if(empty($list)){
?>
    <div>
        <p style="text-align:center;">아직 simpoll이 없네요. 새로운 simpoll을 기다려주세요~</p>
    </div>


<?php
    //투표가 있는 경우
    }else{
        echo "<!-- list of vote -->\n";
        echo "<div class='col-12'>\n";

        $idx = 0;
        // echo "<!--".var_dump($user_choices)."-->";
        foreach($list as $vote){
?>
        <?php include 'component/vote_audience.php';?>
<?php
            $idx++;
        }
        echo "</div>\n";
    }
?>
        </div>
        <!-- room info and vote list end -->
    </body>
    <script>
        function toggleVoteContents(sid){
            var voteResult = document.getElementById("v_con_"+sid);
            var dis = voteResult.style.display;
            if(dis=="none"){
                voteResult.style.display = "block";

            }else
                voteResult.style.display = "none";
        }

        function goBack(){
            location.href = "/index.php/home";
        }

        function mergeChoice(sid){
            let cns = document.getElementsByClassName('cn_'+sid);
            let contentsNumber = document.getElementById('contents_number_'+sid);

            let cnStr = "";
            for(let i=0;i<cns.length;i++){
                if(cns[i].checked){
                    cnStr += cns[i].value;
                    cnStr += "|";
                }
            }
            contentsNumber.value = cnStr.substring(0,cnStr.length-1);


            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let ret = JSON.parse(this.responseText);
                    if(ret.result=="success"){
                        alert("투표가 되었습니다.");
                        for(let i=0;i<cns.length;i++){
                            cns[i].disabled = true;
                        }
                        document.getElementById("submit_"+sid).style.display = "none";
                    }else {
                        alert("투표에 실패하였습니다.");
                    }
                }
            };
            xhttp.open("POST", "/index.php/room/vote_ajax", true);
            xhttp.setRequestHeader("Content-Type","application/json");
            // let vote_choice = "vote_id="+sid+"&contents_number="+contentsNumber.value;
            // xhttp.send(vote_choice);
            let vote_choice = JSON.stringify({vote_id : sid, contents_number : contentsNumber.value});
            xhttp.send(vote_choice);

        }
    </script>
</html>
