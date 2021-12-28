/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC ( contact@vinades.vn )
 * @Copyright ( C ) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 1 - 31 - 2010 5 : 12
 */

function nv_chang_weight(id, func) {
	var nv_timer = nv_settimeout_disable('weight' + id, 5000);
	var newpos = $("#weight" + id).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + func + '&nocache=' + new Date().getTime(), 'changeweight=1&catid=' + id + '&new=' + newpos, function(res) {
		if (res != 'OK') {
			alert(nv_is_change_act_confirm[2]);
		}
		clearTimeout(nv_timer);
		window.location.href = window.location.href;
	});
	return;
}

//  ---------------------------------------

function nv_chang_status(catid, func) {
	var nv_timer = nv_settimeout_disable('change_status' + catid, 5000);
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + func + '&nocache=' + new Date().getTime(), 'changestatus=1&catid=' + catid, function(res) {
		if (res != 'OK') {
			alert(nv_is_change_act_confirm[2]);
			window.location.href = window.location.href;
		}
	});
	return;
}

//  ---------------------------------------

function nv_row_del(catid, func) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + func + '&nocache=' + new Date().getTime(), 'del=1&catid=' + catid, function(res) {
			if (res == 'OK') {
				window.location.href = window.location.href;
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_contract_del(cid) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=contract&nocache=' + new Date().getTime(), 'del=1&cid=' + cid, function(res) {
			if (res == 'OK') {
				window.location.href = window.location.href;
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function get_alias() {
	var title = strip_tags(document.getElementById('idtitle').value);
	if (title != '') {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=alias&nocache=' + new Date().getTime(), 'title=' + encodeURIComponent(title), function(res) {
			if (res != "") {
				document.getElementById('idalias').value = res;
			} else {
				document.getElementById('idalias').value = '';
			}
		});
	}
	return false;
}

function nv_del_items(id) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=items&del&nocache=' + new Date().getTime(), 'id=' + id, function(res) {
			if (res == 'OK') {
				window.location.href = window.location.href;
			}
			else
			{
				alert( nv_is_del_confirm[2] );
			}
		});
	}
	return false;
}

function nv_del_order(id) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order_content&nocache=' + new Date().getTime(), 'del_order=1&orderid=' + id, function(res) {
			if (res == 'OK') {
				window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order';
			}
			else
			{
				alert( nv_is_del_confirm[2] );
			}
		});
	}
	return false;
}

function nv_kill_order(id,method) {
	method = trim( method );
	var msg = ( method == 'kill' ) ? order_in_1 : order_in_2;
	if (confirm(msg)) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=order_content&nocache=' + new Date().getTime(), 'kill_order=1&orderid=' + id + '&method=' + method, function(res) {
			if (res == 'OK') {
				window.location.href = window.location.href;
			}
			else
			{
				alert( nv_is_del_confirm[2] );
			}
		});
	}
	return false;
}

function nv_delete_other_images( i ){
	if (confirm(nv_is_del_confirm[0])) {
		$('#other-image-div-' + i).slideUp().promise().done(function() {
		    $(this).remove();
		});
	}
}

function nv_delete_other_images_tmp( path, thumb, i ){
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=images&nocache=' + new Date().getTime(), 'delete_other_images_tmp=1&path=' + path + '&thumb=' + thumb, function(res) {
			if (res != 'OK') {
				alert(nv_is_del_confirm[2]);
			}
			else{
				$('#other-image-div-' + i).slideUp();
			}
		});
	}
}

function check_add_first() {
	$(this).one("dblclick", check_add_second);
	$("input[name='add_content[]']:checkbox").prop("checked", true);
}

function check_add_second() {
	$(this).one("dblclick", check_add_first);
	$("input[name='add_content[]']:checkbox").prop("checked", false);
}

function check_app_first() {
	$(this).one("dblclick", check_app_second);
	$("input[name='app_content[]']:checkbox").prop("checked", true);
}

function check_app_second() {
	$(this).one("dblclick", check_app_first);
	$("input[name='app_content[]']:checkbox").prop("checked", false);
}

function check_pub_first() {
	$(this).one("dblclick", check_pub_second);
	$("input[name='pub_content[]']:checkbox").prop("checked", true);
}

function check_pub_second() {
	$(this).one("dblclick", check_pub_first);
	$("input[name='pub_content[]']:checkbox").prop("checked", false);
}

