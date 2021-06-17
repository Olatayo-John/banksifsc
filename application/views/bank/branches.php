<div>
	<h5 class="branches"><?php echo $title; ?></h5>
	<div class="text-center mb-4">
		<!-- <small class="text-danger font-weight-bold">Click for more information (IFSC Code, MICR, Address, Contact Number)</small> -->
		<small class="text-danger font-weight-bold">Click on any branch for more information</small>
	</div>

	<?php foreach ($branches->result() as $branch) : ?>
		<li><a href='<?php echo base_url('ifsc/') . $branch->id ?>' class="eachbranch"><?php echo $branch->adr1 ?></a></li>
	<?php endforeach; ?>
</div>