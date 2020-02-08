<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex;

use GuzzleHttp\Exception\RequestException;
use Lin\Bitmex\Exceptions\Exception;

class Request
{
    /**
     * 是否开启bitmex测试账号，需要先去申请测试账号。
     * */
    protected $key='';
    
    protected $secret='';
    
    protected $host='';
    
    protected $nonce='';
    
    protected $signature='';
    
    protected $headers=[];
    
    protected $type='';
    
    protected $path='';
    
    protected $data=[];
    
    protected $timeout=10;
    
    public function __construct(array $data)
    {
        $this->key=$data['key'] ?? '';
        $this->secret=$data['secret'] ?? '';
        $this->host=$data['host'] ?? 'https://www.bitmex.com';
    }
    
    /**
     * 认证
     * */
    protected function auth(){
        $this->nonce();

        $this->signature();
        /*
        if ($this->type === 'GET' && !empty($this->data)) {
            $params = [
                'filter' => null,
                'columns' => null,
                'count' => null,
                'symbol' => null,
            ];

            if (is_array($this->data)) {
                foreach ($this->data as $k => $v) {
                    if ($k === 'columns' && is_array($v)) { // columns  = columnName[]
                        $params['columns'] = $v;
                    } else if ($k === 'count') {
                        $params['count'] = $v;
                    } else {
                        if ($k === 'symbol' && strlen($v) > 3) {
                            $params['filter'][$k] = $v;
                        } else if ($k === 'symbol' && strlen($v) <= 4) {
                            $params['symbol'] = $v;
                        } else {
                            $params['filter'][$k] = $v;
                        }
                    }
                }
            }

            var_dump($params, $this->path);

            if ($params['filter'] !== null  || $params['columns'] !== null || $params['count'] !== null || $params['symbol'] !== null) {
                /**
                 * If have params existing
                 *

                $this->path .= "?"; // gg wp

                if ($params['filter'] !== null) {
                    $this->path .= sprintf("filter=%s&", json_encode($params['filter']));
                }

                if ($params['columns'] !== null) {
                    $this->path .= sprintf("columns=%s&", json_encode($params['columns']));
                }

                if ($params['count'] !== null) {
                    $this->path .= sprintf("count=%d&", $params['count']);
                }

                if ($params['symbol'] !== null) {
                    $this->path .= sprintf("symbol=%s&", $params['symbol']);
                }

                $this->path = rtrim($this->path, "&");
            }

            var_dump($this->path, $this->data);
        }*/



        
        $this->headers();


    }
    
    /**
     * 过期时间
     * */
    protected function nonce(){
        $this->nonce = (string) number_format(round(microtime(true) * 100000), 0, '.', '');
    }
    
    /**
     * 签名
     * */
    protected function signature(){

        if ($this->type === 'GET') {
            $endata = null;
        } else {
            $endata=http_build_query($this->data);
        }
        $path = $this->path;

        $this->signature=hash_hmac('sha256', $this->type.$path.$this->nonce.$endata, $this->secret);
    }
    
    /**
     * 默认头部信息
     * */
    protected function headers(){
        $this->headers=[
            'accept' => 'application/json',
        ];
        
        if(!empty($this->key) && !empty($this->secret)) {
            $this->headers=array_merge($this->headers,[
                'api-expires'      => $this->nonce,
                'api-key'=>$this->key,
                'api-signature' => $this->signature,
            ]);
        }
        
        if(!empty($this->data)) $this->headers['content-type']='application/x-www-form-urlencoded';
    }
    
    /**
     * 发送http
     * */
    protected function send(){
        $client = new \GuzzleHttp\Client();
        
        $data=[
            'headers'=>$this->headers,
            'timeout'=>$this->timeout
        ];
        
        if($this->type !== 'GET' && !empty($this->data)) $data['form_params']=$this->data;

        if ($this->type === 'GET' && !empty($this->data)) {
            $this->path .= '?'.http_build_query($this->data);
        }

        $response = $client->request($this->type, $this->host.$this->path, $data);

        return $response->getBody()->getContents();
    }
    
    /*
     * 执行流程
     * */
    protected function exec(){
        $this->auth();
        
        //可以记录日志
        try {
            return json_decode($this->send(),true);
        }catch (RequestException $e){
            if(method_exists($e->getResponse(),'getBody')){
                $contents=$e->getResponse()->getBody()->getContents();
                
                $temp=json_decode($contents,true);
                
                if (preg_match('/overload/i', $temp['error']['message'])) {
                    $this->auth();
                    try {
                        return json_decode($this->send(),true);
                    } catch (RequestException $e) {
                        throw new Exception($temp);
                    }
                }
                
                if(!empty($temp)) {
                    $temp['_method']=$this->type;
                    $temp['_url']=$this->host.$this->path;
                }else{
                    $temp['_message']=$e->getMessage();
                }
            }else{
                $temp['_message']=$e->getMessage();
            }
            
            $temp['_httpcode']=$e->getCode();
            
            //TODO  该流程可以记录各种日志
            throw new Exception(json_encode($temp));
        }
    }
}
