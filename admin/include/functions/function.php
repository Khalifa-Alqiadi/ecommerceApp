<?php

    /**
     *  Get All Function v1.0 
     *  Function To Get Categories From Database
     */

    function getAllTable($field, $allTable, $where = NULL, $and = NULL, $orderField, $ordering = 'DESC', $limit = NULL){

        global $con;

        $getAll = $con->prepare("SELECT $field FROM $allTable $where $and ORDER BY $orderField $ordering $limit");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;

    }


    /**
     *  Title Function V1.0
     *  Title Function That Echo The Page Title In Case The Page 
     *  Has The Vairable $pageTitle And Echo Defult Title For Other Pages
     */

     function getTitle(){

        global $pageTitle;

        if(isset($pageTitle)){

            echo $pageTitle;

        }else{
            
            echo "Defult";
        }
     }

    /**
     *  Home Redirect Function V2.0
     *  This Function Accept Parameters
     *  $TheMsg = Echo The Error Message
     * $seconds   = Seconds Befor Redirecting
     */

     function redirectHome($TheMsg, $url = null, $seconds = 3){

        if($url === null){
            $url = 'index.php';
            $link = 'HomePage';
        }else{
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

                $url = $_SERVER['HTTP_REFERER'];
                $link = 'Previous Page';

            }else{
                
                $url = 'index.php'; 
                $link = 'HomePage';
            } 
        }

        echo "<div class='container'>";
        echo $TheMsg;
        echo "<div class='alert alert-info'>You Will Redirected To $link After $seconds Seconds.</div>";

            header("refresh:$seconds;url=$url");
            
            exit(); 

        echo "</div>";
     }

     /**
      *  Chick Items Function v1.0 
      *  Function To Chick The Items In Database [Function Accept Parameters]
      *  $select = The Item To Select [Example: user, item, category]
      *  $from = The Table To Select From [Example: Users, Items, Categories]
      *  $value = The Value Of Select [Example: Fiteer, Box, Electronics] 
      */

     function chickItem($select, $from, $value){

        global $con;

        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

        $statement->execute(array($value));

        $count = $statement->rowCount();

        return $count;
     }

     

    /**
      *  Delete Items Function v1.0 
      *  Function To Delete The Items In Database [Function Accept Parameters]
      *  $delete = The Item To Delete [Example: user, item, category]
      *  $from = The Table To Delete From [Example: Users, Items, Categories]
      *  $value = The Value Of Delete [Example: Fiteer, Box, Electronics] 
      */

     function deleteRecord($from, $delete, $value){

        global $con;

        $statment = $con->prepare("DELETE FROM $from WHERE $delete = :zuser");

        $statment->bindParam(":zuser", $value);

        $statment->execute();

        return $statment;
     }

     /**
      *  Count Numbers Of Items Function V1.0 
      *  Function To Count Numbers Of Items Rows
      *  $itme = The Item To Count 
      *  $table = The Table To Choose From
      */

      function countItems($item, $table){

        global $con;

        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

        $stmt2->execute();

        return $stmt2->fetchColumn();

      }

 