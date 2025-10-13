<?php
// admin/teachers/add_notebook.php
// Server-side teacher search (no AJAX) + instant client-side filter
// Place in admin/teachers/ so relative includes below work.

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

// Handle POST: save notebook record (document upload removed)
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
            $sql = "INSERT INTO records 
                (session, eval_date, teacher_name, teacher_id, subject, class_section, notebooks_checked, students_reviewed, 
                 regularity_checking, accuracy, neatness, follow_up, overall_rating, evaluator_name, remarks, undertaking)
                VALUES
                (:session, :eval_date, :teacher_name, :teacher_id, :subject, :class_section, :notebooks_checked, :students_reviewed,
                 :regularity_checking, :accuracy, :neatness, :follow_up, :overall_rating, :evaluator_name, :remarks, :undertaking)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':session', $session);
            $stmt->bindParam(':eval_date', $eval_date);
            $stmt->bindParam(':teacher_name', $teacher_name);
            $stmt->bindParam(':teacher_id', $teacher_id);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':class_section', $class_section);
            $stmt->bindParam(':notebooks_checked', $notebooks_checked, PDO::PARAM_INT);
            $stmt->bindParam(':students_reviewed', $students_reviewed);
            $stmt->bindParam(':regularity_checking', $regularity_checking);
            $stmt->bindParam(':accuracy', $accuracy);
            $stmt->bindParam(':neatness', $neatness);
            $stmt->bindParam(':follow_up', $follow_up);
            $stmt->bindParam(':overall_rating', $overall_rating);
            $stmt->bindParam(':evaluator_name', $evaluator_name);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->bindParam(':undertaking', $undertaking, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $message = "Notebook record saved successfully.";
                // keep selected teacher visible for UX
                // do not clear $_POST entirely so form values remain
            } else {
                $errors[] = "Database insert failed.";
            }
        } catch (PDOException $e) {
            error_log("Insert records error: " . $e->getMessage());
            $errors[] = "DB error. Check logs.";
        }
    }
}

