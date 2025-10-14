<?php
// admin/teachers/edit_notebook.php
// Edit an existing notebook correction record (no AJAX)
// Place in admin/teachers/ same folder as add_notebook.php

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../database.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection(); // expecting PDO

$message = '';
$errors = [];

// Get the record id to edit
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    // no id -> redirect to list
    header('Location: list_notebook.php');
    exit;
}

// Fetch existing record
$record = null;
try {
    $sql = "SELECT * FROM records WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$record) {
        header('Location: list_notebook.php');
        exit;
    }
} catch (PDOException $e) {
    error_log("Fetch record error: " . $e->getMessage());
    header('Location: list_notebook.php');
    exit;
}

// If POST => update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_notebook'])) {
    $session             = trim($_POST['session'] ?? '');
    $eval_date           = trim($_POST['eval_date'] ?? '');
    $teacher_name        = trim($_POST['teacher_name'] ?? '');
    $teacher_id          = trim($_POST['teacher_id'] ?? '');
    $subject             = trim($_POST['subject'] ?? '');
    $class_section       = trim($_POST['class_section'] ?? '');
    $notebooks_checked   = (int)($_POST['notebooks_checked'] ?? 0);
    $students_reviewed   = trim($_POST['students_reviewed'] ?? '');
    $regularity_checking = trim($_POST['regularity_checking'] ?? '');
    $accuracy            = trim($_POST['accuracy'] ?? '');
    $neatness            = trim($_POST['neatness'] ?? '');
    $follow_up           = trim($_POST['follow_up'] ?? '');
    $overall_rating      = trim($_POST['overall_rating'] ?? '');
    $evaluator_name      = trim($_POST['evaluator_name'] ?? '');
    $remarks             = trim($_POST['remarks'] ?? '');
    $undertaking         = isset($_POST['undertaking']) ? 1 : 0;

    // validation
    if ($session === '') $errors[] = "Session required.";
    if ($eval_date === '') $errors[] = "Date of Evaluation required.";
    if ($teacher_id === '') $errors[] = "Please select a teacher.";
    if ($class_section === '') $errors[] = "Class/Section required.";
    if ($notebooks_checked <= 0) $errors[] = "Number of notebooks must be > 0.";
    if ($students_reviewed === '') $errors[] = "Names of students reviewed required.";
    if ($regularity_checking === '') $errors[] = "Regularity required.";
    if ($accuracy === '') $errors[] = "Accuracy required.";
    if ($neatness === '') $errors[] = "Neatness required.";
    if ($follow_up === '') $errors[] = "Follow-up required.";
    if ($overall_rating === '') $errors[] = "Overall rating required.";
    if ($evaluator_name === '') $errors[] = "Evaluator name required.";

    if (empty($errors)) {
        try {
            $updateSql = "UPDATE records SET
                session = :session,
                eval_date = :eval_date,
                teacher_name = :teacher_name,
                teacher_id = :teacher_id,
                subject = :subject,
                class_section = :class_section,
                notebooks_checked = :notebooks_checked,
                students_reviewed = :students_reviewed,
                regularity_checking = :regularity_checking,
                accuracy = :accuracy,
                neatness = :neatness,
                follow_up = :follow_up,
                overall_rating = :overall_rating,
                evaluator_name = :evaluator_name,
                remarks = :remarks,
                undertaking = :undertaking
                WHERE id = :id
                LIMIT 1";
            $ustmt = $conn->prepare($updateSql);
            $ustmt->bindParam(':session', $session);
            $ustmt->bindParam(':eval_date', $eval_date);
            $ustmt->bindParam(':teacher_name', $teacher_name);
            $ustmt->bindParam(':teacher_id', $teacher_id);
            $ustmt->bindParam(':subject', $subject);
            $ustmt->bindParam(':class_section', $class_section);
            $ustmt->bindParam(':notebooks_checked', $notebooks_checked, PDO::PARAM_INT);
            $ustmt->bindParam(':students_reviewed', $students_reviewed);
            $ustmt->bindParam(':regularity_checking', $regularity_checking);
            $ustmt->bindParam(':accuracy', $accuracy);
            $ustmt->bindParam(':neatness', $neatness);
            $ustmt->bindParam(':follow_up', $follow_up);
            $ustmt->bindParam(':overall_rating', $overall_rating);
            $ustmt->bindParam(':evaluator_name', $evaluator_name);
            $ustmt->bindParam(':remarks', $remarks);
            $ustmt->bindParam(':undertaking', $undertaking, PDO::PARAM_INT);
            $ustmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($ustmt->execute()) {
                $message = "Notebook record updated successfully.";
                // refresh $record with new values for display
                $record = [
                    'id' => $id,
                    'session' => $session,
                    'eval_date' => $eval_date,
                    'teacher_name' => $teacher_name,
                    'teacher_id' => $teacher_id,
                    'subject' => $subject,
                    'class_section' => $class_section,
                    'notebooks_checked' => $notebooks_checked,
                    'students_reviewed' => $students_reviewed,
                    'regularity_checking' => $regularity_checking,
                    'accuracy' => $accuracy,
                    'neatness' => $neatness,
                    'follow_up' => $follow_up,
                    'overall_rating' => $overall_rating,
                    'evaluator_name' => $evaluator_name,
                    'remarks' => $remarks,
                    'undertaking' => $undertaking
                ];
            } else {
                $errors[] = "Failed to update record.";
            }
        } catch (PDOException $e) {
            error_log("Update record error: " . $e->getMessage());
            $errors[] = "DB error. Check logs.";
        }
    }
}

