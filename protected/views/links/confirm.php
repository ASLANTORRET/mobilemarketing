<?
$base_url = Yii::app()->getBaseUrl();
$action = "confirm";
if(isset($_GET['vid'])){
    $action .= "?vid=" . $_GET["vid"];
}

?>
<script src="<?=$base_url;?>/js/jquery.maskedinput.min.js" type="text/javascript"></script>

<script>
    jQuery(function($){
        $("#number_field").mask("9999999",{placeholder:" "});
    });
</script>

<script>
    function listPromoSpots(){
        var city_id = $("#city_id").val();
        $.ajax({
            type:"POST",
            url:"promoSpotList",
            data:{city_id:city_id},
            success:function(data){
                $("#promo_spot").html(data);
            }
        });
    }

</script>

<script>
    function checkPhone(){
        var def_code = $("#prefix_list").val();
        var phone_number = $("#number_field").val();
        var city_id = $("#city_id").val();
        var parts=document.location.search.substr(1).split("&");
        var viewer_id = parts[0].split('=')[1];
        $("#prefix_list").attr('disabled', 'disabled'); //Disable
        $("#number_field").attr('disabled', 'disabled'); //Disable
        $("#promo_spot").attr('disabled', 'disabled'); //Disable
        $("#city_id").attr('disabled', 'disabled'); //Disable
        $("#checkphone_btn").attr('disabled', 'disabled'); //Disable

        $.ajax({
            type:"POST",
            url:"sendSMS",
            data:{def:def_code, phone:phone_number, city:city_id, vid:viewer_id},
            success:function(data){
                if(data == 1){
                    $("#check_message").html("<span style=\"color:green;\">Ваш запрос получен. К Вам на телефон придет в течении 15 сек секретный код.</span>");
                }
                else if(data == 2){
                    $("#check_message").html("<span style=\"color:green;\">Вы можете запросить секретный код не более 2 раз в день .</span>");
                }
                else{
                    $("#check_message").html("<span style=\"color:red;\">Проверьте корректность введенного номера</span>");
                }

            }

        });
    }

</script>

<script>

    function checkCode(){

        var parts=document.location.search.substr(1).split("&");
        viewer_id = parts[0].split('=')[1];

        var uid = $("#uid").val();
        var def_code = $("#prefix_list").val();
        var phone_number = $("#number_field").val();
        var promo_spot = $("#promo_spot").val();
        var city = $("#city_id").val();

        $.ajax({
            type:"POST",
            url:"confirm",
            data:{prefix:def_code, phone:phone_number, city:city, promo_spot:promo_spot, vid:viewer_id, uid:uid},
            success:function(data){
                if(data == 0){
                    $("#check_message").html("<span style=\"color:red;\">Введен некорректный секретный код</span>");
                }
                else{

                    data = (parseInt(data, 10) - 1);
                    window.location = "confirmed?gn=" + data;
                }
            }
        });
    }
</script>
<body style="background-image: url(/images/vk_kv_take_gift2.jpg);">

<!--<div id="main_frame">
    <form action="<?/*=$action;*/?>" method="post" id="myForm">
    <div id="float_main">
        <div class="float_blocks" style="width: 125px;">Ваш город:</div>
        <div class="float_blocks">
                <select class="form-control" name="city"  id="city_id" onchange="listPromoSpots()">
                    <?/*$city_list = Yii::app()->params["cities"];
                        foreach($city_list as $index=>$value){
                            echo "<option value=\"{$index}\">{$value}</option>";
                        }
                    */?>
                </select>

        </div>

        <div class="float_blocks" id="pivot_block" style="width: 125px;" >Промо точка</div>

        <div class="float_blocks">

                <select class="form-control" id="promo_spot" name="promo_spot">
                    <option value="1">Dostyk Plaza</option>
                </select>
        </div>
    </div>
    <div id="phone_field_block">

         <p>Введите номер телефона</p>


            <div style="float:left;">
                <select class="form-control" id="prefix_list" name="prefix">
                    <?/*$def_list = Yii::app()->params["def_codes"];
                    foreach($def_list as $index=>$value){
                        echo "<option value=\"{$index}\">{$value}</option>";
                    }
                    */?>
                </select>
            </div>

            <div style="float:left;">
                <input class="form-control" id="number_field" name="phone">
            </div>

            <div style="float:left;">
                <button type="button" class="btn btn-primary btn-sm" id="checkphone_btn" onclick="checkPhone()">Получить код</button>
            </div>


        <p id="check_message"></p>

    </div>

        <div id="confirm_block">
            <input type="text" name="uid" id="uid" class="form-control">
            <button type="button" class="btn btn-primary" onclick="checkCode()">Получить подарок</button>
        </div>

    </form>

    <a href='iframe' id='nav_btn'><img src="/images/vk_kv_back.png"></a>
</div>-->
<p id="gift_title">ЗАПОЛНИТЕ ФОРМУ ПОЛУЧЕНИЯ ПОДАРКА<p>
<div id="main_frame">
<form action="<?/*=$action;*/?>" method="post" id="myForm">
    <div id="float_main">
        <div class="float_blocks">
            <select name="city"  id="city_id" onchange="listPromoSpots()">
                <?$city_list = Yii::app()->params["cities"];
                        foreach($city_list as $index=>$value){
                            echo "<option value=\"{$index}\">{$value}</option>";
                        }
                    ?>
            </select>

        </div>

        <div class="float_blocks">

            <select id="promo_spot" name="promo_spot">
                <option value="">Выберите промо точку</option>
            </select>
        </div>
    </div>
    <p id="phone_title">Введите номер телефона*</p>
    <div id="phone_field_block">


        <div style="float:left;">
            <select id="prefix_list" name="prefix">
                <?$def_list = Yii::app()->params["def_codes"];
                    foreach($def_list as $index=>$value){
                        echo "<option value=\"{$index}\">{$value}</option>";
                    }
                    ?>
            </select>
        </div>

        <div style="float:left;  margin-bottom: 6px;">
            <input id="number_field" name="phone">
        </div>

        <div style="float:left;">
            <button type="button" id="checkphone_btn" onclick="checkPhone()">Получить код</button>
        </div>


        <p id="check_message">* Вы получите SMS секретным кодом<br> в течении 15 секунд.</p>

    </div>

    <div id="confirm_block">
        <input type="text" name="uid" id="uid" placeholder="Введите секретный код">
    </div>

    <button type="button" id="submit_btn" onclick="checkCode()">Получить подарок</button>

</form>

<a href='vk' id='nav_btn'><img src="/images/vk_kv_back.png"></a>
    </div>

</body>