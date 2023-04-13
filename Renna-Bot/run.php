<?php
include __DIR__.'/vendor/autoload.php';
include_once('library.php');

use function Discord\getColor;
use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;
use Discord\Parts\Guild\Role;
use Discord\Parts\Channel\Channel;

set_time_limit(0);

$discord = new Discord([
    'token' => 'OTUyNTMxMzQ1Njg5NjczNzQ5.Yi3X8Q.XRxeNfDyxGBBsWxYveWXiB17oGA',
    'intents' => [Intents::GUILDS, Intents::GUILD_BANS, Intents::GUILD_INTEGRATIONS, Intents::GUILD_MEMBERS, Intents::GUILD_MESSAGES],
    'loadAllMembers' => true
]);


$discord->on('ready', function ($discord){
    echo "Renna está encendida\n";

    $discord->on("MESSAGE_CREATE", function(Message $message, Discord $discord){
    $guild=$message->guild;
    $conex=mysqli_connect("85.159.212.188","renna","rennabotroot","renna_bot") or die("Error:".mysqli_error($conex));
    $gid=$guild->id;
    $table="CREATE TABLE IF NOT EXISTS l$gid(id VARCHAR(255),messages INT,level INT)";
    $resul=mysqli_query($conex,$table);

    $color=getColor('#b87333');
    crearRol($guild,'Cobre',$color,25);

    if ($message->author->id != $discord->id) {
        $member=$message->member;
        $mensaje=$message->content;
        if (test_permisos($member)){
            include("roles.php");
            include("channels.php");
        }

        include("filter.php");

        include("levels.php");
        
        include("help.php");
        
        if ($mensaje=="-ping") {
            $message->channel->sendMessage("¡Pong!");
        }

    }
    });
    $discord->on("GUILD_MEMBER_REMOVE",function($member, Discord $discord){
        $gid=$member->guild->id;
        $conex=mysqli_connect("85.159.212.188","renna","rennabotroot","renna_bot") or die("Error:".mysqli_error($conex));
        $sql="DELETE FROM l$gid WHERE id=$member->id";
        mysqli_query($conex,$sql);
    });
});
while (true) {
    $discord->run();
}