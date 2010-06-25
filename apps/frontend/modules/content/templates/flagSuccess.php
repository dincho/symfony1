<?php use_helper('dtForm') ?>
<?php echo form_tag('content/flag', array('id' => 'flag')) ?>
    <?php echo input_hidden_tag('username', $profile->getUsername(), array('class' => 'hidden')) ?>
    <?php if ( $sf_request->hasParameter('pager') ): ?>
      <?php echo input_hidden_tag('pager', 1, array('class' => 'hidden')) ?>
    <?php endif; ?>
    <div class="photo">
        <?php echo link_to(image_tag($profile->getMainPhoto()->getImg('100x100')), '@profile?username=' . $profile->getUsername()) ?><br />
        <?php echo link_to($profile->getUsername(), '@profile?username=' . $profile->getUsername(), 'class=sec_link') ?>
    </div>
    <div class="left">
        <?php echo pr_label_for('flag_category', __('Please tell us why you are flagging this member.')) ?>
        <fieldset>
            <?php foreach($flag_categories as $flag_cat): ?>
                <?php echo radiobutton_tag('flag_category', $flag_cat->getId(), false) ?>
                <?php echo pr_label_for('flag_category_' . $flag_cat->getId(), __($flag_cat->getTitle())) ?><br />
            <?php endforeach; ?>
          <br />
            <?php if( sfConfig::get('app_settings_flags_comment_field') ): ?>
          <span><?php echo __('(type an optional comment below)') ?></span><br />
            <?php echo textarea_tag('comment', null, array('rows' => 4, 'cols' => '70', 'class' => 'text_area')) ?>
          <br /><br /><br />
            <?php endif; ?>
            <?php echo link_to(__('Cancel and go back to previous page'), $sf_data->getRaw('sf_user')->getRefererUrl(), array('class' => 'sec_link_small')) ?><br />
            <?php echo submit_tag(__('Submit'), array('class' => 'button' ))?>
        </fieldset>
    </div>
</form>