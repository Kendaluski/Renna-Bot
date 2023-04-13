<?php
use Discord\Discord;
use Discord\Parts\Channel\Channel;
if (stristr($mensaje,"-crearCanalVoz")) {
    $array=explode(" ",$mensaje);
    if(isset($array[1])) {
        $guild=$message->guild;
        $canal=$array[1];
        $nuevoCanal=$guild->channels->create([
            'name' => $canal,
            'type' => Channel::TYPE_VOICE,
        ]);
        $guild->channels->save($nuevoCanal)->done(function (Channel $channel) {});
        $message->channel->sendMessage("Canal de Voz creado");
    }
}
else if (stristr($mensaje,"-crearCanal")) {
    $array=explode(" ",$mensaje);
    if(isset($array[1])) {
        $canal=$array[1];
        $guild= $message->guild;
        $nuevoCanal= $guild->channels->create([
            'name' => $canal,
            'type' => Channel::TYPE_TEXT,
            'topic' => "prueba",
            'nsfw' => false,
        ]);
        $guild->channels->save($nuevoCanal)->done(function (Channel $channel) {});
        $message->channel->sendMessage("Canal de Texto creado");
    }
}
if (stristr($mensaje,"-borrarCanal")) {
    $array=explode(" ",$mensaje);
    if(isset($array[1])) {
        $guild=$message->guild;
        $canal=$array[1];
        $canal=substr($canal,2,18);
        $guild->channels->delete("$canal")->done(function (Message $message) {
        });
        $message->channel->sendMessage("Canal borrado");
    }
}
?>