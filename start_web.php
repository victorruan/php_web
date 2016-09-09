<?php
//创建一个tcp套接字,并监听8088端口
if($web = stream_socket_server('0.0.0.0:8088',$errno,$errstr)){
    while(true){
        $conn = @stream_socket_accept($web);
        if($conn){
            fwrite($conn,encode(fgets($conn)));
            fclose($conn);
        }
    }
}else{
    die($errstr);
}
//http协议解码
function decode(){

}
//http协议加密
function encode($str){
    $content = "HTTP/1.1 200 OK\r\nServer: vruan_web/1.0.0\r\nContent-Length: " . strlen($str   )."\r\n\r\n{$str}";
    return $content;
}