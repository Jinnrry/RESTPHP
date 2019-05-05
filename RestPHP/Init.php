<?php
/**
 * Created by PhpStorm.
 * User: jiangwei
 * Date: 2019/5/7
 * Time: 下午2:22
 */

class Init
{

	/**
	 * 获取提交参数
	 * @return array
	 */
	function aGetParas()
	{
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'POST':
				return $_POST;
			case 'GET':
				return $_GET;
			case 'PUT':
				$aParas = [];
				parse_str(file_get_contents('php://input'), $aParas);
				return $aParas;
			case 'DELETE':
				$aParas = [];
				parse_str(file_get_contents('php://input'), $aParas);
				return $aParas;
			case 'PATCH':
				$aParas = [];
				parse_str(file_get_contents('php://input'), $aParas);
				return $aParas;
			case 'OPTIONS':
				$aParas = [];
				parse_str(file_get_contents('php://input'), $aParas);
				return $aParas;
			default:
				return [];
				break;
		}
	}


	private function bCheack($method, $sRequestMethod = 'GET')
	{
		$sDoc = $method->getDocComment();
		if (!$sDoc) return false;
		preg_match("/(?<=@method:).+/", $sDoc, $aMatches);
		return strtolower(trim($aMatches[0])) == strtolower($sRequestMethod);
	}


	public function run()
	{
		$aPath = explode("/", $_SERVER['PHP_SELF']);
		$sClass = $aPath[2] ? $aPath[2] . "Controller" : "IndexController";
		$sFunction = $aPath[3] ?: "Index";
		$sFileName = "./RESTPHP/Controller/" . $sClass . ".php";

	
		if (file_exists($sFileName)) {
			require_once("./RESTPHP/Controller/" . $sClass . ".php");
		} else {
			Printf::vSend("Controller Not Found!", 404);
		}

		try {
			$ref_class = new ReflectionClass($sClass);
			$instance = $ref_class->newInstance();
			$method = $ref_class->getmethod($sFunction);
			$method->setAccessible(true);

			if (!self::bCheack($method, $_SERVER['REQUEST_METHOD'])) {
				Printf::vSend("Method cannot be accessed", 404);
			}

			$aParameters = self::aGetParas();
			$re = $method->getParameters();    //获取对应函数的参数名称
			$functionParameter = array();
			foreach ($re as $index => $ReflectionParameterObject)     //遍历获得函数参数
			{
				if (isset($aParameters[$ReflectionParameterObject->name]))
					$functionParameter[$index] = $aParameters[$ReflectionParameterObject->name];
				else
					$functionParameter[$index] = null;
			}
			Printf::vFomatPrint($method->invoke($instance, ...$functionParameter));

		} catch (ReflectionException $e) {
			Printf::vSend("Method Not Found!", 404);
		}
	}
}