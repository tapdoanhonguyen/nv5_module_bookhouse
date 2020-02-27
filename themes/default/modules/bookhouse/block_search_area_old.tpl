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
.border_search {
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
	line-height: 27px;
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
	<form action="#" method="post" class="form-horizontal">
		<div class="row">
			<div class="col-xs-16 col-sm-18 col-md-19 row border_search">
				
				<div class="col-xs-12 col-sm-12 col-md-12">{LOCATION}</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="thanh_ngan_search">|</div><input type="text" class="form-control" value="{SEARCH.keywords}" name="keywords" placeholder="{LANG.keywords}">
				</div>
			</div>
			<div class="col-xs-8 col-sm-6 col-md-5">
			<span class="btn btn-primary search_button">{LANG.search}</span>
			</div>
		</div>
		
	</form>
</div>

<script>
	$('.search_button').click(function(){
		var key = $('.block_search_area input[name=keywords]').val();
		var dia_diem = '';
		var value_province = $('.block_search_area select[name=provinceid]').val();
		if(value_province > 0)
		  dia_diem = $('.block_search_area select[name=provinceid] option:selected').text();
		
		var search = key + ' ' + dia_diem ;
		
		var link = link_alias(search);
		if(link == '/')
			link = '/timkiem';
		$('.block_search_area form').attr('action', 'http://123nha.net' + link +'/');   
		$('.block_search_area form').submit();
		
		//alert(link);
		
	});
	
	function link_alias(title)
	{
	var html = '';
	if (title != '') {
		$.ajax({
				type : 'POST',
				async: false,
				url : nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=nha-dat&' + nv_fc_variable + '=main',
				data : { get_alias_title : title},
				success : function(res){
					html = res;
				}
			});
		}
		return html;
	}
	
</script>
<!-- END: main -->