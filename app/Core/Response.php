<?php
namespace App\Core;

class Response {

   public function setStatus(int $code) 
   {
      http_response_code($code);
   }
}