<?php
$guild=$message->guild;

$gid=$guild->id;
$table="CREATE TABLE IF NOT EXISTS filtro_$gid(palabra VARCHAR(255))";
$resul=mysqli_query($conex,$table);
if (stristr($mensaje,"-addFiltro")){
    $array=explode(" ",$mensaje);
    
    if (isset($array[1])) {
        $palabra=strtoupper($array[1]);
        $sql="SELECT * FROM filtro_$gid where UPPER(palabra) = '".$palabra."'";
        $resul=mysqli_query($conex,$sql);
        if (mysqli_num_rows($resul)!=0) {
                if (strtoupper($palabra) === strtoupper("filtro") or strtoupper($palabra) === strtoupper("rol") or strtoupper($palabra) === strtoupper("CANAL") or strtoupper($palabra) === strtoupper("help") or strtoupper($palabra) === strtoupper("ping")) {
                    $message->channel->sendMessage("Esa palabra ya está en el filtro o no se puede añadir");
                }
            }
        else {
            $sql="INSERT INTO filtro_$gid VALUES ('".$palabra."')";
            $resul=mysqli_query($conex,$sql);
            $message->channel->sendMessage("Se ha añadido la palabra $palabra al filtro del servidor, si alguien la utiliza no podrá hablar durante un minuto @everyone");
        }
    }
}
elseif (stristr($mensaje,"-remFiltro")) {
    $array=explode(" ",$mensaje);
    if (isset($array[1])) {
        $palabra=$array[1];
        $sql="SELECT * FROM filtro_$gid where UPPER(palabra) = UPPER('".$palabra."')";
        $resul=mysqli_query($conex,$sql);
            if (mysqli_num_rows($resul)==0) {
                $message->channel->sendMessage("Esa palabra no está en el filtro del servidor");
            }
            else {
                $sql="DELETE FROM filtro_$gid WHERE palabra='".$array[1]."'";
                $resul=mysqli_query($conex,$sql);
                $message->channel->sendMessage("Se ha quitado la palabra $array[1] del filtro del servidor @everyone");
            }
    }
}


?>