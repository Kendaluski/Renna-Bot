<?php
use function Discord\getColor;
use Discord\Parts\Guild\Role;
use Discord\Parts\Channel\Message;
use Discord\Parts\Channel\Guild;
use Discord\Parts\User\Member;

if (stristr($mensaje,"-crearRol")) {
    $guild= $message->guild;
    $array=explode(" ",$mensaje);
    if (isset($array[1]) and isset($array[2])) {
        $color=getColor($array[2]);
        $nombre=$array[1];
        $guild->createRole([
            'name' => "$nombre",
            'color' => $color,
            'mentionable'=> 'true'
            ])->done(function (Role $role, Message $message){
            });
        $message->channel->sendMessage("Rol creado");
    }
}

if (stristr($mensaje,"-darRol")) { 
    $array=explode(" ",$mensaje);
    if (isset($array[1]) and isset($array[2])) {
        $id=substr($array[1],2,18);
        $member = $guild->members->get('id', $id);
        $role=substr($array[2],3,18);
        $tiene=false;
        foreach($member->roles as $rol) {
            if ($rol['id'] === $role) {
                $tiene=true;
            }
        }
        if ($tiene) {
            $message->channel->sendMessage("El usuario <@".$id."> ya cuenta con el rol <@&".$role.">");
        }
        else {
            var_dump($member);
            $member->addRole($role)->done(function () {});
            $message->channel->sendMessage("Se ha añadido el rol <@&".$role."> al usuario <@".$id.">");
        }
    }
}

if (stristr($mensaje,"-quitarRol")) {
    $array=explode(" ",$mensaje);
    if (isset($array[1]) and isset($array[2])) {
        $id=substr($array[1],2,18);
        $member = $guild->members->get('id', $id);
        var_dump($member);
        $role=substr($array[2],3,18);
        $tiene=false;
        foreach($member->roles as $rol) {
            if ($rol['id'] === $role) {
                $tiene=true;
            }
        }
        if ($tiene) {
            $member->removeRole($role)->done(function () {
        });
        $message->channel->sendMessage("Se ha quitado el rol <@&".$role."> al usuario <@".$id.">");
        }
        else {
            $message->channel->sendMessage("El usuario <@".$id."> no cuenta con el rol <@&".$role.">");
        }
    }
}
?>