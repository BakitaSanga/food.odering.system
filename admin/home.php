<?php
include 'db_connect.php';

$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$pending_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status = 0")->fetch_assoc()['count'];
$revenue_result = $conn->query("
    SELECT SUM(p.price * ol.qty) as total 
    FROM order_list ol 
    INNER JOIN product_list p ON ol.product_id = p.id
");
$total_revenue = $revenue_result->fetch_assoc()['total'] ?? 0;
$total_users = $conn->query("SELECT COUNT(*) as count FROM user_info")->fetch_assoc()['count'];
$total_products = $conn->query("SELECT COUNT(*) as count FROM product_list")->fetch_assoc()['count'];
?>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, <strong><?php echo $_SESSION['login_name']; ?></strong>!</p>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-orange">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $total_orders; ?></div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $pending_orders; ?></div>
                    <div class="stat-label">Pending Orders</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-green">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo number_format($total_revenue, 0); ?> TSH</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-blue">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $total_users; ?></div>
                    <div class="stat-label">Total Customers</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h5>
                    <div class="row g-2">
                        <div class="col-lg-3 col-md-6">
                            <a href="index.php?page=orders" class="action-btn action-orange">
                                <i class="fas fa-list"></i>
                                <span>View Orders</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="index.php?page=menu" class="action-btn action-green">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add Product</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="index.php?page=categories" class="action-btn action-blue">
                                <i class="fas fa-tags"></i>
                                <span>Categories</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="index.php?page=users" class="action-btn action-purple">
                                <i class="fas fa-user-friends"></i>
                                <span>Manage Users</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>Recent Orders
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $recent_orders = $conn->query("SELECT * FROM orders ORDER BY id DESC LIMIT 8");
                                if($recent_orders && $recent_orders->num_rows > 0):
                                    while($row = $recent_orders->fetch_assoc()): 
                                ?>
                                <tr>
                                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td>
                                        <?php if($row['status'] == 1): ?>
                                            <span class="badge bg-success">Confirmed</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view_order" data-id="<?php echo $row['id']; ?>">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No orders yet</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.view_order').click(function(){
        uni_modal('Order Details','view_order.php?id='+$(this).attr('data-id'))
    });
</script>