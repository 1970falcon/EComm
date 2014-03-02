<?php

class Availability {

    public static function display($availability) {
        return ($availability == 0) ? "Out of Stock" : "In Stock";
    }

    public static function displayClass($availability) {
        return ($availability == 0) ? "outofstock" : "instock";
    }
}

?>
