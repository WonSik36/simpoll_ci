<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simpoll</title>
</head>
<body>
  <h3>회원가입</h3>
  <form action="signup" method="post">
    e-mail: <input type="email" name="email" value="<?=$email?>" readonly>
    name: <input type="text" name="name" value="<?=$name?>" readonly>
    nickname: <input type="text" name="nickname" required>
    <input type="submit" value="signup">
  </form>
</body>
</html>
