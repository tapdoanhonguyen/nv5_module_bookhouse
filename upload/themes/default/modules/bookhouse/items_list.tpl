<!-- BEGIN: main -->
<!-- BEGIN: ok -->
<div class="red" style="margin-bottom:10px">Đăng tin thành công</div>
<!-- END: ok -->
<!-- BEGIN: no_ok -->
<div class="red">Đăng tin thất bại</div>
<div class="thongbao_red">Tin rao của bạn bị trùng,vui lòng chỉnh sửa lại nội dung!</div>
<!-- END: no_ok -->
<div class="content_block_tin">
			<div class="title_qltine">Quản lý tin</div>
			<!-- BEGIN: loop -->		
						<div class="item_blocktin">
							<div class="image_blocktin col-sm-6 col-md-5">
								<a href="{DATA.view_url}" title="{DATA.title}"><img src="{DATA.imghome}" width="{THUMB_WIDTH}" /></a>
							</div>
							<div class="nd_blocktin col-sm-18 col-md-19">
								<ul class="list-info">
					<li><h2><a href="{DATA.view_url}" title="{DATA.title}" style="color: {DATA.color} !important">{DATA.title}</a>
						<!-- BEGIN: image_icon -->	
								<img class="icon_block" src="{image_icon}"/>
						<!-- END: image_icon -->	
						</h2>
					</li>
					<li>
					<li>
						<strong>{LANG.code}:</strong> <span class="money">{DATA.code}</span> - 
						<strong>{LANG.viewcount}:</strong> {DATA.hitstotal} - 
						<strong>{LANG.refresh}:</strong> {DATA.ordertime} - 
						<strong>{LANG.status}:</strong> <span {DATA.tintrung}>{DATA.status_s}</span> 
					</li>
					<li><strong>{LANG.type}:</strong> {DATA.cat}</li>
					<li class="hits_w">
						<i title="Tổng số lượt xem" class="fa fa-eye" aria-hidden="true"></i> {DATA.hitstotal} - <i title="Tổng số lượt click xem điện thoại" class="fa fa-mobile" aria-hidden="true"></i> {DATA.hits_phone}
					</li>
					<li>
						<a href="#">
						<!-- BEGIN: refresh_allow -->
							<em class="fa fa-refresh">&nbsp;</em>
							<!-- BEGIN: refresh -->
							<a href="javascript:void(0)" onclick="nv_refresh({DATA.id}, '{DATA.checkss}'); return !1;">{LANG.refresh}</a>&nbsp;&nbsp;&nbsp;
							<!-- END: refresh -->
							<!-- BEGIN: refresh_label -->
							<a href="javascript:void(0)" onclick="nv_refresh({DATA.id}, '{DATA.checkss}'); return !1;">{LANG.refresh}</a>&nbsp;&nbsp;&nbsp;
							<!-- END: refresh_label -->
						<!-- END: refresh_allow -->
						</a>
						<em class="fa fa-image">&nbsp;</em><a href="{DATA.images_link}">{LANG.images}</a><span class="text-danger"> ({DATA.images_count})</span>&nbsp;&nbsp;&nbsp;
						
						<em class="fa fa-edit">&nbsp;</em><a href="{DATA.edit_url}" title="{GLANG.edit}">{GLANG.edit}</a>&nbsp;&nbsp;&nbsp;
						<em class="fa fa-trash-o">&nbsp;</em><a href="javascript:void(0)" onclick="nv_del_items({DATA.id})">{GLANG.delete}</a>
					</li>
					
					<!-- BEGIN: group_buy -->
					<li>
						<div class="nangcaptin">
						<span>
						<a href="javasctipt:void(0)" onclick="nv_buy_refresh(0, 'nha-dat');" style="color: {GROUP.color}" title="{LANG.buy} {GROUP.title}"> Mua thêm lượt làm mới</a>&nbsp;|
						<!-- BEGIN: loop -->
						<a href="{DATA.url_upgrade}" style="color: {GROUP.color}" title="{LANG.buy} {GROUP.title}">Nâng cấp "{LANG.buy} {GROUP.title}"</a><span class="thanhgach_nc">|</span>
						<!-- END: loop -->
						</span>
						</div>
					</li>
					<!-- END: group_buy -->
				</ul>
			
							</div>
						</div>
	<!-- END: loop -->
		
</div>
	<!-- BEGIN: generate_page -->
	<div class="text-right">{GENERATE_PAGE}</div>
	<!-- END: generate_page -->

<script type="text/javascript">
	var LANG = {};
	LANG['refresh_confirm'] = '{LANG.refresh_confirm}';
	
    function nv_change_status(id) {
        var new_status = $('#change_status_' + id).is(':checked') ? true : false;
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '={OP}&nocache=' + new Date().getTime(), 'change_status=1&id=' + id, function(res) {
                var r_split = res.split('_');
                if (r_split[0] != 'OK') {
                    alert(nv_is_change_act_confirm[2]);
                }
            });
        }
        else{
            $('#change_status_' + id).prop('checked', new_status ? false : true );
        }
        return;
    }
</script>
<!-- END: main -->
