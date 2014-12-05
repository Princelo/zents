<? $v = $playerinfo; ?>
<? $avatar = base_url()."uploads/".substr($v->pic, 0, strpos($v->pic, ".jp")) . "_crop_circle.png"; ?>
<div class="vote-details-block">
<div class="vote-details">
    <div class="player-avatar">
        <img class="player-avatar-img" src="<?//=$avatar;?>" />
    </div>
    <div class="player-intro">
        <label><?=$v->name_chi;?><span>&nbsp;/&nbsp;<?=$v->name_en;?></span></label>
        <p class="song">演唱歌曲：《<?=$v->song;?>》</p>
        <p>个人宣言：<?=$v->motto;?></p>
        <span>已有<label><?=$v->vote;?></label>为TA投票</span>
        <?=form_open("dovote/index");?>
        <div class="captcha-box">
            <?=$captcha;?><br />
            <label>请输入验证码:</label>
            <input type="text" name="captcha" value="" /><br /><br />
            <input type="hidden" name="id" value="<?=$v->id;?>" />
            <input type="hidden" name="vote_token" value="<?=$vote_token;?>" />
        </div>

        <input type="submit" value="为TA投票" />
        <?=form_close()?>
    </div>
</div>
</div>
<script>
    var avatar = "<?=$avatar;?>";
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
        $(".player-avatar-img").attr("src", avatar.replace('_circle', ''));
    }else{
        $(".player-avatar-img").attr("src", avatar);
    }
</script>
