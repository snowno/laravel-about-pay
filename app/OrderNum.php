<?php

namespace App;
/**
 *
 *  0        41        51      64
+------+-----------+------+------+
| sign |   time    |  pc  | inc  |
+------+-----------+------+------+
 *  前41bits是以微秒为单位的timestamp。
 *  接着10bits是事先配置好的机器ID。
 *  最后12bits是累加计数器。
 *  macheine id(10bits)标明最多只能有1024台机器同时产生ID，sequence number(12bits)也标明1台机器1ms中最多产生4096个ID，
 *
 */

class OrderNum {

    private static $workerId = '007';  // 机器ID
    private static $maxWorker = 255; // 最大机器数

    private static $sequence = 0;  // 同一毫秒序列号
    private static $maxSequence = 4095; // 同一毫秒最大序列号

    private static $lastTimestamp = -1; // 最后时间戳
    private static $timestampLeft = 20;

    private static $workerLeft = 8;

    public function __construct($workerId = 101)
    {
        if ($workerId > self::$workerId || $workerId < 0){
            throw new Exception("worker id noavlied", 1);
        }
        self::$workerId = $workerId;
    }

    public static function getTimestamp()
    {
        $timestamp = microtime(true);
        return str_replace('.', '', sprintf("%0.3f", $timestamp));
    }

    public function updateTimestamp($lastTimestamp)
    {
        $timestamp = self::getTimestamp();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = self::getTimestamp();
        }
        return $timestamp;
    }

    public static function getId()
    {
        $timestamp = self::getTimestamp();
        if (self::$lastTimestamp == $timestamp) {
            self::$sequence = (self::$sequence + 1) & self::$maxSequence;

            if (self::$sequence == 0) {
                $timestamp = self::updateTimestamp($lastTimestamp);
            }
        }else {
            self::$sequence = 0;
        }

        self::$lastTimestamp = $timestamp;
        // echo "Sequence:".self::$sequence, " Timestamp: ".$timestamp,"\n";
        return ($timestamp << self::$timestampLeft) | (self::$workerId << self::$workerLeft) | self::$sequence;
    }

    public static function __callStatic($method, $params = array())
    {
        $static = new Static;
        if (!method_exists($static, $method)) {
            throw new Exception($method." Not Exists", 1);
        }
        call_user_func_array(array($static, $method), $params);
    }

    public static function outTradeNo($category = 1)
    {
        //return  date('YmdHis',time()) . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        //echo $sn."\n";
        return self::getTimestamp().self::$workerId.self::getId();
    }

}