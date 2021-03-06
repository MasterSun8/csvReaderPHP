<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    white-space: nowrap;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
<table>
<?php
    $limit = 9;
    if(isset($_GET["limit"])){
        $limit = array_pop($_GET);
        foreach($_GET as $key => $val){
            echo $key."|".$val."<br>";
        }
    }
    $filename = "wykaz.csv";
    $row = 0;
    $keys;
    $allData = array();
    $dataKeys = array();
    if(($handle = fopen($filename, "r")) !== FALSE){
        while(($data = fgetcsv($handle, null, ",")) !== FALSE){
            $row++;
            if($row == 1){
                $keys = $data;
                for($c=0; $c < count($keys); $c++){
                    $x = $data[$c];
                }
                foreach($keys as &$newkey){
                    $newkey = str_replace(' ', '', $newkey);
                    $newkey = str_replace('.', '', $newkey);
                    $newkey = str_replace(',', '', $newkey);
                    $newkey = strtolower($newkey);
                }
                continue;
            }else{
                $ind = 0;    
                foreach($keys as &$newkey){
                    $data[$newkey] = $data[$ind];
                    unset($data[$ind]);
                    $ind++;
                }
            }
            $allData[] = $data;
        }
        fclose($handle);
    }

    echo "<tr>";
    foreach($allData[0] as $key => &$newkey){
        echo "<td>$key</td>";
    }
    echo "</tr>";

    foreach($allData as $k => &$val){
        $filter = true;
        foreach($_GET as $key => $v){
            $filter = ($val[$key] == $v) ? $filter : false;
        }
        if($filter){
            foreach($val as $key => &$elem){
                echo "<td>$elem</td>";
            }
        }

        echo "</tr>";
        if($k == $limit){
            break;
        }
    }
?>
</table>
</body>