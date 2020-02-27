<!-- BEGIN: main -->
<div class="block_search_horziontal">
	<form action="{NV_BASE_SITEURL}index.php" method="get">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" /> <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" /> <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP_NAME}" />
		<div class="row">
			<div class="col-xs-24 col-md-12">
				<div class="form-group">
					<label>{LANG.keywords}</label>
					<input type="text" class="form-control" name="q" value="{SEARCH.q}" placeholder="{LANG.keywords}">
				</div>
			</div>
			<div class="col-xs-24 col-md-12">
				<div class="form-group">
					<label>{LANG.category}</label> 
					<select name="catid" class="form-control">
						<option value=0>---{LANG.all_category}---</option>
						<!-- BEGIN: cat -->
						<option value="{CAT.id}"{CAT.selected}>{CAT.space}{CAT.title}</option>
						<!-- END: cat -->
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-24 col-md-12">
				<div class="form-group">
					<!-- BEGIN: area -->
					<label>{LANG.area}</label>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input type="text" class="form-control" name="area_from" value="{SEARCH.area_from}" placeholder="{LANG.area_from}" />
						</div>
						<div class="col-xs-12 col-md-12">
							<input type="text" class="form-control" name="area_to" value="{SEARCH.area_from}" placeholder="{LANG.to}" />
						</div>
					</div>
					<!-- END: area -->
					<!-- BEGIN: size -->
					<label>{LANG.size}</label>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<input type="text" class="form-control" name="size_v" value="{SEARCH.size_v}" placeholder="{LANG.size_v}" />
						</div>
						<div class="col-xs-12 col-md-12">
							<input type="text" class="form-control" name="size_h" value="{SEARCH.size_h}" placeholder="{LANG.size_h}" />
						</div>
					</div>
					<!-- END: size -->
				</div>
			</div>
			<div class="col-xs-24 col-md-12">
				<div class="form-group">
					<label>{LANG.price}</label>
		            <select name="price_spread" class="form-control">
		                <option value="0">---{LANG.price_spread_c}---</option>
		                <!-- BEGIN: price_spread -->
		                <option value="{PRICE_SPREAD.index}" {PRICE_SPREAD.selected}>{PRICE_SPREAD.title}</option>
		                <!-- END: price_spread -->
		            </select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-24 col-md-12">
				<div class="form-group">
					<label>{LANG.way}</label>
					<select name="way" class="form-control">
						<option value="0">---{LANG.way_chosen}---</option>
						<!-- BEGIN: way -->
						<option value="{WAY.id}" {WAY.selected}>{WAY.title}</option>
						<!-- END: way -->
					</select>
				</div>
			</div>
			<div class="col-xs-24 col-md-12">
				<div class="form-group">
					<label>{LANG.items_location}</label>
					{LOCATION}
				</div>
			</div>
		</div>
		<div class="text-center">
			<button type="submit" name="search" class="btn btn-primary">{LANG.search}</button>
		</div>
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