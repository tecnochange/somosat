<?php
class Routes{
    public function route($pg){
        if($pg == ""){ $pg = "home/muro"; }
        
        //* Todas las rutas aprobadas // proyecto bancario: rutas restringido ISO 25000
        $vista = "views/".$pg.".php"; 
        return $vista;    
    }   
}

?>