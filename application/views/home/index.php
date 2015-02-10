<div class="item-block vote-block">
    <label class="item-title">选手投票专区</label>
    <a class="more" href="<?=base_url();?>index.php/playerlist50">更多50选手&gt;&gt;</a>
    <ul class="playerlist">
        <? if(isset($playerlist) && $playerlist != ""){ ?>
        <? $n = 0; ?>
        <? foreach($playerlist as $k => $v){ ?>
        <? $n ++; ?>
        <li <?=($n%4==0)?"class=\"left\"":"";?>>
            <div class="player-avatar">
                <img src="<?=base_url()?>assets/images/rank-bg.png" />
                <img class="no" src="<?=base_url()?>assets/images/no<?=$n;?>.png" />
                <a href="<?=base_url()?>index.php/comment/index/<?=$v->id?>" class="comment" title="点我留言">
                    <img class="player-avatar-img" src="<?=base_url();?>assets/images/blank.png" data-original="<?=base_url()."uploads/".substr($v->pic, 0, strpos($v->pic, ".")) . "_crop_circle.png";?>" />
                </a>
            </div>
            <div class="player-intro">
                <label><?=$v->name_chi;?><span>&nbsp;/&nbsp;<?=$v->name_en;?></span></label>
                <span>选手编号：<?=str_pad($v->id, 4, '0', STR_PAD_LEFT);?></span>
                <p class="song">演唱歌曲：《<?=$v->song;?>》</p>
                <p>个人宣言：<?=$v->motto;?></p>
                <span>已有<label><?=$v->semifinals_vote;?></label>人为TA投票</span>
                <div><a class="play" href="<?=$v->link;?>"></a><span style="display:none;">03&quot;&nbsp;55&#39;</span></div>
            </div>
        </li>
        <? } ?>
        <? } ?>
    </ul>
</div>
<div class="item-block intro-block">
    <label class="item-title" id="intro">活动介绍</label>
    <img src="<?=base_url();?>assets/images/intro-details.png" />
</div>
<div class="section coop-section">
    <span class="section-title coop-title">合作伙伴</span>
    <div class="coop-wrapper">
        <img src="<?=base_url();?>assets/images/blank.png" data-original="<?=base_url();?>assets/images/coop.png" />
    </div>
</div>
<div class="section thanks-section">
    <span class="section-title thanks-title">特别鸣谢</span>
    <div class="thanks-wrapper">
        <img src="<?=base_url();?>assets/images/blank.png" data-original="<?=base_url();?>assets/images/thx.png" />
        <ul style="display:none;">
            <? //if(isset($thxlist) && $thxlist != ""){ ?>
            <? //$n = 0; ?>
            <? //foreach($thxlist as $k => $v){ ?>
            <? //$n ++; ?>
            <? //if($n < 6) { ?>
            <li <?//=($n==5)?"class=\"right\"":"";?>><img src="<?//=$v->pic;?>"/></li>
            <?// } ?>
            <?// } ?>
            <?// } ?>
        </ul>
        <ul style="display:none;">
            <?// if(isset($thxlist) && $thxlist != ""){ ?>
                <?// $n = 0; ?>
                <?// foreach($thxlist as $k => $v){ ?>
                    <?// $n ++; ?>
                    <?// if($n > 5) { ?>
                        <li <?//=($n==11)?"class=\"right\"":"";?>>
                            <a href="<?//=($v->link=="")?"javascript:void(0);":$v->link;?>">
                                <img src="<?//=base_url();?>assets/images/blank.png" data-original="<?//=$v->pic;?>"/></a></li>
                    <?// } ?>
                <?// } ?>
            <?// } ?>
        </ul>
    </div>
</div>