<?php
$_SERVER = array();
//创建一个tcp套接字,并监听8088端口
if($web = stream_socket_server('0.0.0.0:8088',$errno,$errstr)){
    while(true){
        $conn = @stream_socket_accept($web);
        if($conn){
            $_SERVER = array();
            decode(fgets($conn));
            fwrite($conn,encode("访问方法是:".$_SERVER['REQUEST_METHOD']."\n请求变量是:".$_SERVER['QUERY_STRING']));
            fclose($conn);
        }
    }
}else{
    die($errstr);
}
//http协议解码
function decode($info){
    global $_SERVER;
    list($header,) = explode("\r\n\r\n",$info);
    //将请求头变为数组
    $header = explode("\r\n",$header);
    list($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_SERVER['SERVER_PROTOCOL']) = explode(' ', $header[0]);
    $_SERVER['QUERY_STRING'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
}
//http协议加密
function encode($str){
    $content = "HTTP/1.1 200 OK\r\nServer: vruan_web/1.0.0\r\nContent-Length: " . strlen($str   )."\r\n\r\n{$str}";
    return $content;
}