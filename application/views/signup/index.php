<script>
    function confirmSubmit(){
        $("form").verify();
        if(confirm("请确保您的信息准确无误，若资料不完整，可能审核不会通过。若信息填写无误，请点击确认提交，若需要重新填写，请点击取消"))
            $("form").submit();
        else
            return false;
    }
</script>
<div class="error-msg">
<?= $error; ?>
</div>
<div class="signup-form">
    <?=form_open_multipart('signup/add');?>
    <ul>
        <li><span class="input-span">姓名.Name</span><input name="name_chi" data-validate="required"/></li>
        <li><span class="input-span">英文名.English Name</span><input name="name_en" data-validate="required"/></li>
        <li><span class="input-span">年龄.Age</span><input name="age" data-validate="required,number" maxlength="2"/></li>
        <li><span class="input-span">联系电话.Telephone Number</span><input name="tel" data-validate="required" maxlength="20"/></li>
        <li><span class="input-span">身份证号码.ID Card Number</span><input class="long" name="prcid" data-validate="required" maxlength="18"/></li>
        <li><span class="input-span">通讯地址.Address</span><input class="long" name="address" data-validate="required"/></li>
        <li><span class="input-span">个人参赛宣言.The slogan</span><input class="long" name="motto" maxlength="12"/></li>
        <li><span class="input-span">个人照片.Photo</span><input name="userfile" value="上传" onclick="//alert('upload')" type="file" class="" data-validate="required"/>
            <label>允许上传jpg图片，大小限制在500KB內</label></li>
        <li><span class="input-span">演唱歌曲.Song</span><input name="song" data-validate="required"/></li>
        <li><span class="input-span">唱吧链连.Changba Link</span><input name="link" data-validate="required"/><a class="changba tutorial" href="<?=base_url()?>assets/images/tutorial.jpg"></a></li>
    </ul>
    <input type="hidden" name="token" value="<?=$token;?>"/>
    <input type="hidden" name="pic" />
    <input class="submit" type="button" value="确认提交" onClick="confirmSubmit();"/>
    <?=form_close();?>
</div>
