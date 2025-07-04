<?php
require_once(__DIR__ . "/../models/Category.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/CategoryService.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/BaseController.php");

class CategoryController extends BaseController {

    public function getAllCategories() {
         global $mysqli;
       try {
            if (!isset($_GET["id"])) {
                $categories = Category::all($mysqli);
                echo $this->responseService->success_response(CategoryService::categoriesToArray($categories));
                return;
            }
            $id = $_GET["id"];
            $category = Category::find($mysqli, $id);
            if ($category) {
                echo $this->responseService->success_response($category->toArray());
            } else {
                echo $this->responseService->error_response("Category not found.");
            }
    
    } catch (Exception $e) {
            echo $this->responseService->error_response($e->getMessage());
        }
        return;
    }
    public function createCategory() {
        global $mysqli;
        try {
            if (!isset($_POST["name"]))
            {
                throw new Exception("Missing category name.");
            }
            $data = [ 
                "name" => $_POST["name"]
             ];
            $insertedId = Category::create($mysqli, $data);
            $category = Category::find($mysqli, $insertedId);
            echo $this->responseService->success_response($category->toArray());
        } catch (Exception $e) {
            echo $this->responseService->error_response($e->getMessage());
        }
    }
 public function deleteCategories(){
        global $mysqli;
        try{
            if(isset($_GET["id"])){
               $id=$_GET["id"];
               $deleted = Category::delete($mysqli, $id);
                if ($deleted) {
                echo $this->responseService->success_response("Category with ID {$id} deleted successfully.");
            } else {
                echo $this->responseService->error_response("Category not found.");
            }
            return;
            }
            $deleted = Category::deleteAll($mysqli);
            if ($deleted) {
                echo $this->responseService->success_response("All Category deleted successfully.");
            } else {
                echo $this->responseService->error_response("No Category found to delete.");
            }

        }catch(Exception $e){
            echo $this->responseService->error_response($e->getMessage());
        }
            
    }
     public function updateCategory(){
        global $mysqli;

    try {
        if (
            !isset($_POST["id"]) ||
            !isset($_POST["name"])
        ) {
            throw new Exception("Missing required fields.");
        }

        $id = $_POST["id"];
        $category = Category::find($mysqli, $id);

        if (!$category) {
            throw new Exception("Category not found.");
        }

        $data = [
            "name" => $_POST["name"]
        ];

        $updated = $category->update($mysqli, $data);
        if ($updated) {
            echo $this->responseService->success_response($category->toArray());
        } else {
            echo $this->responseService->error_response("Failed to update category.");
        }

     }catch (Exception $e) {
        echo $this->responseService->error_response($e->getMessage());
        return;
    }
}
}