// SERVER-SIDE SEARCH to populate teacher list (GET q)
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
        $sql = "SELECT id, username, fullname, teacher_id, subject FROM users
                WHERE teacher_id IS NOT NULL AND teacher_id <> '' ORDER BY fullname LIMIT 100";
        $stmt = $conn->query($sql);
        $teacherRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    error_log("Teacher search error: " . $e->getMessage());
    $teacherRows = [];
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
                        <h3>Notebook Corrections</h3>
                        <a href="list_notebook.php" class="btn btn-success">View</a>
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

                    <!-- Search form (server-side, reloads page) -->
                    <!-- <form method="GET" class="mb-3 d-flex gap-2" style="max-width:700px;">
                        <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Search teacher name / username / teacher id">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="add_notebook.php" class="btn btn-secondary">Reset</a>
                    </form> -->

                    <!-- Notebook form -->
                    <form method="POST">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label>Session</label>
                                            <select name="session" class="form-control" required>
                                                <option value="2025-26" <?= (($_POST['session'] ?? '') == '2025-26') ? 'selected' : '' ?>>2025-26</option>
                                                <option value="2026-27" <?= (($_POST['session'] ?? '') == '2026-27') ? 'selected' : '' ?>>2026-27</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Date of Evaluation</label>
                                            <input type="date" name="eval_date" class="form-control" value="<?= htmlspecialchars($_POST['eval_date'] ?? '') ?>" required>
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
                                                            data-subject="<?= $dataSub ?>">
                                                            <?= htmlspecialchars($display) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <!-- Selected teacher display & hidden inputs (single copy) -->
                                        <div class="mb-3">
                                            <label>Selected Teacher (auto-filled)</label>
                                            <input type="text" id="teacherSelectedDisplay" class="form-control" value="<?= htmlspecialchars($_POST['teacher_name'] ?? '') ?>" readonly required>
                                        </div>
                                        <input type="hidden" name="teacher_id" id="teacherIdHidden" value="<?= htmlspecialchars($_POST['teacher_id'] ?? '') ?>">
                                        <input type="hidden" name="teacher_name" id="teacherNameHidden" value="<?= htmlspecialchars($_POST['teacher_name'] ?? '') ?>">
                                        <input type="hidden" name="subject" id="subjectHidden" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">

                                        <div class="mb-3">
                                            <label>Class/Section</label>
                                            <input type="text" name="class_section" class="form-control" value="<?= htmlspecialchars($_POST['class_section'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Number of Notebooks Checked</label>
                                            <input type="number" name="notebooks_checked" class="form-control" min="1" value="<?= htmlspecialchars($_POST['notebooks_checked'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Names of Students Reviewed</label>
                                            <textarea name="students_reviewed" class="form-control" required><?= htmlspecialchars($_POST['students_reviewed'] ?? '') ?></textarea>
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
                                                <?php $sel = $_POST['regularity_checking'] ?? ''; ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Accuracy</label>
                                            <select name="accuracy" class="form-control" required>
                                                <?php $sel = $_POST['accuracy'] ?? ''; ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Neatness</label>
                                            <select name="neatness" class="form-control" required>
                                                <?php $sel = $_POST['neatness'] ?? ''; ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Follow-up of Corrections</label>
                                            <select name="follow_up" class="form-control" required>
                                                <?php $sel = $_POST['follow_up'] ?? ''; ?>
                                                <option <?= $sel == 'Done' ? 'selected' : '' ?>>Done</option>
                                                <option <?= $sel == 'Not Done' ? 'selected' : '' ?>>Not Done</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Overall Rating</label>
                                            <select name="overall_rating" class="form-control" required>
                                                <?php $sel = $_POST['overall_rating'] ?? ''; ?>
                                                <option <?= $sel == 'Excellent' ? 'selected' : '' ?>>Excellent</option>
                                                <option <?= $sel == 'Good' ? 'selected' : '' ?>>Good</option>
                                                <option <?= $sel == 'Satisfactory' ? 'selected' : '' ?>>Satisfactory</option>
                                                <option <?= $sel == 'Needs Improvement' ? 'selected' : '' ?>>Needs Improvement</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Evaluator's Name & Designation</label>
                                            <select name="evaluator_name" class="form-control" required>
                                                <?php $sel = $_POST['evaluator_name'] ?? ''; ?>
                                                <option value="">--Select--</option>
                                                <option value="Meera Marwaha" <?= $sel == 'Meera Marwaha' ? 'selected' : '' ?>>Meera Marwaha</option>
                                                <option value="Manju Setia" <?= $sel == 'Manju Setia' ? 'selected' : '' ?>>Manju Setia</option>
                                                <option value="Madhup Prashar" <?= $sel == 'Madhup Prashar' ? 'selected' : '' ?>>Madhup Prashar</option>
                                                <option value="Other" <?= $sel == 'Other' ? 'selected' : '' ?>>Other</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Remarks</label>
                                            <textarea name="remarks" class="form-control"><?= htmlspecialchars($_POST['remarks'] ?? '') ?></textarea>
                                        </div>

                                        <!-- <div class="mb-3 form-check">
                                            <input type="checkbox" name="undertaking" class="form-check-input" id="undertaking" <?= isset($_POST['undertaking']) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="undertaking">Undertaking</label>
                                        </div> -->

                                        <div class="d-flex gap-2">
                                            <button type="submit" name="save_notebook" class="btn btn-success">Submit</button>
                                            <a href="/mkkschool-new/dashboard.php" class="btn btn-secondary">Back</a>
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

    // small helper: safely get element by id
    function $(id){ return document.getElementById(id); }

    if (!select) return;

    // cache original options for restoring & filtering
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

    // When user selects an option, copy data -> hidden fields & display
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

    // Prefill display from hidden inputs if server re-populated after POST
    (function prefillFromHidden() {
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

        // if hidden teacher_id present, try to select matching option
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
/* small styling for the instant filter dropdown/select */
#teacherQuickSearch { margin-bottom: .5rem; }
#teacherSelect { font-size: 0.95rem; }
</style>
