<?php
    session_start();
    ob_start();

    $currentPage = "Login";
    $message = "";
   
    include('includes/navbar.php');

    if(isset($_POST['btnLogin'])) {

        $user->login();
        $email = $_POST['fEmail'];
        $message = $user->returnedMessage;
    }
    
?>



<main>
        
<?php 
if($user->errors > 0) {echo "<div class='error-div'><p class='error-message'>"; echo $user->returnedMessage . "</p> </div>";
            }
        
    ?> 
         
    <div class="inside-main">


        <div class='auth-div'>
            <form class='auth-form' action="login.php" method="POST">
                <h3 class='form-header'>Login</h3>
                <hr>
                <input id='email-login' type="email" class='auth-input' name="fEmail" placeholder='Email'>
                <input id='password-login' type="password" class='auth-input' name="fPassword" placeholder='Password'>

                <div>
                    <input class='authenticate-btn' type="button" id="btnRegister" value="Register">
                    <input class="authenticate-btn" type="submit" id='btnLogin' name="btnLogin" value="Login"></input>
                </div>
            </form>
        </div>
    </div>

</main>
    <?php
    include_once('includes/footer.php');
?>