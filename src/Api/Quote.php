<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Quote extends Request
{
    public function get($data)
    {
        $this->type='GET';
        $this->path='/api/v1/quote';
        $this->data=$data;
        
        return $this->exec();
    }
}
