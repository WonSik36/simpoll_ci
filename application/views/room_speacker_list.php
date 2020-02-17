<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
        <title>Simpoll</title>
        <style>
            /* contents */
            input[type=text] {
                width: 100%;
                height: 50px;
                margin: 5px;
                padding: 10px;
                font-size: 18px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            button:hover {
                cursor: pointer;
            }

            button.filter {
                width: 80px;
                height: 50px;
                margin: 5px;
                font-size: 15px;
                color: white;
                background-color: grey;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            button.pair-btn {
                position: relative;
                bottom: -3.5rem;
                width: 4rem;
                height: 2rem;
                font-size: 15px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            button.btn-del {
                color: white;
                background-color: rgb(231, 76, 60);
            }
            button.btn-go {
                color: white;
                background-color: rgb(52, 152, 219);
            }
            #nav-bar {
                padding: 0;
                color: #595959;
                font-size: 16px;
                border-bottom: 1px solid #ccc;
            }
            .room {
                background-color: #f0f0f0;
                border-radius: 5px;
                border: 1px solid #ccc;
                margin: 10px;
                height: 150px;
            }
            .title {
                margin: 0;
                font-size: 18px;
                font-weight: 800;
                display: inline;
            }
            .tags {
                float: right;
            }
            .label {
                border-radius: 5px;
                border: 1px solid #ccc;
                margin-right: 1px;
                padding-left: 5px;
                padding-right: 5px;
                float: left;
            }
            .color-code {
                background-color: aquamarine;
            }
            .color-proc {
                background-color: rgb(243, 156, 18);
            }
        </style>
        <link rel="stylesheet" href="/static/css/style.css">
    </head>
    <body>
        <!-- navigation -->
        <?php include 'component/head.php';?>

        <!-- contents -->
        <!-- room filter -->
        <div class="col-12 col-m-12 col-s-12">
            <h3>검색</h3>
            <input type="text" placeholder="검색어를 입력해주세요.">

            <br><br><br>

            <h3>정렬</h3>
            <button class="filter">시간순</button>
            <button class="filter">방제목순</button>
        </div>

        <!-- list of room -->
        <div class="col-12 col-m-12 col-s-12">
            <div class="col-1"></div>
            <div class="col-10">

            <!-- navigation -->
            <?php include 'component/room_list_content.php';?>

            </div>
            <div class="col-1"></div>
        </div>

    </body>
</html>
