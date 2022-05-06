<div class="popularbanksdiv">
	<a href="<?php echo base_url("branches/170") ?>">SBI Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/75") ?>">ICICI Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/72") ?>">HDFC Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/140") ?>">PNB Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/19") ?>">AXIS Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/25") ?>">Bank OF BARODA IFSC Codes,</a>
	<a href="<?php echo base_url("branches/27") ?>">BANK OF INDIA IFSC Codes,</a>
	<a href="<?php echo base_url("branches/109") ?>">KOTAK Bank IFSC Codes,</a>
	<a href="<?php echo base_url("branches/225") ?>">YES Bank IFSC Codes</a>
</div>

<div class="filterdiv mb-3 mt-3">
	<div class="form-group row">
		<div class="col">
			<label for="bank">Bank</label>
			<input type="text" list="banks" class="form-control bank">
			<datalist id="banks">
				<?php foreach ($banks->result() as $bank) : ?>
					<option bnkid="<?php echo $bank->id ?>"><?php echo $bank->name ?></option>
				<?php endforeach; ?>
			</datalist>
		</div>
		<div class="col">
			<label for="branch">Branch</label>
			<input type="text" list="branch" class="form-control branch">
			<datalist id="branch">
			</datalist>
		</div>
	</div>

	<div class="form-group row">
		<div class="col">
			<label for="state">State</label>
			<input type="text" list="state" class="form-control state">
			<datalist id="state">
			</datalist>
		</div>
		<div class="col">
			<label for="city">City</label>
			<input type="text" list="city" class="form-control city">
			<datalist id="city">
			</datalist>
		</div>
	</div>

	<div>
		<button type="button" class="btn btn-block filtersearch">Search</button>
	</div>
</div>

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

			if (searchval !== "" && searchval !== undefined && searchval !== null) {
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
							$('.banksdiv').append('<p class="text-center" style="color:#294a63">Bank <span class="text-danger">"' + searchval + '"</span> not found</p>');
						} else {
							for (let index = 0; index < bnklength; index++) {
								$('.banksdiv').append('<li><a href="branches/' + data.banks[index].id + '" class="eachbank" tasrget="_blank">' + data.banks[index].name + '</a></li>');
							}
						}
					}
				});
			} else {
				$('.closespan').hide();
			}
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

		$('.bank').change(function() {
			var bank = $(this).val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			// console.log(bank);

			if (bank !== "" && bank !== undefined && bank !== null) {
				$.ajax({
					url: '<?php echo base_url('bank-branches'); ?>',
					method: 'post',
					dataType: 'json',
					data: {
						bank: bank,
						[csrfName]: csrfHash
					},
					beforeSend: function() {
						$(".branch,.state,.city").val("");
						$("#branch,#state,#city").children().remove();
					},
					success: function(data) {
						$('.csrf_token').val(data.token);

						if (data.status === 'success') {
							for (let index = 0; index < data.branchs.length; index++) {
								$("#branch").append("<option>" + data.branchs[index].adr1 + "</option>");
							}
						}
					}
				});
			}
		});

		$('.branch').change(function() {
			var bank = $('.bank').val();
			var branch = $(this).val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			if (branch !== "" && branch !== undefined && branch !== null) {
				$.ajax({
					url: '<?php echo base_url('branches-state'); ?>',
					method: 'post',
					dataType: 'json',
					data: {
						bank: bank,
						branch: branch,
						[csrfName]: csrfHash
					},
					beforeSend: function() {
						$(".state,.city").val("");
						$("#state,#city").children().remove();
					},
					success: function(data) {
						$('.csrf_token').val(data.token);

						if (data.status === 'success') {
							for (let index = 0; index < data.states.length; index++) {
								$("#state").append("<option>" + data.states[index].adr4 + "</option>");
							}
						}
					}
				});
			}
		});

		$('.state').change(function() {
			var bank = $('.bank').val();
			var branch = $('.branch').val();
			var state = $(this).val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			if (state !== "" && state !== undefined && state !== null) {
				$.ajax({
					url: '<?php echo base_url('state-city'); ?>',
					method: 'post',
					dataType: 'json',
					data: {
						bank: bank,
						branch: branch,
						state: state,
						[csrfName]: csrfHash
					},
					beforeSend: function() {
						$(".city").val("");
						$("#city").children().remove();
					},
					success: function(data) {
						$('.csrf_token').val(data.token);

						if (data.status === 'success') {
							for (let index = 0; index < data.cities.length; index++) {
								$("#city").append("<option>" + data.cities[index].adr3 + "</option>");
							}
						}
					}
				});
			}
		});

		$(document).on('click', '.filtersearch', function() {
			var bank = $(".bank").val();
			var branch = $(".branch").val();
			var state = $(".state").val();
			var city = $(".city").val();
			var csrfName = $('.csrf_token').attr("name");
			var csrfHash = $('.csrf_token').val();

			if (bank === "" || bank === null || bank === undefined) {
				$(".bank").css('border', '1px solid red');
				return false;
			} else {
				$(".bank").css('border', '1px solid #ced4da');
			}

			if (branch === "" || branch === null) {
				$(".branch").css('border', '1px solid red');
				return false;
			} else {
				$(".branch").css('border', '1px solid #ced4da');
			}

			if (state === "" || state === null) {
				$(".state").css('border', '1px solid red');
				return false;
			} else {
				$(".state").css('border', '1px solid #ced4da');
			}

			if (city === "" || city === null) {
				$(".city").css('border', '1px solid red');
				return false;
			} else {
				$(".city").css('border', '1px solid #ced4da');
			}

			var url = "<?php echo base_url('bank/ifsc') ?>";
			var urltwo = "?bank=" + bank + "&branch=" + branch + "&state=" + state + "&city=" + city + "";
			window.location.assign(url + urltwo);

			// console.log(url + urltwo);
		});
	})
</script>