<?php

class Robot 
{
    protected $orientation;
    protected $coordinates;
    public $status;
    protected $commands;
    protected $prevCoordinates;
    
    const orientations = ['N', 'E', 'S', 'W'];
    const turns = ['R'=>1, 'L'=>-1];

    public static $number_of_robots = 0;

    function __construct($orientation, $coordinates) {
        $this->orientation = array_search($orientation, Robot::orientations);
        $this->coordinates = $coordinates;
        $this->status = '';

        Robot::$number_of_robots++;
    }

    function __get($name) {
        return $this->$name;
    }

    public function move($command, $scented = false) {
        if($command == 'F') {
            if(!$scented){ $this->forward(); }
         } else {
            $this->turn($command);
         }     
    }

    protected function turn($command) {
        $key = $this->orientation + Robot::turns[$command];
        ($key > 3 || $key < 0) ? $this->correctOrientation($key): $this->orientation = $key;;
    }

    protected function correctOrientation($key) {
        ($key > 3)? $this->orientation = 0: $this->orientation = 3;
    }

    protected function forward() {
        //check for orientation and position
        $lookingToward = Robot::orientations[$this->orientation];
        
        $coordinate = 'y';
        $num = 1;

        switch ($lookingToward) {
            case 'N':  break;
            case 'S':  $num = -1; break;
            case 'E':  $coordinate = 'x'; break;
            default:  $coordinate = 'x'; $num = -1; break;
        }

        $this->prevCoordinates = $this->coordinates;
        $this->coordinates[$coordinate] += $num;
    }

    public function robotIsLost() {
        $this->status = 'LOST';
        $this->coordinates = $this->prevCoordinates;
    }

    public function getOrientation() {
        return Robot::orientations[$this->orientation];
    }

    public function getPosition() {
        //for adding scent
        return $this->getOrientation().$this->coordinates['x'].$this->coordinates['y'];
    }

    public function getPrevPosition() {
        //for checking scent
        return $this->getOrientation().$this->prevCoordinates['x'].$this->prevCoordinates['y'];
    }

}