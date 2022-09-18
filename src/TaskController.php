<?php

class TaskController{

    public function processRequest(string $method, ?string $id) : void
    {   
        if($id === null){

            if($method == 'GET'){
                echo "index";
            }elseif($method == 'POST'){
                echo "create";
            }else{
                $this->respondMethodNotAllowed("Allow: GET, POST");
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
                    $this->respondMethodNotAllowed("Allow: GET, PATCH, DELETE");
                    break;
            }
            
        }
    }


    private function respondMethodNotAllowed(string $allowedMethod): void
    {
        http_response_code(405);
        header($allowedMethod);
    }
}