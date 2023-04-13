<?php
use function Discord\getColor;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;
use Discord\Parts\Guild\Role;
include_once('library.php');

$user=$message->author->id;
$guild=$message->guild;
$gid=$guild->id;
$conex=mysqli_connect("85.159.212.188","renna","rennabotroot","renna_bot") or die("Error:".mysqli_error($conex));
$sql="SELECT messages,level from l$gid where id = ".$user;
$resul=mysqli_query($conex,$sql);
if (mysqli_num_rows($resul)==0) {
    $sql1="INSERT INTO l$gid VALUES(".$user.",0,0)";
    $resul2=mysqli_query($conex,$sql1);
}
else {
    $row=mysqli_fetch_row($resul);
    $num_mens=$row[0]+1;
    $update="UPDATE l$gid SET messages=".$num_mens." where id= ".$user;
    $resul3=mysqli_query($conex,$update);
    switch($num_mens) {
        case 1:
            $nivel=1;
            $rol='Cobre';
            $role=obtenerRol($guild,$rol);
            $member=$message->member;
            $member->addRole($role)->done(function () {});
            updateLevel($message,$user,$nivel,$rol,$conex,$gid);
            break;
        case 24:
            $rol='Plomo';
            $color=getColor('#3c5173');
            $pos=3;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 25:
            $nivel=2;
            $rol='Plomo';
            $role=obtenerRol($guild,$rol);
            $anterior='Cobre';
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 49:
            $rol='Plata';
            $color=getColor('#f6f9fa');
            $pos=5;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 50:
            $nivel=3;
            $rol='Plata';
            $role=obtenerRol($guild,$rol);
            $anterior='Plomo';
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 99:
            $rol='Tungsteno';
            $color=getColor('#4c7749');
            $pos=7;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 100:
            $nivel=4;
            $rol='Tungsteno';
            $anterior='Plata';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 199:
            $rol='Oro';
            $color=getColor('#baa510');
            $pos=9;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 200:
            $nivel=5;
            $rol='Oro';
            $anterior='Tungsteno';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 299:
            $rol='Meteorita';
            $color=getColor('#5a2a3e');
            $pos=11;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 300:
            $nivel=6;
            $rol='Meteorita';
            $anterior='Oro';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 399:
            $rol='Crimsonita';
            $color=getColor('#8f2225');
            $pos=13;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 400:
            $nivel=7;
            $rol='Crimsonita';
            $anterior='Meteorita';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 499:
            $rol='Inframundita';
            $color=getColor('#ee6644');
            $pos=15;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 500:
            $nivel=8;
            $rol='Inframundita';
            $anterior='Crimsonita';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 599:
            $rol='Cobalto';
            $color=getColor('#3aa5c5');
            $pos=17;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 600:
            $nivel=9;
            $rol='Cobalto';
            $anterior='Inframundita';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 699:
            $rol='Mythril';
            $color=getColor('#66a561');
            $pos=19;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 700:
            $nivel=10;
            $rol='Mythril';
            $anterior='Cobalto';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 799:
            $rol='Adamantita';
            $color=getColor('#de5499');
            $pos=21;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 800:
            $nivel=11;
            $rol='Adamantita';
            $anterior='Mythril';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 899:
            $rol='Clorofita';
            $color=getColor('#4ec029');
            $pos=23;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 900:
            $nivel=12;
            $rol='Clorofita';
            $anterior='Adamantita';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
        case 999:
            $rol="Luminita";
            $color=getColor('#96eac3');
            $pos=10;
            crearRol($guild,$rol,$color,$pos);
            break;
        case 1000:
            $nivel=979;
            $rol="Luminita";
            $member=$message->member;
            $anterior='Clorofita';
            $role=obtenerRol($guild,$rol);
            cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild);
            break;
    }
}
$mensaje=$message->content;
if (stristr($mensaje,"-level")) {
    $uid=$message->author->id;
    $sql="SELECT * from l$gid WHERE id=$uid";
    $resul=mysqli_query($conex,$sql);
    $row=mysqli_fetch_row($resul);
    $message->channel->sendMessage("<@$uid>, tu nivel es $row[2]");
}
?>