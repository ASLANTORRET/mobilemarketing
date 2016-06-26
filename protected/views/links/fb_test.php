<body>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '850165548365822',
                xfbml      : true,
                version    : 'v2.0'
            });

            // Place following code after FB.init call.

            function onLogin(response) {

                if (response.status == 'connected') {
                    /*FB.ui({
                        'method':'apprequests',
                        'message':'Получи подарок "Lipton Ice Tea"\n Забирай здесь https://apps.facebook.com/aslantorrettester/',
                        'title':'Выберите из списка не более трех друзей'
                    });*/

                   /* FB.ui({method: 'apprequests',
                        message: 'YOUR_MESSAGE_HERE',
                        to: 'USER_ID'
                    }, function(response){
                        console.log(response);
                    });*/

                    /* make the API call */

                    /*FB.ui({method: 'apprequests',
                        message: 'YOUR_MESSAGE_HERE'
                    }, function(response){
                        console.log(response);
                    });*/


                   /* FB.api(
                        "/me/friends",
                        function (data) {
                            if (data && !data.error) {

                                alert(dump(data));
                            }
                        }
                    );*/
                }
            }

            FB.getLoginStatus(function(response) {
                // Check login status on load, and if the user is
                // already logged in, go directly to the welcome message.
                if (response.status == 'connected') {
                    onLogin(response);
                } else {
                    // Otherwise, show Login dialog first.
                    FB.login(function(response) {
                        onLogin(response);
                    }, {scope: 'user_friends, email'});
                }
            });

        };


        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


        function dump(arr,level) {
            var dumped_text = "";
            if(!level) level = 0;

            //The padding given at the beginning of the line.
            var level_padding = "";
            for(var j=0;j<level+1;j++) level_padding += "    ";

            if(typeof(arr) == 'object') { //Array/Hashes/Objects
                for(var item in arr) {
                    var value = arr[item];

                    if(typeof(value) == 'object') { //If it is an array,
                        dumped_text += level_padding + "'" + item + "' ...\n";
                        dumped_text += dump(value,level+1);
                    } else {
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    }
                }
            } else { //Stings/Chars/Numbers etc.
                dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
            }
            return dumped_text;
        }

    </script>

    <h1 id="fb-welcome"></h1>


</body>