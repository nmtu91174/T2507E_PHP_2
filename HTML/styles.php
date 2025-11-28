<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    body {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* Sidebar Styles - Desktop */
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 48px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        background-color: #343a40;
        min-height: 100vh; /* Đảm bảo sidebar full chiều cao */
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #adb5bd;
        padding: 10px 16px;
    }

    .sidebar .nav-link .fa-icon {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .sidebar .nav-link:hover {
        color: #fff;
        background-color: #495057;
    }

    .sidebar .nav-link.active {
        color: #fff;
        background-color: #0d6efd;
    }

    /* Main Content Styles - Desktop */
    .main-content {
        margin-left: 16.66667%; /* Tương ứng với col-md-2 */
        padding: 20px;
        width: 83.33333%; /* Tương ứng với phần còn lại */
    }

    /* Mobile / Tablet Responsiveness */
    @media (max-width: 767.98px) {
        .sidebar {
            position: relative; /* Không fix cứng nữa */
            width: 100%;
            height: auto;
            min-height: auto;
            padding-top: 10px;
            margin-bottom: 20px;
        }

        .main-content {
            margin-left: 0; /* Reset lề trái */
            width: 100%; /* Full màn hình */
            padding: 15px;
        }
    }
</style>