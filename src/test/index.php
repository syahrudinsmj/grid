<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://testing-code.local/smjlabs/libs/Grid/assets/css/app.css">
</head>
<body>

<?php echo $table->render();?>

<div class="smj-half-box">
    <div class="flex-container">
        <div class="flex-item-left">
            <?php echo $table->render();?>
        </div>
        <div class="flex-item-right">
            <?php echo $table->render();?>
        </div>
    </div>
</div>

</body>
</html>