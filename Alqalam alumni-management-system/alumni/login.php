<!DOCTYPE html>
<html lang="en">
<?php 

include('admin/db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<?php session_start() ?>
<div class="container-fluid">
	<form action="" id="login-frm">
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" name="username" required="" class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Password</label>
			<input type="password" name="password" required="" class="form-control">
			<small><a href="index.php?page=signup" id="new_account">Create New Account</a></small>
		</div>
		<button class="button btn btn-info btn-sm">Login</button>
	</form>
</div>

<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>

<script>
	$('#login-frm').submit(function(e){
		e.preventDefault()
		$('#login-frm button[type="submit"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'admin/ajax.php?action=login2',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				console.log(resp);
				if(resp == 1){
					location.href ='<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
				}else if(resp == 2){
					$('#login-frm').prepend('<div class="alert alert-danger">Your account is not yet verified.</div>')
					$('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
				}else{
					$('#login-frm').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>')
					$('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>