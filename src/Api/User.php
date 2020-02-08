<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class User extends Request
{
    public function get(){
        $this->type='GET';
        $this->path='/api/v1/user';
        
        return $this->exec();
    }
    
    public function put($data){
        $this->type='PUT';
        $this->path='/api/v1/user';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function post($data){
        
    }
    
    /**
     * 获取钱包余额
     * https://testnet.bitmex.com/api/v1/user/wallet?currency=XBt
     * */
    public function getWallet($data){
        $this->type='GET';
        $this->path='/api/v1/user/wallet?currency='. $data['currency'] ?? 'XBt';
        //$this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * 获取保证金余额
     * https://testnet.bitmex.com/api/v1/user/margin?currency=XBt
     * */
    public function getMargin($data){
        $this->type='GET';
        $this->path='/api/v1/user/margin';
        $this->data=$data;
        
        return $this->exec();
    }
}