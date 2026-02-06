<?php
include 'db_connect.php';

if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $qry = $conn->query("SELECT * FROM user_info WHERE user_id = '$user_id'");
    if($qry->num_rows > 0){
        $row = $qry->fetch_assoc();
        foreach($row as $k => $v){
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form id="manage-customer">
        <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : '' ?>">
        
        <div class="form-group">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo isset($first_name) ? $first_name : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo isset($last_name) ? $last_name : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo isset($email) ? $email : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" class="form-control" value="<?php echo isset($mobile) ? $mobile : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3" required><?php echo isset($address) ? $address : '' ?></textarea>
        </div>
    </form>
</div>

<script>
    $('#manage-customer').submit(function(e){
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_customer',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp == 1){
                    alert_toast("Customer updated successfully", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
</script>
