<!DOCTYPE html>
<html lang="en">
<head>
    <title>Live Cropping Demo</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <script src="<?=base_url();?>assets/js/jquery.1.4.2.min.js"></script>
    <script src="<?=base_url();?>assets/js/jquery.Jcrop.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/jcrop/main.css" type="text/css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/jcrop/demos.css" type="text/css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/jcrop/jquery.Jcrop.css" type="text/css" />

    <script type="text/javascript">

        $(function(){

            $('#cropbox').Jcrop({
                aspectRatio: 1,
                onSelect: updateCoords,
                onChange: showPreview,
            });

        });
        function showPreview(coords)
        {
            var rx = 100 / coords.w;
            var ry = 100 / coords.h;

            $('#preview').css({
                width: Math.round(rx * 500) + 'px',
                height: Math.round(ry * 370) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });
        }
        function updateCoords(c)
        {
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        };

        function checkCoords()
        {
            if (parseInt($('#w').val())) return true;
            alert('Please select a crop region then press submit.');
            return false;
        };

    </script>
    <style type="text/css">
        /* Apply these styles only when #preview-pane has
         been placed within the Jcrop widget */
        .jcrop-holder #preview-pane {
            display: block;
            position: absolute;
            z-index: 2000;
            top: 10px;
            right: -280px;
            padding: 6px;
            border: 1px rgba(0,0,0,.4) solid;
            background-color: white;

            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;

            -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
            box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        }

        /* The Javascript code will set the aspect ratio of the crop
           area based on the size of the thumbnail preview,
           specified here */
        #preview-pane .preview-container {
            width: 250px;
            height: 170px;
            overflow: hidden;
        }


    </style>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="jc-demo-box">

                <div class="page-header">
                    <ul class="breadcrumb first" style="display:none;">
                        <li><a href="../index.html">Jcrop</a> <span class="divider">/</span></li>
                        <li><a href="../index.html">Demos</a> <span class="divider">/</span></li>
                        <li class="active">Live Demo (Requires PHP)</li>
                    </ul>
                    <h1>请裁剪您的相片</h1>
                </div>

                <img src="<?=base_url()."uploads/".$pic;?>" id="cropbox" />

                <!-- This is the image we're attaching Jcrop to -->
                <!--
                <table>
                    <tr>
                        <td>
                            <img src="<?//=base_url()."uploads/".$pic;?>" id="cropbox" />
                        </td>
                        <td>
                            <div style="width:100px;height:100px;overflow:hidden;margin-left:5px;">
                                <img src="<?//=base_url()."uploads/".$pic;?>" id="preview" style="width: 500px; height: 370px; margin-left: -345px; margin-top: -159px;">
                            </div>

                        </td>
                    </tr>
                </table>
                -->
                        <!-- This is the form that our event handler fills -->
                    <form action="<?=base_url();?>index.php/signup/crop" method="post" onsubmit="return checkCoords();">
                        <input type="hidden" id="x" name="x" />
                        <input type="hidden" id="y" name="y" />
                        <input type="hidden" id="w" name="w" />
                        <input type="hidden" id="h" name="h" />
                        <input type="hidden" name="pic" value="<?=base_url()."uploads/".$pic;?>"/>
                        <input type="hidden" name="picname" value="<?=$pic;?>"/>
                        <input type="hidden" name="crop_token" value="<?=$crop_token;?>"/>
                        <input type="submit" value="裁剪头像" class="btn btn-large btn-inverse" />
                    </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
