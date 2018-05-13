<?php 
    //start a session - users browser
    session_start();

    //setting a cookie
    $sessionID = session_id(); //storing session id

//check token already generated or not
if(empty($_SESSION['tokenkey']))
{
    //generate and set the token to the SESSION
    $_SESSION['tokenkey']=bin2hex(random_bytes(32));
    
}

//generate CSRF token
$token = sha1( $_SESSION['tokenkey']. $_SESSION['sessionId'].'IT16128200' );
    

setcookie("session_id",$sessionID,time()+3600,"/","localhost",false,true); //cookie terminates after 1 hour - HTTP only flag
setcookie("csrf_token",$token,time()+3600,"/","localhost",false,true); //csrf token cookie


?>


<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>


<style>
.backdrop-modal{
    
    padding: 64px;
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.8); /* Black w/ opacity */
    
}

.login-area{
    margin: 0px auto;
    position: relative;
    width: 500px;
    height: 500px;
    background: #ffffff;
    padding: 32px;
    vertical-align: middle;
   
   
}
.close-button{
    margin-left: auto;
    margin-right: 0;
    margin-bottom: 15px;
    width: 20px;
    height: 20px;
   
}

.social-button{
    border-radius: 4px;
    border: none;
    width: 100%;
    height: 45px;;
    margin-bottom: 10px;
}

.facebook{
    margin-top:10px;
    background: #3b5998;
    
}
.google{

    background: #ffffff;
    border: 2px solid #d63031;
}

.fb-button-desc div{

    display: table;
    display: inline-block;
    vertical-align: middle;
}

.google-button-desc div{
    display: table;
    display: inline-block;
    vertical-align: middle;
}

.fb-button-text{

    text-align: center;
    padding: 4px 0;
    color: #ffffff;
    font-family: Montserrat;
    font-size: 18px;
    line-height: 25px;
    text-align: center;
    padding: 4px 0;
}
.google-button-text{

    text-align: center;
    padding: 4px 0;
    color: #484848;
    font-family: Montserrat;
    font-size: 18px;
    line-height: 25px;
    text-align: center;
    padding: 4px 0;
}
.fb-icon{

    vertical-align: middle;
    width:25px;
    height: 25px;
    fill: #ffffff;
}
.google-icon{

    width:20px;
    height: 20px;
    fill: #ffffff;
}
svg{

    height: 100%;
    width: 100%;
}

.email-login-topic{

    border-bottom: 1px solid #d8d8d8;
    font-family: 'Muli';
    font-size: 15px;
    line-height: 17px;
    text-align: center;
    margin-bottom: 15px;
}

.email-login-topic span{
   
    background:#FFF;
    position:relative;
    bottom:-8px;
    padding:0 15px;
}

.email-login{

    padding-top: 15px;
    position: relative;
}

.text-container{
    width: 100%;
    height: 45px;
    border: 1px solid #d8d8d8;
    margin-bottom: 10px;

}

.text-container input{

    vertical-align: middle;
    width: 98%;
    height: 42px;
    border: none;
    font-size: 20px;
    padding-left: 15px;
    font-family: 'Muli';
   
}

.remember{
    position: relative;
    padding-top: 6px;

}

.containerz {
    font-family: 'Muli';
    position: relative;
    padding-left: 25px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 15px;
    line-height: 16px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  
}

/* Hide the browser's default checkbox */

.containerz input {
    
    opacity: 0;
    cursor: pointer;
   
}

/* Create a custom checkbox */
.checkmark {
 
    position: absolute;
    top: 0;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: #fff;
    border: 1px solid  #484848;
}

/* On mouse-over, add a grey background color */
.containerz:hover input ~ .checkmark {
    border: 1px solid  #5f27cd;
}