// Prepare teacher list (server-side search GET 'q')
// To keep UI same as add_notebook, we prepopulate teacherRows (either filtered by q or top list)
$searchQuery = trim($_GET['q'] ?? '');
$teacherRows = [];
try {
    if ($searchQuery !== '') {
        $term = '%' . $searchQuery . '%';
        $sql = "SELECT id, username, fullname, teacher_id, subject 
                FROM users
                WHERE (fullname LIKE :term OR username LIKE :term OR teacher_id LIKE :term)
                  AND teacher_id IS NOT NULL AND teacher_id <> ''
                ORDER BY fullname
                LIMIT 200";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':term', $term, PDO::PARAM_STR);
        $stmt->execute();
        $teacherRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // default list; make sure current teacher (from $record) is included
        $sql = "SELECT id, username, fullname, teacher_id, subject FROM users
                WHERE teacher_id IS NOT NULL AND teacher_id <> ''
                ORDER BY fullname LIMIT 200";
        $stmt = $conn->query($sql);
        $teacherRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    error_log("Teacher list error: " . $e->getMessage());
    $teacherRows = [];
}

// helper to get form-value fallback to DB record
function val($field, $record) {
    // prefer POST (when posted), else record value
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return htmlspecialchars($_POST[$field] ?? '', ENT_QUOTES);
    }
    return htmlspecialchars($record[$field] ?? '', ENT_QUOTES);
}

