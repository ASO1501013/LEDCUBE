<?php
    require_once "DBManager.php";
    $dbMng = new DBManager();
    $pointerTbl = $dbMng->getPointer();
    var_dump($pointerTbl);
?>