<?php
class RestApi
{
    protected $aPostArg=null;    //存储提交过来的数据
    function __construct($method)
    {
        if($_SERVER['REQUEST_METHOD'] == $method )
        {
            switch ($method) {
                case 'POST':
                    $this->aPostArg = $_POST;
                    if ( !isset($this->aPostArg['action'])  || $this->aPostArg['action']==''   )   //检查action是否存在
                    {
                        exit($this->buildJson(false,'action参数不存在',[]));
                    }
                    break;
                case 'GET':
                    $this->aPostArg = $_GET;
                    if ( !isset($this->aPostArg['action'])  || $this->aPostArg['action']==''   )   //检查action是否存在
                    {
                        exit($this->buildJson(false,'action参数不存在',[]));
                    }
                    break;
                case 'PUT':
                    parse_str(file_get_contents('php://input'), $this->aPostArg);
                    if ( !isset($this->aPostArg['action'])  || $this->aPostArg['action']==''   )   //检查action是否存在
                    {
                        exit($this->buildJson(false,'action参数不存在',[]));
                    }
                    break;
                case 'DELETE':
                    parse_str(file_get_contents('php://input'), $this->aPostArg);
                    if ( !isset($this->aPostArg['action'])  || $this->aPostArg['action']==''   )   //检查action是否存在
                    {
                        exit($this->buildJson(false,'action参数不存在',[]));
                    }
                    break;
                case 'PATCH':
                    parse_str(file_get_contents('php://input'), $this->aPostArg);
                    if ( !isset($this->aPostArg['action'])  || $this->aPostArg['action']==''   )   //检查action是否存在
                    {
                        exit($this->buildJson(false,'action参数不存在',[]));
                    }
                    break;
                case 'OPTIONS':
                    parse_str(file_get_contents('php://input'), $this->aPostArg);
                    if ( !isset($this->aPostArg['action'])  || $this->aPostArg['action']==''   )   //检查action是否存在
                    {
                        exit($this->buildJson(false,'action参数不存在',[]));
                    }
                    break;
                default:
                    break;
            }
        }
    }



    /**
     * 当action对应的函数不存在的时候给出错误返回
     * @param $name
     * @param $arguments
     * @return string
     */
    function __call($name, $arguments)
    {
        return $this->buildJson(false,'该action('.$name.')操作不存在',[]);
    }

    //获取方法里面的参数名
    function getFucntionParameterName($classname,$func)
    {
        try{
            $ReflectionMethod = new \ReflectionMethod($classname,$func);
        }catch (Exception $e){
            exit($this->buildJson(false,'该action('.$func.')操作不存在',[])) ;
        }

        return $ReflectionMethod->getParameters();
    }

    function run()
    {
        if ( !isset($this->aPostArg['action']))   //检查action是否存在
        {
            return;
        }
        $functionName=$this->aPostArg['action'];  //获取action对应的函数名
        $childClassName=get_class($this);         //获取子类的类名
        $re=$this->getFucntionParameterName( $childClassName ,$functionName  );    //获取对应函数的参数名称
        $functionParameter=array();
        foreach ($re as $index=>$ReflectionParameterObject)     //遍历获得函数参数
        {
            if(isset($this->aPostArg[$ReflectionParameterObject->name]))
                $functionParameter[$index]=$this->aPostArg[$ReflectionParameterObject->name];
            else
                $functionParameter[$index]=null;
        }

        echo $this->$functionName(...$functionParameter);


    }



    /**构建一个json格式数据
     * boolean status     表示请求是否成功
     * string msg    返回说明
     * array  data    返回数据
     */
    protected function buildJson($status,$msg,$data)
    {
        $args=array("status"=>$status,"data"=>$data,"msg"=>$msg);
        return json_encode($args);
    }

}