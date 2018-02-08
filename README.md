# RESTPHP
一个超轻量级的PHP REST API框架

使用示例 test.php

<?php

require_once "RestApi.php";

class postapitest extends Ko_App_RestApi{

    //会自动将POST中的name和id和news 字段注入到 $name $id  $news变量中
    //当POST中的action值为  ttc的时候会调用这个方法
    function  ttc($name,$id,$news)
    {
        return $this->buildJson(true,'POST接口',["name"=>$name,"id"=>$id,"n"=>$news]);
    }


    //会自动将POST中的name和id字段注入到 $name $id 变量中
    //当POST中的action值为  tt的时候会调用这个方法
    function  tt($name,$id)
    {
        return $this->buildJson(true,'POST接口',["name"=>$name,"id"=>$id]);
    }

}

class getapitest extends Ko_App_RestApi{
    //会自动将GET中的name和id和news 字段注入到 $name $id  $news变量中
    //当GET中的action值为  ttc的时候会调用这个方法
    function  ttc($name,$id,$news)
    {
        return $this->buildJson(true,'GET接口',["name"=>$name,"id"=>$id,"n"=>$news]);
    }


    //同上
    function  tt($name,$id)
    {
        return $this->buildJson(true,'GET接口',["name"=>$name,"id"=>$id]);
    }

}

$api=new postapitest('POST');
$api->run();

$getapi=new getapitest('GET');
$getapi->run();



这时即可通过get或者post方法访问http://xxxx/test.php
