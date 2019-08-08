<?php

namespace QaqPay;

class Pay {
    public $Charset = 'utf-8';

    private $secret_key = '';

    /**
     * 验证签名
     */
    public function verifySign($param,$secret_key)
    {
        $sign = $param['sign'];
        # 去除secret_key
//        unset($param['secret_key']);
        unset($param['sign']);

        if ($this->generateSign($param,$secret_key) !== $sign) {
            throw new \Exception('签名错误');
        }
        return true;
    }

    /**
     * 生成签名
     */
    public function generateSign($param, $secret_key)
    {
        # 排序并进行url编码
        $urlparam = $this->getUrlParam($param);
        $sign = md5($urlparam.$secret_key);
        return $sign;
    }


    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *  if is null , return true;
     **/
    protected function checkEmpty($value) {
        if (!isset($value)) return true;
        if ($value === null) return true;
        if (trim($value) === "") return true;

        return false;
    }

    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {

        if (!empty($data)) {
            $fileType = $this->Charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //				$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }


    /**
     * 做数组排序并进行urlparam处理
     */
    public function getUrlParam($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, $this->Charset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }


    /**
     * 此方法对value做urlencode
     */
    public function getUrlencode($params) {
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, $this->Charset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . urlencode($v);
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . urlencode($v);
                }
                $i++;
            }
        }

        unset ($k, $v);
        // urlencode 会把空格转换成 +  这里需要把 + 替换成 %20
        $stringToBeSigned = str_replace('+','%20',$stringToBeSigned);

        return $stringToBeSigned;
    }


}