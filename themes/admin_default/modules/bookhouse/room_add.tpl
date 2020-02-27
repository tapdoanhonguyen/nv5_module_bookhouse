<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form action="{FORM_ACTION}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<td>{LANG.category_cat_name}</td>
					<td><input class="w300 form-control" type="text"
						value="{DATA.title}" name="title" id="title" maxlength="100" /></td>
				</tr>
				<tr>
					<td>{LANG.alias}</td>
					<td>
						<div class="input-group w300">
							<input class="form-control" type="text" name="alias"
								value="{DATA.alias}" id="id_alias" /> <span
								class="input-group-btn">
								<button class="btn btn-default" type="button">
									<i class="fa fa-refresh fa-lg"
										onclick="nv_get_alias('id_alias');">&nbsp;</i>
								</button>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>{LANG.category_cat_parent}</td>
					<td><select name="parentid" class="form-control w200">
							<!-- BEGIN: parentid -->
							<option value="{LISTROOMS.id}"{LISTROOMS.selected}>{LISTROOMS.name}</option>
							<!-- END: parentid -->
					</select></td>
				</tr>
				<tr>
					<td>{LANG.description}</td>
					<td><input class="w300 form-control" type="text"
						value="{DATA.description}" name="description" maxlength="255" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit"
						value="{LANG.cat_save}" class="btn btn-primary" /></td>
				</tr>
			</tbody>
		</table>
	</div>
</form>

<script>
	function nv_get_alias(id) {
		var title = strip_tags($("[name='title']").val());
		if (title != '') {
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name
					+ '&' + nv_fc_variable + '=roomtype&nocache='
					+ new Date().getTime(), 'get_alias_title='
					+ encodeURIComponent(title), function(res) {
				$("#" + id).val(strip_tags(res));
			});
		}
		return false;
	}
</script>
<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
	//<![CDATA[
	$("[name='title']").change(function() {
		nv_get_alias('id_alias');
	});
	//]]>
</script>
<!-- END: auto_get_alias -->

<!-- END: main -->