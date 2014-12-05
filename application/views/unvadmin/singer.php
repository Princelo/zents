<!-- begin: #col3 static column -->
<div id="col3" role="main" class="one_column">
    <div id="col3_content" class="clearfix">


        <div class="info view_form">
            <h2>选手  管理 </h2>
            <table width="70%">
                <!--<col width="50%">
                <col width="50%">-->
                <tr>
                    <th>搜索<br/>
                        姓名或歌曲
                    </th>
                    <form action="<?=base_url()?>index.php/unvadmin/singer" method="post">
                    <td><input type="text" name="search" value=""  /><input type="submit" />
                        &nbsp;&nbsp;<a href="<?=base_url();?>index.php/unvadmin/<?=($valid=='all')?"invalid":"singer";?>"><?=($valid=='all')?"未审核会员":"全部会员";?></a>
                    </td>
                    </form>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>NAME</td>
                    <td>SONG</td>
                    <td>唱吧链接</td>
                    <td>票数</td>
                    <td>审核</td>
                    <td>进入管理</td>
                    <td>刪除</td>
                </tr>
                <? foreach($playerlist as $k => $v){ ?>
                <tr>
                    <th><?=str_pad($v->id, 4, '0', STR_PAD_LEFT);?></th>
                    <td><?=$v->name_chi;?></td>
                    <td style="display:none;"><img style="display:none;" src="<?//=substr($v->pic, 0, strpos($v->pic, ".jp"))."_crop.png";?>"</td>
                    <th><?=$v->song;?></th>
                    <td><a href="<?=$v->link;?>" target="_blank">打开</a> </td>
                    <th><?=$v->vote;?></th>
                    <td><?=($v->is_valid == 1)?"通过":"待审核";?></td>
                    <th><a href="<?=base_url()?>index.php/unvadmin/singeredit/<?=$v->id;?>">EDIT</a></th>
                    <td><a onclick="myconfirm(<?=$v->id;?>);" href="#">DELETE</a></td>
                </tr>
                <? } ?>
            </table>
            <div class="page"><?=$page;?></div>
            <script>
                function myconfirm(id){
                    if (confirm("are you sure?")){
                        window.location.href = "<?=base_url()?>index.php/unvadmin/singerdelete/"+id;
                    } else {

                    }
                }
            </script>


        </div>



        <div class="">
            <h2></h2>


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