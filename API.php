<?php
    // Khởi tạo kết nối CSDL 
    function initDB()
    {
        $paPDO = new PDO('pgsql:host=localhost;dbname=Hanoi;port=5432', 'postgres', 'Camhutthuoc123');
        return $paPDO;
    }
    // Ngắt kết nối CSDL
    function closeDB($paPDO)
    {
        $paPDO = null;
    }

    // Hàm truy vấn dữ liệu
    function query($paPDO, $paSQLStr)
    {
        try
        {
            // Khai báo exception
            $paPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Sử đụng Prepare 
            $stmt = $paPDO->prepare($paSQLStr);
            // Thực thi câu truy vấn
            $stmt->execute();
            
            // Khai báo fetch kiểu mảng kết hợp
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            // Lấy danh sách kết quả
            $paResult = $stmt->fetchAll();   
            return $paResult;                 
        }
        catch(PDOException $e) {
            echo "Thất bại, Lỗi: " . $e->getMessage();
            return null;
        }       
    }

    // Hàm chức năng
    if(isset($_POST['functionname']))
    {
        $paPDO = initDB();
        $paSRID = '4326';
        $paPoint = $_POST['paPoint'];
        
        $functionname = $_POST['functionname'];
        
        $aResult;
        switch ($functionname) {
            case 'getInfoHN4':
                $aResult = GetInfoHN4($paPDO);
                break;

            case 'getInfoHN6':
                $aResult = GetInfoHN6($paPDO, $paSRID, $paPoint);
                break;

            case 'getInfoHN8':
                $aResult = GetInfoHN8($paPDO, $paSRID, $paPoint);
                break;

            case 'getInfoHSHN':
                $aResult = GetInfoHSHN($paPDO, $paSRID, $paPoint);
                break;
            case 'getInfoRHN':
                $aResult = GetInfoRHN($paPDO, $paSRID, $paPoint);
                break;
            case 'getInfoSOS':
                    $aResult = GetInfoSOS($paPDO, $paSRID, $paPoint);
                break;
            default:
                # code...
                break;
        }

        if ($aResult != null)
            echo json_encode($aResult);
        else
            echo "null";
        
        closeDB($paPDO);
    }    

    function GetInfoHN4($paPDO){
        $mySQLStr = "SELECT gid_1, name_1, type_1, name_0, area , ST_AsGeoJson(geom) as geo from \"hanoi4\"";
        //echo $mySQLStr;
        $result = query($paPDO, $mySQLStr);   
        //echo $result;
        return $result;
    }

    function GetInfoHN6($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
        //echo $paPoint;
        $mySQLStr = "SELECT gid_2, name_2, type_2, name_1, name_0, area , ST_AsGeoJson(geom) as geo from \"hanoi6\" where ST_Within('SRID=".$paSRID.";".$paPoint."'::geometry,geom);";
        //echo $mySQLStr;
        $result = query($paPDO, $mySQLStr);        
        return $result;
    }

    function GetInfoHN8($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
        //echo $paPoint;
        $mySQLStr = "SELECT gid_3, name_3, type_3, name_2, name_1, name_0, area , ST_AsGeoJson(geom) as geo from \"hanoi8\" where ST_Within('SRID=".$paSRID.";".$paPoint."'::geometry,geom);";
        //echo $mySQLStr;
        $result = query($paPDO, $mySQLStr);        
        return $result;
    }

    function GetInfoHSHN($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
        //echo $paPoint;
        $strDistance = "ST_Distance('".$paPoint."',ST_AsText(geom))";
        $strMinDistance = "SELECT min(ST_Distance('".$paPoint."',ST_AsText(geom))) from daihoc";
        $mySQLStr = "SELECT full_id, name, phone, website, email, url_img, addr_stree, ST_AsGeoJson(geom) as geo from daihoc where ".$strDistance." = (".$strMinDistance.") and ".$strDistance." < 0.05";
        //echo $mySQLStr;
        $result = query($paPDO, $mySQLStr);        
        return $result;
    }

    function GetInfoRHN($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
        //echo $paPoint;
        $strDistance = "ST_Distance('".$paPoint."',ST_AsText(geom))";
        $strMinDistance = "SELECT min(ST_Distance('".$paPoint."',ST_AsText(geom))) from road_hanoi";
        $mySQLStr = "SELECT gid, name, length, ST_AsGeoJson(geom) as geo from road_hanoi where ".$strDistance." = (".$strMinDistance.") and ".$strDistance." < 0.05";
        //echo $mySQLStr;
        $result = query($paPDO, $mySQLStr);        
        return $result;
    }

    function GetInfoSOS($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
        //echo $paPoint;
        $strDistance = "ST_Distance('".$paPoint."',ST_AsText(geom))";
        $strMinDistance = "SELECT min(ST_Distance('".$paPoint."',ST_AsText(geom))) from daihoc";
        $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo from daihoc where ".$strDistance." < 0.05 ORDER BY ".$strDistance." ASC limit 5";
        //echo $mySQLStr;
        $result = query($paPDO, $mySQLStr);        
        return $result;
    }
    function getSearch($search)
    {
        //echo $paPoint;
        //echo "<br>";
        $paPDO = initDB();
            $mySQLStr = "SELECT  daihoc.name,daihoc.addr_stree,daihoc.website,daihoc.phone
                from  \"daihoc\" 
                where  daihoc.name   ILIKE '%$search%' ";
            //echo $mySQLStr;
            //echo "<br><br>";
            $result = query($paPDO, $mySQLStr);
            
        if ($result != null)
        {   
            $resFin = '
            <table class="table" >
            
    <thead>
    <tr>
      <th scope="col">Tên  trường</th>
      <th scope="col" >Vị Trí</th>
      <th scope="col" >Website</th>
      <th scope="col" >Số điện thoại</th>


    </tr>
  </thead>
  <tbody>'; 
            
             foreach ($result as $value){
                 $resFin = $resFin.'<tr>
                 <td>'.$value['name'].'</td>';
                 $resFin = $resFin.'<td>'.$value['addr_stree'].'</td>
                ';
                 $resFin = $resFin.'<td>'.$value['website'].'</td>';
                 $resFin = $resFin.'<td>'.$value['phone'].'</td>
                 </tr>';
            //     $resFin = $resFin.'<br>'; 
             }
             $resFin = $resFin.'</tbody>
             </table>'; 
            
             echo $resFin;
        }
        else
            return "error";
    }
?>



