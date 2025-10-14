<?php
// admin/class_show/edit_class_show.php
 require_once '../config.php';
 require_once '../auth.php';
 require_once '../database.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || !$auth->hasPermission(ROLE_ADMIN)) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // throw exceptions

$errors = [];
$message = '';
$dbErrorDetail = '';

// get id param
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list_class_show.php');
    exit;
}
$id = (int)$_GET['id'];

// fetch record
try {
    $stmt = $conn->prepare("SELECT * FROM class_show WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$record) {
        header('Location: list_class_show.php');
        exit;
    }
} catch (PDOException $e) {
    error_log("Fetch class_show error: " . $e->getMessage());
    die("Database error.");
}

// fetch teacher list
try {
    $tstmt = $conn->prepare("SELECT id, username, fullname, teacher_id, subject FROM users WHERE teacher_id IS NOT NULL AND teacher_id <> '' ORDER BY fullname");
    $tstmt->execute();
    $teachers = $tstmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $teachers = [];
    error_log("Fetch teachers error: " . $e->getMessage());
}

// handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    // collect & sanitize
    $session = trim($_POST['session'] ?? $record['session']);
    $eval_date = trim($_POST['eval_date'] ?? $record['eval_date']);
    $topic = trim($_POST['topic'] ?? $record['topic']);
    $video_link = trim($_POST['video_link'] ?? $record['video_link']);
    $teacher_id = trim($_POST['teacher_id'] ?? $record['teacher_id']);
    $teacher_name = trim($_POST['teacher_name'] ?? $record['teacher_name']);
    $class_section = trim($_POST['class_section'] ?? $record['class_section']);
    $evaluator_name = trim($_POST['evaluator_name'] ?? $record['evaluator_name']);

    // numeric fields
    $prayer = is_numeric($_POST['prayer'] ?? null) ? (float)$_POST['prayer'] : (float)($record['prayer'] ?? 0);
    $news = is_numeric($_POST['news'] ?? null) ? (float)$_POST['news'] : (float)($record['news'] ?? 0);
    $participation = is_numeric($_POST['participation'] ?? null) ? (float)$_POST['participation'] : (float)($record['participation'] ?? 0);
    $speeches = is_numeric($_POST['speeches'] ?? null) ? (float)$_POST['speeches'] : (float)($record['speeches'] ?? 0);
    $poem_recitation = is_numeric($_POST['poem_recitation'] ?? null) ? (float)$_POST['poem_recitation'] : (float)($record['poem_recitation'] ?? 0);
    $dance = is_numeric($_POST['dance'] ?? null) ? (float)$_POST['dance'] : (float)($record['dance'] ?? 0);
    $song = is_numeric($_POST['song'] ?? null) ? (float)$_POST['song'] : (float)($record['song'] ?? 0);
    $stage_management = is_numeric($_POST['stage_management'] ?? null) ? (float)$_POST['stage_management'] : (float)($record['stage_management'] ?? 0);
    $innovation = is_numeric($_POST['innovation'] ?? null) ? (float)$_POST['innovation'] : (float)($record['innovation'] ?? 0);
    $skit = is_numeric($_POST['skit'] ?? null) ? (float)$_POST['skit'] : (float)($record['skit'] ?? 0);
    $ppt = is_numeric($_POST['ppt'] ?? null) ? (float)$_POST['ppt'] : (float)($record['ppt'] ?? 0);
    $anchoring = is_numeric($_POST['anchoring'] ?? null) ? (float)$_POST['anchoring'] : (float)($record['anchoring'] ?? 0);

    $speaking_skills = trim($_POST['speaking_skills'] ?? $record['speaking_skills']);
    $dancing_skills = trim($_POST['dancing_skills'] ?? $record['dancing_skills']);
    $singing_skills = trim($_POST['singing_skills'] ?? $record['singing_skills']);
    $dramatic_skills = trim($_POST['dramatic_skills'] ?? $record['dramatic_skills']);
    $comments1 = trim($_POST['comments1'] ?? $record['comments1']);
    $comments2 = trim($_POST['comments2'] ?? $record['comments2']);
    $marks_judge1 = $_POST['marks_judge1'] === '' ? null : (is_numeric($_POST['marks_judge1']) ? (float)$_POST['marks_judge1'] : null);
    $marks_judge2 = $_POST['marks_judge2'] === '' ? null : (is_numeric($_POST['marks_judge2']) ? (float)$_POST['marks_judge2'] : null);

    // calculate total server-side
    $total = $prayer + $news + $participation + $speeches + $poem_recitation + $dance + $song + $stage_management + $innovation + $skit + $ppt + $anchoring;
    $total = round($total, 2);

    // validations
    if ($session === '') $errors[] = "Session is required.";
    if ($eval_date === '') $errors[] = "Date of class show is required.";
    if ($topic === '') $errors[] = "Topic is required.";
    if ($teacher_id === '') $errors[] = "Please select a teacher.";
    if ($class_section === '') $errors[] = "Class/Section is required.";
    if ($evaluator_name === '') $errors[] = "Name of judge is required.";

    // === Replace the existing update try/catch with this block ===
    if (empty($errors)) {
        try {
            $sql = "UPDATE class_show SET
            session = :session,
            eval_date = :eval_date,
            topic = :topic,
            video_link = :video_link,
            teacher_name = :teacher_name,
            teacher_id = :teacher_id,
            evaluator_name = :evaluator_name,
            class_section = :class_section,
            prayer = :prayer,
            news = :news,
            participation = :participation,
            speeches = :speeches,
            poem_recitation = :poem_recitation,
            dance = :dance,
            song = :song,
            stage_management = :stage_management,
            innovation = :innovation,
            skit = :skit,
            ppt = :ppt,
            anchoring = :anchoring,
            total = :total,
            speaking_skills = :speaking_skills,
            dancing_skills = :dancing_skills,
            singing_skills = :singing_skills,
            dramatic_skills = :dramatic_skills,
            comments1 = :comments1,
            comments2 = :comments2,
            marks_judge1 = :marks_judge1,
            marks_judge2 = :marks_judge2,
            updated_at = NOW()
            WHERE id = :id
        ";

            $stmt = $conn->prepare($sql);

            // Bind required strings
            $stmt->bindValue(':session', $session, PDO::PARAM_STR);
            $stmt->bindValue(':eval_date', $eval_date, PDO::PARAM_STR);
            $stmt->bindValue(':topic', $topic, PDO::PARAM_STR);
            $stmt->bindValue(':video_link', $video_link, PDO::PARAM_STR);
            $stmt->bindValue(':teacher_name', $teacher_name, PDO::PARAM_STR);
            $stmt->bindValue(':teacher_id', $teacher_id, PDO::PARAM_STR);
            $stmt->bindValue(':evaluator_name', $evaluator_name, PDO::PARAM_STR);
            $stmt->bindValue(':class_section', $class_section, PDO::PARAM_STR);

            // Bind numeric values (use NULL when appropriate)
            $stmt->bindValue(':prayer', is_numeric($prayer) ? $prayer : null, is_numeric($prayer) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':news', is_numeric($news) ? $news : null, is_numeric($news) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':participation', is_numeric($participation) ? $participation : null, is_numeric($participation) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':speeches', is_numeric($speeches) ? $speeches : null, is_numeric($speeches) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':poem_recitation', is_numeric($poem_recitation) ? $poem_recitation : null, is_numeric($poem_recitation) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':dance', is_numeric($dance) ? $dance : null, is_numeric($dance) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':song', is_numeric($song) ? $song : null, is_numeric($song) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':stage_management', is_numeric($stage_management) ? $stage_management : null, is_numeric($stage_management) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':innovation', is_numeric($innovation) ? $innovation : null, is_numeric($innovation) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':skit', is_numeric($skit) ? $skit : null, is_numeric($skit) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':ppt', is_numeric($ppt) ? $ppt : null, is_numeric($ppt) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':anchoring', is_numeric($anchoring) ? $anchoring : null, is_numeric($anchoring) ? PDO::PARAM_STR : PDO::PARAM_NULL);

            // Total (always numeric)
            $stmt->bindValue(':total', $total, PDO::PARAM_STR);

            // Strings / text fields
            $stmt->bindValue(':speaking_skills', $speaking_skills, PDO::PARAM_STR);
            $stmt->bindValue(':dancing_skills', $dancing_skills, PDO::PARAM_STR);
            $stmt->bindValue(':singing_skills', $singing_skills, PDO::PARAM_STR);
            $stmt->bindValue(':dramatic_skills', $dramatic_skills, PDO::PARAM_STR);
            $stmt->bindValue(':comments1', $comments1, PDO::PARAM_STR);
            $stmt->bindValue(':comments2', $comments2, PDO::PARAM_STR);

            // Marks — allow NULL
            if ($marks_judge1 === null) {
                $stmt->bindValue(':marks_judge1', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':marks_judge1', $marks_judge1, PDO::PARAM_STR);
            }

            if ($marks_judge2 === null) {
                $stmt->bindValue(':marks_judge2', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':marks_judge2', $marks_judge2, PDO::PARAM_STR);
            }

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            // --- DEBUG (temporary) ---
            // Uncomment the next two lines while debugging to log the SQL and parameters:
            // error_log("SQL: " . $sql);
            // error_log("Params: " . print_r([
            //    'session'=>$session, 'eval_date'=>$eval_date, 'topic'=>$topic, 'teacher_id'=>$teacher_id, 'id'=>$id, 'total'=>$total
            // ], true));

            if ($stmt->execute()) {
                $message = "Record updated successfully.";
                $auth->logActivity($_SESSION['user_id'], "Updated class_show ID: $id");

                // reload record
                $stmt2 = $conn->prepare("SELECT * FROM class_show WHERE id = :id LIMIT 1");
                $stmt2->execute([':id' => $id]);
                $record = $stmt2->fetch(PDO::FETCH_ASSOC);
            } else {
                $err = $stmt->errorInfo();
                $errors[] = "Update failed. SQLSTATE: " . ($err[0] ?? '') . " - " . ($err[2] ?? 'Unknown error');
                error_log("Update failed errorInfo: " . print_r($err, true));
            }
        } catch (PDOException $e) {
            // capture detailed DB error for display/logging
            $dbErrorDetail = $e->getMessage();
            error_log("Update class_show PDOException: " . $dbErrorDetail . "\nParams: " . print_r([
                'id' => $id,
                'teacher_id' => $teacher_id,
                'total' => $total
            ], true));
            $errors[] = "Database error while updating record: " . htmlspecialchars($dbErrorDetail);
        } catch (Exception $e) {
            error_log("Update class_show Exception: " . $e->getMessage());
            $errors[] = "Unexpected error: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<?php include  '../includes/css.php'; ?>
<?php include  '../includes/header.php'; ?>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">
                    <div class="header-button d-flex justify-content-between align-items-center mb-3">
                        <h3 class="">Edit Class Show</h3>
                        <a href="list_class_show.php" class="btn btn-success">View</a>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
                            </ul>
                            <?php if ($dbErrorDetail): ?>
                                <pre class="small text-muted"><?= htmlspecialchars($dbErrorDetail) ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="mb-4">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Session</label>
                                            <select name="session" class="form-control" required>
                                                <option value="2025-26" <?= ($record['session'] ?? '') == '2025-26' ? 'selected' : '' ?>>2025-26</option>
                                                <option value="2026-27" <?= ($record['session'] ?? '') == '2026-27' ? 'selected' : '' ?>>2026-27</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Date of class show</label>
                                            <input type="date" name="eval_date" class="form-control" value="<?= htmlspecialchars($record['eval_date'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Topic</label>
                                            <textarea name="topic" class="form-control" required><?= htmlspecialchars($record['topic'] ?? '') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label>Class Show Video Link</label>
                                            <input type="text" name="video_link" class="form-control" value="<?= htmlspecialchars($record['video_link'] ?? '') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label>Search Teacher (type to filter below)</label>
                                            <input type="text" id="teacherQuickSearch" class="form-control mb-2" placeholder="Type name, username or teacher id to filter the list...">
                                            <select id="teacherSelect" class="form-control" size="6" style="height:auto;">
                                                <?php if (empty($teachers)): ?>
                                                    <option disabled>No teachers found</option>
                                                <?php else: ?>
                                                    <?php foreach ($teachers as $t):
                                                        $display = ($t['fullname'] ?: $t['username']) . ' (' . ($t['teacher_id'] ?? '') . ')';
                                                        $dataName = htmlspecialchars($t['fullname'] ?: $t['username'], ENT_QUOTES);
                                                        $dataTid  = htmlspecialchars($t['teacher_id'] ?? '', ENT_QUOTES);
                                                        $dataSub  = htmlspecialchars($t['subject'] ?? '', ENT_QUOTES);
                                                    ?>
                                                        <option value="<?= htmlspecialchars($dataTid) ?>"
                                                            data-name="<?= $dataName ?>"
                                                            data-subject="<?= $dataSub ?>"><?= htmlspecialchars($display) ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Name of the Teacher</label>
                                            <input type="text" name="teacher_name" id="teacherName" class="form-control" value="<?= htmlspecialchars($record['teacher_name'] ?? '') ?>" readonly required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Teacher ID</label>
                                            <input type="text" name="teacher_id" id="teacherId" class="form-control" value="<?= htmlspecialchars($record['teacher_id'] ?? '') ?>" readonly required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Class/Section</label>
                                            <input type="text" name="class_section" class="form-control" value="<?= htmlspecialchars($record['class_section'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Name of The Judge</label>
                                            <input type="text" name="evaluator_name" class="form-control" value="<?= htmlspecialchars($record['evaluator_name'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Prayer (03)</label>
                                            <input type="number" name="prayer" class="form-control" min="0" max="3" step="0.01" value="<?= htmlspecialchars($record['prayer'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>News (English Only) (2)</label>
                                            <input type="number" name="news" class="form-control" min="0" max="2" step="0.01" value="<?= htmlspecialchars($record['news'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Participation (3)</label>
                                            <input type="number" name="participation" class="form-control" min="0" max="3" step="0.01" value="<?= htmlspecialchars($record['participation'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Speeches [English (5), Hindi (01)]</label>
                                            <input type="number" name="speeches" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['speeches'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Poem Recitation [English (2), Hindi (01)]</label>
                                            <input type="number" name="poem_recitation" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['poem_recitation'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Group Dance (4)</label>
                                            <input type="number" name="dance" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['dance'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Group Song (4)</label>
                                            <input type="number" name="song" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['song'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Stage Management (3)</label>
                                            <input type="number" name="stage_management" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['stage_management'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Innovation (2)</label>
                                            <input type="number" name="innovation" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['innovation'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Theme Based Skit Presentation (4)</label>
                                            <input type="number" name="skit" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['skit'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Theme Based Power Point Presentation (4)</label>
                                            <input type="number" name="ppt" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars($record['ppt'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Anchoring (3)</label>
                                            <input type="number" name="anchoring" class="form-control" min="0" max="3" step="0.01" value="<?= htmlspecialchars($record['anchoring'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Total (Auto-calculated)</label>
                                            <input type="number" name="total_display" id="totalField" class="form-control" step="0.01" readonly value="<?= htmlspecialchars($record['total'] ?? '') ?>">
                                            <small class="text-muted">This field is calculated automatically on the server; it will also update live below.</small>
                                        </div>
                                        <div class="mb-3">
                                            <label>Speaking Skills (Students)</label>
                                            <input type="text" name="speaking_skills" class="form-control" value="<?= htmlspecialchars($record['speaking_skills'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Dancing Skills (Students)</label>
                                            <input type="text" name="dancing_skills" class="form-control" value="<?= htmlspecialchars($record['dancing_skills'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Singing Skills (Students)</label>
                                            <input type="text" name="singing_skills" class="form-control" value="<?= htmlspecialchars($record['singing_skills'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Dramatic Skills (Students)</label>
                                            <input type="text" name="dramatic_skills" class="form-control" value="<?= htmlspecialchars($record['dramatic_skills'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Comments by Judge 1</label>
                                            <textarea name="comments1" class="form-control"><?= htmlspecialchars($record['comments1'] ?? '') ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Comments by Judge 2</label>
                                            <textarea name="comments2" class="form-control"><?= htmlspecialchars($record['comments2'] ?? '') ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Total Marks By Judge 1</label>
                                            <input type="number" name="marks_judge1" class="form-control" step="0.01" value="<?= htmlspecialchars($record['marks_judge1'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Total Marks By Judge 2</label>
                                            <input type="number" name="marks_judge2" class="form-control" step="0.01" value="<?= htmlspecialchars($record['marks_judge2'] ?? '') ?>">
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" name="save" class="btn btn-success">Update</button>
                                            <a href="list_class_show.php" class="btn btn-secondary">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <?php include '../includes/footer.php'; ?>

            <!-- Small client-side filtering & auto-total JS -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sel = document.getElementById('teacherSelect');
                    const quick = document.getElementById('teacherQuickSearch');
                    const teacherName = document.getElementById('teacherName');
                    const teacherId = document.getElementById('teacherId');
                    const totalField = document.getElementById('totalField');

                    // build options cache
                    if (sel) {
                        const optionsCache = Array.from(sel.options).map(o => ({
                            value: o.value,
                            text: o.text,
                            dataName: o.getAttribute('data-name') || '',
                            dataSubject: o.getAttribute('data-subject') || ''
                        }));

                        function renderList(q) {
                            q = (q || '').toLowerCase().trim();
                            sel.innerHTML = '';
                            const filtered = optionsCache.filter(o => {
                                if (!q) return true;
                                return o.text.toLowerCase().includes(q) || o.dataName.toLowerCase().includes(q) || o.value.toLowerCase().includes(q);
                            });
                            if (filtered.length === 0) {
                                const opt = document.createElement('option');
                                opt.disabled = true;
                                opt.textContent = 'No teachers match your search';
                                sel.appendChild(opt);
                                return;
                            }
                            filtered.forEach(o => {
                                const opt = document.createElement('option');
                                opt.value = o.value;
                                opt.textContent = o.text;
                                if (o.dataName) opt.setAttribute('data-name', o.dataName);
                                if (o.dataSubject) opt.setAttribute('data-subject', o.dataSubject);
                                sel.appendChild(opt);
                            });
                            // try to preselect teacherId if present
                            const currentTeacherId = "<?= addslashes($record['teacher_id'] ?? '') ?>";
                            if (currentTeacherId) {
                                for (let i = 0; i < sel.options.length; i++) {
                                    if (sel.options[i].value === currentTeacherId) {
                                        sel.selectedIndex = i;
                                        sel.dispatchEvent(new Event('change'));
                                        break;
                                    }
                                }
                            }
                        }

                        // initial render
                        renderList('');

                        if (quick) {
                            let t;
                            quick.addEventListener('input', function() {
                                clearTimeout(t);
                                t = setTimeout(() => renderList(this.value), 120);
                            });
                        }

                        sel.addEventListener('change', function() {
                            const o = sel.options[sel.selectedIndex];
                            if (!o) return;
                            const name = o.getAttribute('data-name') || '';
                            const tid = o.value || '';
                            teacherName.value = name;
                            teacherId.value = tid;
                        });
                    }

                    // live total calculation (client-side just for visual; server calculates authoritative total)
                    function calcTotal() {
                        const fields = ['prayer', 'news', 'participation', 'speeches', 'poem_recitation', 'dance', 'song', 'stage_management', 'innovation', 'skit', 'ppt', 'anchoring'];
                        let sum = 0;
                        fields.forEach(fn => {
                            const el = document.querySelector('[name="' + fn + '"]');
                            if (el && el.value !== '') {
                                const v = parseFloat(el.value);
                                if (!isNaN(v)) sum += v;
                            }
                        });
                        totalField.value = Math.round(sum * 100) / 100;
                    }

                    ['prayer', 'news', 'participation', 'speeches', 'poem_recitation', 'dance', 'song', 'stage_management', 'innovation', 'skit', 'ppt', 'anchoring'].forEach(name => {
                        const el = document.querySelector('[name="' + name + '"]');
                        if (el) el.addEventListener('input', calcTotal);
                    });

                    // run once
                    calcTotal();
                });
            </script>