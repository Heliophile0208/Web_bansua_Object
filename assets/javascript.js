
document.addEventListener('DOMContentLoaded', function () {
    const menuLinks = document.querySelectorAll('.menu a');
    const currentUrl = window.location.pathname;

    // Lặp qua tất cả các liên kết trong menu
    menuLinks.forEach(link => {
        // Kiểm tra nếu href của liên kết khớp với URL hiện tại
        if (link.href.includes(currentUrl)) {
            // Thêm class 'active' cho liên kết đang mở
            link.classList.add('active');
        }
    });
});