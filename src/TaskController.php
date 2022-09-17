<?php

class TastController{

    public function processRequest($method,$id){
        
        if($id === null){

            if($method == 'GET'){
                echo "index";
            }elseif($method == 'POST'){
                echo "create";
            }
            
        }else{

        }
    }
}