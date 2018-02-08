# RESTPHP
一个超轻量级的PHP REST API框架

整个“框架”只有一个类，够轻吧！

实现了表单数据自动注入接口函数，But 目前只支持POST和GET方式提交~~~~ 待有时间再补充

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
