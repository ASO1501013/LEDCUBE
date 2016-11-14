<?php
    
    require_once "invisible/DBLoginInfo.php";
    require_once "pointerTblDT.php";
    
    class DBManager{
        private $myPDO;
        
        //DB接続
        function dbConnect(){
            $dbLoginInfo = new DBLoginInfo();
            try{
                $this->myPDO = new PDO("mysql:host=". $dbLoginInfo->dbhost . ";dbname=" . $dbLoginInfo->dbname . ";charset=utf8", $dbLoginInfo->userid, $dbLoginInfo->password, array(PDO::ATTR_EMULATE_PREPARES => false));
                
            }catch(PDOException $e){
                print('データベース接続失敗。'.$e->getMessage());
                throw $e;
            }
        }
        
        //DB切断
        function dbDisconnect(){
            unset($myPDO);
        }
        
        //ポインター情報取得
        function getPointer(){
            $this->dbConnect();
            
            $stmt = $this->myPDO->prepare(
                'SELECT * FROM pointer;'
            );
            $stmt->execute();
            
            $pointerTblDT = array();
            while($row = $stmt->fetch()){
                $rowData = new pointerTblDT();
                
                $rowData->pointer_id = $row['pointer_id'];
                $rowData->pointer_name = $row['pointer_name'];
                $rowData->s_xpoint = $row['s_xpoint'];
                $rowData->s_ypoint = $row['s_ypoint'];
                $rowData->e_xpoint = $row['e_xpoint'];
                $rowData->e_ypoint = $row['e_ypoint'];
                
                array_push($pointerTblDT, $rowData);
            }
            
            $this->dbDisconnect();
            
            return $pointerTblDT;
        }
        
        function addPointer($id,$name,$sx,$sy,$ex,$ey){
            $this->dbConnect();
            
            $stmt = $this->myPDO->prepare(
                'INSERT INTO pointer(pointer_name,s_xpoint,s_ypoint,e_xpoint,e_ypoint)
                VALUES(:name,:sx,:sy,:ex,:ey);'
            );
            $stmt->bindParam('name',$name,PDO::PARAM_STR);
            $stmt->bindParam('sx',$sx,PDO::PARAM_STR);
            $stmt->bindParam('sy',$sy,PDO::PARAM_STR);
            $stmt->bindParam('ex',$ex,PDO::PARAM_STR);
            $stmt->bindParam('ey',$ey,PDO::PARAM_STR);
            $stmt->execute();
            
            $this->dbDisconnect();
        }
    }
?>