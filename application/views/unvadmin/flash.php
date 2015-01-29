<!-- begin: #col3 static column -->
<script>
    function confirmSubmit(){
        $("form").verify();
        $("form").submit();
    }
</script>
<div id="col3" role="main" class="one_column">
    <div id="col3_content" class="clearfix">


        <div class="info view_form">
            <h2>幻灯片  管理 </h2><h1 style="color:#f00;"><?=$error;?></h1>
            <span class="red">
                <?=$this->session->flashdata('flashdata', 'value');?>
            </span>
            <table width="70%">
                <!--<col width="50%">
                <col width="50%">-->
                <tr>
                    <td>ID</td>
                    <td>LINK</td>
                    <td>PIC</td>
                    <td>编辑</td>
                    <td>刪除</td>
                </tr>
                <? $n = 0; ?>
                <? foreach($flashlist as $k => $v){ ?>
                    <? $n ++ ?>
                    <tr <?=($n%2==0)?"class=\"even\"":"class=\"odd\""?>>
                        <td><?=$v->id;?></td>
                        <td><?=$v->url;?><br />
                            <a href="<?=($v->url=="")?"javascript:void(0);":$v->url;?>" target="_blank">LINK</a>
                        </td>
                        <td><img src="<?=$v->pic;?>" width="200" /></td>
                        <td><a href="<?=base_url()?>index.php/unvadmin/flashedit/<?=$v->id;?>">EDIT</a></td>
                        <td><a onclick="myconfirm(<?=$v->id;?>);" href="#">DELETE</a></td>
                    </tr>
                <? } ?>
            </table>
            <style> tr.odd{background:#f6f6f6;}</style>
            <script>
                function myconfirm(id){
                    if (confirm("are you sure?")){
                        window.location.href = "<?=base_url()?>index.php/unvadmin/flashdelete/"+id;
                    } else {

                    }
                }
            </script>

            <h2>添加幻灯片</h2>
            <?=form_open_multipart('unvadmin/flashadd');?>
            <table>
                <tr>
                    <th>图片上传<br />允许类型jpg, 尺寸建议为985x361</th>
                    <td><input name="userfile" value="上传" onclick="//alert('upload')" type="file" class="" data-validate="required" /></td>
                </tr>
                <tr>
                    <th>幻灯片跳转地址<br />留空则不跳转</th>
                    <td><input name="url" valeu="" /></td>
                </tr>
                <input type="hidden" name="token" value="<?=$token;?>" />
            </table>
            <div></div>


        </div>

        <div class="toolbar type-button">
            <div class="c50l">
                <input type="submit" name="btnSubmit" value="提交 " onClick="confirmSubmit();" />			</div>
            <div class="c50r right">
            </div>
        </div>

        <?=form_close();?>

        </div>
        <style>
            .toolbar.type-button .c50l input{
            background: #536474;
            border: 1px solid #999;
            padding: 10px 20px;
            color: #fff;
            margin-top: 0;
            }
        </style>


        <div class="">
        </div>
    </div>
    <!-- IE Column Clearing -->
    <div id="ie_clearing">&nbsp;</div>
    <!--
            <script>
                $(document).ready(function(){
                    Calendar.setup({
                        weekNumbers   : true,
                        fdow		: 0,
                        inputField : 'end_time',
                        trigger    : 'end_time-trigger',
                        onSelect   : function() { this.hide() }
                    });

                });

            </script>

        : IE Column Clearing -->
</div>
<!-- end: #col4 -->	</div>

<div id="footer">
    Copyright &copy; <?=date('Y');?> by UNVWEB<br/>
    All Rights Reserved.<br/>
</div><!-- footer -->
</body>
</html>