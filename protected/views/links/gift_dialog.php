<body>
<div id="main_frame">
    <p id="gift_message">Спасибо!
        Ваши данные приняты!
        Для того чтобы получить приз, предъявите секретный код в промо точке!</p>
    <?

    if($model == 1){
        $gift_messages = "У вас " .  $model . " подарок";
    }
    else if($model > 1 && $model < 5){
        $gift_messages = "У вас " .  $model . " подарка";
    }
    else{
        $gift_messages = "У вас " .  $model . " подарков";
    }

    if($model > 0){
        echo "<p style='color: white; background-color: rgb(152, 181, 45); font-size: 22px;border-radius: 10px;'>" . $gift_messages  . "<img src='http://icons.iconarchive.com/icons/icondrawer/winter-holiday/128/gift-icon.png' id='gift'></p><a href='iframe' id='nav_btn'>Забрать остальные</a>";
    }
    else{
        echo "<a href='vk' id='nav_btn'>На главную</a>";
    }
    ?>

</div>

</body>