<?php
// add_class_show.php
// Add Class Show record - server + client (no AJAX)

require_once '../config.php';
require_once '../auth.php';
require_once '../database.php';

$auth = new Auth();
if (!$auth->isLoggedIn() || !$auth->hasPermission(ROLE_ADMIN)) {
    header('Location: /mkkschool-new/login.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection(); // PDO

$message = '';
$errors = [];

// Fetch teachers for select (users table where teacher_id is present)
try {
    $stmt = $conn->prepare("SELECT id, username, fullname, teacher_id, subject FROM users WHERE teacher_id IS NOT NULL AND teacher_id <> '' ORDER BY fullname");
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Fetch teachers error: " . $e->getMessage());
    $teachers = [];
}

// Handle POST (save class show)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // trim and collect
    $session = trim($_POST['session'] ?? '');
    $eval_date = trim($_POST['eval_date'] ?? '');
    $topic = trim($_POST['topic'] ?? '');
    $video_link = trim($_POST['video_link'] ?? '');
    $teacher_id = trim($_POST['teacher_id'] ?? '');
    $teacher_name = trim($_POST['teacher_name'] ?? '');
    $class_section = trim($_POST['class_section'] ?? '');
    $evaluator_name = trim($_POST['evaluator_name'] ?? '');

    // numeric fields (use float cast)
    $prayer = is_numeric($_POST['prayer'] ?? null) ? (float)$_POST['prayer'] : 0.0;
    $news = is_numeric($_POST['news'] ?? null) ? (float)$_POST['news'] : 0.0;
    $participation = is_numeric($_POST['participation'] ?? null) ? (float)$_POST['participation'] : 0.0;
    $speeches = is_numeric($_POST['speeches'] ?? null) ? (float)$_POST['speeches'] : 0.0;
    $poem_recitation = is_numeric($_POST['poem_recitation'] ?? null) ? (float)$_POST['poem_recitation'] : 0.0;
    $dance = is_numeric($_POST['dance'] ?? null) ? (float)$_POST['dance'] : 0.0;
    $song = is_numeric($_POST['song'] ?? null) ? (float)$_POST['song'] : 0.0;
    $stage_management = is_numeric($_POST['stage_management'] ?? null) ? (float)$_POST['stage_management'] : 0.0;
    $innovation = is_numeric($_POST['innovation'] ?? null) ? (float)$_POST['innovation'] : 0.0;
    $skit = is_numeric($_POST['skit'] ?? null) ? (float)$_POST['skit'] : 0.0;
    $ppt = is_numeric($_POST['ppt'] ?? null) ? (float)$_POST['ppt'] : 0.0;
    $anchoring = is_numeric($_POST['anchoring'] ?? null) ? (float)$_POST['anchoring'] : 0.0;

    $speaking_skills = trim($_POST['speaking_skills'] ?? '');
    $dancing_skills  = trim($_POST['dancing_skills'] ?? '');
    $singing_skills  = trim($_POST['singing_skills'] ?? '');
    $dramatic_skills = trim($_POST['dramatic_skills'] ?? '');
    $comments1 = trim($_POST['comments1'] ?? '');
    $comments2 = trim($_POST['comments2'] ?? '');
    $marks_judge1 = is_numeric($_POST['marks_judge1'] ?? null) ? (float)$_POST['marks_judge1'] : null;
    $marks_judge2 = is_numeric($_POST['marks_judge2'] ?? null) ? (float)$_POST['marks_judge2'] : null;

    // Calculate total server-side to avoid tampering
    $total = $prayer + $news + $participation + $speeches + $poem_recitation + $dance + $song + $stage_management + $innovation + $skit + $ppt + $anchoring;

    // Basic validation
    if ($session === '') $errors[] = "Session is required.";
    if ($eval_date === '') $errors[] = "Date of class show is required.";
    if ($topic === '') $errors[] = "Topic is required.";
    if ($teacher_id === '') $errors[] = "Please select a teacher.";
    if ($class_section === '') $errors[] = "Class/Section is required.";
    if ($evaluator_name === '') $errors[] = "Name of the judge is required.";

    // You can add more validation for numeric ranges (optional)
    // Example: ensure prayer between 0 and 3
    if ($prayer < 0 || $prayer > 3) $errors[] = "Prayer value must be between 0 and 3.";
    if ($news < 0 || $news > 2) $errors[] = "News value must be between 0 and 2.";
    if ($participation < 0 || $participation > 3) $errors[] = "Participation must be between 0 and 3.";
    // ... add more range checks if required

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO class_show 
                (session, eval_date, topic, video_link, teacher_name, teacher_id, evaluator_name, class_section, prayer, news, participation, speeches, poem_recitation, dance, song, stage_management, innovation, skit, ppt, anchoring, total, speaking_skills, dancing_skills, singing_skills, dramatic_skills, comments1, comments2, marks_judge1, marks_judge2, created_at)
                VALUES
                (:session, :eval_date, :topic, :video_link, :teacher_name, :teacher_id, :evaluator_name, :class_section, :prayer, :news, :participation, :speeches, :poem_recitation, :dance, :song, :stage_management, :innovation, :skit, :ppt, :anchoring, :total, :speaking_skills, :dancing_skills, :singing_skills, :dramatic_skills, :comments1, :comments2, :marks_judge1, :marks_judge2, NOW())";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':session', $session);
            $stmt->bindParam(':eval_date', $eval_date);
            $stmt->bindParam(':topic', $topic);
            $stmt->bindParam(':video_link', $video_link);
            $stmt->bindParam(':teacher_name', $teacher_name);
            $stmt->bindParam(':teacher_id', $teacher_id);
            $stmt->bindParam(':evaluator_name', $evaluator_name);
            $stmt->bindParam(':class_section', $class_section);
            $stmt->bindParam(':prayer', $prayer);
            $stmt->bindParam(':news', $news);
            $stmt->bindParam(':participation', $participation);
            $stmt->bindParam(':speeches', $speeches);
            $stmt->bindParam(':poem_recitation', $poem_recitation);
            $stmt->bindParam(':dance', $dance);
            $stmt->bindParam(':song', $song);
            $stmt->bindParam(':stage_management', $stage_management);
            $stmt->bindParam(':innovation', $innovation);
            $stmt->bindParam(':skit', $skit);
            $stmt->bindParam(':ppt', $ppt);
            $stmt->bindParam(':anchoring', $anchoring);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':speaking_skills', $speaking_skills);
            $stmt->bindParam(':dancing_skills', $dancing_skills);
            $stmt->bindParam(':singing_skills', $singing_skills);
            $stmt->bindParam(':dramatic_skills', $dramatic_skills);
            $stmt->bindParam(':comments1', $comments1);
            $stmt->bindParam(':comments2', $comments2);
            $stmt->bindParam(':marks_judge1', $marks_judge1);
            $stmt->bindParam(':marks_judge2', $marks_judge2);

            if ($stmt->execute()) {
                $message = "Class show saved successfully.";
                // clear POST to reset form
                $_POST = [];
                // refresh teacher list in case needed (optional)
                $stmt2 = $conn->prepare("SELECT id, username, fullname, teacher_id, subject FROM users WHERE teacher_id IS NOT NULL AND teacher_id <> '' ORDER BY fullname");
                $stmt2->execute();
                $teachers = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $errors[] = "Failed to save. Please try again.";
            }
        } catch (PDOException $e) {
            error_log("Insert class_show error: " . $e->getMessage());
            $errors[] = "Database error. Please check logs.";
        }
    }
}

