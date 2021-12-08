<!-- BEGIN: main -->
<div class="project-detail">
    <!-- BEGIN: homeimg -->
    <div class="image pull-left">
        <a href="{DATA.link}" title="{DATA.title}"><img src="{DATA.homeimg}" alt="{DATA.title}" class="img-thumbnail" /></a>
    </div>
    <!-- END: homeimg -->
    <h1 class="m-bottom">{DATA.title}</h1>
    <p>{DATA.description}</p>
    <!-- BEGIN: image -->
    <div class="row">
        <div class='col-md-24'>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <!-- BEGIN: loop_control -->
                    <li data-target="#myCarousel" data-slide-to="{NUM}" class="jcontrol"></li>
                    <!-- END: loop_control -->
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <!-- BEGIN: loop_img -->
                    <div class="item">
                        <img src="{IMG}" alt="Los Angeles" style="width: 100%;">
                    </div>
                    <!-- END: loop_img -->
                </div>
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span>
                </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <!-- END: image -->
    <!-- BEGIN: descriptionhtml -->
    <hr />
    <p class="m-bottom">{DATA.descriptionhtml}</p>
    <!-- END: descriptionhtml -->
    <!-- BEGIN: type -->
    <h2>{TYPE.title}</h2>
    <div id="main_div_{TYPE.id}">{OTHER}</div>
    <!-- END: type -->
</div>
<script>
    $(".item:first").addClass("active");
    $(".jcontrol:first").addClass("active");
</script>
<!-- END: main -->
<!-- BEGIN: list -->
{DATA}
<!-- BEGIN: generate_page -->
<div class="text-center">{PAGE}</div>
<!-- END: generate_page -->
<!-- END: list -->
