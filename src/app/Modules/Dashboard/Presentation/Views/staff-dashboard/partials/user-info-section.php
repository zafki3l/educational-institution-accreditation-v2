<?php
$firstName = $user->first_name ?? '';
$lastName = $user->last_name ?? '';
$initials = '';
if (!empty($firstName)) $initials .= mb_substr($firstName, 0, 1);
if (!empty($lastName)) $initials .= mb_substr($lastName, 0, 1);
$initials = strtoupper($initials);
?>

<div class="card user-info-card">
    <div class="card-body">
        <h2 class="card-title">Thông tin của tôi</h2>
        <p class="subtitle">
            Xem và quản lý thông tin cá nhân của bạn
        </p>

        <div class="profile-container">
            <div class="profile-header">
                <div class="avatar-wrapper">
                    <div class="avatar-box">
                        <?= htmlspecialchars($initials) ?>
                    </div>
                    <div class="status-dot"></div>
                </div>
                
                <div class="profile-name-section">
                    <h3 class="user-full-name"><?= htmlspecialchars(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?></h3>
                    
                    <div class="info-list">
                        <div class="info-item-new">
                            <div class="info-icon email-icon">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <div class="info-text">
                                <label>EMAIL CÔNG VIỆC</label>
                                <p><?= htmlspecialchars($user->email ?? 'Chưa cập nhật') ?></p>
                            </div>
                        </div>

                        <div class="info-item-new">
                            <div class="info-icon dept-icon">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div class="info-text">
                                <label>PHÒNG BAN</label>
                                <p><?= htmlspecialchars($user->department->name ?? 'Chưa xác định') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
