<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpoll</title>
</head>
<body>
<script>
window.onload = function{

<?php
    if(empty($message)){
        echo "alert('올바르지 않은 접근입니다!');";
        echo "history.back();";
    }else{
        echo "alert('".$message."');";
        echo "history.back();";
        echo "location.href = '".$location."';";
    }
?>

}
</script>
</body>
</html>