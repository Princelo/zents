<?php
//debug($page);
//debug($playerlist);
$this->load->helper('cookie');
function is_voted($id, $votedlist){
    if(in_array($id, $votedlist))
        return true;
    if(get_cookie('voted'.$id) == '1')
        return true;
}
?>

<div class="item-block playerlist-details">
<div class="search-block">
    <form action="<?=base_url();?>index.php/playerlist/index" method="post">
    <label>选手搜索：</label>
    <input name="search" placeholder="请输入选手姓名或编号" />
    <input type="submit" value="SEARCH" />
    </form>
</div>
<label class="item-title">选手投票专区</label>
<ul class="playerlist-details-ul">
    <? if(isset($playerlist) && $playerlist != ""){ ?>
        <? $n = 0; ?>
        <? foreach($playerlist as $k => $v){ ?>
            <? $n ++; ?>
            <li <?=($n%4==0)?"class=\"left\"":"";?>>
                <div class="player-avatar">
                    <img style="display:none;" src="<?=base_url()?>assets/images/rank-bg.png" />
                    <img style="display:none;" class="no" src="<?=base_url()?>assets/images/no<?=$n;?>.png" />
                    <img class="player-avatar-img" src="<?=base_url();?>assets/images/blank.png" data-original="<?=base_url()."uploads/".substr($v->pic, 0, strpos($v->pic, ".")) . "_crop_circle.png";?>" />
                </div>
                <div class="player-intro">
                    <label><?=$v->name_chi;?><span>&nbsp;/&nbsp;<?=$v->name_en;?></span></label>
                    <span>选手编号：<?=str_pad($v->id, 4, '0', STR_PAD_LEFT);?></span>
                    <p class="song">演唱歌曲：《<?=$v->song;?>》</p>
                    <p>个人宣言：<?=$v->motto;?></p>
                    <span>已有<label><?=$v->vote;?></label>人为TA投票</span>
                    <div><a class="play" href="<?=$v->link;?>" ></a>
                        <? $is_voted = is_voted($v->id, $votedlist); ?>
                        <a class="<?=($is_voted)?"yes":"vote";?>" href="<?=($is_voted)?"javascript:void(0);":base_url()."index.php/vote/index/".$v->id;?>"></a></div>
                </div>
            </li>
        <? } ?>
    <? } ?>
</ul>
<div style="clear:both"></div>
<div class="page"><?=$page;?></div>
</div>
<div style="clear:both"></div>
