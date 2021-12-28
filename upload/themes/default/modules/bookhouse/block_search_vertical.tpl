<!-- BEGIN: main -->
<div class="block_search_vertical">
	<form action="{NV_BASE_SITEURL}" method="get" class="form-horizontal">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" /> <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" /> <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP_NAME}" />
		<div class="form-group">
			<label>{LANG.keywords}</label> <input type="text" class="form-control" name="keywords" placeholder="{LANG.keywords}">
		</div>
		<div class="form-group">
			<label>{LANG.category}</label>
			<select name="catid" class="form-control">
				<option value=0>---{LANG.all_category}---</option>
				<!-- BEGIN: cat -->
				<option value="{CAT.id}"{CAT.selected}>{CAT.space}{CAT.title}</option>
				<!-- END: cat -->
			</select>
		</div>
		<!-- BEGIN: area -->
		<div class="form-group">
			<label>{LANG.area_from}</label>
			<input type="text" class="form-control" name="area_from" value="{SEARCH.area_from}" placeholder="{LANG.area_from}" />
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="area_to" value="{SEARCH.area_to}" placeholder="{LANG.to}" />
		</div>
		<!-- END: area -->
		<!-- BEGIN: size -->
		<div class="form-group">
			<label>{LANG.size}</label>
			<input type="text" class="form-control" name="size_v" value="{SEARCH.size_v}" placeholder="{LANG.size_v}" />
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="size_h" value="{SEARCH.size_h}" placeholder="{LANG.size_h}" />
		</div>
		<!-- END: size -->
		<div class="form-group">
			<label>{LANG.price}</label>
            <select name="price_spread" class="form-control">
                <option value="0">---{LANG.price_spread_c}---</option>
                <!-- BEGIN: price_spread -->
                <option value="{PRICE_SPREAD.index}" {PRICE_SPREAD.selected}>{PRICE_SPREAD.title}</option>
                <!-- END: price_spread -->
            </select>
		</div>
		<div class="form-group">
			<label>{LANG.way}</label>
			<select name="way" class="form-control">
				<option value="0">---{LANG.way_chosen}---</option>
				<!-- BEGIN: way -->
				<option value="{WAY.id}"{WAY.selected}>{WAY.title}</option>
				<!-- END: way -->
			</select>
		</div>
		<div class="form-group">
			<label>{LANG.items_location}</label>
			{LOCATION}
		</div>
		<button type="submit" name="search" class="btn btn-primary">{LANG.search}</button>
	</form>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/js/bookhouse_autoNumeric-1.9.41.js"></script>
<script>
$(document).ready(function() {
	var Options = {
		aSep : '{DES_POINT}',
		aDec : '{THOUSANDS_SEP}',
		vMin : '0',
		vMax : '999999999'
	};
	$('.price').autoNumeric('init', Options);
	$('.price').bind('blur focusout keypress keyup', function() {
		$(this).autoNumeric('get', Options);
	});
});
</script>
<!-- END: main -->