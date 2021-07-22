<?php
    session_start();
    ob_start();
    $currentPage = "FAQ";
    $message = "";

    include('includes/navbar.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/admin.php');

    $admin = new Admin();
    $functions->isLoggedIn();
    $adminCheck = $user->isAdmin();

    if(isset($_POST['addFAQ'])){
        $admin->faq('add');
    }
    if(isset($_POST['delFAQ'])){
        $admin->faq('del');
    }

    if(isset($_GET['updatedFAQ'])){
        if($_GET['updatedFAQ'] == "True"){
            $message = $admin->returnedMessage = "Question successfully added";
        }
        else if($_GET['updatedFAQ'] == "False"){
            $admin->errors ++;
            $message = $admin->returnedMessage = "Problem with adding question";
        }
    }
    else if(isset($_GET['deletedFAQ'])){
        if($_GET['deletedFAQ'] == "True"){
            $message = $admin->returnedMessage = "Question successfully removed";
        }
        else if($_GET['deletedFAQ'] == "False"){
            $admin->errors ++;
            $message = $admin->returnedMessage = "Problem with removing question";
        }
    }

?>



<main>
        <?php if($admin->errors > 0) {echo "<div class='error-div'><p class='error-message'>"; echo $message . "</p> </div>";
            }
        
            else if($admin->errors === 0 && $admin->returnedMessage == true) {
                echo "<div class='success-div'><p class='error-message'>"; echo $message . "</p> </div>";
            }
        ?>  

    <div class="inside-main">
     
        <form class='form-style' id='faq-form' method='POST'>
            <div class='form-manage' id='inside-faq-form'>
            <h3 class='form-header'>Frequently Asked Questions</h3>
                            <hr>
                <?php if($user->isAdmin() === 2){
                        
                    echo "
                    <div class='tooltip'><span id='btnAddFaq'><i class='fas fa-2x fa-plus-circle'></i><p class='tooltip-view'>Add</p></span></div>
                    <div class='tooltip'><span id='btnRemoveFaq'><i class='fas fa-2x fa-trash-alt'></i><p class='tooltip-view'>Remove</p></span></div>
                    ";
                    }
                ?>
                    
                <ol class='faq-display'>
                    <?php $user->displayFAQ(); ?>
                </ol>
            </div>
        </form>
                
    

        
        <div class='form-manage' id='create-ticket-popup'>
            <form class="popup-create-ticket" method='POST'>
                <span id='close-btn'><i class="fas fa-times-circle"></i></span>
            
                <h3 class='form-header'>Add Question</h3>
                <hr>
                <p class='settings-list'><label class='input-label' for="faq-topic">Topic</label>
                <input type='text' class='faq-inputs' placeholder='Topic...' name='faq-topic'></p>

                <p class='settings-list'><label class='input-label' for="faq-question">Question</label>
                <input type='text' class='faq-inputs' placeholder='Question...' name='faq-question'></p>

                <p class='settings-list'><label class='input-label' for="faq-answer">Answer</label>
                <textarea maxlength='250' id='faq-add-textarea'  class='faq-inputs' placeholder='Answer...' name='faq-answer'></textarea></p>
                <span class='text-limit'>250 characters remaining</span>

                <input class="submit-btn" type="submit" id="addQuestion" name="addFAQ" value="Add Question">
            </form>
        </div>

        <div class='form-manage' id='remove-faq-popup'>
            <form class="popup-create-ticket" method='POST'>
                <span id='close-btn-faq'><i class="fas fa-times-circle"></i></span>
            
                <h3 class='form-header'>Remove Question</h3>
                <hr>

                <?php $admin->getSettings('faq');?>
                <p class='settings-list'><label class='input-label' for="faq-answer">Answer</label>
                <textarea maxlength='250' id='faq-textarea' class='faq-textarea' placeholder='Answer...' name='faq-answer'></textarea></p>
                <span id='add-textarea' class='text-limit'>250 characters remaining</span>

                <input class="submit-btn" type="submit" id="deleteQuestion" name="delFAQ" value="Delete Question">
            </form>
        </div>

                </div>
    
    
</main>
    
    
<?php
    include_once('includes/footer.php');
?>
