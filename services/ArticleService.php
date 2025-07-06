<?php 

class ArticleService {

    public static function articlesToArray($articles_db){
        $results = [];

        foreach($articles_db as $a){
             $results[] = $a->toArray(); 
        } 

        return $results;
    }



}