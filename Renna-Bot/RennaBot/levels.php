<?php
$user=$message->author->id;
$conex=mysqli_connect("85.159.212.188","renna","rennabotroot","renna_bot") or die("Error:".mysqli_error($conex));
$sql="SELECT messages,level from users where id = ".$user;
$resul=mysqli_query($conex,$sql);
if (mysqli_num_rows($resul)==0) {
    $sql1="INSERT INTO users VALUES(".$user.",0,1)";
    $resul2=mysqli_query($conex,$sql1);
}
else {
    $sql1="SELECT messages,level FROM users WHERE id= ".$user;
    $resul2=mysqli_query($conex,$sql1);
    //Recibo datos de la bd
    $row=mysqli_fetch_row($resul2);
    //Sumo 1 al número de mensajes
    $num_mens=$row[0]+1;
    //Lo subo a la bd
    $update="UPDATE users SET messages=".$num_mens." where id= ".$user;
    $resul3=mysqli_query($conex,$update);
    //Compruebo los mensajes para los niveles
    switch($num_mens) {
        case 1:
            $nivel=1;
            break;
        case 5:
            $nivel=2;
            break;
        case 10:
            $nivel=3;
            break;
        case 20:
            $nivel=4;
            break;
        case 30:
            $nivel=5;
            break;
        case 40:
            $nivel=6;
            break;
        case 50:
            $nivel=7;
            break;
    }
    if (isset($nivel)) {
        $message->channel->sendMessage("¡Enhorabuena <@".$user.">, has subido al nivel ".$nivel."!");
        $update2="UPDATE users SET users.level=$nivel where users.id=".$user;
        $resul4=mysqli_query($conex,$update2);
    }
}
?>