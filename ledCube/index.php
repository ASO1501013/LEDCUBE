<?php
    require_once "class/DBManager.php";
    $dbMng = new DBManager();
    $scale = 8;
    $layNum = 1;
    $boxNum = 1;
    $layer = array();
    if(isset($_POST['submit'])){
        $layNum = ((int)htmlspecialchars($_POST['layNum'],ENT_QUOTES,"utf-8"));
        $boxNum = ((int)htmlspecialchars($_POST['boxNum'],ENT_QUOTES,"utf-8"));
        if($layNum >= $scale){
            $boxNum++;
            $layNum = 1;
        }else{
            $layNum++;
        }
        var_dump($_POST);
        while ($val = current($_POST)) {
            if ($val == 'on') {
                array_push($layer,key($_POST));
            }
            next($_POST);
        }
        var_dump($layer);
    }
?>

<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="js/jquery-3.1.1.min.js"></script>
        
        <title>LedCube</title>
    </head>
    
    <body>
        <h1>LEDアニメーション設定</h1>
        <form action="" method="post">
            <table>
            <?php
                for($i = 0; $i < $scale+1; $i++){
                    echo "<tr>";
                    for($j = 0; $j < $scale+1; $j++){
                        echo "<td>";
                        if($i != 0 || $j != 0){
                            if($i == 0){
                                echo $j;
                            }else{
                                if($j == 0){
                                    echo $i;
                                }else{
                                    $nameVal = $i*$scale+$j;
                                    echo "<input type='checkbox' name='".$nameVal."'>";
                                }
                            }
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            ?>
            </table>
            <input type="text" name="layNum" value="<?php echo $layNum;?>">
            <input type="text" name="boxNum" value="<?php echo $boxNum;?>">
            <input type="submit" name="submit" value="次の層へ">
        </form>
        
        <div>アニメーションテーブル</div>
        <table border="1">
            <tr>
                <th> ポインタ名</th>
                <th>始点x</th>
                <th> 始点y</th>
                <th>終点x</th>
                <th>終点y</th>
                <th></th>
            </tr>
            <?php
                $pointerData = $dbMng->getPointer();
                if(isset($pointerData)){
                    for($i = 0; $i < count($pointerData); $i++){
                        echo "<tr>";
                            echo "<td><input type='text' name='pointer_name' value='".$pointerData[$i]->pointer_name."'></input></td>";
                            echo "<td><input type='text' name='s_xpoint' value='".$pointerData[$i]->s_xpoint."'></input></td>";
                            echo "<td><input type='text' name='s_ypoint' value='".$pointerData[$i]->s_ypoint."'></input></td>";
                            echo "<td><input type='text' name='e_xpoint' value='".$pointerData[$i]->e_xpoint."'></input></td>";
                            echo "<td><input type='text' name='e_ypoint' value='".$pointerData[$i]->e_ypoint."'></input></td>";
                            echo "<td><button>変更</button></td>";
                        echo "</tr>";
                    }
                }
            ?>
            <form name="add_pointer" action="" method="post">
                <tr>
                    <td><input id='inPName' type='text' name='pointer_name'></input></td>
                    <td><input id='inStXPoint' type='text' name='s_xpoint'></input></td>
                    <td><input id='inStYPoint' type='text' name='s_ypoint'></input></td>
                    <td><input id='inEnXPoint' type='text' name='e_xpoint'></input></td>
                    <td><input id='inEnYPoint' type='text' name='e_ypoint'></input></td>
                    <td><input type='button' onClick="addPointer2('add_pointer','class/addPointer.php','POST')" value="追加"></input></td>
                </tr>
            </form>
        </table>
    </body>
</html>

<script type="text/javascript">

function addPointer()
{
    if(window.confirm('ポインターを追加しますか？')){
        var a = $("inPName").value();
        var b = $("inStXPoint").value();
        var c = $("inStYPoint").value();
        var d = $("inEnXPoint").value();
        var e = $("inEnYPoint").value();
        $.ajax({
            url: 'class/addPointer.php',
            type: 'POST',
            dataType: 'json',
            timeout: 1000,
            data: {
                pointer_name: a,
                s_xpoint: b,
                s_ypoint: c,
                e_xpoint: d,
                e_ypoint: e
            },
            success: function(data) {
                alert("追加されました");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown,data) {
                alert("追加できませんでした");
            }
        });
    }
}

function addPointer2(formName, url, method)
{
     if(window.confirm('選択したタスクを完了しますか？')){
        // サブミットするフォームを取得
        var f = document.forms[formName];
        
        f.method = method; // method(GET or POST)を設定する
        f.action = url; // action(遷移先URL)を設定する
        f.submit(); // submit する
        return true;
	}
   
}
</script>