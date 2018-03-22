<?php
class Pwd
{
	// public $str;//明文密码
	// public $cipher;//密文密码
	// function __construct($str=null,$cipher=null)
	// {
	// 	$this->str = $str;
	// 	$this->cipher = $cipher;
	// }
	// var_dump($str);
	// 逆序
	function toCipher()
	{
		if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$this->str) || !is_numeric(substr($this->str,0,1))) 
		{
			return '密码以数字开头，且只能由数字和字母组成';
		}

		// 逆序
		$str = strrev($this -> str);
		for($i=0;$i<strlen($str);$i++)
		{
			static $cipher=null;
			if(is_numeric($str[$i]))
			{
				// 数字加一
				$str[$i] = $str[$i]+1;
				// 数字加.
				$cipher .= $str[$i].'.';
			}
			// 数字重复一遍
			$cipher .= $str[$i];
		}
		return $cipher;
	}		

	//////////////////////////////// 接下来反加密的步骤////////////////
	function toDecode() 
	{
		// 根据.讲字符串拆成数组
		$arr = explode('.',$this -> cipher);
		// var_dump(explode('.',$cipher));
		// 将.之后的每一个数字去掉（因为这个是重复的），但是数组中第一个元素不处理
		foreach ($arr as $key => $value){
		// 如果下标为0则不执行去除操作
			if ($key) {
				$arr[$key]=substr($value,1);
			}
			// 将元素逆序
			$arr[$key] = strrev($arr[$key]);	
		}
		// var_dump($arr);
		// 将数组逆序
		$arr = array_reverse($arr);
		// var_dump($arr);
		// 将含有字母的元素中的数字减一
		foreach ($arr as $key => $value){
			// var_dump($value-1);
			// 长度大于1的都是含有字母的
			if(strlen($value)>1) {
				// 提取出来字母
				$char = substr($value, 1);
				// 将数字减一
				$num = $value-1;
				$arr[$key] = $num . $char;
			}
			// 将数字类型的减一
			if (strlen($value)==1) {
				$arr[$key] = $value-1;
			}
		}
		// var_dump($arr);
		$password = join('',$arr);
		return $password;
	}
}

// 加密类
class toCipher extends Pwd
{
	public $str;//明文密码
	function __construct($str=null)
	{
		$this->str = $str;
	}
}
// 解密类
class toDecode extends Pwd
{
	public $cipher;//明文密码
		
	function __construct($cipher=null)
	{
		$this->cipher = $cipher;
	}
}

// $password = new toCipher('123qw');
// echo $password ->toCipher();
// echo '<br/>';
// $password = new toDecode('wwq4.48.32.2');
// echo $password ->toDecode();
// 使用的时候直接在其他php页面包含过去就然后调用下面的两个类就可以了