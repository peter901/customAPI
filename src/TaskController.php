<?php

class TaskController{

    public function processRequest($method,$id){
        
        if($id === null){

            if($method == 'GET'){
                echo "index";
            }elseif($method == 'POST'){
                echo "create";
            }else{

            }

        }else{

            switch ($method){
                case "GET":
                    echo "get {$id}";
                    break;
                case "PATCH":
                    echo "edit {$id}";
                    break;

                case "DELETE":
                    echo "delete {$id}";
                    break;

                default:
                    echo "invalid request"; 
                    break;
            }
            

        }
    }
}