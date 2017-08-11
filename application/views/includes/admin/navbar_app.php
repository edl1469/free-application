<div class="navbar">

	<div class="navbar-inner">

		<ul class="nav-divider pull-right" style="padding-right:3em;padding-top: 1em;">
			<li class="user">Hello, <?= $_SESSION['user-fname']; ?>
				| <?= anchor('authenticate/logout', 'Logout'); ?></li>

		</ul>
		<h1 style="color:#eaeaea;"><?= APP_NAME ?></h1>
		<!--<div class="col-lg-4 pull-left" style="margin-top: 10px;">

			<a href="<?php echo base_url()?>dashboard_admin" class="btn btn-default" style="list-style: none;color:#000; margin:10px 10px;">Admin Dashboard</a>
			<a href="<?php echo base_url()?>users_admin" class="btn btn-default" style="list-style: none;color:#000; margin:10px 10px;">View Users</a>
			<a href="<?php echo base_url()?>approvers_admin" class="btn btn-default" style="list-style: none;color:#000; margin:10px 10px;">View Approvers</a>
			<a href="<?php echo base_url()?>approvals_admin" class="btn btn-default" style="list-style: none;color:#000; margin:10px 10px;">View Approvals</a>

			</div>-->




	</div>
</div> 
<div class="clearfix"></div>       
<div class="navbar navbar-inverse " id="adminnav">
  
  <ul class="nav navbar-nav">
   
   <li><a href="<?php echo base_url()?>dashboard/user_app">Return to Approvals</a></li>
   
  </ul>
</div>
<!-- #header ends -->
