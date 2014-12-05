<!-- begin: #col3 static column -->
<div id="col3" role="main" class="one_column">
    <div id="col3_content" class="clearfix">



        <div class="toolbar type-button">
            <div class="c50l">
                <h3>幻灯片编辑 </h3>
            </div>
        </div>


        <form action="<?=base_url()?>index.php/unvadmin/flashupdate" method="post">

            <fieldset>
                <legend>幻灯片编辑 </legend>

                <table>
                    <col width="150">

                    <input type="hidden" name="id" value="<?=$v->id;?>" />
                    <tr>
                        <th><label for="type">跳转地址</label></th>
                        <td>
                            <input name="url" value="<?=$v->url;?>" />
                        </td>
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
