<?php
    session_start();
    ob_start();
    $currentPage = "Dashboard";
    $message = "";

    // include('includes/dbConnect.php');
    include('includes/navbar.php');

    
    // $db = new Database;
    $functions->isLoggedIn();
    $adminCheck = $user->isAdmin();

    if(isset($_POST['updateAccount'])) {
        $message = $user->returnedMessage;
        $user->updateAccount();
    }

?>



    <main id='main-id'>


    <form class='form-style' method='POST' enctype='multipart/form-data'>
    <?php if($level >= 1){ ?>
        <div class="row">
            <div class="column">
                <div class="card"><span class='dash-icon'><i class="fas fa-5x fa-clipboard-check"></i></span><p class='dash-number'><?php $user->getDashInfo('completed');?></p><p class='dash-subject'>Tickets Completed</p></div>
            </div>
            <div class="column">
                <div class="card"><span class='dash-icon'><i class="fas fa-5x fa-clipboard-list"></i></span><p class='dash-number'><?php $user->getDashInfo('active');?></p><p class='dash-subject'>Active Tickets</p></div>
            </div>
            <div class="column">
                <div class="card"><span class='dash-icon'><i class="fas fa-5x fa-user-shield"></i></span><p class='dash-number'><?php $user->getDashInfo('admins');?></p><p class='dash-subject'>Current Admins</p></div>
            </div>
        </div>
        <?php } ?>
        
    
        <?php if($user->errors > 0) {echo "<div class='error-div'><p class='error-message'>"; echo $user->returnedMessage . "</p> </div>";
            }
        
        else if($user->errors === 0 && $user->returnedMessage == true) {
            echo "<div class='success-div'><p class='error-message'>"; echo $user->returnedMessage . "</p> </div>";
        }
    ?> 
        <!-- <h2 id='form-heading'>User Settings</h2> -->
        <div class='image-container'>
            <?php $user->getImg('user-settings'); ?>
            <input type="file" name="file" id="file" class="file" />
            <?php $user->getDetails(); ?>
        </div>
        <div class='form-content'>
        <h3 class='form-header'>Change Information</h3>
        <hr>
        
            <div class='profile-settings'>
                    <h4>General Settings</h4>

                    <p class='settings-list'><label class='input-label' for="forename">Forename</label>
                    <input id='input-forename' type="text" class='input-type' name="forename" ></p>

                    <p class='settings-list'><label class='input-label' for="surname">Surname</label>
                    <input id='input-surname' type="text" class='input-type' name="surname" ></p>

                    <p class='settings-list'><label class='input-label' for="name">Username</label>
                    <input id='input-username' type="text" class='input-type' name="name" ></p>

                    <p class='settings-list'><label class='input-label' for="email">Email</label>
                    <input id='input-email' type="text" class='input-type' name="email" ></p>

                    <p class='settings-list'><label class='input-label' for="email_confirm">Email confirm</label>
                    <input id='input-confirm-email' type="text" class='input-type' name="email_confirm" ></p>

                    <p class='settings-list'><label class='input-label' for="phone">Mobile</label>
                    <input id='input-mobile' type="text" class='input-type' name="phone" ></p>

                                <?php if($user->isAdmin() >= 1){ 
                              echo "<p  id='role-option' class='settings-list'><label for='userRole' class='input-label'>Role: </label>
                              <select class='select-input' name='usergroup'>
                              <option value='none' selected disabled hidden> Select an Option 
                              </option>";
                              
                    
                    $user->showRoles();     
                    echo "</select></p>"; 
                    }
                ?>
            </div>
                
            <div class='profile-settings'>
            <h4>Password Settings</h4>
                    <p class='settings-list'><label class='input-label' for="current_password">Current password</label>
                    <input id='input-password-old' type="password" class='input-type' name="current_password" ></p>

                    <p class='settings-list'><label class='input-label' for="new_password">New password</label>
                    <input id='input-password' type="password" class='input-type' name="new_password" ></p>

                    <p class='settings-list'><label class='input-label' for="new_password_confirm">Password confirm</label>
                    <input id='input-password-confirm' type="password" class='input-type' name="new_password_confirm" ></p>
            </div>


        <input class='submit-btn' type='submit' value='Update' name='updateAccount'>
                </div>
    </form>
            
    </main>


    </div>
<?php
    include_once('includes/footer.php');
?>