?>
<?php include '../includes/css.php'; ?>
<?php include '../includes/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">
                    <div class="header-button d-flex justify-content-between align-items-center mb-3">
                        <h3 class="">Add Class Show</h3>
                        <a href="list_class_show.php" class="btn btn-success">View</a>
                    </div>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="classShowForm" novalidate>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Session</label>
                                            <select name="session" class="form-control" required>
                                                <option value="2025-26" <?= (($_POST['session'] ?? '') == '2025-26') ? 'selected' : '' ?>>2025-26</option>
                                                <option value="2026-27" <?= (($_POST['session'] ?? '') == '2026-27') ? 'selected' : '' ?>>2026-27</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Date of class show</label>
                                            <input type="date" name="eval_date" class="form-control" value="<?= htmlspecialchars($_POST['eval_date'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Topic</label>
                                            <textarea name="topic" class="form-control" required><?= htmlspecialchars($_POST['topic'] ?? '') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label>Class Show Video Link</label>
                                            <input type="text" name="video_link" class="form-control" value="<?= htmlspecialchars($_POST['video_link'] ?? '') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label>Search / Filter Teacher</label>
                                            <input type="text" id="teacherQuickSearch" class="form-control mb-2" placeholder="Type name, username or teacher id to filter the list...">
                                            <small class="form-text text-muted">Type to filter the list below, then click the teacher to select.</small>

                                            <label class="mt-2">Select Teacher</label>
                                            <select id="teacherSelect" class="form-control" size="6" style="height:auto;">
                                                <?php if (empty($teachers)): ?>
                                                    <option disabled>No teachers found</option>
                                                <?php else: ?>
                                                    <?php foreach ($teachers as $t):
                                                        $display = ($t['fullname'] ?: $t['username']) . ' (' . ($t['teacher_id'] ?? '') . ')';
                                                        $dataName = htmlspecialchars($t['fullname'] ?: $t['username'], ENT_QUOTES);
                                                        $dataId   = htmlspecialchars($t['teacher_id'] ?? '', ENT_QUOTES);
                                                        $dataSub  = htmlspecialchars($t['subject'] ?? '', ENT_QUOTES);
                                                    ?>
                                                        <option value="<?= htmlspecialchars($t['id']) ?>"
                                                            data-name="<?= $dataName ?>"
                                                            data-teacherid="<?= $dataId ?>"
                                                            data-subject="<?= $dataSub ?>">
                                                            <?= htmlspecialchars($display) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Name of the Teacher (auto-filled)</label>
                                            <input type="text" id="teacherNameDisplay" class="form-control" value="<?= htmlspecialchars($_POST['teacher_name'] ?? '') ?>" readonly required>
                                        </div>

                                        <!-- Hidden inputs that will be submitted -->
                                        <input type="hidden" name="teacher_id" id="teacherIdHidden" value="<?= htmlspecialchars($_POST['teacher_id'] ?? '') ?>">
                                        <input type="hidden" name="teacher_name" id="teacherNameHidden" value="<?= htmlspecialchars($_POST['teacher_name'] ?? '') ?>">
                                        <input type="hidden" name="subject" id="subjectHidden" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">

                                        <div class="mb-3">
                                            <label>Class/Section</label>
                                            <input type="text" name="class_section" class="form-control" value="<?= htmlspecialchars($_POST['class_section'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Name of The Judge</label>
                                            <input type="text" name="evaluator_name" class="form-control" value="<?= htmlspecialchars($_POST['evaluator_name'] ?? '') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Prayer (03)</label>
                                            <input type="number" name="prayer" id="prayer" class="form-control calc-field" min="0" max="3" step="0.01" value="<?= htmlspecialchars($_POST['prayer'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>News (English Only) (2)</label>
                                            <input type="number" name="news" id="news" class="form-control calc-field" min="0" max="2" step="0.01" value="<?= htmlspecialchars($_POST['news'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Participation (3)</label>
                                            <input type="number" name="participation" id="participation" class="form-control calc-field" min="0" max="3" step="0.01" value="<?= htmlspecialchars($_POST['participation'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Speeches [English (5), Hindi (01)]</label>
                                            <input type="number" name="speeches" id="speeches" class="form-control calc-field" min="0" max="15" step="0.01" value="<?= htmlspecialchars($_POST['speeches'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Poem Recitation [English (2), Hindi (01)]</label>
                                            <input type="number" name="poem_recitation" id="poem_recitation" class="form-control calc-field" min="0" max="40" step="0.01" value="<?= htmlspecialchars($_POST['poem_recitation'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Group Dance (4)</label>
                                            <input type="number" name="dance" id="dance" class="form-control calc-field" min="0" max="5" step="0.01" value="<?= htmlspecialchars($_POST['dance'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Group Song (4)</label>
                                            <input type="number" name="song" id="song" class="form-control calc-field" min="0" max="5" step="0.01" value="<?= htmlspecialchars($_POST['song'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Stage Management (3)</label>
                                            <input type="number" name="stage_management" id="stage_management" class="form-control calc-field" min="0" max="3" step="0.01" value="<?= htmlspecialchars($_POST['stage_management'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Innovation (2)</label>
                                            <input type="number" name="innovation" id="innovation" class="form-control calc-field" min="0" max="2" step="0.01" value="<?= htmlspecialchars($_POST['innovation'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Theme Based Skit Presentation (4)</label>
                                            <input type="number" name="skit" id="skit" class="form-control calc-field" min="0" max="4" step="0.01" value="<?= htmlspecialchars($_POST['skit'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Theme Based Power Point Presentation (4)</label>
                                            <input type="number" name="ppt" id="ppt" class="form-control calc-field" min="0" max="4" step="0.01" value="<?= htmlspecialchars($_POST['ppt'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card dash-widget">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Anchoring (3)</label>
                                            <input type="number" name="anchoring" id="anchoring" class="form-control calc-field" min="0" max="3" step="0.01" value="<?= htmlspecialchars($_POST['anchoring'] ?? '') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label>Total (Auto-calculated)</label>
                                            <input type="number" name="total_display" id="totalField" class="form-control" step="0.01" readonly value="<?= htmlspecialchars($_POST['total'] ?? '') ?>">
                                            <small class="text-muted">This field is automatically calculated</small>
                                        </div>

                                        <div class="mb-3">
                                            <label>Speaking Skills (Students)</label>
                                            <input type="text" name="speaking_skills" class="form-control" value="<?= htmlspecialchars($_POST['speaking_skills'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Dancing Skills (Students)</label>
                                            <input type="text" name="dancing_skills" class="form-control" value="<?= htmlspecialchars($_POST['dancing_skills'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Singing Skills (Students)</label>
                                            <input type="text" name="singing_skills" class="form-control" value="<?= htmlspecialchars($_POST['singing_skills'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Dramatic Skills (Students)</label>
                                            <input type="text" name="dramatic_skills" class="form-control" value="<?= htmlspecialchars($_POST['dramatic_skills'] ?? '') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label>Comments by Judge 1 (Meera Marwaha)</label>
                                            <textarea name="comments1" class="form-control"><?= htmlspecialchars($_POST['comments1'] ?? '') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label>Comments by Judge 2 (Anjali Dewan)</label>
                                            <textarea name="comments2" class="form-control"><?= htmlspecialchars($_POST['comments2'] ?? '') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label>Total Marks By Judge 1 (Meera Marwaha)</label>
                                            <input type="number" name="marks_judge1" class="form-control" step="0.01" min="0" max="50" value="<?= htmlspecialchars($_POST['marks_judge1'] ?? '') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label>Total Marks By Judge 2 (Anjali Dewan)</label>
                                            <input type="number" name="marks_judge2" class="form-control" step="0.01" min="0" max="50" value="<?= htmlspecialchars($_POST['marks_judge2'] ?? '') ?>">
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <a href="./dashboard.php" class="btn btn-secondary">Back</a>
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

