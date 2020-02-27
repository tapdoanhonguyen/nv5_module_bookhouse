<!-- BEGIN: main -->
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/bookhouse.js"></script>
<div class="block_user">
		<div class="tttk_account"><i class="fa fa-user" aria-hidden="true"></i>
 {USER.last_name} {USER.first_name}</div>
		<div class="body_block_user">
			<div class="tien_tk">
				<label>Tài khoản:</label> {tien} k
			</div>
			<div class="tien_tk"><label>Loại tài khoản: </label> <span class="red">{TITLE}</span></div>
			<!-- BEGIN: hethan -->
			<div class="tien_tk"><label>Ngày hết hạn: </label> <span class="red">{NGAYHETHAN}</span></div>
			<!-- END: hethan -->
			<!-- BEGIN: refresh -->
			<div class="luot_lammoi"><label>{LANG.refresh}:</label> {DATA.refresh} Lượt <!-- BEGIN: buy_refresh -->(<a href="javascript:void(0);" onclick="nv_buy_refresh(0, '{MODULE_NAME}');">{LANG.buy_refresh}</a>)<!-- END: buy_refresh --></div>
			<!-- BEGIN: refresh_free -->
				<div class="luot_lammoi"><label>{LANG.refresh_free}:</label> {DATA.refresh_free} Lượt</div>
		<!-- END: refresh_free -->
			<!-- END: refresh -->
			<div class="naptientk"><a href="{NV_BASE_SITEURL}wallet/main/"><i class="fa fa-usd" aria-hidden="true"></i>
	 Nạp tiền vào tài khoản</a></div>
			<div class="hd_naptien"><a href="{NV_BASE_SITEURL}nap-tien/Huong-dan-nap-tien.html" title="Hướng dẫn nạp tiền">Hướng dẫn nạp tiền</a></div>
			<div class="ghichu_naptien">
				Đổi tiền ra k: 1000đ = 1k 
			</div>
		</div>
</div>
<!-- END: main -->