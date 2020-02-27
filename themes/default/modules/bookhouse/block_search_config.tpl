<!-- BEGIN: main -->
<tr>
	<td>{LANG.styletype}</td>
	<td><select class="form-control" name="config_styletype">
			<!-- BEGIN: styletype -->
			<option value="{STYLE.index}"{STYLE.selected}>{STYLE.value}</option>
			<!-- END: styletype -->
	</select></td>
</tr>
<tr>
	<td>{LANG.price_begin}</td>
	<td><input type="number" name="config_price_begin" value="{DATA.price_begin}" class="form-control" /></td>
</tr>

<tr>
	<td>{LANG.price_end}</td>
	<td><input type="number" name="config_price_end" value="{DATA.price_end}" class="form-control" /></td>
</tr>

<tr>
	<td>{LANG.price_step}</td>
	<td><input type="number" name="config_price_step" value="{DATA.price_step}" class="form-control" /></td>
</tr>
<!-- END: main -->