<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <title>臻LIVE臻声音 -- 活动官方网站</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="<?=base_url();?>assets/base.css"/>
    <link rel="stylesheet" href="<?=base_url();?>assets/flash.css"/>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/jquery.lightbox-0.5.css"/>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/jquery.fancybox.css"/>
    <script src="<?=base_url();?>assets/js/jquery.1.8.0.min.js"></script>
    <script src="<?=base_url();?>assets/js/slider.js"></script>
    <script src="<?=base_url();?>assets/js/verify.notify.min.js"></script>
    <script src="<?=base_url();?>assets/js/jquery.lazyload.js"></script>
    <script src="<?=base_url();?>assets/js/jquery.fancybox.js"></script>
    <script src="<?=base_url();?>assets/js/jquery.lightbox-0.5.min.js"></script>
    <script>
    $(document).ready(function(){
        var supports = (function() {
            var div = document.createElement('div'),
                vendors = 'Khtml Ms O Moz Webkit'.split(' '),
                len = vendors.length;

            return function(prop) {
                if ( prop in div.style ) return true;

                prop = prop.replace(/^[a-z]/, function(val) {
                    return val.toUpperCase();
                });

                while(len--) {
                    if ( vendors[len] + prop in div.style ) {
                        // browser supports box-shadow. Do what you need.
                        // Or use a bang (!) to test if the browser doesn't.
                        return true;
                    }
                }
                return false;
            };
        })();

        if ( supports('border-radius') ) {
            $(".player-avatar-img").each(function(){
                    $(this).attr("data-original", $(this).attr("data-original").replace('_circle', ''));
                }
            );
        }else if(navigator.userAgent.indexOf('Firefox') != -1){
            $(".player-avatar-img").each(function(){
                    $(this).attr("data-original", $(this).attr("data-original").replace('_circle', ''));
                }
            );
        }

        if(navigator.userAgent.indexOf('Phone') == -1 && navigator.userAgent.indexOf('Android') == -1
            && navigator.userAgent.indexOf('iPad') == -1 && navigator.userAgent.indexOf('BlackBerry') == -1
            && navigator.userAgent.indexOf('BB10') == -1 && navigator.userAgent.indexOf('Kindle') == -1){
            $(".bg-section").css("width", "1920px");
            $(".bg-top").css("width", "1920px");
            $(".bg-bottom").css("width", "1920px");
            $(".top-banner").css("width", "1667px");
            $("img").lazyload({failurelimit:4,effect:"fadeIn"});
        }else{
            $(".bg-section").css("width", "1460px");
            $(".bg-top").css("width", "1460px");
            $(".bg-bottom").css("width", "1460px");
            $("body").css("width", "1000px");
            $('img').each(function(){
                if($(this).attr("data-original") != undefined && $(this).attr("data-original") != null){
                    $(this).attr("src", $(this).attr("data-original"));
                }
            });
        }
        //alert(navigator.userAgent);
        $(".play").fancybox({
            width      : '980px',
            height     : '600px',
            type       : 'iframe',
            wrapCSS    : 'fancybox-custom',
            closeClick : true,
            openEffect : 'none',
            helpers : {
                title : {
                    type : 'inside'
                },
                overlay : {
                    css : {
                        'background' : 'rgba(238,238,238,0.85)'
                    }
                }
            }
        });
        $(".comment").fancybox({
            width      : '1024px',
            height     : '595px',
            type       : 'iframe',
            wrapCSS    : 'fancybox-custom',
            closeClick : true,
            openEffect : 'none',
            helpers : {
                title : {
                    type : 'inside'
                },
                overlay : {
                    css : {
                        'background' : 'rgba(238,238,238,0.85)'
                    }
                }
            }
        });
        /*$(".vote").fancybox({
            width      : '615px',
            height     : '520px',
            type       : 'iframe',
            wrapCSS    : 'fancybox-custom',
            closeClick : true,
            openEffect : 'none',
            helpers : {
                title : {
                    type : 'inside'
                },
                overlay : {
                    css : {
                        'background' : 'rgba(238,238,238,0.85)'
                    }
                }
            }
        });*/
        $(".semivote").fancybox({
         width      : '615px',
         height     : '520px',
         type       : 'iframe',
         wrapCSS    : 'fancybox-custom',
         closeClick : true,
         openEffect : 'none',
         helpers : {
         title : {
         type : 'inside'
         },
         overlay : {
         css : {
         'background' : 'rgba(238,238,238,0.85)'
         }
         }
         }
         });
        $("a.tutorial").lightBox();
        $(".side ul li").hover(function(){
            $(this).find(".sidebox").stop().animate({"width":"124px"},200).css({"opacity":"1","filter":"Alpha(opacity=100)","background":"#ae1c1c"})
        },function(){
            $(this).find(".sidebox").stop().animate({"width":"54px"},200).css({"opacity":"0.8","filter":"Alpha(opacity=80)","background":"#000"})
        });
    });

    function goTop(){
        $('html,body').animate({'scrollTop':0},300);
    }
    </script>
    <style type="">
        .li-vote {position: relative;}
        .li-signup {position: relative;}
        .li-vote:hover .dropdown-menu{display:block;}
        .li-signup:hover .dropdown-menu{display:block;}
        .dropdown-menu{
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding;
            background-clip: padding-box;
            width:140px;
            padding-left:3px;
        }
        .dropdown-menu li{
            line-height: 20px;
            display: list-item;
            text-align: -webkit-match-parent;
            padding:0;
        }
        .dropdown-menu li a{color:#000; text-decoration: none; display: block; width:143px; padding-left:14px;
            line-height: 50px;}
        .dropdown-menu li a:hover{color:#fff; background:#007dbc;}
    </style>

</head>
<body>
<div class="o">
    <div class="global-bg">
        <div class="bg-section"></div>
    </div>
    <div class="header">
        <div class="bg-top"></div>
        <a href="" class="top-logo"></a>
        <div class="top-banner">
        </div>
        <ul class="menu">
            <li>
                <a class="menu-home" href="<?=base_url();?>"><span class="<?=($current=="home")?"current":"";?>"></span></a>
            </li>
            <li>
                <a class="menu-intro" href="<?=base_url();?>#intro"><span class="<?=($current=="home")?"intro":"";?>"></span></a>
            </li>
            <li class="li-vote">
                <a class="menu-vote" href="javascript:;">
                    <span class="<?=($current=="playerlist")?"current":"";?>"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?=base_url()?>index.php/playerlist50">50强投票</a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/playerlist">海选投票</a>
                    </li>
                </ul>
            </li>
            <li class="li-signup">
                <a class="menu-signup" href="javascript:;""><span class="<?=($current=="signup")?"current":"";?>"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?=base_url()?>index.php/signup50">50强报名</a>
                    </li>
                    <li>
                        <a href="<?=base_url()?>index.php/signup">海选报名</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="menu-contact" href="<?=base_url();?>index.php/contact"><span class="<?=($current=="contact")?"current":"";?>"></span></a>
            </li>
        </ul>
        <div class="bann-content">
            <div class="corner"></div>
            <div class="product-slide">
                <div class="product-img-box">
                    <? if(isset($flash) && $flash != ""){?>
                    <? foreach($flash as $k => $v){ ?>
                    <div class="media-head" style="left: 0px;">
                        <p class="product-image">
                            <a href="<?=($v->url=="")?"javascript:void(0);":$v->url;?>" target="_blank" alt="">
                                <img width="985px" height="361px" border="0" src="<?=$v->pic?>" title="">
                            </a>
                        </p>
                        <div class="product-shop">
                        </div>
                        <div class="clear">
                        </div>
                    </div>
                    <? } ?>
                    <? } ?>
                </div>
                <div class="product-img-box banner-more">
                    <div class=" more-views">
                        <div class="move-content nubmer-bar" style="width: 985px;">
                            <ul>
                                <? if(isset($flash) && $flash != ""){?>
                                <? for($i = 0; $i < count($flash); $i ++) { ?>
                                <li class="item<?=$i?>">
                                    <div class="ico-img">
                                    </div>
                                </li>
                                <? } ?>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(function(){
                    jQuery.bestnwSlider({
                        baseUrl: "/",
                        hasGallery: 0,
                        hasArrow: 1,
                        barType : 2,
                        speed : 500,
                        autoSpeed:5000,
                        preText:'left',
                        nextText: 'right'
                    });
                });
            </script>
        </div>
    </div>
    <div class="side">
        <ul>
            <li><a href="<?=base_url()?>index.php/contact"><div class="sidebox" style="width: 54px; opacity: 0.8; background: none repeat scroll 0% 0% rgb(0, 0, 0);"><img src="<?=base_url()?>assets/images/side_icon01.png">联系我们</div></a></li>
            <li><a href="http://zhenzhihzp.tmall.com" target="_blank"><div class="sidebox" style="width: 54px; opacity: 0.8; background: none repeat scroll 0% 0% rgb(0, 0, 0);"><img src="<?=base_url()?>assets/images/side_icon02.png">天猫商城</div></a></li>
            <li><a href="http://wpa.qq.com/msgrd?v=3&uin=303846302&site=qq&menu=yes" target="_blank"><div class="sidebox"><img src="<?=base_url();?>assets/images/side_icon04.png">QQ客服</div></a></li>
            <li><a href="http://weibo.com/zhenzhi22" target="_blank"><div class="sidebox"><img src="<?=base_url();?>assets/images/side_icon03.png">新浪微博</div></a></li>
            <li style="border:none;"><a class="sidetop" href="javascript:goTop();"><img src="<?=base_url();?>assets/images/side_icon05.png"></a></li>
        </ul>
    </div>
