<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * from system_settings limit 1");
if($qry->num_rows > 0){
	foreach($qry->fetch_array() as $k => $val){
		$meta[$k] = $val;
	}
}
?>
<div class="container-fluid">
	<div class="row mb-3">
		<div class="col-12">
			<h4><i class="fas fa-cog me-2 text-success"></i>System Settings</h4>
			<p class="text-muted">Configure your food ordering system</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-header">
					<i class="fas fa-store me-2"></i>Restaurant Information
				</div>
				<div class="card-body">
					<form action="" id="manage-settings">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="name" class="form-label">Restaurant Name</label>
									<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($meta['hotel_name']) ? $meta['hotel_name'] : '' ?>" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="contact" class="form-label">Phone Number</label>
									<input type="text" class="form-control" id="contact" name="contact" value="<?php echo isset($meta['contact']) ? $meta['contact'] : '' ?>" required>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="email" class="form-label">Contact Email</label>
							<input type="email" class="form-control" id="email" name="email" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required>
						</div>
						
						<div class="form-group">
							<label for="" class="form-label">Cover Image</label>
							<input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
							<small class="text-muted">Recommended size: 1200x600px</small>
						</div>
						
						<?php if(isset($meta['cover_img']) && !empty($meta['cover_img'])): ?>
						<div class="form-group">
							<label class="form-label">Current Image</label>
							<div>
								<img src="<?php echo '../assets/img/'.$meta['cover_img'] ?>" alt="" id="cimg" class="img-thumbnail">
							</div>
						</div>
						<?php else: ?>
						<div class="form-group">
							<img src="" alt="" id="cimg" class="img-thumbnail" style="display:none;">
						</div>
						<?php endif; ?>
						
						<div class="mt-3">
							<button type="submit" class="btn btn-success">
								<i class="fas fa-save me-2"></i>Save Settings
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4">
			<div class="card">
				<div class="card-header">
					<i class="fas fa-info-circle me-2"></i>Quick Tips
				</div>
				<div class="card-body">
					<ul class="list-unstyled">
						<li class="mb-2"><i class="fas fa-check text-success me-2"></i>Keep your contact info updated</li>
						<li class="mb-2"><i class="fas fa-check text-success me-2"></i>Use a professional email address</li>
						<li class="mb-2"><i class="fas fa-check text-success me-2"></i>Upload a high-quality cover image</li>
						<li class="mb-2"><i class="fas fa-check text-success me-2"></i>Ensure phone number is correct</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	img#cimg{
		max-height: 200px;
		max-width: 100%;
		border-radius: 8px;
		margin-top: 10px;
	}
</style>

<script>
	function displayImg(input,_this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#cimg').attr('src', e.target.result).show();
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$('#manage-settings').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_settings',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			error:err=>{
				console.log(err)
				alert_toast('Error saving settings','error')
				end_load()
			},
			success:function(resp){
				if(resp == 1){
					alert_toast('Settings saved successfully','success')
					setTimeout(function(){
						location.reload()
					},1500)
				} else {
					alert_toast('Failed to save settings','error')
					end_load()
				}
			}
		})
	})
</script>