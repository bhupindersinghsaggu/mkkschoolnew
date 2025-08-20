<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../config/functions.php';

// Get record ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: list_class_show.php?message=Invalid record ID");
    exit();
}

// Fetch specific record
$query = "SELECT * FROM class_show WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: list_class_show.php?message=Record not found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Class Show Record</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="content">
            <div class="header-button d-flex justify-content-between align-items-center mb-3">
                <h3>Class Show Record Details</h3>
                <div>
                    <a href="list_class_show.php" class="btn btn-secondary">Back to List</a>
                    <a href="edit_class_show.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Session:</th>
                                    <td><?= htmlspecialchars($row['session']) ?></td>
                                </tr>
                                <tr>
                                    <th>Evaluation Date:</th>
                                    <td><?= date('d M Y', strtotime($row['eval_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Teacher Name:</th>
                                    <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Teacher ID:</th>
                                    <td><?= htmlspecialchars($row['teacher_id']) ?></td>
                                </tr>
                                <tr>
                                    <th>Class/Section:</th>
                                    <td><?= htmlspecialchars($row['class_section']) ?></td>
                                </tr>
                                <tr>
                                    <th>Topic:</th>
                                    <td><?= htmlspecialchars($row['topic']) ?></td>
                                </tr>
                                <tr>
                                    <th>Evaluator:</th>
                                    <td><?= htmlspecialchars($row['evaluator_name']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Scores & Evaluation</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60%">Prayer:</th>
                                    <td><?= $row['prayer'] ?></td>
                                </tr>
                                <tr>
                                    <th>News:</th>
                                    <td><?= $row['news'] ?></td>
                                </tr>
                                <tr>
                                    <th>Participation:</th>
                                    <td><?= $row['participation'] ?></td>
                                </tr>
                                <tr>
                                    <th>Speeches:</th>
                                    <td><?= $row['speeches'] ?></td>
                                </tr>
                                <tr>
                                    <th>Poem Recitation:</th>
                                    <td><?= $row['poem_recitation'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dance:</th>
                                    <td><?= $row['dance'] ?></td>
                                </tr>
                                <tr>
                                    <th>Song:</th>
                                    <td><?= $row['song'] ?></td>
                                </tr>
                                <tr>
                                    <th>Stage Management:</th>
                                    <td><?= $row['stage_management'] ?></td>
                                </tr>
                                <tr>
                                    <th>Innovation:</th>
                                    <td><?= $row['innovation'] ?></td>
                                </tr>
                                <tr>
                                    <th>Skit:</th>
                                    <td><?= $row['skit'] ?></td>
                                </tr>
                                <tr>
                                    <th>PPT:</th>
                                    <td><?= $row['ppt'] ?></td>
                                </tr>
                                <tr>
                                    <th>Anchoring:</th>
                                    <td><?= $row['anchoring'] ?></td>
                                </tr>
                                <tr class="table-success">
                                    <th><strong>Total Score:</strong></th>
                                    <td><strong><?= $row['total'] ?></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Skills Assessment</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60%">Speaking Skills:</th>
                                    <td><?= $row['speaking_skills'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dancing Skills:</th>
                                    <td><?= $row['dancing_skills'] ?></td>
                                </tr>
                                <tr>
                                    <th>Singing Skills:</th>
                                    <td><?= $row['singing_skills'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dramatic Skills:</th>
                                    <td><?= $row['dramatic_skills'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Comments & Metadata</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label"><strong>Comments:</strong></label>
                                <p class="form-control-plaintext"><?= nl2br(htmlspecialchars($row['comments'])) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Record Created:</strong></label>
                                <p class="form-control-plaintext"><?= date('d M Y h:i A', strtotime($row['created_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>

<?php
// Close statement
mysqli_stmt_close($stmt);
?>