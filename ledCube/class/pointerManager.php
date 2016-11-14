<?php
    require_once "DBManager.php";
    
    function addPointer(){
        $dbMng = new DBManager();
        $name = htmlspecialchars($_POST["pointer_name"],ENT_QUOTES,'utf-8');
        $sx = htmlspecialchars($_POST["s_xpoint"],ENT_QUOTES,'utf-8');
        $sy = htmlspecialchars($_POST["s_ypoint"],ENT_QUOTES,'utf-8');
        $ex = htmlspecialchars($_POST["e_xpoint"],ENT_QUOTES,'utf-8');
        $ey = htmlspecialchars($_POST["e_ypoint"],ENT_QUOTES,'utf-8');
        $dbMng->addPointer($name,$sx,$sy,$ex,$ey);
        header('Location: /index.php');
    }
    
    function getPointer(){
        
    }
?>