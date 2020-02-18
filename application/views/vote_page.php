<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
        <title>Simpoll</title>
        <style>
            body {
                margin: 0;
                background-color: #eee;
            }
            .header {
                background-color: #ff9999;
            }
            ul.vote_tab {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }
            ul.vote_tab li {
                float: left;
            }
            ul.vote_tab li {
                display: block;
                text-align: center;
                padding: 18px 16px;
                text-decoration: none;
            }
            ul.vote_tab li.right {
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
            .contents {
                background-color: #eee;
                padding-top: 10px;
            }
            .vote {
                padding-left: 20px;
            }
            @media screen and (max-width: 600px) {
                ul.submit li.right {
                    float: none;
                }
                ul.submit li {
                    float: none;
                }
                ul.submit {
                    float: none;
                }
            }
        </style>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="header">
            <ul class="vote_tab">
                <li class="check_icon">
                    <i class="far fa-check-square"></i>
                </li>
                <li class="title"><?=$vote['title']?><br><?=$vote['part_num']?></li>
                <li>
                    <i class="far fa-thumbs-up"></i>
                </li>
                <li>
                    <i class="far fa-thumbs-down"></i>
                </li>
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

        <div class="contents">
            <div class="vote">
                <form class="radio" action="index.html">
                    <input type="radio" name="gender" value="삼촌네 찜닭" checked="checked">
                    삼촌네 찜닭<br>
                    <input type="radio" name="gender" value="파닭">
                    파닭<br>
                    <input type="radio" name="gender" value="학관">
                    학관<br>
                    <div id="submit">
                        <ul class="submit">
                            <li class="cancel">
                                <a href="list_poll03.html" style="color: #00e6b8;">방으로 이동</a>
                            </li>
                            <li class="right"><input type="submit" style="color: #00e6b8;"></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

    </body>
</html>
