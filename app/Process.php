<?php
session_start();
require('World.php');
require('Robot.php');

unset($_SESSION['error']);
unset($_SESSION['results']);

if(isset($_POST['process'])) {
    if($_POST['inputs']) {
        //clean input
        $str = trim(strtoupper($_POST['inputs']));
        //preserve original input
        $_SESSION['inputs'] = $str;
        //break into array
        $inputs = cleanInputs(explode(PHP_EOL, $str));
        //get 1st line the world coordinate
        $world_coordinates = rtrim(array_shift($inputs));
        
        //check validity
        if(validateInputs($world_coordinates, $inputs)) {
            //convert world coordinates to key value pairs
            $coordinates_array = coordinatesConverter($world_coordinates);
            start_process($coordinates_array, $inputs);
        }else {
            header("Location: ../");
        }

    } else {
        $_SESSION['error'] = 'Invalid Input!';
        header("Location: ../");
    }
}
else {
    header("Location: ../");
}

function cleanInputs($array) {
    for($x = 0; $x < count($array); $x++) {
        $array[$x] = trim($array[$x]);
    }

    return $array;
}

function coordinatesConverter($string) {
    $coordinates = explode(" ", $string);
    $arr = ['x'=>$coordinates[0], 'y'=>$coordinates[1]];
    return $arr;
}

function positionConverter($string) {
    $position = explode(" ", $string);
    $array = ['coordinates'=>['x'=>$position[0], 'y'=>$position[1]], 'orientation'=>$position[2]];
    return $array;
}

function validateInputs($world, $robotInputs) { 
    if(!preg_match("/^(\d{1,2}\s{1}\d{1,2})$/", $world)) {
        //if world coordinates are invalid
        $_SESSION['error'] = 'Invalid coordinates in line 1';
        return false;
    }

    $world_arr = explode(" ", $world);
    if($world_arr[0] > 50 || $world_arr[1] > 50) {
        $_SESSION['error'] = 'Maximum value for coordinates is 50 in line 1';
        return false;
    }

    if(count($robotInputs) % 2 || count($robotInputs) == 0) { 
        //if robot inputs are disproportionate
        $_SESSION['error'] = 'Uneven or lacks Input!';
        return false; 
    }

    //checking for robot inputs if correct
    for($x = 0; $x < count($robotInputs); $x++) {
        if($x % 2) {
            if(!preg_match("/^[LRF]+$/", $robotInputs[$x])) {
                $_SESSION['error'] = "'".$robotInputs[$x]."' Somethings wrong in line ".$x+=2;
                return false;
            } else if (strlen($robotInputs[$x]) > 99) {
                $_SESSION['error'] = "'".$robotInputs[$x]."' Commands too long in line ".$x+=2;
                return false;
            }
        } else {
            if(!preg_match("/^\d{1,2}\s{1}\d{1,2}\s{1}[NEWS]{1}+$/", $robotInputs[$x])){
                $_SESSION['error'] = "'".$robotInputs[$x]."' Somethings wrong in line ".$x+=2;
                return false;
            } 
            $robotCoordinates = explode(" ", $robotInputs[$x]);
            if($robotCoordinates[0] > 50 || $robotCoordinates[1] > 50) {
                $_SESSION['error'] = "'".$robotInputs[$x]."' Maximum value for coordinates is 50 ".$x+=2;
                return false;
            }

        }
    }

    return true;
}

function start_process($world_coordinates, $robots) {
    //instantiate world
    $mars = new World($world_coordinates);
    
    $results = "";
    //process the the robots one by one
    for($x = 0; $x < count($robots); $x+=2) {
        //prepare data for the robot
        $position = positionConverter($robots[$x]);
        $commands = str_split($robots[$x+1]);

        //instantiate a new robot
        $bot = new Robot($position['orientation'], $position['coordinates']);
    
        //loop through the commands
        foreach($commands as $command) {
            //foreach command check if there is a scent in the current position
            $scent = $mars->checkForScent($bot->getPosition());
            //pass the scent[true or false] into the move command
            $bot->move($command, $scent);

            //check if the robot is still in the designated area
            if(!$mars->checkPosition($bot->coordinates)) {
                //if not declare robot is lost
                $bot->robotIsLost();
                //robot leave a scent in previous position
                $mars->addScent($bot->getPrevPosition());
                //ignore all other commands to follow
                break;
            }
        }

        //record how the expidition went
        $results .= $bot->coordinates['x'].' '.$bot->coordinates['y'].' '.$bot->getOrientation().' <span class="status">'.$bot->status.'</span><br>';
    }

    $_SESSION['results'] = $results;
    header("Location: ../");
}
