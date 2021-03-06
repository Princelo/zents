<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?=base_url();?>assets/navigator_memu.css" type="text/css" media="screen, projection" >

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>UNVWEB Management System 远维网络</title>

    <meta name="language" content="en" />

    <!--[if IE]>
    <script src="<?=base_url();?>assets/js/html5.js"></script>
    <![endif]-->

    <!-- ********** jQuery ********** -->

    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.1.8.0.min.js"></script>


    <!-- ********** PHPJS ********** -->
    <script type="text/javascript" src="<?=base_url();?>assets/js/php.default.namespaced.min.js"></script>


    <!-- ********** Custom JS ********** -->
    <script type="text/javascript" src="<?=base_url();?>assets/js/general.js"></script>




    <!-- Css -->
    <!--
    -->
    <link rel="stylesheet" href="<?=base_url();?>assets/general.css" type="text/css">
    <link rel="stylesheet" href="<?=base_url();?>assets/layout.css" type="text/css">




    <!-- ********** JSCal2 ********** -->
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/jscal2.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/border-radius.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/reduce-spacing.css" />
    <script type="text/javascript" src="<?=base_url();?>assets/js/jscal2.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/en.js"></script>

    <!-- Clock Picker -->
    <script type="text/javascript" src="<?=base_url();?>assets/jquery.clockpick.1.2.7.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/js/jquery.clockpick.1.2.7.css"/>

    <!-- ********** :: Animated jQuery Menu Style 08  ********** -->
    <script type="text/javascript" src="<?=base_url();?>assets/js/menu.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/menu.css" />

    <!-- ********** :: colorbox-master  ********** -->
    <link rel="stylesheet" href="<?=base_url();?>assets/colorbox.css" />
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.colorbox.js"></script>

    <!-- Freeze Header  ********** -->
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.freezeheader.js"></script>

    <!-- Mobile Detector  ********** -->
    <script type="text/javascript" src="<?=base_url();?>assets/js/detectmobilebrowser.js"></script>
    <script src="<?=base_url();?>assets/js/verify.notify.min.js"></script>
    <script>
        $(document).ready(

        );
    </script>
</head>

<body>


<div id="header">
    <div id="logo">远维网络管理系统 </div>


    <div id='head_info'>

									<span style="margin-right:40px">
					</span>
        <!--
        <a href=""  class="image_button"  title="Tutor Buffer Table"><img src='/cgi-bin/common/images/page_white_gear.png'></a>
        <a href=""  class="image_button"  title="Tutor Buffer Table"><img src='/cgi-bin/common/images/chart_organisation.png'></a>
        <a href=""  class="image_button"  title="Tutor Buffer Table"><img src='/cgi-bin/common/images/status_online.png'></a>
        <a href=""  class="image_button"  title="Tutor Buffer Table"><img src='/cgi-bin/common/images/door_in.png'></a>
-->
    </div>
</div><!-- header -->


<div id="mainmenu">

    <!-- begin: main navigation #nav -->
    <div id="menu">
        <ul class="menu">
            <li class="current"><a href="<?=base_url();?>index.php/unvadmin/manage" class="parent"><span>管理系统首页 </span></a>
            </li>
            <li class=""><a href="<?=base_url();?>index.php/unvadmin/password" class=""><span>修改密碼 </span></a></li>
            <li class=""><a href="<?=base_url();?>index.php/unvadmin/logout" class=""><span>登出 </span></a></li>
        </ul>
    </div>

<!-- end: main navigation -->

</div><!-- mainmenu -->

<div id="container">



    <!-- begin: #col1 - first float column -->
    <div id="col1" role="complementary">
        <div id="col1_content" class="clearfix">

            <ul id="left_menu">
                <li><a href='<?=base_url()?>index.php/unvadmin/singer' ><div>歌手管理 </div></a></li>
                <li><a href='<?=base_url()?>index.php/unvadmin/singer50' ><div>50强 </div></a></li>
                <li><a href='<?=base_url();?>index.php/unvadmin/flash' ><div>幻灯片管理 </div></a></li>
                <li style="display:none;"><a href='<?=base_url();?>index.php/unvadmin/thx' ><div>鸣谢单位管理 </div></a></li>
                <li><a href='<?=base_url();?>index.php/unvadmin/password' ><div>修改密码 </div></a></li>
            </ul>
        </div>
    </div>
    <!-- end: #col1 -->



    <script>
$(document).ready(function(){
    //Examples of how to assign the Colorbox event to elements
    $(".group1").colorbox({rel:'group1'});
            $(".group2").colorbox({rel:'group2', transition:"fade"});
            $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
            $(".group4").colorbox({rel:'group4', slideshow:true});
            $(".ajax").colorbox();
            $(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});
            $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
            $(".iframe").colorbox({iframe:true, width:"100%", height:"100%"});
            $(".inline").colorbox({inline:true, width:"50%"});
            $(".callbacks").colorbox({
                //onOpen:function(){ alert('onOpen: colorbox is about to open'); },
                //onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
                //onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
                //onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
                //onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
            });

            $('.non-retina').colorbox({rel:'group5', transition:'none'})
            $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});

            //Example of preserving a JavaScript event for inline calls.
            $("#click").click(function(){
                $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                return false;
            });
        });
    </script>

