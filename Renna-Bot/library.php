<?php
    function crearRol($guild,$rol,$color,$pos) {
        $tiene=false;
        foreach($guild->roles as $roles) {
            if ($roles['name'] === $rol) {
                $tiene=true;
            }
        }
        if($tiene==false) {
            $guild->createRole([
                'name' => "$rol",
                'color' => $color,
                'mentionable'=> 'true',
                'position'=> $pos
                ])->done(function (Role $role, Message $message){});
        }
    }
    
    function obtenerRol($guild,$rol) {
        foreach($guild->roles as $roles) {
            if ($roles['name'] === $rol) {
                $role=$roles['id'];
            }
        }
        return $role;
    }
    
    function updateLevel ($message,$user,$nivel,$rol,$conex,$gid) {
        $message->channel->sendMessage("¡Enhorabuena <@".$user.">, has alcanzado el nivel ".$nivel."! Ahora tienes el rol ".$rol);
        $update2="UPDATE l$gid SET level=$nivel where id=".$user;
        $resul4=mysqli_query($conex,$update2);
    }

    function cambiarRoles ($message,$role,$user,$nivel,$rol,$conex,$gid,$anterior,$guild) {
            $member=$message->member;
            $member->addRole($role)->done(function () {});
            updateLevel($message,$user,$nivel,$rol,$conex,$gid);
            $rolant=obtenerRol($guild,$anterior);
            $member->removeRole($rolant)->done(function () {});
    }

    function test_permisos($member) {
        $tiene_permisos=false;
        foreach ($member->roles as $rol) {
            if ($rol['permissions']['manage_roles']==true and $rol['permissions']['kick_members'] ==true and $rol['permissions']['administrator']==true and $rol['permissions']['manage_guild']==true and $rol['permissions']['moderate_members']==true) {
                $tiene_permisos=true;
            }
        }
        return $tiene_permisos;
    }
?>