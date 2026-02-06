<div class="container-fluid">
    <div class="card shadow-sm" style="border-radius: 15px; border: none;">
        <div class="card-header bg-white" style="border-radius: 15px 15px 0 0; border-bottom: 2px solid #f0f0f0;">
            <h5 class="fw-bold mb-0"><i class="fas fa-shopping-bag me-2 text-primary"></i>Orders Management</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        include 'db_connect.php';
                        $qry = $conn->query("SELECT * FROM orders ORDER BY id DESC");
                        while($row=$qry->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><strong><?php echo $row['name'] ?></strong></td>
                            <td><?php echo $row['address'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['mobile'] ?></td>
                            <?php if($row['status'] == 1): ?>
                                <td class="text-center"><span class="badge bg-success">Confirmed</span></td>
                            <?php else: ?>
                                <td class="text-center"><span class="badge bg-warning text-dark">Pending</span></td>
                            <?php endif; ?>
                            <td>
                                <button class="btn btn-sm btn-primary view_order" data-id="<?php echo $row['id'] ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-danger delete_order" data-id="<?php echo $row['id'] ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('.view_order').click(function(){
        uni_modal('Order Details','view_order.php?id='+$(this).attr('data-id'))
    });

    $('.delete_order').click(function(){
        const id = $(this).attr('data-id');
        if(confirm('Are you sure you want to delete this order?')){
            $.ajax({
                url: 'ajax.php?action=delete_order',
                method: 'POST',
                data: {id: id},
                success: function(resp){
                    if(resp == 1){
                        alert('Order deleted successfully');
                        location.reload();
                    } else {
                        alert('Failed to delete order');
                    }
                }
            });
        }
    });
</script>