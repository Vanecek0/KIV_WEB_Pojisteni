<?php

class App {
    public function __construct() {
        echo 'PHP version: ' . phpversion();
        echo $this->bullshit();
    }

    public function bullshit():string {
        return "bullshit";
    }
}