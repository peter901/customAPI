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
                $data = (array) json_decode(file_get_contents("php://input"),true);
                
                $errors = $this->getValidationErrors($data);

                if(! empty($errors)){
                    $this->respondUnprocessableEntity($errors);
                    return;
                }
                
                $id = $this->gateway->create($data);
                $this->respondCreated($id);

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
                    
                    $data = (array) json_decode(file_get_contents("php://input"),true);
                
                    $errors = $this->getValidationErrors($data);
    
                    if(! empty($errors)){
                        $this->respondUnprocessableEntity($errors, false);
                        return;
                    }
                    
                    $id = $this->gateway->update($data);
                    $this->respondCreated($id);

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

    private function respondUnprocessableEntity(array $errors):void
    {
        http_response_code(422);

        echo json_encode(['errors'=>$errors]);
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

    private function respondCreated(string $id):void
    {
        http_response_code(201);
        echo json_encode(["message"=>"Task created", "id"=>$id]);
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if(empty($data["name"]) and $is_new)
        {
            $errors[] = "name is required";
        }

        if(! empty($data["priority"])){
            if(! filter_var($data["priority"], FILTER_VALIDATE_INT)){
                $errors[] = "priority must be an integer";
            }
        }
        return $errors;
    }
}