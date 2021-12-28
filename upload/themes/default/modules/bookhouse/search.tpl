<!-- BEGIN: main -->
<div class="kq_search_bds">
<div class="item_note row">
	<div class="col-md-12 soluong_tk">
		<div class="note_kq">{LANG.search_result}</div>
	</div>
	<div class="col-md-12 sapxep_tin">
		<select class="form-control" name="sapxep">
			<option {s0} value="{macdinh}">Sắp xếp mặc định</option>
			<option {s1} value="{moi}">Tin mới nhất</option>
			<option {s2} value="{tangdan}">Giá tăng dần</option>
			<option {s3} value="{giamdan}">Giá giảm dần</option>
		</select>
	</div>
</div>
<div class="clear"></div>

<div class="Footer">
Tìm kiếm theo các tiêu chí: 
<!-- BEGIN: title_catid --><span class="greencolor">{title_catid}</span><!-- END: title_catid --> 
<!-- BEGIN: districtid_tai -->
 Tại {districtid}.
<!-- END: districtid_tai -->
<!-- BEGIN: provinceid --> Tỉnh/Tp: <span class="greencolor"><strong>{provinceid}</strong></span>
<!-- END: provinceid --> 

<!-- BEGIN: area -->
 Diện tích: <span class="greencolor"><strong>{SEARCH.area} m2.</strong></span>
<!-- END: area -->
<!-- BEGIN: price_spread -->
 Giá: <span class="greencolor"><strong>{so1}-{so2} {donvi}</strong></span>
<!-- END: price_spread -->
</div>

<div class="mota_kqtk"><div class="no_title">
<h1 style="text-align: center;"><!-- BEGIN: title_catid1 -->{title_catid}<!-- END: title_catid1 --> <!-- BEGIN: districtid -->
<span class="greencolor"><strong>{districtid}.</strong></span>
<!-- END: districtid -->
</h1>Trang thông tin mua bán bất động sản uy tín tại <span class="bold">{diadiem}</span> với các tin mua, bán, cho thuê phòng trọ, căn hộ, chung cư, nhà đất, khách sạn... được cập nhật 24/7 tại muanha.com.vn
</div></div>

{DATA}

<div class="clear"></div>
	<!-- BEGIN: page -->
	<div class="text-center">{PAGE}</div>
	<!-- END: page -->

</div>

	<script type="text/javascript">
		$(function () {
			$('.sapxep_tin select').change(function (e){
				var search = $('.sapxep_tin select').val();
				if (search!="")
				window.location.href = search;
			});
		});
	</script>
	
<!-- END: main -->