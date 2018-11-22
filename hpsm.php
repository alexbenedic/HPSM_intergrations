<?php
$servername = "172.31.192.28";
$username = "root";
$password = "MBBastios2020!";
$dbname = "glpi";
$serial = $_GET["id"];
$hostname = $_GET["hostname"];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT id FROM `glpi_computers` WHERE serial='".$serial."' OR name='". $serial."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
//        echo $id;
         }
//       $sql = "SELECT`glpi_computers`.`name`,`glpi_computers`.`serial`,`glpi_computers`.`contact`,`glpi_computers`.`comment`,`glpi_computers`.`date_mod`,`glpi_computers`.`uuid`,`glpi_domains`.`name` AS domain,`glpi_computers`.`date_creation`,`glpi_manufacturers`.`name` AS manufact,`glpi_computermodels`.`name` AS model,`glpi_computertypes`.`name` AS type
//FROM `glpi_computers`
//INNER JOIN `glpi_manufacturers`
//ON `glpi_computers`.`manufacturers_id` = `glpi_manufacturers`.`id`
//INNER JOIN `glpi_computermodels`
//ON `glpi_computers`.`computermodels_id` = `glpi_computermodels`.`id`
//INNER JOIN `glpi_computertypes`
//ON `glpi_computers`.`computertypes_id` = `glpi_computertypes`.`id`
//INNER JOIN `glpi_domains`
//ON `glpi_computers`.`domains_id` = `glpi_domains`.`id`
//Where `glpi_computers`.`id`=".$id;
      $sql = "SELECT`glpi_computers`.`name`,`glpi_computers`.`tag_id`,`glpi_computers`.`serial`, `glpi_operatingsystems`.`name` AS OS,`glpi_computers`.`contact`,`glpi_domains`.`name` AS domain ,`glpi_manufacturers`.`name` AS manufact,`glpi_computermodels`.`name` AS model,
`glpi_computertypes`.`name` AS type
FROM `glpi_computers`
INNER JOIN `glpi_manufacturers`
ON `glpi_computers`.`manufacturers_id` = `glpi_manufacturers`.`id`
INNER JOIN `glpi_computermodels`
ON `glpi_computers`.`computermodels_id` = `glpi_computermodels`.`id`
INNER JOIN `glpi_computertypes`
ON `glpi_computers`.`computertypes_id` = `glpi_computertypes`.`id`
INNER JOIN `glpi_domains`
ON `glpi_computers`.`domains_id` = `glpi_domains`.`id`

INNER JOIN `glpi_items_operatingsystems`
ON `glpi_computers`.`id` = `glpi_items_operatingsystems`.`items_id`
INNER JOIN `glpi_operatingsystems`
 ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
Where `glpi_computers`.`id`=".$id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $hostname = $row["name"];
        $MBBTAg = $row["tag_id"];
        $Serial = $row["serial"];
        $Manufacture = $row["manufact"];
        $Model = $row["model"];

        $Domain = $row["domain"];
        $Os = $row["OS"];
        $type = $row["type"];

    }
    
       $sql = "SELECT `glpi_items_devicenetworkcards`.`mac` FROM `glpi_items_devicenetworkcards` WHERE `glpi_items_devicenetworkcards`.`items_id` = ".$id." AND NOT `glpi_items_devicenetworkcards`.`mac` = '00:00:00:00:00:00' LIMIT 4";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $a=0;
//    $b='a';
    // output data of each row
    while($row = $result->fetch_assoc()) {
//          echo $a;
//  echo $a."&nbsp;".$row["mac"] ."<br>";
  $MAC[$a] = $row["mac"];
        $a++;
//        $b++;
      
    }
    
    
} else {
//    echo $conn->error;
}
    
           $sql = "SELECT `glpi_ipaddresses`.`name` as ip
FROM `glpi_ipaddresses`
where `glpi_ipaddresses`.`mainitems_id`='".$id."'
limit 4";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $a=0;
//    $b='a';
    // output data of each row
    while($row = $result->fetch_assoc()) {
//          echo $a;
//  echo $c."&nbsp;".$row["ip"] ."<br>";
  $ip[$a] = $row["ip"];
        $a++;
//        $b++;
      
    }
    
    
} else {
//    echo $conn->error;
}
 
      $sql = "SELECT `glpi_items_deviceharddrives`.`capacity`
FROM `glpi_items_deviceharddrives`
where `glpi_items_deviceharddrives`.`items_id` = '".$id."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
            $hd = round(( $row['capacity'] /1024),2) ;
//        echo  $row["capacity"]. "<br>";
    }
} else {
//    echo "0 results";
}  
    
      $sql = "SELECT `glpi_items_devicememories`.`size`
FROM `glpi_items_devicememories`
where `glpi_items_devicememories`.`items_id` = '".$id."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
//            $ram = round(( $row['size'] /1024),2) ;
//        $ram+$ram;
//        echo $ram."<br>";
//        echo  $row["size"]. "<br>";
        $sum += $row['size'];
      
    }
//      echo $sum."<br>";
} else {
//    echo "0 results";
}   
    $sql = "SELECT `glpi_locations`.`name` as location
FROM `glpi_computers`
INNER JOIN `glpi_locations`
ON `glpi_computers`.`locations_id` = `glpi_locations`.`id`
Where `glpi_computers`.`id`= '".$id."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $Location = $row["location"];
    }

} else {
//    echo "0 results";
}
    
        
//    echo $hostname."<br>".$MBBTAg."<br>".$Serial."<br>".$Manufacture."<br>".$Model."<br>".$Location."<br>".$Domain."<br>".$Os."<br>".$type."<br>".$MAC[0]."<br>".$MAC[1]."<br>".$MAC[2]."<br>".$MAC[3]."<br>".$ip[0]."<br>".$ip[1]."<br>".$ip[2]."<br>".$ip[3]."<br>".$hd."<br>".c;
            $out = array ('Hostname' => $hostname,
               'IP address' => array($ip), 
               'MBB TAg' => $MBBTAg, 
               'Serial Number' =>$Serial , 
               'Manufacture' =>$Manufacture , 
               'Model' => $Model,  
               'Location' => $Location, 
               'Domain' => $Domain, 
               'Operating System' => $Os , 
               'Type' =>  $type ,
                'Memory' =>  "$sum" ,
                'Hard Disk' =>  "$hd",
                'MAC Address' =>  array ($MAC)
                          
                         ) ;
    
       header('Content-type:application/json;charset=utf-8');
        $toJSON = json_encode($out,JSON_PRETTY_PRINT);
 echo($toJSON);

} else {
    echo "No item";
} 
   
} else {
    echo "No results";
}

$conn->close();
?>