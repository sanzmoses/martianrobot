<?php

class World 
{
    public $area;
    public $scent;

    function __construct($area) {
        $this->area = $area;
        $this->scent = array();
    }

    public function getArea() {
        return $this->area;
    }

    public function checkPosition($robot_coordinates) {
        if($robot_coordinates['x'] > $this->area['x'] 
        || $robot_coordinates['x'] < 0) {
            return false;
        }

        if($robot_coordinates['y'] > $this->area['y'] 
        || $robot_coordinates['y'] < 0) {
            return false;
        }

        return true;
    }

    public function addScent($prevPosition) {
        array_push($this->scent, $prevPosition);
    }

    public function checkForScent($position) {
        return in_array($position, $this->scent);
    }
}