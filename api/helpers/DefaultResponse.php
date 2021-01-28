<?php


include_once 'ErrorCodes.php';

class DefaultResponse extends ErrorCodes
{
    private $res;

    function __construct()
    {
        $this->res['status'] = false;
        $this->res['msg'] = "Unknown error occured";
        //$this->res['version'] = "9";
        $this->res['errorCode'] = parent::getUNKNOWERROR();
    }

    public function clear()
    {
        $this->res = null;
        $this->__construct();
    }

    public function setStatus($status)
    {
        $this->res['status'] = $status;
    }

    public function setMsg($msg)
    {
        $this->res['msg'] = $msg;
    }
    public function setSndrId($snd)
    {
        $this->res['sendrId'] = $snd;
    }

    public function setErrorCode($errCode)
    {
        $this->res['errorCode'] = $errCode;
    }
    
    public function setVersion($version)
    {
        $this->res['version'] = $version;
    }

    public function setCustomRsp($key, $val)
    {
        $this->res[$key] = $val;
    }

    public function getResponse()
    {
        return stripslashes(json_encode($this->res));
    }

}