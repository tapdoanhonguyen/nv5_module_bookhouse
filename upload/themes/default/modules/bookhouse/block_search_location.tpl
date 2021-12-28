<!-- BEGIN: main -->
<style>
.block_search_location .col-md-12 {
	width: 100%
}
</style>
<div class="block_search_location">
	<form action="{NV_BASE_SITEURL}" method="get" class="form-horizontal">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
		<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP_NAME}" />
		{LOCATION}
		<button type="submit" name="search" class="btn btn-default">{LANG.search}</button>
	</form>
</div>
<!-- END: main -->