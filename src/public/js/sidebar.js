const sidebarItems = document.querySelectorAll('.sidebar-item');
const criteriaLinks = document.querySelectorAll('.sidebar-criteria-link');
const ACTIVE_KEY = 'activeSidebar';

// Đánh dấu menu hiện tại (các link sidebar-item có href)
sidebarItems.forEach(item => {
    item.addEventListener('click', () => {
        sidebarItems.forEach(i => i.classList.remove('active'));

        item.classList.add('active');

        localStorage.setItem(ACTIVE_KEY, item.getAttribute('href'));
    });
});

// Đánh dấu khi click vào tiêu chí
criteriaLinks.forEach(link => {
    link.addEventListener('click', () => {
        localStorage.setItem(ACTIVE_KEY, link.getAttribute('href'));
    });
});

const activeHref = localStorage.getItem(ACTIVE_KEY);
if (activeHref) {
    sidebarItems.forEach(item => {
        if (item.getAttribute('href') === activeHref) {
            item.classList.add('active');
        }
    });

    // Khôi phục trạng thái cho tiêu chí đang chọn
    criteriaLinks.forEach(link => {
        if (link.getAttribute('href') === activeHref) {
            link.classList.add('active');

            const criteriaList = link.closest('.sidebar-criteria-list');
            if (criteriaList) {
                // Mở danh sách tiêu chí
                criteriaList.classList.add('open');

                // Mở tiêu chuẩn chứa tiêu chí đó
                const targetId = criteriaList.id;
                const toggle = document.querySelector(`.sidebar-standard-toggle[data-target="${targetId}"]`);
                if (toggle) {
                    toggle.classList.add('open');
                }
            }

            // Đảm bảo group "Quản lý minh chứng đánh giá" đang mở
            const group = link.closest('.sidebar-group');
            if (group) {
                group.classList.add('open');
            }
        }
    });
}

// Nhóm có thể thu gọn/mở rộng (dùng cho "Phân quyền người dùng", "Quản lý minh chứng đánh giá", ...)
const groupToggles = document.querySelectorAll('.sidebar-toggle');

groupToggles.forEach(toggle => {
    const group = toggle.closest('.sidebar-group');
    if (!group) return;

    toggle.addEventListener('click', () => {
        group.classList.toggle('open');
    });
});

// Xử lý sidebar dạng phân cấp Tiêu chuẩn -> Tiêu chí
const STANDARD_OPEN_KEY = 'sidebarOpenStandards';
const standardToggles = document.querySelectorAll('.sidebar-standard-toggle');

// Lấy danh sách tiêu chuẩn đang mở từ localStorage
let openStandards = [];
try {
    const saved = localStorage.getItem(STANDARD_OPEN_KEY);
    if (saved) {
        openStandards = JSON.parse(saved);
    }
} catch (e) {
    openStandards = [];
}

const saveOpenStandards = () => {
    localStorage.setItem(STANDARD_OPEN_KEY, JSON.stringify(openStandards));
};

standardToggles.forEach(toggle => {
    const targetId = toggle.getAttribute('data-target');
    const criteriaList = document.getElementById(targetId);

    if (!criteriaList) {
        return;
    }

    // Khởi tạo trạng thái mở/đóng theo localStorage
    if (openStandards.includes(targetId)) {
        criteriaList.classList.add('open');
        toggle.classList.add('open');
    }

    toggle.addEventListener('click', () => {
        criteriaList.classList.toggle('open');
        toggle.classList.toggle('open');

        const isOpen = criteriaList.classList.contains('open');
        const idx = openStandards.indexOf(targetId);

        if (isOpen && idx === -1) {
            openStandards.push(targetId);
        }

        if (!isOpen && idx !== -1) {
            openStandards.splice(idx, 1);
        }

        saveOpenStandards();
    });
});