<?php include '../includes/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // elements
        const teacherQuickSearch = document.getElementById('teacherQuickSearch');
        const teacherSelect = document.getElementById('teacherSelect');
        const teacherNameDisplay = document.getElementById('teacherNameDisplay');
        const teacherIdHidden = document.getElementById('teacherIdHidden');
        const teacherNameHidden = document.getElementById('teacherNameHidden');
        const subjectHidden = document.getElementById('subjectHidden');

        // build options cache for client filtering
        const optionsCache = Array.from(teacherSelect.options).map(o => ({
            value: o.value,
            text: o.textContent,
            name: o.getAttribute('data-name') || '',
            tid: o.getAttribute('data-teacherid') || '',
            subject: o.getAttribute('data-subject') || ''
        }));

        function normalize(s) {
            return (s || '').toString().trim().toLowerCase();
        }

        function filterTeachers(q) {
            q = normalize(q);
            teacherSelect.innerHTML = '';
            const filtered = optionsCache.filter(o => {
                if (!q) return true;
                return normalize(o.text).includes(q) || normalize(o.name).includes(q) || normalize(o.tid).includes(q);
            });
            if (filtered.length === 0) {
                const opt = document.createElement('option');
                opt.disabled = true;
                opt.textContent = 'No teachers match your search';
                teacherSelect.appendChild(opt);
                return;
            }
            filtered.forEach(o => {
                const opt = document.createElement('option');
                opt.value = o.value;
                opt.textContent = o.text;
                if (o.name) opt.setAttribute('data-name', o.name);
                if (o.tid) opt.setAttribute('data-teacherid', o.tid);
                if (o.subject) opt.setAttribute('data-subject', o.subject);
                teacherSelect.appendChild(opt);
            });
        }

        // initial preselect if hidden has value (e.g. after validation error)
        (function preselect() {
            const hidTid = teacherIdHidden.value || '';
            if (!hidTid) return;
            for (let i = 0; i < teacherSelect.options.length; i++) {
                const opt = teacherSelect.options[i];
                if (opt.getAttribute('data-teacherid') === hidTid) {
                    teacherSelect.selectedIndex = i;
                    teacherSelect.dispatchEvent(new Event('change'));
                    break;
                }
            }
        })();

        teacherQuickSearch && teacherQuickSearch.addEventListener('input', function() {
            const q = this.value;
            filterTeachers(q);
        });

        teacherSelect && teacherSelect.addEventListener('change', function() {
            const opt = teacherSelect.options[teacherSelect.selectedIndex];
            if (!opt) return;
            const name = opt.getAttribute('data-name') || opt.textContent;
            const tid = opt.getAttribute('data-teacherid') || '';
            const sub = opt.getAttribute('data-subject') || '';

            teacherNameDisplay.value = name + (tid ? (' (' + tid + ')') : '') + (sub ? (' — ' + sub) : '');
            teacherIdHidden.value = tid;
            teacherNameHidden.value = name;
            subjectHidden.value = sub;
        });

        // calculation: sum of all calc-field inputs
        const calcFields = Array.from(document.querySelectorAll('.calc-field'));
        const totalField = document.getElementById('totalField');

        function calcTotal() {
            let sum = 0;
            calcFields.forEach(f => {
                const v = parseFloat(f.value);
                if (!isNaN(v)) sum += v;
            });
            // round to 2 decimals
            sum = Math.round(sum * 100) / 100;
            totalField.value = sum;
        }

        calcFields.forEach(f => f.addEventListener('input', calcTotal));

        // run calc on load (in case persisted values exist)
        calcTotal();
    });
</script>