<!-- BEGIN: main -->
<div class="payment">
<!-- BEGIN: taikhoan -->
<div class="des_payment">
	<div class="des1_payment">Tài khoản của bạn thuộc nhóm tài khoản: <span class="nhom_tk">{NHOM}</span></div>
	<div class="des1_payment">Đến hết ngày :<span class="{class}">{NGAYHETHAN}</span></div>
</div>
<!-- END: taikhoan -->
	<!-- BEGIN: show_row_info -->
	<ul class="list">

		<li><label>{LANG.title}:</label> {INFO.title}</li>

		<li><label>{LANG.code}:</label> {INFO.code}</li>

		<li><label>{LANG.cat}:</label> {INFO.cat}</li>
	</ul>
	<!-- END: show_row_info -->
	<div class="row">
		<!-- BEGIN: refresh -->
		<div class="{COL_CLASS}">

			<div class="panel panel-default">
				<div class="panel-heading">{LANG.buy_refresh_item}</div>
				<div class="panel-body">
					<p class="m-bottom">{LANG.payment_refresh_note}</p>
					<select class="form-control payment-option-0" name="option[0]" data-groupid="0" onchange="nv_payment_option_change($(this)); return !1;">
						<!-- BEGIN: option -->
						<option value="{OPTION.number}" data-price="{OPTION.price}" data-tokenkey="{OPTION.tokenkey}" data-checksum="{OPTION.checksum}" {OPTION.selected}>{OPTION.number} {LANG.refresh_count_sort} - {OPTION.price_format}{MONEY_UNIT}</option>
						<!-- END: option -->
					</select>
				</div>
				<div class="panel-footer">
					<div class="text-center">
						<button class="btn btn-warning ws_c_d" id="payment-btn-0" data_product_id="{INFO.id}" data_title="{INFO.title}" data_money="{FIRST.price}" data_money_unit="VND" data_tokenkey="{FIRST.tokenkey}" data-checksum="{FIRST.checksum}" data-mod="refresh" data-groupid="0">{LANG.payment}</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END: refresh -->

		<!-- BEGIN: group -->
		<div class="{COL_CLASS}">

			<div class="payment-group">
				<div class="panel panel-default">
					<div class="panel-heading">{GROUP.title}</div>
					<div class="panel-body">
						<div class="m-bottom">{GROUP.description}</div>
						<select class="form-control payment-option-{GROUP.bid}" name="option[{GROUP.bid}]" data-groupid="{GROUP.bid}" onchange="nv_payment_option_change($(this)); return !1;" {DISABLED}>
							<!-- BEGIN: option -->
							<option value="{OPTION.time}" data-price="{OPTION.price}" data-tokenkey="{OPTION.tokenkey}" data-checksum="{OPTION.checksum}" {OPTION.selected}>{OPTION.time} {GLANG.day} - {OPTION.price_format}{MONEY_UNIT}</option>
							<!-- END: option -->
						</select>
					</div>
					<div class="panel-footer">
						<div class="text-center">
							<button class="btn btn-warning ws_c_d" {DISABLED} id="payment-btn-{GROUP.bid}" data_product_id="{INFO.id}" data_title="{INFO.title}" data_money="{FIRST.price}" data_money_unit="VND" data_tokenkey="{FIRST.tokenkey}" data-checksum="{FIRST.checksum}" data-mod="{MOD}" data-groupid="{GROUP.bid}">{LANG.payment}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END: group -->
	</div>
</div>
<script>
	var LANG = {};
	LANG['payment_confirm'] = '{LANG.payment_confirm}';
</script>
<!-- END: main -->