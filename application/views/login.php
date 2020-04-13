<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/228af79543.js" crossorigin="anonymous"></script>
    <title>Simpoll</title>
    <style>
    input[type=text] {
        width: 360px;
        height: 50px;
        padding: 10px;
        font-size: 18px;
        border-radius: 5px;
        border :1px solid #ccc;
    }

    input[type=submit] {
        width: 360px;
        height: 50px;
        padding: 10px;
        font-size: 18px;
        color : white;
        background-color: lightskyblue;
        border-radius: 5px;
        border :1px solid #ccc;
    }

    a {
        color : black;
        text-decoration: none;
    }

    hr {
        width: 360px;
    }

    </style>
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
    <div class="align-center" style="margin-top: 100px;">
        <h1 style="margin-bottom: 100px;"><a href="/index.php/home">Simpoll</a></h1>
		<a href="<?=$authUrl?>"><i class="fa fa-google left"></i>Google login</a>
    </div>
</body>
</html>