?>
<?php include __DIR__ . '/../../includes/css.php'; ?>
<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">

                    <div class="header-button d-flex justify-content-between align-items-center mb-3">
                        <h3>Edit Notebook Correction</h3>
                        <a href="list_notebook.php" class="btn btn-success">Back to list</a>
                    </div>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Search form (server-side) -->
                    <form method="GET" class="mb-3 d-flex gap-2" style="max-width:700px;">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Search teacher name / username / teacher id">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="edit_notebook.php?id=<?= $id ?>" class="btn btn-secondary">Reset</a>
                    </form>

                    <!-- Edit form -->
                    <form method="POST">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label>Session</label>
                                            <select name="session" class="form-control" required>
                                                <option value="2025-26" <?= (val('session', $record) == '2025-26') ? 'selected' : '' ?>>2025-26</option>
                                                <option value="2026-27" <?= (val('session', $record) == '2026-27') ? 'selected' : '' ?>>2026-27</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Date of Evaluation</label>
                                            <input type="date" name="eval_date" class="form-control" value="<?= val('eval_date', $record) ?>" required>
                                        </div>

                                        <!-- Instant client-side filter + server-populated select -->
                                        <div class="mb-3">
                                            <label>Search / Filter Teacher (instant)</label>
                                            <input type="text" id="teacherQuickSearch" class="form-control mb-2" placeholder="Type name, username or teacher id to filter the list...">
                                            <small class="form-text text-muted">Typing filters the list below. Click an entry to select it.</small>

                                            <select id="teacherSelect" class="form-control" size="8" style="height:auto;">
                                                <?php if (count($teacherRows) === 0): ?>
                                                    <option disabled>No teachers found. Use search box above.</option>
                                                <?php else: ?>
                                                    <?php foreach ($teacherRows as $t): 
                                                        $display = ($t['fullname'] ?: $t['username']) . ' (' . ($t['teacher_id'] ?? '') . ')';
                                                        $dataName = htmlspecialchars($t['fullname'] ?: $t['username'], ENT_QUOTES);
                                                        $dataId   = htmlspecialchars($t['teacher_id'] ?? '', ENT_QUOTES);
                                                        $dataSub  = htmlspecialchars($t['subject'] ?? '', ENT_QUOTES);
                                                    ?>
                                                        <option value="<?= htmlspecialchars($t['id'], ENT_QUOTES) ?>"
                                                            data-name="<?= $dataName ?>"
                                                            data-teacherid="<?= $dataId ?>"
                                                            data-subject="<?= $dataSub ?>"
                                                            <?= ($t['teacher_id'] === ($record['teacher_id'] ?? '')) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($display) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <!-- Selected teacher display & hidden inputs -->
                                        <div class="mb-3">
                                            <label>Selected Teacher (auto-filled)</label>
                                            <input type="text" id="teacherSelectedDisplay" class="form-control" value="<?= val('teacher_name', $record) ?>" readonly required>
                                        </div>
                                        <input type="hidden" name="teacher_id" id="teacherIdHidden" value="<?= val('teacher_id', $record) ?>">
                                        <input type="hidden" name="teacher_name" id="teacherNameHidden" value="<?= val('teacher_name', $record) ?>">
                                        <input type="hidden" name="subject" id="subjectHidden" value="<?= val('subject', $record) ?>">

                                        <div class="mb-3">
                                            <label>Class/Section</label>
                                            <input type="text" name="class_section" class="form-control" value="<?= val('class_section', $record) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Number of Notebooks Checked</label>
                                            <input type="number" name="notebooks_checked" class="form-control" min="1" value="<?= val('notebooks_checked', $record) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Names of Students Reviewed</label>
                                            <textarea name="students_reviewed" class="form-control" required><?= val('students_reviewed', $record) ?></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label>Regularity in Checking</label>
                                            <select name="regularity_checking" class="form-control" required>
                                                <?php $sel = ($_SERVER['REQUEST_METHOD'] === 'POST') ? ($_POST['regularity_checking'] ?? '') : ($record['regularity_checking'] ?? ''); ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Accuracy</label>
                                            <select name="accuracy" class="form-control" required>
                                                <?php $sel = ($_SERVER['REQUEST_METHOD'] === 'POST') ? ($_POST['accuracy'] ?? '') : ($record['accuracy'] ?? ''); ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Neatness</label>
                                            <select name="neatness" class="form-control" required>
                                                <?php $sel = ($_SERVER['REQUEST_METHOD'] === 'POST') ? ($_POST['neatness'] ?? '') : ($record['neatness'] ?? ''); ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Follow-up of Corrections</label>
                                            <select name="follow_up" class="form-control" required>
                                                <?php $sel = ($_SERVER['REQUEST_METHOD'] === 'POST') ? ($_POST['follow_up'] ?? '') : ($record['follow_up'] ?? ''); ?>
                                                <option <?= $sel == 'Done' ? 'selected' : '' ?>>Done</option>
                                                <option <?= $sel == 'Not Done' ? 'selected' : '' ?>>Not Done</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Overall Rating</label>
                                            <select name="overall_rating" class="form-control" required>
                                                <?php $sel = ($_SERVER['REQUEST_METHOD'] === 'POST') ? ($_POST['overall_rating'] ?? '') : ($record['overall_rating'] ?? ''); ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Evaluator's Name & Designation</label>
                                            <?php $sel = ($_SERVER['REQUEST_METHOD'] === 'POST') ? ($_POST['evaluator_name'] ?? '') : ($record['evaluator_name'] ?? ''); ?>
                                            <select name="evaluator_name" class="form-control" required>
                                                <option value="">--Select--</option>
                                                <option value="Meera Marwaha" <?= $sel == 'Meera Marwaha' ? 'selected' : '' ?>>Meera Marwaha</option>
                                                <option value="Manju Setia" <?= $sel == 'Manju Setia' ? 'selected' : '' ?>>Manju Setia</option>
                                                <option value="Madhup Prashar" <?= $sel == 'Madhup Prashar' ? 'selected' : '' ?>>Madhup Prashar</option>
                                                <option value="Other" <?= $sel == 'Other' ? 'selected' : '' ?>>Other</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Remarks</label>
                                            <textarea name="remarks" class="form-control"><?= ($_SERVER['REQUEST_METHOD'] === 'POST') ? htmlspecialchars($_POST['remarks'] ?? '') : htmlspecialchars($record['remarks'] ?? '') ?></textarea>
                                        </div>

                                        <div class="mb-3 form-check">
                                            <?php $chk = ($_SERVER['REQUEST_METHOD'] === 'POST') ? (isset($_POST['undertaking']) ? 'checked' : '') : (!empty($record['undertaking']) ? 'checked' : ''); ?>
                                            <input type="checkbox" name="undertaking" class="form-check-input" id="undertaking" <?= $chk ?>>
                                            <label class="form-check-label" for="undertaking">Undertaking</label>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" name="save_notebook" class="btn btn-primary">Update</button>
                                            <a href="list_notebook.php" class="btn btn-secondary">Cancel</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<!-- Client-side scripts: filter + select -> fill hidden fields + prefill -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterInput = document.getElementById('teacherQuickSearch');
    const select = document.getElementById('teacherSelect');

    function $(id){ return document.getElementById(id); }
    if (!select) return;

    const originalOptions = Array.from(select.options).map(opt => ({
        value: opt.value,
        text: opt.text,
        dataName: opt.getAttribute('data-name') || '',
        dataTeacherId: opt.getAttribute('data-teacherid') || '',
        dataSubject: opt.getAttribute('data-subject') || ''
    }));

    function normalize(s){ return (s||'').toString().toLowerCase().trim(); }

    function renderOptions(list) {
        select.innerHTML = '';
        if (list.length === 0) {
            const opt = document.createElement('option');
            opt.disabled = true;
            opt.textContent = 'No teachers match your search';
            select.appendChild(opt);
            return;
        }
        list.forEach(o => {
            const opt = document.createElement('option');
            opt.value = o.value;
            opt.textContent = o.text;
            if (o.dataName) opt.setAttribute('data-name', o.dataName);
            if (o.dataTeacherId) opt.setAttribute('data-teacherid', o.dataTeacherId);
            if (o.dataSubject) opt.setAttribute('data-subject', o.dataSubject);
            select.appendChild(opt);
        });
    }

    if (filterInput) {
        let debounce = null;
        filterInput.addEventListener('input', function () {
            clearTimeout(debounce);
            const q = this.value || '';
            debounce = setTimeout(function () {
                const nq = normalize(q);
                if (!nq) {
                    renderOptions(originalOptions);
                    return;
                }
                const filtered = originalOptions.filter(o =>
                    normalize(o.text).includes(nq) ||
                    normalize(o.dataName).includes(nq) ||
                    normalize(o.dataTeacherId).includes(nq)
                );
                renderOptions(filtered);
            }, 120);
        });
    }

    // copy selection -> hidden fields & display
    select.addEventListener('change', function () {
        const opt = select.options[select.selectedIndex];
        if (!opt) return;
        const name = opt.getAttribute('data-name') || opt.textContent || '';
        const tid  = opt.getAttribute('data-teacherid') || '';
        const sub  = opt.getAttribute('data-subject') || '';

        $('teacherIdHidden').value = tid;
        $('teacherNameHidden').value = name;
        $('subjectHidden').value = sub;

        let disp = name;
        if (tid) disp += ' (' + tid + ')';
        if (sub) disp += ' — ' + sub;
        $('teacherSelectedDisplay').value = disp;
    });

    // Prefill display & selected option from record/POST
    (function prefill() {
        const hidName = $('teacherNameHidden');
        const hidTid  = $('teacherIdHidden');
        const hidSub  = $('subjectHidden');
        const dispEl  = $('teacherSelectedDisplay');

        if (hidName && hidName.value && dispEl) {
            let disp = hidName.value;
            if (hidTid && hidTid.value) disp += ' (' + hidTid.value + ')';
            if (hidSub && hidSub.value) disp += ' — ' + hidSub.value;
            dispEl.value = disp;
        }

        if (hidTid && hidTid.value) {
            for (let i = 0; i < select.options.length; i++) {
                const o = select.options[i];
                if (o.getAttribute('data-teacherid') === hidTid.value || o.value === hidTid.value) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }
    })();

});
</script>

<style>
#teacherQuickSearch { margin-bottom: .5rem; }
#teacherSelect { font-size: 0.95rem; }
</style>
