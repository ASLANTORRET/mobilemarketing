<html>
<head>
<!-- подключаем xd_connection.js -->
<script src="http://vkontakte.ru/js/api/xd_connection.js?2" type="text/javascript"></script>

<script type="text/javascript" charset="cp1251" >

    $(document).ready(function(){
        var friends_data; // отсортированный список друзей
        var userPersonalData;
        var viewer_id;
        var promoImageID;

        VK.init(function() {

            var parts=document.location.search.substr(1).split("&");
            var flashVars={}, curr;
            var friendStatus = 0;
            var authorID = "192335129";

            for (i=0; i<parts.length; i++) {
                curr = parts[i].split('=');
                // записываем в массив flashVars значения. Например: flashVars['viewer_id'] = 1;
                flashVars[curr[0]] = curr[1];
            }

            // получаем viewer_id из полученных переменных
            viewer_id = flashVars['viewer_id'];

            VK.api("users.get", {uids:viewer_id,fields:"photo_big"}, function(data) {

                userPersonalData = data.response[0].first_name + ' ' + data.response[0].last_name;
            });

            VK.api("users.get", {uids:authorID,fields:"photo_id"}, function(data) {

                promoImageID = data.response[0].photo_id;
            });

            VK.api("photos.get", {owner_id:"-"+authorID,fields:"photo_id"}, function(data) {

                alert(data.response[0].length);

            });


            // выполняем запрос получения списка друзей
            VK.api("friends.get", {fields:"first_name,photo,photo_id"}, function(data) {
                // узнаем количество друзей
                var fr = data.response.length;
                // сортируем друзей по имени (функция sFirstName описана ниже)
                friends_data = data.response.sort(sFirstName);

                // в value элемента будем записывать номер пользователя в массиве friends_data
                for(var i=0;i<fr;i++){
                    $('#friends_list').append('<option value="'+ i +'">'+ friends_data[i].first_name + ' ' + friends_data[i].last_name +'</option>');
                }


                $("#friends_list").change(function () {
                    // узнаем какой элемент выбран в select
                    selectVal = $('#friends_list option:selected').val();
                    if (selectVal!='') { // если выбран друг
                        // вытаскиваем из массива фотографию выбранного пользователя по номеру в массиве
                        $('#user_info').html('<img src="'+ friends_data[selectVal].photo +'"/>');
                    } else { // если выбрано "выберите друга"
                        // очищаем блок с аватаркой
                        $('#user_info').html('');
                    }
                })
            });


        });

        // выполняем запрос получения профля

        $('#send_btn').click(function() {
            if ($('#friends_list option:selected').val()!='') { // если выбран пользователь
                //if ($('#message_tf').val()!='') { // если введено сообщение
                    uid_to = friends_data[$('#friends_list option:selected').val()].uid; // id выбранного пользователя
                    $.ajax({
                           type:"GET",
                           url:"check",
                           data:{uid:viewer_id},
                           success:function(data){
                               friendStatus = data;
                              /* if(friendStatus=="0"){
                                   alert("Вы не можете отправить подарок больше 3 в день.");
                               }*/

                               if(friendStatus=="1"){

                                   message_to = $('#message_tf').val();
                                   var promo_message = "Вы получили подарок от "+userPersonalData+"\n";

                                   //var image = "photo"+friends_data[$('#friends_list option:selected').val()].photo_id;
                                   var image = "photo"+promoImageID;

                                   VK.api('wall.post',{owner_id:uid_to, message:promo_message, attachment:image},function(data) {
                                       if (data.response) { // если получен ответ

                                           $.ajax({
                                                   type:"POST",
                                                   url:"save",
                                                   data:{invite:viewer_id + "-" + uid_to},
                                                   success:function(data){
                                                       alert('Подарок успешно отправлен! ID сообщения: ' + data);
                                                   }
                                               }
                                           );

                                           // $('#post_info').html('<form action="save" method="post"><input type="hidden" name="invite" value="' + viewer_id + "-" + uid_to+'"><input type="submit" value="Продолжить"></form>');
                                       } else { // ошибка при отправке сообщения
                                           alert('Ошибка! ' + data.error.error_code + ' ' + data.error.error_msg);
                                       }
                                   });
                               }
                               else{
                                   alert("Вы не можете отправить подарок больше чем 3 друзьям в день.");
                               }
                           }
                        }
                    );

               /* } else {
                    alert('Введите сообщение!');
                }*/
            } else {
                alert('Выберите пользователя!');
            }

            return false;
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

    /* flapps.ru */
</script>
</head>
<body>

<table style="width: 607px;height:500px;">
    <tr>
        <td>

            <select id="friends_list">
                <option value="">Выберите друга</option>
            </select>

        </td>
        <td rowspan="3">

            <div id="user_info"></div>

        </td>
    </tr>

    <tr>
        <td>
            <a href="#" id="send_btn">Отправить</a>
        </td>
    </tr>
</table>


<br /><br /><br />

<div id="post_info">

</div>

</body>
</html>