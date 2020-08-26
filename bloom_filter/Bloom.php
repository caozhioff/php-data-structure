<?php


//php实现布隆过滤器 二进制向量和一系列随机映射函数
//缓存穿透是指查询一个根本不存在的数据，缓存层和存储层都不会命中，但是出于容错的考虑，如果从存储层查不到数据则不写入缓存层。简单说，就查询一个不存在的 key，因为没有缓存，就会去数据库查询，从而达到穿透缓存。增大数据库压力的险恶目的。


require_once 'Hash.php';

abstract class ABliimFilterRedis {
	protected $hashFunction;
	protected $bucket;
	private $hashObj;
	private $redis;

	public function __construct()
	{
		if (!$this->bucket || !$this->hashFunction) {
			throw new Exception("Error");	
		}

		$this->hashObj = new HashCodes;
		$this->redis = static::getRedis();
	}

	//获取redis连接
	public static function getRedis()
	{
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		$redis->select(1);
		return $redis;
	}

	public function add($string)
	{
		foreach ($this->hashFunction as $key => $func) {
			$hash = $this->hashObj->$func($string);
			$this->redis->setBit($this->bucket, $hash, 1);
		}

		return true;
	}

	//不存在结果肯定无偏差，存在结果会存在一定偏差
	public function isExists($string)
	{
		$res = [];
		foreach ($this->hashFunction as $key => $func) {
			$hash = $this->hashObj->$func($string);
			$res[] = $this->redis->getBit($this->bucket, $hash);
		}
		foreach ($res as $b) {
			if ($b == 0) return false;
		}

		return true;
	}
} 


class FilterOne extends ABliimFilterRedis {
	protected $bucket = 'bucket';

	protected $hashFunction = ['JSHash', 'PJWHash', 'ELFHash'];
}


$f = new FilterOne;
$f->add('a');
$f->add('b');
$f->add('c');
$f->add('d');
$f->add('e');

var_dump($f->isExists('b'));
var_dump($f->isExists('t'));