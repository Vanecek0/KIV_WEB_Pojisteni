<?php
namespace App\Core;

class Request {

    private array $urlParams = [];
    private array $baseUrlArray = [];

    public function __construct(string $url) {
        $this->urlParams = explode('/', $_GET['url'] ?? '/');
        $this->baseUrlArray = array_filter(array_slice(explode('/', $url), 0, -1));
    }

    public function get():array {
        return array_values(array_diff($this->urlParams, $this->baseUrlArray));
    }
}