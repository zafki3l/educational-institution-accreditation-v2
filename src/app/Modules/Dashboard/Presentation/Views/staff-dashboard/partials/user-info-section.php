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

<style>
.user-info-card {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.card-title {
    color: #003D80;
    font-weight: 700;
    font-size: 24px;
    margin-bottom: 5px;
}

.profile-container {
    margin-top: 25px;
    padding: 25px;
    border: 1px solid #edf2f7;
    border-radius: 20px;
    background: #ffffff;
}

.profile-header {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

.avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.avatar-box {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    background: #4A90E2; /* Matches image blue */
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
}

.status-dot {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 18px;
    height: 18px;
    background: #48bb78;
    border: 3px solid white;
    border-radius: 50%;
}

.profile-name-section {
    flex-grow: 1;
}

.user-full-name {
    font-size: 24px;
    color: #1a202c;
    font-weight: 700;
    margin-bottom: 20px;
    margin-top: 5px;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-item-new {
    display: flex;
    align-items: center;
    gap: 15px;
}

.info-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.email-icon {
    background: #ebf4ff;
    color: #3182ce;
}

.dept-icon {
    background: #f0f5ff;
    color: #5a67d8;
}

.info-text label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    color: #a0aec0;
    margin-bottom: 2px;
    letter-spacing: 0.5px;
}

.info-text p {
    font-size: 14px;
    color: #2d3748;
    font-weight: 600;
    margin: 0;
}

/* Ensure the layout has enough space */
.card-grid {
    gap: 30px;
}
</style>
