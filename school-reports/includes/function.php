
<!-- teacher count from database -->
<?php
$count_query = "SELECT COUNT(*) as total_teachers FROM users";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_teachers = $count_data['total_teachers'];




// notebook check count from database 
$count_query = "SELECT COUNT(*) as notebook_count FROM record";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$notebook_count = $count_data['notebook_count'];
?>
?>