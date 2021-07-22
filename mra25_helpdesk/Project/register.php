<?php
    session_start();
    ob_start();

    $currentPage = "Register";
    include('includes/navbar.php');
  
    if(isset($_POST['btnRegister'])) {
        $user->register();   
    }
?>

    <main>
    
    <?php if($user->errors > 0) {echo "<div class='error-div'><p class='error-message'>"; echo $user->returnedMessage . "</p> </div>";
            }
        
    ?> 
    <div class="inside-main">
        <div class='auth-div'>
            <form class='auth-form' action="register.php" method="POST">
                <h3 class='form-header'>Register</h3>
                <hr>
                <input class='auth-input' id='input-username' type="text" name="fUsername" placeholder='Username *' value='<?php if(isset($_POST['fUsername'])) {echo $_POST['fUsername'];}  ?>'>
                <input class='auth-input' id='input-forename' type="text" name="forename" placeholder='First Name *' value='<?php if(isset($_POST['forename'])) {echo $_POST['forename'];}  ?>'>
                <input class='auth-input' id='input-surname' type="text" name="surname" placeholder='Last Name *' value='<?php if(isset($_POST['surname'])) {echo $_POST['surname'];}  ?>'>
                <input class='auth-input' id='input-mobile' type="text" name="mobile" id='mobileInput' placeholder='Mobile Number' value='<?php if(isset($_POST['mobile'])) {echo $_POST['mobile'];}  ?>'>
                <input class='auth-input' id='input-email' type="email"  name="fEmail" placeholder='Email *'>
                <input class='auth-input' id='input-pass' type="password"  name="fPassword" placeholder='Password *' ><div class='pass-show-div'><i id='show-pass'class='fas fa-eye'></i></div>
                <input class='auth-input' id='input-confirm' type="password"  name="confirm_password" placeholder='Confirm Password *'>

                <div>
                    <input class='authenticate-btn' type="button" id="btnBack" value="Back">
                    <input class='authenticate-btn' type="submit" name="btnRegister" id="btnRegister" value='Register'>
                </div>
            </form>
        </div>
    
    </div>
    </main>
    <?php
    include_once('includes/footer.php');
?>