/* When the checkbox is checked, add a blue background */
.containerz input:checked ~ .checkmark {
    background-color: #5f27cd;
    border: 1px solid  #5f27cd;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.containerz input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.containerz .checkmark:after {
    left: 5px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

.log-button{
    width: 100%;
    height: 45px;
    background-color: #796eff;
    border: none;
    border-radius: 2px;
    color: #FFF;
    font-family: 'Muli';
    font-size: 19px;
    margin-top:25px;
}

.login-link-area{
    position: relative;
    vertical-align: middle;
}
.login-link-area div{
    
    display: inline-block;
}

.reset-link-area{
    font-size: 15px;
    line-height: 16px;
    font-family: 'Muli';
    position: absolute;
    right:0;
    bottom: 12px;
}

a{
    text-decoration: none;
    color: inherit;
}

.login-signup{
    font-family: 'Muli';
    font-size: 19px;
    padding-top: 20px;
    text-align: center;
}

</style>

</head>
<body>

<div id="login" class="backdrop-modal">
    <div class="login-area">
      
      <div class="social-login">
        <div class="fb-login-area">
          <form>
            <button type="button" aria-busy="false" class="facebook social-button">
              <span class="fb-button-desc">
                <div class="fb-icon">
                  <svg viewBox="0 0 512 512">
                    <path d="M211.9 197.4h-36.7v59.9h36.7V433.1h70.5V256.5h49.2l5.2-59.1h-54.4c0 0 0-22.1 0-33.7 0-13.9 2.8-19.5 16.3-19.5 10.9 0 38.2 0 38.2 0V82.9c0 0-40.2 0-48.8 0 -52.5 0-76.1 23.1-76.1 67.3C211.9 188.8 211.9 197.4 211.9 197.4z"
                    />
                  </svg>
                </div>
                <div class="fb-button-text">Login with Facebook</div>
              </span>

            </button>
          </form>
        </div>
        <div class="goole-login-area">
          <form>
            <button type="button" aria-busy="false" class="google social-button">
              <span class="google-button-desc">
                <div class="google-icon">
                  <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 18px; width: 18px; display: block;">
                    <g fill="none" fill-rule="evenodd">
                      <path d="M9 3.48c1.69 0 2.83.73 3.48 1.34l2.54-2.48C13.46.89 11.43 0 9 0 5.48 0 2.44 2.02.96 4.96l2.91 2.26C4.6 5.05 6.62 3.48 9 3.48z"
                        fill="#EA4335"></path>
                      <path d="M17.64 9.2c0-.74-.06-1.28-.19-1.84H9v3.34h4.96c-.1.83-.64 2.08-1.84 2.92l2.84 2.2c1.7-1.57 2.68-3.88 2.68-6.62z"
                        fill="#4285F4"></path>
                      <path d="M3.88 10.78A5.54 5.54 0 0 1 3.58 9c0-.62.11-1.22.29-1.78L.96 4.96A9.008 9.008 0 0 0 0 9c0 1.45.35 2.82.96 4.04l2.92-2.26z"
                        fill="#FBBC05"></path>
                      <path d="M9 18c2.43 0 4.47-.8 5.96-2.18l-2.84-2.2c-.76.53-1.78.9-3.12.9-2.38 0-4.4-1.57-5.12-3.74L.97 13.04C2.45 15.98 5.48 18 9 18z"
                        fill="#34A853"></path>
                      <path d="M0 0h18v18H0V0z"></path>
                    </g>
                  </svg>
                </div>
                <div class="google-button-text">Log in with Google</div>
              </span>

            </button>
          </form>
        </div>
      </div>

      <div class="email-login-topic">
        <span>Login with user name</span>
      </div>
      <form class="email-login" method="POST" action="server.php">
        <div class="text-container">
          <div class="email-icon icon"></div>
          <input type="text" placeholder="User name" id="login-email" name="user_name">

        </div>
        <div class="text-container">
          <div class="email-icon icon"></div>
          <input type="password" placeholder="Password" id="login-pass" name="user_pass">
          <input type="hidden" id="csrfToken" name="CSRF" value="<?php echo $token; ?>"/>
        </div>

        <div class="login-link-area">
          <div class="remember">

            <label class="containerz">Remember Me
              <input type="checkbox" checked="checked">
              <span class="checkmark"></span>
            </label>

          </div>
          <div class="reset-link-area">
            <a href="/password-forgot" class="forgot-link" aria-busy="false">Forgot my password!</a>
          </div>
        </div>


         <input type="submit" class="log-button" name="submit" value="Log in" />
      </form>

      <div class="login-signup">
        <span>New to CS?</span>
        <span class="login-signup-link">
          <a href="/sign_up">Sign up</a>
        </span>
      </div>
    </div>
  </div>
  <?php 
        //Check if the session-id cookie is set,
       if(isset($_COOKIE['session_id']))
            { 
                //get the csrf token and set it in the hidden field
                echo '<script> var token = onLoad();  </script>'; 
                   
                  
            }
    ?>

</body>
</html>
