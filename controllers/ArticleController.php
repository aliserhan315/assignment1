<?php 

require(__DIR__ . "/../models/Article.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ArticleService.php");
require(__DIR__ . "/../services/ResponseService.php");
require(__DIR__ . "/BaseController.php");

class ArticleController extends BaseController{
    
    public function getAllArticles(){
        global $mysqli;
       
        try{

        if(!isset($_GET["id"])){
            $articles = Article::all($mysqli);
            $articles_array = ArticleService::articlesToArray($articles); 
           
            echo $this->success_response($articles_array);
            return;
        }

        $id = $_GET["id"];
        $article = Article::find($mysqli, $id)->toArray();
   
        echo $this->success_response($article);
     
    }catch(Exception $e){
     
        echo $this->error_response($e->getMessage());
    }

       return;
}

    public function deleteAllArticles(){
        global $mysqli;
        try{
            if(isset($_GET["id"])){
               $id=$_GET["id"];
               $deleted = Article::delete($mysqli, $id);
                if ($deleted) {
                echo $this->responseService->success_response("Article with ID {$id} deleted successfully.");
            } else {
                echo $this->responseService->error_response("Article not found.");
            }
            return;
            }
            $deleted = Article::deleteAll($mysqli);
            if ($deleted) {
                echo $this->responseService->success_response("All articles deleted successfully.");
            } else {
                echo $this->responseService->error_response("No articles found to delete.");
            }

        }catch(Exception $e){
            echo $this->responseService->error_response($e->getMessage());
        }
            
    }
    public function createArticle(){
        global $mysqli;
        try{
            if(!isset($_POST["name"]) || !isset($_POST["author"]) || !isset($_POST["description"])){
                throw new Exception("Missing required fields.");
            }

            $data = [
                "name" => $_POST["name"],
                "author" => $_POST["author"],
                "description" => $_POST["description"]
            ];
          $insertedId = Article::create($mysqli , $data );

            $article = Article::find($mysqli,$insertedId);
            echo $this->responseService->success_response($article->toArray());
        }catch(Exception $e){
            echo $this->responseService->error_response($e->getMessage());
        }
    }

     public function updateArticle( ){
        global $mysqli;
        try{
            if(!isset($_POST["id"]) || !isset($_POST["name"]) || !isset($_POST["author"]) || !isset($_POST["description"])){
                throw new Exception("Missing required fields.");
            }

            $id = $_POST["id"];
            $article = Article::find($mysqli, $id);
            if (!$article) {
                throw new Exception("Article not found.");
            }
               $data = [
                "name" => $_POST["name"],
                "author" => $_POST["author"],
                "description" => $_POST["description"]
            ];
            
            $updated = $article->update($mysqli, $data);

            if ($updated) {
                echo $this->responseService->success_response("Article updated successfully.");
            } else {
                echo $this->responseService->error_response("Failed to update article.");
            }
        } catch(Exception $e) {
            echo $this->responseService->error_response($e->getMessage());
        }
    }

}

//To-Do:

//1- Try/Catch in controllers ONLY!!! 
//2- Find a way to remove the hard coded response code (from ResponseService.php)
//3- Include the routes file (api.php) in the (index.php) -- In other words, seperate the routing from the index (which is the engine)
//4- Create a BaseController and clean some imports 