<?php
$count_query = "SELECT COUNT(*) as total_teachers FROM users";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_teachers = $count_data['total_teachers'];
?>