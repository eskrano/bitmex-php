<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class ApiKey extends Request
{
    public function get(){
        $this->type='GET';
        $this->path='/api/v1/apiKey';
        
        return $this->exec();
    }
    
    public function post(){
        
    }
    
    public function postDisable(){
        
    }
    
    public function delete($data){
        $this->type='DELETE';
        $this->path='/api/v1/apiKey';
        $this->data=$data;
        
        return $this->exec();
    }
}