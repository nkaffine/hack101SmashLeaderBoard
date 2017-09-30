<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 11:20 AM
 */

    // Show an error and stop the script
    function showerror($connection){
        // If there was an error in the connection
        if(mysqli_connect_errno()){
            die("Error " . mysqli_connect_errno($connection) . " : " .
                mysqli_connect_error($connection));
        }
    }

    //Cleaning up the input from the user
    function clean($input, $maxLength) {
        // Acces the mysqli connection from outside of the function
        global $connection;

        // Limit the length of the string
        $input = substr($input, 0, $maxLength);

        // Escapes the semicolons and single quotes if maginc quotes are off.
        if(get_magic_quotes_gpc()){
            $input = stripslashes($input);
        }
        $input = mysqli_real_escape_string($connection, $input);
        return $input;
    }

    function loginCheck(){
        if(!isset($_COOKIE['users'])){
            header("Location: /index.php");
            exit;
        }
        session_start();
        $_SESSION['id'] = $_COOKIE['users'];
        return $_COOKIE['users'];
    }

    function apiLoginCheck() {
        if(!isset($_COOKIE['users'])){
            throw new Exception("not logged in");
        }
        session_start();
        $_SESSION['id'] = $_COOKIE['users'];
        return $_COOKIE['users'];
    }

    // Checks if there is only one row in the result
    function notUnique($result){
        return (mysqli_num_rows($result) != 1);
    }

    function validInputSizeAlpha($uncleanString, $maxLength) {
        $sizedString=substr($uncleanString, 0, $maxLength);
        $cleanString= preg_replace("[^\.a-zA-Z' ]",'',$sizedString);
        return($cleanString);
    }
    function validInputSize($uncleanString, $maxLength) {
        $cleanString=substr($uncleanString, 0, $maxLength);
        return($cleanString);
    }
    function validNumbers($uncleanString, $maxLength) {
        $cleanString=substr($uncleanString, 0, $maxLength);
        $cleanString = preg_replace("[^\.0-9]",'',$cleanString);
        return($cleanString);
    }
    function validInputDate($uncleanString, $maxLength) {
        $cleanString=substr($uncleanString, 0, $maxLength);
        //This should be in the form MM/DD/YYYY
        if(preg_replace("[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}", $cleanString)){
            //Check to see if it is a date before today

            $cleanDate = $cleanString;
        }
        //But is could be in the form MM/DD/YY
        elseif(ereg("[0-9]{1,2}/[0-9]{1,2}/[0-9]{2}", $cleanString)) {
            echo "Hey, I am a part year!";
            $monthNumber = substr($cleanString,0,2);
            $day = substr($cleanString,3,2);
            $partYear = substr($cleanString,6,2);
            $year = "20" . $partYear;
            echo "DAy: $day, Month $monthNumber, year $partYear";
            $cleanDate = $monthNumber . "/" . $day. "/" .$year ;
        }
        else{
            # This is not a good date
            $cleanDate = 'BAD';
        }
        return($cleanDate);

    }
    function validDate($uncleanString, $maxLength) {

        $cleanString=substr($uncleanString,0,$maxLength);
        if (preg-match("[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}", $cleanString)) {
            $dateString=split('/',$cleanString);
            $cleanDate=$dateString[2] .'-' .$dateString[0] .'-' . $dateString[1];
        }
        return($cleanDate);
    }
    function validInputDateIsPast($uncleanString, $maxLength) {
        $cleanString=substr($uncleanString, 0, $maxLength);
        $today=time();
        //This should be in the form MM/DD/YYYY
        if(ereg("[0-9]{2}/[0-9]{2}/[0-9]{4}", $cleanString)){
            //Check to see if it is a date before today
            $monthNumber = substr($cleanString,0,2);
            $day = substr($cleanString,3,2);
            $year = substr($cleanString,6,4);
            $thisTime=mktime(0,0,0,$monthNumber, $day, $year);
            if ($thisTime >= $today) {
                $isPast='0';
            }
            else {
                //This date is in the past
                $isPast='1';
            }
            $cleanDate = $cleanString;
        }
        //But it could be in the form MM/DD/YY
        elseif(ereg("[0-9]{2}/[0-9]{2}/[0-9]{2}", $cleanString)) {
            $monthNumber = substr($cleanString,0,2);
            $day = substr($cleanString,3,2);
            $partYear = substr($cleanString,6,2);
            $year = "20" . $partYear;
            $cleanDate = $monthNumber . "/" . $day. "/" .$year ;
            $thisTime=mktime(0,0,0,$monthNumber, $day, $year);
            if ($thisTime >= $today) {
                $isPast='0';
            }
            else {
                //This date is in the past
                $isPast='1';
            }
        }
        else{
            # This is not a good date
            $cleanDate = 'BAD';
        }
        return array($cleanDate, $isPast);

    }
    function isDefined ($value){
        $exists = FALSE;
        if(isset($value) && ($value != ''  && $value != ' ')){
            $exists =TRUE;
        }
        return $exists;
    }
    function convertDBDate ($dbDate){

        $year = substr($dbDate,0,4);
        $monthNumber = substr($dbDate,5,2);
        if (substr($monthNumber,0,1) == '0'){
            $monthNumber  = substr($dbDate,6,1);
        }
        $day = substr($dbDate,8,2);
        $monthName = getMonthName($monthNumber);
        $readableDate = $monthName . " " . $day . ", " . $year;
        return $readableDate;


    }
    function flipDBDate ($dbDate){

        $year = substr($dbDate,0,4);
        $monthNumber = substr($dbDate,5,2);

        $day = substr($dbDate,8,2);

        $readableDate = $monthNumber. "/" . $day . "/" . $year;
        return $readableDate;


    }
    function flipDateBacktoDB ($formDate){
        $year = substr($formDate,6,4);
        $monthNumber = substr($formDate,0,2);
        $day = substr($formDate,3,2);
        $dbDate = $year. "-" . $monthNumber . "-" . $day;
        return $dbDate;
    }
    function addDays ($dbDate, $numDays){
        $year = substr($dbDate,0,4);
        $monthNumber = substr($dbDate,5,2);
        $day = substr($dbDate,8,2);
        $day=$day+$numDays;
        $newDate = date("Y-m-d", mktime(0, 0, 0, $monthNumber, $day, $year));
        return $newDate;
    }
    function getMonthName ($monthNumber){
        $months = array (' ','January','February','March','April','May','June','July','August','September','October','November','December');
        $monthName=$months[$monthNumber];
        return ($monthName);

    }
    function getTimeAndUnit ($classLengthIn){

        if (($classLengthIn < 1) && ($classLengthIn !=0)) {
            $classLengthOut = $classLengthIn*8;
            $timeUnit = "hour";
        }
        else {
            $classLengthOut = $classLengthIn;
            $timeUnit = "day";
        }

        if ($classLengthOut > 1) {
            $timeUnit = $timeUnit .'s' ;
        }



        return array($classLengthOut, $timeUnit);

    }
    function convertHoursToDays ($classLengthIn, $classTimeUnit){
        /* One day is 8 hours */
        if ($classTimeUnit == 'hours' )  {
            $classLengthOut = $classLengthIn/8;
        }
        else {
            $classLengthOut = $classLengthIn;
        }


        return $classLengthOut;

    }

    function error($error_code){
        $message = "Something went wrong, please contact the administrator. Error code: {$error_code}";
        header("Location: /error.php?message=" . urlencode($message));
        exit;
    }

    function debug($error){
        header("Location: /error.php?message=" . urlencode($error));
        exit;
    }

    function badAlert($message, $class){
        return"<div class='".$class."' style='margin-top:2%;'>
                        <div class='panel panel-danger'>
                            <div class='panel-heading'>Alert:</div>
                            <div class='panel-body'>{$message}</div>
                        </div>
                    </div>";
    }
    function getGMT($date){
        return gmdate('Y-m-d H:i:s', strtotime($date));
    }
    function process_date($date, $page1, $page2){
        $date = preg_replace("[/0-9]",'',$date);
        if(strpos($date, "/") !== false){
            $pos = strpos($date, "/");
        } else {
            error($page1."-4");
        }
        $month = substr($date, 0 , $pos);
        if(strlen($month) == 1){
            $month = "0" . $month;
        }
        $date = substr($date, $pos + 1, strlen($date));
        if(strpos($date, "/") !== false){
            $pos = strpos($date, "/");
        } else {
            error($page2."-4");
        }
        $day = substr($date, 0, $pos);
        $date = substr($date, $pos + 1, strlen($date));
        if(strpos($date, " ")){
            $pos = strpos($date, " ");
        } else {
            $pos = strlen($date);
        }
        $year = substr($date, 0, $pos);
        if(strlen($year) == 2){
            $year = "20" . $year;
        }

        return $year.'-'.$month.'-'.$day." 00:00:00";
    }
    function commaSeparate($balance){
        $balance = strrev($balance);
        $point = strpos($balance, ".");
        $balance2 = substr($balance, $point+1, strlen($balance));
        $decimals = substr($balance, 0 ,$point + 1);
        $balance = $balance2;
        $balance1 = "";
        while ((strlen($balance) / 3) >= 1) {
            $balance1 = $balance1. substr($balance, 0, 3) . ",";
            $balance = substr($balance, 3, strlen($balance) - 3);
        }
        if ($balance == ""){
            return strrev(substr($balance1, 0, strlen($balance1)-1));
        } else {
            return strrev($decimals . $balance1 . $balance);
        }

    }
    function getTag($user_id){
        global $connection;
        $query = "select tag from users where user_id = {$user_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            error("Query Failed");
        }
        if(notUnique($result)){
            error("User Not Found");
        }
        $row = @ mysqli_fetch_array($result);
        return $row['tag'];
    }
?>