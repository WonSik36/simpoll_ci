<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
        <title>Simpoll</title>
        <style>
            /* navigation */
            body {
                margin: 0;
            }
            div.header {
                border-bottom: 1px solid #ccc;
            }
            ul.topnav {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                float: right;
            }
            ul.topnav li {
                float: left;
            }
            ul.topnav li a {
                display: block;
                text-align: center;
                padding: 18px 16px;
                text-decoration: none;
            }
            span.title {
                display: inline-block;
                font-size: 20px;
                padding: 16px;
            }
            a:link {
                text-decoration: none;
                color: #595959;
            }
            a:visited {
                text-decoration: none;
                color: #595959;
            }
            i {
                color: #ccc;
                padding: 10px 0;
                font-size: 30px;
            }
            a.nickname {
                float: right;
            }
            ul.topnav li a.nickname {
                padding: 18px 0;
            }
            li#info {
                display: block;
                text-align: center;
                text-decoration: none;
                padding: 18px 5px;
                color: #595959;
            }
            @media screen and (max-width: 600px) {
                span.title {
                    text-align: center;
                    display: block;
                }
                ul.topnav li.right {
                    float: none;
                }
                ul.topnav li {
                    float: none;
                }
                ul.topnav {
                    float: none;
                }
                ul.topnav #icon,
                ul.topnav #info {
                    display: none;
                }
            }

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

            ul.submit-ul li {
                float: left;
            }

            ul.submit-ul li.right {
                float: right;
            }

            ul.submit-ul li a {
                display: block;
                text-align: center;
                padding: 15px 60px;
                text-decoration: none;
            }

            ul.submit-ul {
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

            /* vote add button */
            div#add-button {
                position: absolute;
                bottom: 3rem;
                right: 2rem;
                width: 5rem;
                height: 5rem;
                border-radius: 2.5rem;
                font-size: 3rem;
                font-weight: bold;
                background-color: #aefc9d;
                vertical-align: middle;
                cursor: pointer;
            }
        </style>
        <link rel="stylesheet" href="/static/css/style.css">
    </head>
    <body>
        <!-- navigation -->
        <?php include 'head.php';?>

        <!-- room info and vote list -->
        <div>
            <!-- 방 정보 표시창 -->
            <?php include 'room_head.php';?>
            <!-- 투표 정보 표시창 -->

<?php
    // 투표가 없는 경우
    if(empty($list)){
?>
        <?php include 'empty_vote.php';?>
<?php
    //투표가 있는 경우
    }else{
        echo "<!-- list of vote -->";
        echo "<div class='col-12'>";
        foreach($list as $vote){
?>
        <?php include 'vote.php';?>
<?php
        }
        echo "</div>";
    }
?>
        </div>
        <!-- room info and vote list end -->
    </body>

    <!-- vote add button -->
    <div id="add-button" class="align-center">
        <span>
            <a href="#">
                <i class="fas fa-plus" style="color:white"></i>
            </a>
        </span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
window.onload = function() {
<?php
foreach ($list as $vote) {
    echo "vote_view_".$vote['sid']."()\n";
}
?>
};
        function toggleVoteContents(id){
            var voteResult = document.getElementById('v_con_'+id);
            var dis = voteResult.style.display;
            if(dis=="none")
                voteResult.style.display = "block";
            else
                voteResult.style.display = "none";
        }
    </script>
</html>
