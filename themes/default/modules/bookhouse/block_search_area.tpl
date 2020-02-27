<!-- BEGIN: main -->
<style>
.block_search_area .select2-container--bootstrap .select2-selection--single {
    box-shadow: none !important;
	border:none !Important;
    border-right: 1px soild #ccc !important;
}
.block_search_area .form-control {
    border: none !important;
    box-shadow: none !important;
}
.col-xs-12.col-sm-18.col-md-18.row.border_search {
    border: 1px solid #ccc;
    height: 40px;
    padding-top: 4px;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
}
.block_search_area .btn-primary {
    color: #fff;
    background-color: #59AE37;
    border-color: #59AE37;
    text-transform: uppercase;
    border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
    height: 40px;
}
.thanh_ngan_search {
    position: absolute;
    top: 0px;
    font-size: 20px;
    left: 0px;
	color:#ccc
}
.timkiem_header2 {
    margin-top: 22px;
}
.block_search_area .btn-primary:hover {
    background-color: #67CB3F;
    border-color: #67CB3F;
}
</style>
<div class="block_search_area">
	<form action="{NV_BASE_SITEURL}" method="post" class="form-horizontal">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" /> <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" /> <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP_NAME}" />
		<div class="row">
			<div class="col-xs-12 col-sm-18 col-md-18 row border_search">
				
				<div class="col-xs-12 col-sm-12 col-md-14">{LOCATION}</div>
				<div class="col-xs-12 col-sm-12 col-md-10">
					<div class="thanh_ngan_search">|</div><input type="text" class="form-control" name="keywords" value="{SEARCH.keywords}" placeholder="{LANG.keywords}">
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
			<button type="submit" name="search" class="btn btn-primary">{LANG.search}</button>
			</div>
		</div>
		
	</form>
</div>
<!-- END: main -->