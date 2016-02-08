function statusChangeCallback(response) {
    console.log('Facebook API >> statusChangeCallback');
    console.log(response);
    console.log('Facebook API >> Response status: ' + response.status);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      connectUser();
    }else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      disconnectUser();
    }else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      disconnectUser();
    }
}

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

window.fbAsyncInit = function() {
  FB.init({
    appId      : '1667530230157770',
    cookie     : true,  // enable cookies to allow the server to access
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.4' // use version 2.2
  });

  // Now that we've initialized the JavaScript SDK, we call
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

};

  // Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
function connectUser(){
    console.log('Facebook API >> Fetching information ... ');
    FB.api('/me?fields=id,name,first_name,last_name,picture', function(response){
      console.log('Facebook API >> Successful login for: ' + response.name);

      Interface.closePopUp('logIntoFb-box');

      if(!Engine.getCookie('AcceptationCookies') || Engine.getCookie('AcceptationCookies') != 1){
        Interface.showPopUp("welcome-box");
      }
      Engine.logUser(response.id, response.first_name, response.last_name, "http://graph.facebook.com/" + response.id + "/picture");
    });
}

function disconnectUser()
{
  $.post("src/php/executor.php", { action: "logOut"}, function(data){
    console.log(data.reply);

    if(data.result){
      Interface.loadHeader();
      Interface.loadModel('home');
      Interface.showPopUp("logIntoFb-box");
    }else {

    }

  }, "json");
}

function disconnectApp()
{
  FB.api('/me/permissions', 'delete', function(response){
    disconnectUser();
  });
}
