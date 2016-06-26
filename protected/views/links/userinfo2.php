<?php $base_url = Yii::app()->getBaseUrl();?>

<script src="http://vkontakte.ru/js/api/xd_connection.js?2" type="text/javascript"></script>

<script type="text/javascript" charset="cp1251" >

    var friends_data; // отсортированный список друзей
    var userPersonalData;
    var viewer_id;
    var promoImageID;

    $(document).ready(function(){


        VK.init(function() {

            var parts=document.location.search.substr(1).split("&");
            var friendStatus = 0;
            var authorID = "192335129";
            viewer_id = parts[0].split('=')[1];
            /*for (i=0; i<parts.length; i++) {
                curr = parts[i].split('=');
                alert(curr[0]);
                // записываем в массив flashVars значения. Например: flashVars['viewer_id'] = 1;
                flashVars[curr[0]] = curr[1];
            }*/
            // получаем viewer_id из полученных переменны
            //viewer_id = flashVars['vid'];



            VK.api("users.get", {uids:viewer_id,fields:"photo_big,photo_id"}, function(data) {

                userPersonalData = data.response[0].first_name + ' ' + data.response[0].last_name;
                //promoImageID = data.response[0].photo_id;
            });

            VK.api("photos.getProfile", {uid:authorID,fields:"src, pid"}, function(data) {

                    promoImageID = authorID + "_" + data.response[0].pid;
             });


            // выполняем запрос получения списка друзей
            VK.api("friends.get", {fields:"first_name,photo,photo_id"}, function(data) {
                // узнаем количество друзей
                var fr = data.response.length;
                // сортируем друзей по имени (функция sFirstName описана ниже)
                friends_data = data.response.sort(sFirstName);

                // в value элемента будем записывать номер пользователя в массиве friends_data

                for(var i=0;i<fr;i++){
                    $('#friends_list').append('<div class="friend" style="margin-bottom: 10px;"onclick="invite('+i+');">'+ '<img src="'+ friends_data[i].photo +'"/><span>' + friends_data[i].first_name + ' ' + friends_data[i].last_name +'</span></div>');
                }

            });


        });

    });

    // функции сортировки
    function sFirstName(a,b) {
        if (a.first_name > b.first_name)
            return 1;
        else if  (a.first_name < b.first_name)
            return -1;
        else
            return 0;
    }

    //функция - приглашалка
    function invite(user_index){
        var uid_to = friends_data[user_index].uid; // id выбранного пользователя
        var receiverName = friends_data[user_index].first_name + ' ' + friends_data[user_index].last_name;

        $.ajax({
                type:"GET",
                url:"check",
                data:{uid:viewer_id, fuid:uid_to},
                success:function(data){

                    friendStatus = data;
                    //friendStatus = "1";
                    /* if(friendStatus=="0"){
                     alert("Вы не можете отправить подарок больше 3 в день.");
                     }*/

                    if(friendStatus=="1"){

                        message_to = $('#message_tf').val();
                        var promo_message = "Получи подарок 'Lipton Ice Tea'\n Забирай здесь http://vk.com/app4953800_192335129";

                        var image = "photo"+promoImageID;
                        //var image = "photo"+promoImageID;

                        VK.api('wall.post',{owner_id:uid_to, message:promo_message, attachment:image},function(data) {
                            if (data.response) { // если получен ответ

                                $.ajax({
                                        type:"POST",
                                        url:"save",
                                        data:{invite:viewer_id + "-" + uid_to},
                                        success:function(data){
                                            var erorMessage = "<h2>Спасибо</h2>";

                                            window.location = "#openModal";

                                            $("#modalText").html(erorMessage + "Подарок отправлен пользователю «" + receiverName + "»");
                                        }

                                    }

                                );

                                // $('#post_info').html('<form action="save" method="post"><input type="hidden" name="invite" value="' + viewer_id + "-" + uid_to+'"><input type="submit" value="Продолжить"></form>');
                            } else { // ошибка при отправке сообщения

                                var erorMessage = "<h2>Ошибка</h2>";

                                if(data.error.error_code != "10007"){

                                    window.location = "#openModal";

                                    if(data.error.error_code == "214"){
                                        erorMessage += "<p>Пользователь запретил публикацию на своей странице</p>";
                                    }
                                    //$("#modalText").html('<p>Подарок отправлен пользователю «Берик Сериков» ' + data.error.error_code + ' ' + data.error.error_msg + ' </p>');
                                    $("#modalText").html(erorMessage);
                                }
                            }
                        });
                    }
                    else if(data=="2"){
                        var erorMessage = "<h2>Ошибка</h2>";

                        window.location = "#openModal";

                        $("#modalText").html(erorMessage + "Выбранный пользователь уже получал подарок сегодня.");
                    }

                    else{
                        var erorMessage = "<h2>Ошибка</h2>";

                        window.location = "#openModal";

                        $("#modalText").html(erorMessage + "Вы не можете отправить подарок больше чем 3 друзьям в день.");
                    }
                }
            }
        );

        /* } else {
         alert('Введите сообщение!');
         }*/
    }

</script>
<body style="background-image: url(/images/vk_kv_background.jpg);">


<p id="friend_title">ОТПРАВЬТЕ ПОДАРОК ТРЕМ ДРУЗЬЯМ</p>
<div id="friends_list">

</div>

<br /><br /><br />
<a href='vk' id='nav_btn'><img src="/images/vk_kv_back.png"></a>
<div id="openModal" class="modalDialog">

    <div>
        <a href="#close" title="Close" class="close">X</a>
        <div id="modalText">
        <div>
    </div>
</div>

</body>