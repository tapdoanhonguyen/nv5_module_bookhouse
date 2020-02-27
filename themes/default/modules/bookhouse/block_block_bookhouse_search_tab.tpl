<!-- BEGIN: main -->
<div class="block_search_type_tab">
	<form action="{NV_BASE_SITEURL}" method="post" class="form-horizontal">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" /> <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" /> <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP_NAME}" />
		<input type="hidden" name="tab_index" id="tab_index" value="0" />
		
		<ul class="nav nav-tabs" role="tablist">
			<!-- BEGIN: tab -->
			<li role="presentation" class="{TAB.active}"><a href="#block_search_type_tab" aria-controls="block_search_type_tab" role="tab" data-toggle="tab" data-catid="{TAB.id}" data-index="{TAB.index}">{TAB.title}</a></li>
			<!-- END: tab -->
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="block_search_type_tab">
				<div class="form-group">
					<label>{LANG.keywords}</label> <input type="text" class="form-control" name="keywords" placeholder="{LANG.keywords}">
				</div>
				<div class="form-group">
					<label>{LANG.category}</label> 
					<!-- BEGIN: cat -->
					<select name="catid" class="form-control tab_cat {CAT_HIDDEN}" id="search_tab_{CATID}" {DISABLED}>
						<!-- BEGIN: loop -->
						<option value="{CAT.id}"{CAT.selected}>{CAT.space}{CAT.title}</option>
						<!-- END: loop -->
					</select>
					<!-- END: cat -->
				</div>
				<!-- BEGIN: area -->
				<div class="form-group">
					<label>{LANG.area_from}</label> <input type="text" class="form-control" name="area_from" value="{SEARCH.area_from}" placeholder="{LANG.area_from}" />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="area_to" value="{SEARCH.area_to}" placeholder="{LANG.to}" />
				</div>
				<!-- END: area -->
				<!-- BEGIN: size -->
				<div class="form-group">
					<label>{LANG.size}</label> <input type="text" class="form-control" name="size_v" value="{SEARCH.size_v}" placeholder="{LANG.size_v}" />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="size_h" value="{SEARCH.size_h}" placeholder="{LANG.size_h}" />
				</div>
				<!-- END: size -->
				<div class="form-group">
					<label>{LANG.price}</label> <select name="price_spread" class="form-control">
						<option value="0">---{LANG.price_spread_c}---</option>
						<!-- BEGIN: price_spread -->
						<option value="{PRICE_SPREAD.index}"{PRICE_SPREAD.selected}>{PRICE_SPREAD.title}</option>
						<!-- END: price_spread -->
					</select>
				</div>
				<div class="form-group">
					<label>{LANG.way}</label> <select name="way" class="form-control">
						<option value="0">---{LANG.way_chosen}---</option>
						<!-- BEGIN: way -->
						<option value="{WAY.id}"{WAY.selected}>{WAY.title}</option>
						<!-- END: way -->
					</select>
				</div>
				<div class="form-group">
					<label>{LANG.items_location}</label> {LOCATION}
				</div>
				<button type="submit" name="search" class="btn btn-primary">{LANG.search}</button>
			</div>
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

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			$('#tab_index').val($(this).attr('data-index'));
			$('.tab_cat').addClass('hidden').attr('disabled', true);
			$('#search_tab_' + $(this).attr('data-catid')).removeClass('hidden').attr('disabled', false);
		});
	});
</script>
<!-- END: main -->

<!-- BEGIN: config -->
<tr>
	<td>{LANG.catid}</td>
	<td>
		<div style="height: 150px; overflow: scroll; border: solid 1px #ddd; padding: 10px">
			<!-- BEGIN: cat -->
			<label class="show"><input type="checkbox" name="config_catid[]" value="{CAT.id}" {CAT.checked} >{CAT.title}</label>
			<!-- END: cat -->
		</div>
	</td>
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
<!-- END: config -->