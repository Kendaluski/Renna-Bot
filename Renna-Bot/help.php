<?php
    use Discord\Parts\Channel\Channel;
    use Discord\Parts\Channel\Message;

    if ($mensaje=="-help") {
        $message->channel->sendMessage("Hola " . $message->author->username . "\n
        **Aquí tienes una lista de mis comandos:** \n
        -crearRol 'nombre' 'color' Creo un rol con ese nombre y ese color (El color debe ir en inglés) \n
        -darRol 'usuario' 'rol' Si mencionas tanto al usuario como al rol daré el rol mencionado al usuario \n
        -quitarRol 'usuario' 'rol' Si mencionas tanto al usuario como al rol, quitaré ese rol al usuario \n
        -crearCanal 'nombre' Crearé un canal de texto con el nombre especificado, si no especificas nombre, no crearé el canal \n
        -crearCanalVoz 'nombre' Crearé un canal de voz con el nombre especificado \n
        -borrarCanal '#nombre' Borraré ese canal, de texto o voz \n
        -ping Respondo con Pong, sirve para comprobar si estoy funcionando \n
        -addFiltro 'palabra' Añado esa palabra al filtro sel servidor, si alguien la dicé no podrá hablar durante 5 minutos \n
        -remFiltro 'palabra' Quito esa palabra del filtro del servidor \n
        -filtro Muestro todas las palabras del filtro del servidor \n
        -level Muestro tu nivel actual
        ¡Además, cuento con un sistema de niveles en el que vas subiendo de nivel conforme hablas en los servidores y se te asignará un rol correspondiente con tu nivel!");
    }
?>