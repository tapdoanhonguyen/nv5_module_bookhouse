<!-- BEGIN: main -->
<h1>{LANG.item_saved}</h1>
<hr />
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center" width="50"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);"></th>
				<th>{LANG.title}</th>
				<th>{LANG.poster}</th>
				<th width="150">{LANG.addtime}</th>
				<th width="100" class="text-center">{LANG.countview}</th>
				<th width="100" class="text-center"></th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr id="row_{DATA.id}">
				<td class="text-center"><input type="checkbox" class="post" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{DATA.id}" name="idcheck[]"></td>
				<td><a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a></td>
				<td>{DATA.poster}</td>
				<td>{DATA.addtime}</td>
				<td class="text-center">{DATA.hitstotal}</td>
				<td class="text-center"><a href="" title="{LANG.saved_delete}" onclick="nv_delete_save({DATA.id}, '{DATA.checkss}'); return !1;"><em class="fa fa-trash-o">&nbsp;</em>{LANG.delete}</a></td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</form>

<form class="form-inline m-bottom pull-left">
	<select class="form-control" id="action">
		<!-- BEGIN: action -->
		<option value="{ACTION.key}">{ACTION.value}</option>
		<!-- END: action -->
	</select>
	<button class="btn btn-primary" onclick="nv_list_action($('#action').val(), '{ACTION_URL}', '{LANG.saved_empty_data}', '{CHECKSS}'); return false;">{LANG.perform}</button>
</form>
<!-- END: main -->