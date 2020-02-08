<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class OrderBook extends Request
{
    /**
     * 
     * @param array symbol=XBTUSD&depth=25
     * */
    public function get(array $data=['symbol'=>'XBTUSD','depth'=>100]){
        $this->type='GET';
        $this->path='/api/v1/orderBook/L2?symbol='.$data['symbol'].'&depth='. $data['depth'];
        $this->data=[];
        
        return $this->exec();
    }
}