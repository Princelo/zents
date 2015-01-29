<div class="comment-block">
   <div class="comment-top"></div>
   <div class="comment-wrapper" >
       <div class="comment-content">
           <div class="comment-list">
               <div class="comment-title comment-list-title">互动</div>
               <ul>
                   <? $n = 0; ?>
                   <? foreach($commentlist as $k => $v) {?>
                   <? $n ++; ?>
                   <li <?=$n%2==0?'':'class="odd"';?>>
                       <label class="floor"><?=$v->floor?>楼</label>
                       <p class="comment-details">
                           <strong>·<?=$v->name?>说：</strong><?=$v->content?>
                       </p>
                       <span><?=$v->time?></span>
                   </li>
                   <? } ?>
               </ul>
           </div>
           <div class="comment-action">
               <?=form_open("comment/add/{$id}");?>
               <div class="comment-title comment-action-title">发言</div>
               <div class="comment-action-input">
                   <div class="comment-action-input-name">
                       昵称: <input name="name" value="" data-validate="required" size="20" maxlength="50"/>
                       E-mail: <input name="email" value="" data-validate="required,email" size="20" maxlength="50"/>
                   </div>
                   <textarea name="content" data-validate="required"></textarea>
               </div>
               <div class="comment-action-btn">
                   <input type="reset" value="重置" />
                   <input type="submit" value="提交" />
               </div>
               <?=form_close();?>
           </div>
           <div class="comment-myad">
               <img src="<?=base_url()?>assets/images/comment-myad1.jpg" />
               <img src="<?=base_url()?>assets/images/comment-myad2.jpg" />
           </div>
       </div>
   </div>
</div>
