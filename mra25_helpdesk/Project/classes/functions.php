<?php
class Functions{

    
    public $errors = 0;
    public $returnedMessage;

    public function getErrors(){
        return $this->errors;
    }
    public function getMessage(){
        return $this->returnedMessage;
    }

    
    public function checkPriority($priority){
        switch($priority){
            case 'Low':
                echo "<td role='cell' id='priority_low'>".$priority."</td>";
                break;
            case 'Medium':
                echo "<td role='cell' id='priority_medium'>".$priority."</td>";
                break;
            case 'High':
                echo "<td role='cell' id='priority_high'>".$priority."</td>";
                break;

        }
    }

    public function convertDate($date, $value){
        if($value === 'date'){
            $currDate = date('m/d/Y h:i:s', time()); //this second
            $date = date_format($date, "F j, Y h:i");
            return $date;
        }
        else if($value === 'days'){
            $currDate = date('m/d/Y h:i:s', time()); //this second
            $origin = new DateTime($currDate);
            $interval = $date->diff($origin);
            $days = $interval->format('%R%a days');
            return $days;
        }
    }


    
    public function hidePhone($phone){
        $first = substr($phone, 0, 2); // finds first 2 digits
        $last = str_repeat('*', strlen($phone) - 4) . substr($phone, -4); // replacing all with * until the last 4 digits
        $str2 = substr($last, 4); 
        return $first . $last;
    }

    public function hideEmail($email){
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        $len  = floor(strlen($name)/2);
        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
    }

          
    public function valueChecks($value, $type, $alphaNumeric, $max_length, $min_length){
        trim($value);
        if($alphaNumeric != NULL){
            if($alphaNumeric == "YES"){
                if(!ctype_alnum($value)){
                    $this->errors ++;
                    $this->returnedMessage = $type . " must be alpha numerical";
                }
            }
            else if($alphaNumeric == "NO"){
                if(ctype_alnum($value)){
                    $this->errors ++;
                    $this->returnedMessage = $type . " must not be alpha numerical";
                }
            }
            else if($alphaNumeric == "NUMBERS_ONLY"){
                if(!is_numeric($value)){
                    $this->errors ++;
                    $this->returnedMessage = $type . " must not contain letters";
                }
    
            }
            else if($alphaNumeric == "TEXT_ONLY"){
                if(is_numeric($value)){
                    $this->errors ++;
                    $this->returnedMessage = $type . " must not contain numbers";
                }
            }
        }


        else if($type === "Password"){
            $uppercase    = preg_match('@[A-Z]@', $value);
            $lowercase    = preg_match('@[a-z]@', $value);
            $number       = preg_match('@[0-9]@', $value);
            $specialChars = preg_match('@[^\w]@', $value);

            if(!$uppercase || !$lowercase || !$number || !$specialChars) {
                $this->errors ++;
                $this->returnedMessage = $type . " Password requirements: 8 characters, one lowercase, one uppercase, one number, and one special character";
            }
        }
        if(strlen($value) > $max_length){
            $this->errors ++;
            $this->returnedMessage = $type . " must be of suitable length (too high)";
        }
        if(strlen($value) < $min_length){
            $this->errors ++;
            $this->returnedMessage = $type . " must be of suitable length (too small)";
        }
    }

    
    public function isLoggedIn(){
        $logged_in = $_SESSION['id'];
        if(!isset($logged_in)) {
            header("Location: login.php");
        }
    }


  





}//Closing