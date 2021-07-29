<div>
	<h1 class="branchinfo p-3"><?php echo $title ?></h1>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="name">Bank Name</label>
			<input type="text" name="name" class="form-control" readonly value="<?php echo $branchinfo->name ?>">
		</div>
		<div class="form-group">
			<div class="d-flex" style="justify-content:space-between">
				<label for="ifsc">IFSC Code<i class="fas fa-copy ml-2 copy_i" style="cursor:pointer" onclick="copylink_fun('#linkshare')"></i></label>
				<div class="linkcopyalert font-weight-bolder" style="display:none;color:#666">Copied to your clipboard</div>
			</div>
			<input type="text" name="ifsc" class="form-control" id="linkshare" readonly value="<?php echo $branchinfo->ifsc ?>">
		</div>
		<div class="form-group">
			<label for="micr">MICR</label>
			<input type="text" name="micr" class="form-control" readonly value="<?php echo $branchinfo->micr ?>">
		</div>
		<div class="form-group">
			<label for="contact">Contact No.</label>
			<input type="text" name="contact" class="form-control" readonly value="<?php echo $branchinfo->contact ?>">
		</div>
		<!-- <div class="form-group">
			<label for="district">District</label>
			<input type="text" name="district" class="form-control" readonly value="<?php echo $branchinfo->adr2 ?>">
		</div> -->
		<div class="form-group">
			<label for="city">City</label>
			<input type="text" name="city" class="form-control" readonly value="<?php echo $branchinfo->adr3 ?>">
		</div>
		<div class="form-group">
			<label for="state">State</label>
			<input type="text" name="state" class="form-control" readonly value="<?php echo $branchinfo->adr4 ?>">
		</div>
		<div class="form-group">
			<label for="add">Address</label>
			<textarea rows="3" readonly class="form-control"><?php echo $branchinfo->adr5 ?></textarea>

			<!-- <textarea rows="5" readonly class="form-control"><?php echo $branchinfo->adr1 . ", " . $branchinfo->adr2 . "\n" . $branchinfo->adr3 . ", " .  $branchinfo->adr4 . "\n" . $branchinfo->adr5 ?></textarea> -->
		</div>
	</div>
	<div class="col-md-6 addiv">
		<a href="">Space for Google-AD right</a>
	</div>
</div>

<style>
	.form-group input:focus {
		background: #e9ecef !important;
	}
</style>

<script>
	function copylink_fun(element) {
		var link = $("<input>");
		$("body").append(link);
		link.val($(element).val()).select();
		document.execCommand("copy");
		link.remove();
		$('.linkcopyalert').fadeIn("slow").delay("5000").fadeOut("slow");
	}
</script>