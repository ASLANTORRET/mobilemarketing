

<?

if(isset($_GET['viewer_id'])){
    $viewer_id = $_GET["viewer_id"];
}
else{
    $viewer_id = "192335129";
}

$gifts_number =  Activations::model()->checkGifts($viewer_id);

$gift_info = "";
$gift_messages = "";

if($gifts_number == 0){
    $gift_messages = "У вас пока нет подарков. Ждите подарки от друзей :)";
    $gift_info = "нет подарков ";
    echo "<div id='gift_messages'>{$gift_info}</div>";
}
else{
    if($gifts_number == 1){
        $gift_messages = "У вас " .  $gifts_number . " подарок";
        $gift_info = $gifts_number .  " ";
    }
    else if($gifts_number > 1 && $gifts_number < 5){
        $gift_messages = "У вас " .  $gifts_number . " подарка";
        $gift_info = $gifts_number .  " ";
    }
    else{
        $gift_messages = "У вас " .  $gifts_number . " подарков";
        $gift_info = $gifts_number .  " ";

    }

    echo "<div id='gift_messages'>{$gift_info}<img src='http://icons.iconarchive.com/icons/icondrawer/winter-holiday/128/gift-icon.png' id='gift'></div>";
}


?>
<body style="background-image: url(/images/vk_kv_main3.jpg);">

<div id="vkapp_top">
    <!--<div id="app_header">
        &nbsp;
        &nbsp;
    </div>-->

    <div id="app_buttons">
        <a href="javascript:void(0)"><div class="app_inner_btn1">ОБ АКЦИИ</div></a>
        <a href="javascript:void(0)"><div class="app_inner_btn2">ПРАВИЛА<br>УЧАСТИЯ</div></a>
        <a href="javascript:void(0)"><div class="app_inner_btn3">ОБРАТНАЯ<br>СВЯЗЬ</div></a>
    </div>

</div>

<div id="bottom">

   <div id="bottom_buttons">
       <a href="javascript:void(0)" onclick="this.href='invitePage?vid=<?=$viewer_id;?>&gn=<?=$gifts_number;?>'"><button id="bottom_btn1" class="active_btn">ОТПРАВИТЬ ПОДАРОК</button></a>
       <a href="javascript:void(0)" onclick="this.href='confirmPage?vid=<?=$viewer_id;?>&gn=<?=$gifts_number;?>'" title="<?=$gift_messages;?>"><button id="bottom_btn2"  class="<?=$gifts_number==0?'non_active_btn':'active_btn';?>" <?=$gifts_number==0?'disabled':'';?>>ПОЛУЧИТЬ ПОДАРОК</button></a>
       <a href="javascript:void(0)" onclick="this.href=''"><button id="bottom_btn3" class="<?=$gifts_number==0?'non_active_btn':'active_btn';?>" <?=$gifts_number==0?'disabled':'';?>">МОИ ПОДАРКИ</button></a>
   </div>

</div>

</body>