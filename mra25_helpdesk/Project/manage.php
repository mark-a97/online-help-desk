<?php

    session_start();
    ob_start();
    $currentPage = "Management";

    include('includes/navbar.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/admin.php');
    
    $admin = new Admin();

    if($modify === 0) {
        if($level < 2){
            header("Location: index.php");
        }
    }
   

    $functions->isLoggedIn();

    if(isset($_POST['updateSettings'])){
        $admin->addRole();
    }

  
?>



<main>


    <?php if($admin->errors > 0) {echo "<div class='error-div'><p class='error-message'>"; echo $admin->returnedMessage . "</p> </div>";
            }
        
            else if($admin->errors === 0 && $admin->returnedMessage == true) {
                echo "<div class='success-div'><p class='error-message'>"; echo $admin->returnedMessage . "</p> </div>";
            }
    ?> 
    <div class="inside-main">
    
        <form class='form-style' id='managementForm' method='POST'>
            <div class='form-manage' id='manage-form'>
            <h3 class='form-header'>Manage Website Settings</h3>
                <hr>

                <div class='profile-settings'>
                    <p class='settings-list'><label class='input-label' for="userSpeciality">Add department</label>
                        <input type="text" class='input-type' name="addDepartment"></p>

                    <p class='settings-list'><label class='input-label' for='addDepartment'>Remove department </label>
                        <?php $admin->getSettings('speciality') ?></p>

                    <p class='settings-list'><label class='input-label' for='addAdmin'>New admin: </label>
                        <?php $admin->getSettings('admin') ?>
                            <input type="checkbox" name="del-perms">
                            <label class='checkbox-perms' for="del-perms">Can delete</label>
                            <input type="checkbox" name="settings-perms">
                            <label class='checkbox-perms' for="settings-perms">Can modify</label>
                        
                    </p>

                    <div><p class='settings-list'><label class='input-label' for='changePerms'>Modify perms: </label>
                    <?php $admin->getSettings('perms') ?>
                        
                            <input type="checkbox" name="update-del-perms">
                            <label class='checkbox-perms' for="update-del-perms">Can delete</label>
                            <input type="checkbox" name="update-settings-perms">
                            <label class='checkbox-perms' for="update-settings-perms">Can modify</label>
                        
                    </p>
                   
                    <p class='settings-list'><label class='input-label' for='addAdmin'>Remove admin: </label>
                        <?php $admin->getSettings('admin-remove') ?> </p>
                    <input class='submit-btn' type='submit' name='updateSettings' value='Update'>

                </div>
            </div>
        </form>
    </div>
</main>


<?php
    include_once('includes/footer.php');
?>