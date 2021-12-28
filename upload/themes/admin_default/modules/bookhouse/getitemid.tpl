<!-- BEGIN: main -->
<form action="{NV_BASE_ADMINURL}" method="get" class="form-horizontal">
	<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
	<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP_NAME}" /> <input
		type="hidden" name="area" value="{AREA}" />
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<colgroup>
				<col class="w200" />
			</colgroup>
			<tbody>
				<tr>
					<td colspan="2" class="text-center">{LANG.contract_search_items}</td>
				</tr>
				<tr>
					<td>{LANG.search_key}</td>
					<td><input type="text" class="form-control" name="keywords"
						value="{ARRAY_SEARCH.keywords}" /></td>
				</tr>
				<tr>
					<td>{LANG.cat}</td>
					<td><select name="catid" class="form-control">
							<option value="0">{LANG.all_category}</option>
							<!-- BEGIN: cat -->
							<option value="{CAT.key}"{CAT.selected}>{CAT.title}</option>
							<!-- END: cat -->
					</select></td>
				</tr>
				<tr>
					<td>{LANG.items_code}</td>
					<td><input type="text" class="form-control" name="code"
						value="{ARRAY_SEARCH.code}" /></td>
				</tr>
				<tr>
					<td colspan="2" class="text-center"><input type="reset"
						class="btn btn-danger" value="{LANG.items_reset}" /> <input
						type="submit" name="search" class="btn btn-primary"
						value="{LANG.search}" /></td>
				</tr>
			</tbody>
		</table>
	</div>
</form>

<!-- BEGIN: result -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<colgroup>
			<col span="3" />
			<col class="w150" />
			<col class="w100" />
		</colgroup>
		<thead>
			<tr>
				<th>{LANG.items_}</th>
				<th>{LANG.items_code}</th>
				<th>{LANG.cat}</th>
				<th class="text-center">{LANG.items_status}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td>{DATA.title}</td>
				<td>{DATA.code}</td>
				<td>{DATA.cat_title}</td>
				<td class="text-center">{DATA.status}</td>
				<td class="text-center"><em class="fa fa-pencil">&nbsp;</em><a
					href="" onclick="nv_close_pop({DATA.id}, '{DATA.title}')">{LANG.chosen}</a>
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: result -->

<!-- BEGIN: no_result -->
<p class="text-center">{LANG.no_result}</p>
<!-- END: no_result -->

<!-- BEGIN: page -->
<div class="text-center">{PAGE}</div>
<!-- END: page -->

<script type="text/javascript">
	function nv_close_pop(itemid, itemtitle) {
		$('#item_id', opener.document).val(itemid);
		$('#item_title', opener.document).val(itemtitle);
		window.close();
	}
</script>
<!-- END: main -->