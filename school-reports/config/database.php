

 <?php 
 $host = 'localhost';
 $username = 'u315669183_school_reports';
 $password = 'E*QPe#Y3';
 $dbname = 'u315669183_school_reports';
 $conn = new mysqli($host, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

?>

