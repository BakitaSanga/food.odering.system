<div class="container-fluid">
    <!-- Registered Customers Section -->
    <div class="row mb-2">
        <div class="col-lg-12">
            <h4><i class="fas fa-user-friends me-2 text-info"></i>Registered Customers</h4>
            <p class="text-muted mb-2">All users who signed up on the website</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'db_connect.php';
                                // Don't use ORDER BY id since column may not exist
                                $users_query = "SELECT * FROM user_info";
                                $users = $conn->query($users_query);
                                
                                if(!$users) {
                                    echo "<tr><td colspan='5' class='text-center text-danger'>Error: " . $conn->error . "</td></tr>";
                                } elseif($users->num_rows > 0) {
                                    $i = 1;
                                    while($row = $users->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['email']) ?></td>
                                    <td><?php echo htmlspecialchars($row['mobile']) ?></td>
                                    <td><?php echo htmlspecialchars($row['address']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit_customer" 
                                            data-user_id="<?php echo $row['user_id'] ?>"
                                            data-first_name="<?php echo htmlspecialchars($row['first_name']) ?>"
                                            data-last_name="<?php echo htmlspecialchars($row['last_name']) ?>"
                                            data-email="<?php echo htmlspecialchars($row['email']) ?>"
                                            data-mobile="<?php echo htmlspecialchars($row['mobile']) ?>"
                                            data-address="<?php echo htmlspecialchars($row['address']) ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete_customer" data-user_id="<?php echo $row['user_id'] ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                } else {
                                    echo "<tr><td colspan='6' class='text-center text-muted'>No registered customers yet. Users will appear here when they sign up on the website.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Users Section -->
    <div class="row mb-2">
        <div class="col-lg-12">
            <h4><i class="fas fa-user-shield me-2 text-success"></i>Admin Users</h4>
            <button class="btn btn-primary btn-sm mb-2" id="new_user">
                <i class="fa fa-plus"></i> New Admin
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $admin_users = $conn->query("SELECT * FROM users ORDER BY name ASC");
                                if($admin_users && $admin_users->num_rows > 0):
                                    $i = 1;
                                    while($row = $admin_users->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['name']) ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['username']) ?></td>
                                    <td>
                                        <?php if($row['type'] == 1): ?>
                                            <span class="badge bg-danger">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-info">Staff</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit_user" data-id="<?php echo $row['id'] ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete_user" data-id="<?php echo $row['id'] ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Customer (Registered User) handlers
    $('.edit_customer').click(function(){
        const data = $(this).data();
        uni_modal('Edit Customer', 'manage_customer.php?user_id=' + data.user_id);
    });

    $('.delete_customer').click(function(){
        const user_id = $(this).attr('data-user_id');
        if(confirm('Are you sure you want to delete this customer?')){
            $.ajax({
                url: 'ajax.php?action=delete_customer',
                method: 'POST',
                data: {user_id: user_id},
                success: function(resp){
                    if(resp == 1){
                        alert('Customer deleted successfully');
                        location.reload();
                    } else {
                        alert('Failed to delete customer');
                    }
                }
            });
        }
    });

    // Admin user handlers
    $('#new_user').click(function(){
        uni_modal('New Admin User','manage_user.php')
    });

    $('.edit_user').click(function(){
        uni_modal('Edit Admin User','manage_user.php?id='+$(this).attr('data-id'))
    });

    $('.delete_user').click(function(){
        const id = $(this).attr('data-id');
        if(confirm('Are you sure you want to delete this admin user?')){
            $.ajax({
                url: 'ajax.php?action=delete_user',
                method: 'POST',
                data: {id: id},
                success: function(resp){
                    if(resp == 1){
                        alert('User deleted successfully');
                        location.reload();
                    } else {
                        alert('Failed to delete user');
                    }
                }
            });
        }
    });
</script>