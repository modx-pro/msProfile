<form action="[[~[[*id]]]]" method="post">
	<div class="form-group">
		<label for="sum">[[%ms2_profile_enter_sum]]</label>
		<input type="text" class="form-control" name="sum" id="sum" value="[[+sum]]" />
		<div class="error">[[+error_sum]]</div>
	</div>

	<div class="form-group">
		<label>[[%ms2_profile_select_payment]]</label>
		[[+payments]]
		<div class="error">[[+error_payment ]]</div>
	</div>
	[[+error]]
	<input type="hidden" name="action" value="profile_charge" />
	<input type="submit" class="btn btn-primary" value="[[%ms2_profile_pay]]" />
</form>
<!--minishop2_error <div class="alert alert-danger">[[+error]]</div>-->