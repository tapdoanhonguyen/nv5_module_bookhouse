<!-- BEGIN: main -->
<div class="projects">
    <!-- BEGIN: loop -->
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- BEGIN: homeimg -->
            <div class="image pull-left">
                <a href="{DATA.link}" title="{DATA.title}"><img src="{DATA.homeimg}" alt="{DATA.title}" class="img-thumbnail" /></a>
            </div>
            <!-- END: homeimg -->
            <h2>
                <a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a>
            </h2>
            <p>{DATA.description}</p>
        </div>
    </div>
    <!-- END: loop -->
    <!-- BEGIN: page -->
    <div class="text-center">{PAGE}</div>
    <!-- END: page -->
</div>
<!-- END: main -->