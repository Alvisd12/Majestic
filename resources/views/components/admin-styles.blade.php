<style>
    :root {
        --primary-blue: #2563eb;
        --sidebar-bg: #000000;
        --sidebar-active: #fbbf24;
        --text-muted: #6b7280;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc;
    }

    .sidebar {
        background: linear-gradient(180deg, var(--sidebar-bg) 0%, #000000 100%);
        min-height: 100vh;
        width: 250px;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .sidebar-brand {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-brand img {
        width: 180px;
        height: 60px;
        margin-right: 10px;
    }

    .sidebar-brand h3 {
        color: white;
        font-weight: bold;
        margin: 0;
        font-size: 1.5rem;
    }

    .sidebar-brand small {
        color: rgba(255,255,255,0.7);
        font-size: 0.8rem;
    }

    .sidebar-nav {
        padding: 20px 0;
    }

    .nav-item {
        margin-bottom: 5px;
    }

    .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 12px 20px;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 0;
    }

    .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
        color: white;
    }

    .nav-link.active {
        background-color: var(--sidebar-active);
        color: #1f2937;
        font-weight: 600;
    }

            .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        /* Dropdown styling for sidebar */
        .sidebar .dropdown-toggle {
            position: relative;
        }

        .sidebar .dropdown-toggle::after {
            display: none;
        }

        .sidebar .collapse {
            background-color: rgba(255,255,255,0.05);
            border-radius: 8px;
            margin: 5px 10px;
        }

        .sidebar .collapse .nav-link {
            padding: 8px 15px;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
            border-left: 2px solid transparent;
        }

        .sidebar .collapse .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--sidebar-active);
        }

        .sidebar .collapse .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: var(--sidebar-active);
            border-left-color: var(--sidebar-active);
        }

        .sidebar .collapse .nav-link i {
            width: 16px;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        /* Dropdown animation */
        .sidebar .collapse {
            transition: all 0.3s ease;
        }

        .sidebar .dropdown-toggle .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .sidebar .dropdown-toggle[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }

    .main-content {
        margin-left: 250px;
        min-height: 100vh;
    }

    .topbar {
        background: white;
        padding: 15px 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .content-area {
        padding: 30px;
    }

    .search-box {
        position: relative;
        max-width: 400px;
        margin-bottom: 25px;
    }

    .search-box input {
        padding-left: 45px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        height: 45px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .add-button {
        background-color: var(--sidebar-active);
        color: #1f2937;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .add-button:hover {
        background-color: #f59e0b;
        transform: translateY(-1px);
    }

    .data-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table {
        margin: 0;
    }

    .table thead th {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
        font-weight: 600;
        padding: 15px;
        font-size: 0.9rem;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }

    .motor-image {
        width: 60px;
        height: 40px;
        background-color: #e5e7eb;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 0.8rem;
        overflow: hidden;
    }

    .motor-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        margin: 0 2px;
    }

    .btn-edit {
        background-color: #dbeafe;
        color: #2563eb;
    }

    .btn-edit:hover {
        background-color: #bfdbfe;
        transform: scale(1.1);
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background-color: #fecaca;
        transform: scale(1.1);
    }

    .pagination-container {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .price-badge {
        background-color: #dbeafe;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .alert {
        border: none;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

            .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

    .alert .btn-close {
        padding: 0.5rem;
        margin: -0.5rem -0.5rem -0.5rem auto;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    }

    .btn-primary {
        background-color: var(--primary-blue);
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6b7280;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-1px);
    }

    .current-photo {
        width: 100px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
        
        .main-content {
            margin-left: 0;
        }
        
        .topbar {
            padding: 15px 20px;
        }
        
        .content-area {
            padding: 20px 15px;
        }
        
        .table-responsive {
            font-size: 0.85rem;
        }
    }

    .logo {
        width: 120px;
        height: 50px;
        border-radius: 8px;
        object-fit: contain;
    }
</style> 