<?php

// current path
$path = getcwd();
// exclude folder
$arrExcludeFolder = [];
// empty: all
$arrSpecificFolder = []; // ex: [5,7,'test']
// -1: all
$numberLimitImport = -1;
// MySQL host
$mysql_host = 'localhost';
// MySQL username
$mysql_username = 'root';
// MySQL password
$mysql_password = '';

// get file sql each folder
$arr = [];
$index = 0;
$directories = array_map('basename', glob($path . '/*', GLOB_ONLYDIR));
foreach ($directories as $index => $directory) {
    if (!in_array($directory, $arrExcludeFolder)) {
        $new_path = $path .'\\' . $directory;
        $Directory = new RecursiveDirectoryIterator($new_path);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, '/^.+\.sql$/i', RecursiveRegexIterator::GET_MATCH);

        $arr[$index]['name'] = $directory;
        $count = 0;
        $arr[$index]['path'] = [];
        foreach($Regex as $path_sql => $each){
            $count++;
            $arr[$index]['path'][] = $path_sql;
        }
        $arr[$index]['import'] = false;

        if($count === 1){
            $arr[$index]['import'] = true;
        }
    }
}

// import each
foreach($arr as $index => $each){
    if(!empty($arrSpecificFolder) && !in_array($each['name'], $arrSpecificFolder)){
        continue;
    }
    echo $each['name'];
    echo ";";
    $check_error = '0';
    if($each['import']){
        $check_error = '';
        // Name of the file
        $filename = $each['path'][0];

        // Connect to MySQL server
        $connect = mysqli_connect($mysql_host, $mysql_username, $mysql_password);

        $database_name = $each['name'];
        $sql = "DROP DATABASE IF EXISTS `$database_name`";
        mysqli_query($connect,$sql);

        $sql = "CREATE DATABASE IF NOT EXISTS `$database_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
        mysqli_query($connect,$sql);
        $sql = "USE `$database_name`";
        mysqli_query($connect,$sql);

        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($filename);
        // Loop through each line
        foreach ($lines as $line)
        {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            // Skip create database 
            if (strpos($line, 'CREATE DATABASE') !== false || strpos($line, 'USE') !== false)
                continue;

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';')
            {
                // Perform the query
                mysqli_query($connect,$templine);
                if(!empty(mysqli_error($connect))){
                    echo('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($connect) . '<br /><br />');
                    $check_error = 'x';
                }
                // Reset temp variable to empty
                $templine = '';
            }
        }  
    }
    echo $check_error;
    echo ";";
    echo implode(';', $each['path']);
    echo "<br>";
    if($index === $numberLimitImport){
        break;
    }
}
