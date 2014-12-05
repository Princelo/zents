<?=$error;?>

<div class="uploadform">
    <?=form_open_multipart('signup/do_upload');?>
    <input type="file" name="userfile" size="20" /><label>允许上传类型: jpg; 文件大小不得超过500KB。</label>
    <br /><br />
    <input type="submit" value="上传" />
    </form>
</div>
