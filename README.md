# RESTPHP
一个轻量级的PHP REST API框架


简介：实现了使用注解配置接口的请求方法。

例如，声明一个GET接口只需要在对应函数的注释里写上@method:GET


使用示例 index.php

    <?php

    require_once "RestPHP/autoload.php";




Controller/IndexController.php

	<?php
	class IndexController
    {
    	/**
    	 * 会自动将请求参数中的name值注入到这个函数的name参数中
    	 * 声明这个接口是POST调用
    	 * @method:POST
    	 */
    	public function Index($name)
    	{
    		return [
    			"_code" => 200,
    			"_message" => '成功！',
    			"name" => "小米"
    		];
    	}
    
    
    	/**
    	 * 会自动将请求参数中的name,id值注入到这个函数的name,id参数中
    	 * 声明这个接口是GET调用
    	 * @method:get
    	 */
    	public function test($id, $name)
    	{
    		return array(
    			"id" => $id,
    			"name" => $name
    		);
    	}
    }

对应接口：

GET: http://localhost/index.php/Index/test?name=xiaoming&id=22

返回：
	
	{"data":{"id":"22","name":"xiaoming"},"message":"success","code":200}


POST: http://localhost/index.php

	{"data":{"name":"\u5c0f\u7c73"},"message":"\u6210\u529f\uff01","code":200}
