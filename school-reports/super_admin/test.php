<div class="page-wrapper">
    <div class="content mb-3">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Card -->
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if (!empty($teacher['profile_pic'])): ?>
                            <img src="../uploads/profile_pics/<?php echo htmlspecialchars($teacher['profile_pic']); ?>"
                                class="teacher-img mb-3" alt="Profile Picture">
                            <?php else: ?>
                            <div class="profile-placeholder mb-3">
                                <i class="fas fa-user fa-5x text-secondary"></i>
                            </div>
                            <?php endif; ?>

                            <h4><?php echo htmlspecialchars($teacher['teacher_name'] ?? 'Teacher Name'); ?></h4>
                            <p class="text-muted">
                                <?php echo htmlspecialchars($teacher['teacher_type'] ?? 'Teacher Type'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <!-- Teacher Details -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th width="30%">Teacher ID</th>
                                    <td><?= htmlspecialchars($teacher['teacher_id'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <td><?= htmlspecialchars($teacher['subject'] ?? 'Not specified') ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= htmlspecialchars($teacher['email'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?= htmlspecialchars($teacher['username'] ?? 'N/A') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Class Show Section -->
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>