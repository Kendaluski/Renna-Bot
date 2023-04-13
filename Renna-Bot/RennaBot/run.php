<?php

include __DIR__.'/vendor/autoload.php';


use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;
use Discord\Parts\Guild\Role;
use Discord\Parts\Channel\Channel;

use function Discord\getColor;

$discord = new Discord([
    'token' => 'OTUyNTMxMzQ1Njg5NjczNzQ5.Yi3X8Q.XRxeNfDyxGBBsWxYveWXiB17oGA',
    'intents' => [Intents::GUILDS, Intents::GUILD_BANS, Intents::GUILD_INTEGRATIONS, Intents::GUILD_MEMBERS, Intents::GUILD_MESSAGES]
]);


$discord->on('ready', function ($discord){
    echo "Renna está encendida\n";

    $discord->on("MESSAGE_CREATE", function(Message $message, Discord $discord){
    if ($message->author->id != $discord->id) {
        $mensaje=$message->content;
        if ($mensaje=="-help") {
             $message->channel->sendMessage("Hola " . $message->author->username . "\n \n 
             **Aquí tienes una lista de mis comandos:** \n \n 
             -crearRol 'nombre' 'color' Creo un rol con ese nombre y ese color (El color debe ir en inglés) \n \n 
             -crearCanal 'nombre' Crearé un canal de texto con el nombre especificado, si no especificas nombre, no crearé el canal \n \n
             -crearCanalVoz 'nombre' Crearé un canal de voz con el nombre especificado \n \n
             -ping Respondo con Pong, sirve para comprobar si estoy funcionando \n \n");
             print_r($message->channel);
        }
        if ($mensaje=="-ping") {
            $message->channel->sendMessage("Pong");
        }
        if (stristr($mensaje,"-crearRol")) {
                $guild= $message->guild;
                $array=explode(" ",$mensaje);
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
        if (stristr($mensaje,"-crearCanalVoz")) {
            $guild=$message->guild;
            $canal=substr($mensaje,15,120);
            $nuevoCanal=$guild->channels->create([
                'name' => $canal,
                'type' => Channel::TYPE_VOICE,
                'parent_id' => '952531834686808114'
            ]);
            $guild->channels->save($nuevoCanal)->done(function (Channel $channel) {});
            $message->channel->sendMessage("Canal de Voz creado");
        }
        else if (stristr($mensaje,"-crearCanal")) {
            $guild= $message->guild;
            $canal=substr($mensaje,12,120);
            $nuevoCanal= $guild->channels->create([
                'name' => $canal,
                'type' => Channel::TYPE_TEXT,
                'topic' => "prueba",
                'nsfw' => false,
                'parent_id' => '952531834686808114'
            ]);
            $guild->channels->save($nuevoCanal)->done(function (Channel $channel) {});
            $message->channel->sendMessage("Canal de Texto creado");
        }
    }
    });
});

while (true) {
    $discord->run();
}