function check_edit_first() {
	$(this).one("dblclick", check_edit_second);
	$("input[name='edit_content[]']:checkbox").prop("checked", true);
}

function check_edit_second() {
	$(this).one("dblclick", check_edit_first);
	$("input[name='edit_content[]']:checkbox").prop("checked", false);
}

function check_del_first() {
	$(this).one("dblclick", check_del_second);
	$("input[name='del_content[]']:checkbox").prop("checked", true);
}

function check_del_second() {
	$(this).one("dblclick", check_del_first);
	$("input[name='del_content[]']:checkbox").prop("checked", false);
}

function check_admin_first() {
	$(this).one("dblclick", check_admin_second);
	$("input[name='admin_content[]']:checkbox").prop("checked", true);
}

function check_admin_second() {
	$(this).one("dblclick", check_admin_first);
	$("input[name='admin_content[]']:checkbox").prop("checked", false);
}

function nv_del_block_cat(bid) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=groups&nocache=' + new Date().getTime(), 'del_block_cat=1&bid=' + bid, function(res) {
			var r_split = res.split('_');
			if (r_split[0] == 'OK') {
				nv_show_list_block_cat();
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_chang_block_cat(bid, mod) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + bid, 5000);
	var new_vid = $('#id_' + mod + '_' + bid).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=chang_block_cat&nocache=' + new Date().getTime(), 'bid=' + bid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
		var r_split = res.split('_');
		if (r_split[0] != 'OK') {
			alert(nv_is_change_act_confirm[2]);
		}
		clearTimeout(nv_timer);
		nv_show_list_block_cat();
	});
	return;
}

function nv_show_list_block_cat() {
	if (document.getElementById('module_show_list')) {
		$('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block_cat&nocache=' + new Date().getTime());
	}
	return;
}

function nv_chang_block(bid, id, mod) {
	if (mod == 'delete' && !confirm(nv_is_del_confirm[0])) {
		return false;
	}
	var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
	var new_vid = $('#id_weight_' + id).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&nocache=' + new Date().getTime(), 'id=' + id + '&bid=' + bid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
		nv_chang_block_result(res);
	});
	return;
}

function nv_chang_block_result(res) {
	var r_split = res.split('_');
	if (r_split[0] != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	var bid = parseInt(r_split[1]);
	nv_show_list_block(bid);
	return;
}

function nv_show_list_block(bid) {
	if (document.getElementById('module_show_list')) {
		$('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block&bid=' + bid + '&nocache=' + new Date().getTime());
	}
	return;
}

function nv_del_block_list(oForm, bid, del_confirm_no_post) {
	var del_list = '';
	var fa = oForm['idcheck[]'];
	if (fa.length) {
		for (var i = 0; i < fa.length; i++) {
			if (fa[i].checked) {
				del_list = del_list + ',' + fa[i].value;
			}
		}
	} else {
		if (fa.checked) {
			del_list = del_list + ',' + fa.value;
		}
	}

	if (del_list != '') {
		if (confirm(nv_is_del_confirm[0])) {
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&nocache=' + new Date().getTime(), 'del_list=' + del_list + '&bid=' + bid, function(res) {
				nv_chang_block_result(res);
			});
		}
	}
	else{
		alert(del_confirm_no_post);
	}
}

function nv_list_action( action, url_action, del_confirm_no_post )
{
    var listall = [];
    $('input.post:checked').each(function() {
        listall.push($(this).val());
    });
    
    if (listall.length < 1) {
        alert( del_confirm_no_post );
        return false;
    }
    
    if( action == 'delete_list_id' )
    {
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type : 'POST',
                url : url_action,
                data : 'delete_list=1&listall=' + listall,
                success : function(data) {alert(data);
                    var r_split = data.split('_');
                    if( r_split[0] == 'OK' ){
                        window.location.href = window.location.href;
                    }
                    else{
                        alert( nv_is_del_confirm[2] );
                    }
                }
            });
        }
    }
	
	 if( action == 'duyet_list_id' )
    {
        if (confirm('Bạn có chắc muốn duyệt tất cả !')) {
            $.ajax({
                type : 'POST',
                url : url_action,
                data : 'duyet_list=1&listall=' + listall,
                success : function(data) {
                    var r_split = data.split('_');
                    if( r_split[0] == 'OK' ){
                        window.location.href = window.location.href;
                    }
                    else{
                        alert( nv_is_del_confirm[2] );
                    }
                }
            });
        }
    }
    
    return false;
}