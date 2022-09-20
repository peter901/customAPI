<?php

class TaskController{

    private TaskGateway $gateway;

    public function __construct(TaskGateway $gateway)
    {
        $this->gateway =  $gateway;   
    }

    public function processRequest(string $method, ?string $id) : void
    {   
        if($id === null){

            if($method == 'GET')
            {
                echo json_encode($this->gateway->getAll());
            }
            elseif($method == 'POST')
            {
                echo "create";
            }
            else
            {
                $this->respondMethodNotAllowed("Allow: GET, POST");
            }

        }
        else
        {
            $task = $this->gateway->get($id);

            if($task === false){
                $this->respondMethodNotFound($id);
                return;
            }

            switch ($method){
                case "GET":
                    echo json_encode($task);
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

    private function respondMethodNotFound(string $id): void
    {
        http_response_code(404);
        echo json_encode(["message"=>"Task with ID {$id} not found"]);
    }
}