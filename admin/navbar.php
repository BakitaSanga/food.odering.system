
<style>
    #sidebar {
        background: #27ae60;
        min-height: 100vh;
        width: 200px;
        position: fixed;
        left: 0;
        top: 0;
        padding-top: 70px;
        box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    }

    .sidebar-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .sidebar-list a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-list a:hover {
        background: rgba(255, 255, 255, 0.1);
        border-left-color: #e67e22;
        color: white;
    }

    .sidebar-list a.active {
        background: rgba(255, 255, 255, 0.15);
        border-left-color: #e67e22;
        color: white;
    }

    .sidebar-list a i {
        width: 20px;
        margin-right: 12px;
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #sidebar {
            width: 60px;
        }
        .sidebar-list a span:not(i) {
            display: none;
        }
        .sidebar-list a {
            justify-content: center;
            padding: 12px 10px;
        }
        .sidebar-list a i {
            margin-right: 0;
        }
    }
</style>

<nav id="sidebar">
    <div class="sidebar-list">
        <a href="index.php?page=home" class="nav-item nav-home">
            <i class="fa fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="index.php?page=orders" class="nav-item nav-orders">
            <i class="fa fa-shopping-bag"></i>
            <span>Orders</span>
        </a>
        <a href="index.php?page=menu" class="nav-item nav-menu">
            <i class="fa fa-utensils"></i>
            <span>Menu</span>
        </a>
        <a href="index.php?page=categories" class="nav-item nav-categories">
            <i class="fa fa-tags"></i>
            <span>Categories</span>
        </a>
        
        <?php if($_SESSION['login_type'] == 1): ?>
        <a href="index.php?page=users" class="nav-item nav-users">
            <i class="fa fa-users"></i>
            <span>Users</span>
        </a>
        <a href="index.php?page=site_settings" class="nav-item nav-site_settings">
            <i class="fa fa-cogs"></i>
            <span>Settings</span>
        </a>
        <?php endif; ?>
    </div>
</nav>

<script>
    $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>').addClass('active')
</script>