<?php
/**
 * @author lin <465382251@qq.com>
 * 
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/bitmex-php.git
 * */

namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Order extends Request
{
    /**
     * Get your orders.
     * Parameter	  Value	Description	Parameter Type	Data Type
        symbol		    Instrument symbol. Send a bare series (e.g. XBU) to get data for the nearest expiring contract in that series.	query	string
        		            You can also send a timeframe, e.g. XBU:monthly. Timeframes are daily, weekly, monthly, quarterly, and biquarterly.		
        filter		        Generic table filter. Send JSON key/value pairs, such as {"key": "value"}. You can key on individual fields, and do more advanced querying on timestamps. See the Timestamp Docs for more details.	query	string
        columns		Array of column names to fetch. If omitted, will return all columns.	query	string
        		            Note that this method will always return item keys, even when not specified, so you may receive more columns that you expect.		
        count		    Number of results to fetch.	query	double
        start		        Starting point for results.	query	double
        reverse	        If true, will sort results newest first.	query	boolean
        startTime		Starting date filter for results.	query	date-time
        endTime		Ending date filter for results.	query	date-time
     * */
    public function get(array $data=[]){
        $this->type='GET';

        $data['reverse']=$data['reverse'] ?? 'true';
        $data['symbol']=$data['symbol'] ?? 'XBTUSD';
        $data['count']=$data['count'] ?? '100';
        $data['filter'] = isset($data['filter']) ? $data['filter'] : null;

        $this->path='/api/v1/order?'.http_build_query($data);
        
        var_dump($this->path);
        
        
        //$this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * 
     * */
    public function getOne(array $data){
        if(!isset($data['orderID']) && !isset($data['clOrdID']) ) return [];
        $symbol=$data['symbol'];
        unset($data['symbol']);
        
        $data=[
            'reverse'=>'true',
            'symbol'=>$symbol,
            'count'=>1,
            'filter'=>json_encode($data)
        ];
        
        return current($this->get($data));
    }
    
    /**
     *
     * */
    public function getAll(array $data){
        if(!isset($data['count'])) $data['count']=100;//默认100条
        
        $data['reverse']='true';
        
        return $this->get($data);
    }
    
    public function put(array $data){
        $this->type='PUT';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * $data=[
            'symbol'=>'XBTUSD',
            'price'=>'10',
            'side'=>'Sell  Buy',
            'orderQty'=>'10',
            'ordType'=>'Limit',
            
            'clOrdID'    Optional Client  ID
            
            More  https://www.bitmex.com/api/explorer/#!/Order/Order_new
        ];
     * */
    public function post(array $data){
        $this->type='POST';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * 
     * */
    public function delete(array $data){
        $this->type='DELETE';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     *
     * */
    public function deleteAll(array $data){
        $this->type='DELETE';
        $this->path='/api/v1/order/all';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function putBulk(array $data){
        $this->type='PUT';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function postBulk(array $data){
        $this->type='POST';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function postCancelAllAfter(array $data){
        $this->type='POST';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function postClosePosition(array $data){
        $this->type='POST';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
}