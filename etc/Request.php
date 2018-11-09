<?php

namespace Framework;

use Framework\Interfaces\RequestInterface;

class Request implements RequestInterface
{
   public $query;
   public $post;
   public $file;
   public $session;
   public $server;

   public function __construct($query = [], $post = [], $file = [], $session = [], $server = [])
   {
       $this->query = $query;
       $this->post = $post;
       $this->file = $file;
       $this->session = $session;
       $this->server = $server;
   }


   public static function createFromGlobals()
   {
       return new self($_GET, $_POST, $_FILES, $_SESSION, $_SERVER);
   }
}