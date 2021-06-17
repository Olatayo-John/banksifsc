<div>
	<div class="d-flex searchbox mb-3">
		<span class="searchspan m-auto"><i class="fas fa-search"></i></span>
		<input type="text" name="banksearch" id="banksearch" class="banksearch form-control" autofocus="true" placeholder="Type to start searching...">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
		<span class="closespan text-danger m-auto"><i class="fas fa-times"></i></span>
	</div>
</div>
<div class="banksdiv">
	<?php foreach ($banks->result() as $bank) : ?>
		<li><a href='<?php echo base_url("branches/") . $bank->id ?>' class="eachbank" tasrget='_blank'><?php echo $bank->name ?></a></li>
	<?php endforeach; ?>

</div>

<script>
	$(document).ready(function() {
		$(document).on('keyup', '.banksearch', function() {
			var searchval = $(this).val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();
			$('.closespan').show();

			$.ajax({
				url: "<?php echo base_url("bank/searchbank") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
					searchval: searchval
				},
				success: function(data) {
					$('.csrf_token').val(data.token);
					var bnklength = data.banks.length;
					$('.banksdiv').children().remove();
					if (bnklength == 0) {
						$('.banksdiv').append('<p class="text-dark text-center font-weight-bold">Bank <span class="text-danger">"' + searchval + '"</span> not found</p>');
					} else {
						for (let index = 0; index < bnklength; index++) {
							$('.banksdiv').append('<li><a href="branches/' + data.banks[index].id + '" class="eachbank text-primary" tasrget="_blank">' + data.banks[index].name + ' IFSC Code</a></li>');
						}
					}
				}
			})
		});

		$(document).on('click', '.closespan', function() {
			$(".banksearch").val("");

			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			$.ajax({
				url: "<?php echo base_url("bank/banksreload") ?>",
				method: "post",
				dataType: "json",
				data: {
					[csrfName]: csrfHash,
				},
				success: function(data) {
					$('.csrf_token').val(data.token);

					$('.banksdiv').children().remove();

					var bnklength = data.banks.length;
					for (let index = 0; index < bnklength; index++) {
						$('.banksdiv').append('<li><a href="branches/' + data.banks[index].id + '" class="eachbank" tasrget="_blank">' + data.banks[index].name + '</a></li>');
					}

					$('.closespan').hide();
				}
			})
		});
	})
</script>