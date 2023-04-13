<?php
use Carbon\Carbon;

$guild=$message->guild;

$gid=$guild->id;
$table="CREATE TABLE IF NOT EXISTS filtro_$gid(palabra VARCHAR(255))";
$resul=mysqli_query($conex,$table);


$sql="SELECT * from filtro_$gid";
$result=mysqli_query($conex,$sql);
$member=$message->member;

if (stristr($mensaje,"-filtro")) {
    $sql="SELECT * FROM filtro_$gid";
    $resul=mysqli_query($conex,$sql);
    if (mysqli_num_rows($resul)==0) {
        $message->channel->sendMessage("Actualmente no hay ninguna palabra en el filtro del servidor, sed buenos :(");
    }
    else {
        $row=mysqli_fetch_row($resul);
        $countFil="Las palabras del filtro son: ";
        $palabras=null;
        while($row) {
            $word=strtolower($row[0]);
            $palabras.="$word, ";
            $row=mysqli_fetch_row($resul);
        }
        $countFil.=$palabras;
        $message->channel->sendMessage($countFil);
    }
}
elseif (test_permisos($member)) {
    if(stristr($mensaje,"-addFiltro")){
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
}
elseif(mysqli_num_rows($result) != 0) {
    $row=mysqli_fetch_row($result);
    $palabra_en_filtro=false;
    while($row) {
        if (stristr(strtoupper($mensaje),strtoupper($row[0]))) {
            $palabra_en_filtro=true;
        }
        $row=mysqli_fetch_row($result);
    }
    if ($palabra_en_filtro) {
        $member=$message->member;
        $member->timeoutMember(new Carbon('5 minutes'))->done(function () {});
        $channel=$message->channel;
        $channel->messages->delete($message);
        $message->channel->sendMessage("¡MAL! No se dicen palabras que estén en el filtro, haz -filtro para ver las palabras $message->author");
    }
}
?>