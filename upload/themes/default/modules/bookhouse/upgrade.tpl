<!-- BEGIN: main -->
<div class="upgrade">
    <!-- BEGIN: rowinfo -->
    <ul class="list-info">
        <li><label>{LANG.title}:</label> {DATA.title}</li>
        <li><label>{LANG.items_code}:</label> <span class="xanh">{DATA.code}</span></li>
        <li><label>{LANG.link_item}:</label><a class="xanh" href="{DATA.link}"> 123nha.net{DATA.link}</a></li>
        <li><label>{LANG.cat}:</label> <a href="{DATA.link_cat}" title="{DATA.cat}">{DATA.cat}</a></li>
    </ul>	
    <!-- END: rowinfo -->
    {CONTENT}
</div>
<script>
    $(document).ready(function () {
        $('a.btn-upgrade').click(function () {
            nv_upgrade_group('{MOD}', $(this).attr('id'), {DATA.id}, $(this).attr('title'));
        });
    });
</script>
<!-- END: main -->
