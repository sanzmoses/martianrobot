# My own solution to the Martian Robot Programming Problem

### Architecture & Design Overview

#### There are 2 Objects
1. World
2. Robot

#### These are classes with its own attributes
* World
    * Attributes
        * Orientation
        * Coordinates
        * Status
        * Previous Coordinates
    * Methods
        * Move
        * Turn
        * Forward
        * Robot is Lost
        * And other helper methods

* Robot
    * Attributes
        * Area
        * Scent (_Array of scent_)
    * Methods
        * Check Position
        * Add Scent
        * Check for Scent

#### These objects meet in Process.php where the user input is process

Basically it:
* Trims the input
* Separates them and validates both
    * The world coordinates
    * Robot position and commands

* Processes the inputs by:
    * Instantiating the world area
    * Loop over robots position and commands
        * Instantiate the first robot
        * Loop over the commands one by one
            * Check for scent, return true if scent found
            * Call the move function and pass scent (_the forward method will act according to the scent value_)
            * Check if the robot is still inside the coordinates
                * if not call method __robotIsLost()__
                * then leave a scent in the area for the next robot
                * break the command loop
    * Record the result of the robot before looping back
    * Loop back over another robot or done

    * Report back the result to UI

### List of Assumptions

> No unit/automated tests

### An estimate of how long this would take if you were asked to build the entire solution for a customer

> Probably a week or two

### Source code 

> See code above