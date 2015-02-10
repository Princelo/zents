<!-- begin: #col3 static column -->
<div id="col3" role="main" class="one_column">
    <div id="col3_content" class="clearfix">



        <div class="toolbar type-button">
            <span class="red">
                <?=$this->session->flashdata('flashdata', 'value');?>
            </span>
            <div class="c50l">
                <h3><?=($error!="")?"<span style=\"color:red\">".$error."</span>":"选手编辑(".$v->name_chi.")";?> </h3>
            </div>
        </div>


        <form action="<?=base_url()?>index.php/unvadmin/singerupdate" method="post">

            <fieldset>
                <legend>选手编辑 </legend>

                <table>
                    <col width="150">

                    <tr>
                        <th><label for="the_date">ID </label></th>
                        <td><input type="text" name="" value="<?=str_pad($v->id, 4, '0', STR_PAD_LEFT);?>" disabled="disabled"  />
                            <input type="hidden" name="id" value="<?=$v->id;?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="type">姓名(中) </label></th>
                        <td>
                            <input name="name_chi" value="<?=$v->name_chi;?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="type">姓名(英) </label></th>
                        <td>
                            <input name="name_en" value="<?=$v->name_en;?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>原始相片</th>
                        <td><img width="" height="120" src="<?=base_url()."uploads/".$v->pic;?>" />
                        <a href="<?=base_url()."index.php/unvadmin/crop/".$v->id;?>">现在裁剪</a></td>
                    </tr>
                    <tr>
                        <th>裁剪相片（方）</th>
                        <td>
                            <?=file_exists(substr($v->avatardir, 0, strpos($v->avatardir, ".")). "_crop.png")
                                ?"<img width=\"100\" src=\"".base_url()."uploads/".
                                substr($v->pic, 0, strpos($v->pic, "."))."_crop.png\" />":"未裁剪";?>
                        </td>
                    </tr>
                    <tr>
                        <th>裁剪相片（圆）</th>
                        <td>
                            <?=file_exists(substr($v->avatardir, 0, strpos($v->avatardir, ".")). "_crop_circle.png")
                                ?"<img width=\"100\" src=\"".base_url()."uploads/".
                                substr($v->pic, 0, strpos($v->pic, "."))."_crop_circle.png\" />":"未裁剪";?>
                        </td>
                    </tr>
                    <tr>
                        <th>电话</th>
                        <td><input name="prcid" value="<?=$v->tel;?>" /></td>
                    </tr>
                    <tr>
                        <th>身份证</th>
                        <td><input name="prcid" value="<?=$v->prcid;?>" /></td>
                    </tr>
                    <tr>
                        <th>年龄</th>
                        <td><input name="age" value="<?=$v->age;?>" /></td>
                    </tr>
                    <tr>
                        <th>地址</th>
                        <td><input name="address" value="<?=$v->address;?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="remarks">唱吧地址 </label></th>
                        <td><textarea name="link" cols="50" rows="6" id="remarks" size="20" ><?=$v->link?></textarea><br />
                        <a href="<?=$v->link?>" target="_blank">LINK</a>
                        </td>
                    </tr>
                    <tr>
                        <th>票数</th>
                        <td><input disabled="disabled" value="<?=$v->vote;?>" /></td>
                    </tr>
                    <tr>
                        <th>50强票数</th>
                        <td><input disabled="disabled" value="<?=$v->semifinals_vote;?>" /></td>
                    </tr>


                    <tr>
                        <th><label for="remarks">個人宣言 </label></th>
                        <td><textarea name="motto" cols="50" rows="6" id="remarks" size="20" ><?=$v->motto?></textarea></td>
                    </tr>
                    <tr>
                        <th>排序权重<br />
                            数字越大排序越前</th>
                        <td><input name="sort" value="<?=$v->sort;?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="time_slot">审核 <span>*</span></label></th>
                        <td><select name="is_valid" id='time_slot'>
                                <option value="1" <?=($v->is_valid==1)?"selected=\"selected\"":"";?>>通过</option>
                                <option value="0" <?=($v->is_valid==0)?"selected=\"selected\"":"";?>>待审核</option>
                            </select></td>
                    </tr>
                </table>

            </fieldset>


            <div class="toolbar type-button">
                <div class="c50l">
                    <input type="submit" name="btnSubmit" value="提交 "  />			</div>
                <div class="c50r right">
                </div>
            </div>


        </form>

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
