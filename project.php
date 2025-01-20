<?php

class BlueProject {

    public $id;
    public $planningType;
    public $start;
    public $end;

    function __construct($id,  $start, $end, $planningType) {
        $this->id = $id;
        $this->end = $end;
        $this->start = $start;
        $this->planningType = $planningType;
    }

    // Methods
    function set_planningType($planningType) {
        $this->planningType = $planningType;
    }
    function get_planningType() {
        return $this->planningType;
    }

}
?>

