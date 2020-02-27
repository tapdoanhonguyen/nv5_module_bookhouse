/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 13 Aug 2014 00:24:32 GMT
 */
$(function () {
    $('#upload_fileupload').change(function () {
        $('#file_name').val($(this).val().match(/[-_\w]+[.][\w]+$/i)[0]);
    });

    // taikhoan
    $('.ws_c_d').click(function () {
        if (confirm(LANG.payment_confirm)) {
            var product_id = $(this).attr('data_product_id');
            var checksum = $('.payment-option:checked').data('checksum');
            var groupid = $(this).data('groupid');
            var number = $('.payment-option:checked').val();
            var mod = $(this).data('mod');
			
			$(".khung_loading").fadeIn("faster");

            $.ajax({
                type: "POST",
                url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=taikhoan&' + nv_fc_variable + '=ws&nocache=' + new Date().getTime(),
                data: 'product_id=' + product_id + '&product_title=' + $(this).attr('data_title') + '&module_send=' + nv_module_name + '&money=' + $(this).attr('data_money') + '&money_unit=' + $(this).attr('data_money_unit') + '&tokenkey=' + $(this).attr('data_tokenkey'),
                success: function (result) {
                    if (result.status != 200) {
                        alert(result.message); 
                    } else {
                        if (mod == 'refresh') {
                            $.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), 'buy_refresh=1&id=' + product_id + '&number=' + number + '&checksum=' + checksum, function (res) {
                                var r_split = res.split('_');
                                alert(r_split[1]);
                                if (r_split[0] == 'OK') {
                                    window.location.reload(true);
                                }
                            });
                        } else if (mod == 'group') {
                            $.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), 'buy_group=1&id=' + product_id + '&time=' + number + '&groupid=' + groupid + '&checksum=' + checksum, function (res) {
                                var r_split = res.split('_');
                                alert(r_split[1]);
                                if (r_split[0] == 'OK') {
					window.location.href = LANG.url_item;
                                }
                            });
                        } else if (mod == 'upgrade_group') {
                            $.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), 'upgrade_group=1&id=' + product_id + '&time=' + number + '&groupid=' + groupid + '&checksum=' + checksum, function (res) {
                                var r_split = res.split('_');
                                alert(r_split[1]);
                                if (r_split[0] == 'OK') {
					window.location.href = LANG.url_item;
                                }
                            });
                        }
						
						//$(".khung_loading").fadeOut(1000);
                    }
                },
                dataType: "json",
            });
        }
    });
});



function nv_del_items(id) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=items&del&nocache=' + new Date().getTime(), 'id=' + id, function(res) {
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
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=items&nocache=' + new Date().getTime(), 'get_alias=1&title=' + encodeURIComponent(title), function(res) {
            if (res != "") {
                document.getElementById('idalias').value = res;
            } else {
                document.getElementById('idalias').value = '';
            }
        });
    }
    return false;
}

function nv_delete_other_images(i) {
    if (confirm(nv_is_del_confirm[0])) {
        $('#other-image-div-' + i).slideUp().promise().done(function() {
            $(this).remove();
        });
    }
}

function nv_delete_other_images_tmp(path, thumb, i) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=images&nocache=' + new Date().getTime(), 'delete_other_images_tmp=1&path=' + path + '&thumb=' + thumb, function(res) {
            if (res != 'OK') {
                alert(nv_is_del_confirm[2]);
            } else {
                $('#other-image-div-' + i).slideUp();
            }
        });
    }
}

function nv_view_on_main(id) {
    $('.main_content').hide();
    $('#main_content_' + id).slideDown();
}

function nv_refresh(rowsid, checkss) {
    if (confirm(LANG.refresh_confirm)) {
        $.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), 'refresh=1&id=' + rowsid + '&checkss=' + checkss, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(r_split[1]);
            } else {
                window.location.href = window.location.href;
            }

        });
    }
}

function nv_save_rows(id, mod, is_user) {
    if (!is_user) {
        alert(LANG.error_save_login);
    } else if (confirm(nv_is_change_act_confirm[0])) {
        $.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), 'save=1&id=' + id + '&mod=' + mod, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(r_split[1]);
            } else {
                if (mod == 'add') {
                    $('#save').hide();
                    $('#saved').show();
                } else {
                    $('#saved').hide();
                    $('#save').show();
                }
                alert(r_split[1]);
            }
        });
    }
    return false;
}

function nv_delete_save(id, checkss) {
    if (confirm(nv_is_del_confirm[0])) {
        $.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), 'saved_delete=1&id=' + id + '&checkss=' + checkss, function(res) {
            var r_split = res.split('_');
            if (r_split[0] != 'OK') {
                alert(r_split[1]);
            } else {
                $('#row_' + id).remove();
            }
        });
    }
}

function nv_list_action(action, url_action, del_confirm_no_post, checkss) {
    var listall = [];
    $('input.post:checked').each(function() {
        listall.push($(this).val());
    });

    if (listall.length < 1) {
        alert(del_confirm_no_post);
        return false;
    }

    if (action == 'delete_list_id') {
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: url_action,
                data: 'saved_delete_list=1&listall=' + listall + '&checkss=' + checkss,
                success: function(data) {
                    var r_split = data.split('_');
                    if (r_split[0] == 'OK') {
                        window.location.href = window.location.href;
                    } else {
                        alert(nv_is_del_confirm[2]);
                    }
                }
            });
        }
    }

    return false;
}


function nv_buy_refresh(id, module, all) {





    $.ajax({
        type: 'POST',
        url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + module + '&' + nv_fc_variable + '=payment',
        cache: !1,
        data: '&id=' + id + '&mod=refresh&all=' + all,

        dataType: "html"
    }).done(function(a) {
        $('#sitemodal .modal-dialog').addClass('modal-lg');
        modalShow('', a);
    });
    return !1
}

$('.update_account').click(function(){
	
	nv_upgrade_group();

});


function nv_upgrade_group(mod, groupid, rowid, title)
{
    $.ajax({
        type: 'POST',
        url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=payment',
        cache: !1,
        data: 'mod=' + mod + '&groupid=' + groupid + '&id=' + rowid,
        dataType: "html"
    }).done(function(a) {
    	$('#sitemodal .modal-dialog').addClass('modal-lg');
        modalShow(title, a);
    });
    return!1
}

function nv_buy_group(id, bid, module, all) {
    $.ajax({
        type: 'POST',
        url: nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + module + '&' + nv_fc_variable + '=payment',
        cache: !1,
        data: '&id=' + id + '&groupid=' + bid + '&mod=group&all=' + all,
        dataType: "html"
    }).done(function(a) {
        $('#sitemodal .modal-dialog').addClass('modal-lg');
        modalShow('', a);
    });
    return !1
}

function nv_payment_option_change($_this)
{
	$('#payment-btn').attr('data_money', $_this.data('price'));
	$('#payment-btn').attr('data_tokenkey', $_this.data('tokenkey'));
	$('#payment-btn').attr('data-checksum', $_this.data('checksum'));
}
