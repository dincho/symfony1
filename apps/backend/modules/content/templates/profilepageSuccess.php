<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/profilepage', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Profile Page</div>
    <fieldset class="form_fields" id="labels_120">
        <div class="float-right">
            <label for="profile_max_photos">Display Photos</label>
            <?php echo input_tag('profile_max_photos', sfSettingPeer::valueForCatalogAndName($catalog, 'profile_max_photos'), array('class' => 'mini')) ?><br />

            <label for="profile_num_recent_messages">Display Recent Activities</label>
            <?php echo input_tag('profile_num_recent_activities', sfSettingPeer::valueForCatalogAndName($catalog, 'profile_num_recent_activities'), array('class' => 'mini')) ?><br />

            <label for="profile_display_video">Display Video</label>
            <?php echo bool_select_tag('profile_display_video', array(), sfSettingPeer::valueForCatalogAndName($catalog, 'profile_display_video')) ?><br />
        </div>
        <label for="trans_8">Message Panel<br />Signup Preview</label>
        <?php echo textarea_tag('trans[8]', (isset($trans[8])) ? $trans[8]->getTarget() : null, array('cols' => 60, 'rows' => 9)) ?><br />

        <label for="trans_9">Message Panel<br />Full View from dashboard</label>
        <?php echo textarea_tag('trans[9]', (isset($trans[9])) ? $trans[9]->getTarget() : null, array('cols' => 60, 'rows' => 9)) ?><br />
    </fieldset>

    <fieldset class="form_fields error_msgs_fields" id="labels_120">
        <label style="width: 120px;">Error Messages</label>
        <?php echo input_tag('trans[10]', (isset($trans[10])) ? $trans[10]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[79]', (isset($trans[79])) ? $trans[79]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[80]', (isset($trans[80])) ? $trans[80]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[83]', (isset($trans[83])) ? $trans[83]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[85]', (isset($trans[85])) ? $trans[85]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[119]', (isset($trans[119])) ? $trans[119]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[135]', (isset($trans[135])) ? $trans[135]->getTarget() : null) ?><br />

        <br /><label style="width: 120px;">To Standard members</label><br />
        <label></label><?php echo input_tag('trans[137]', (isset($trans[137])) ? $trans[137]->getTarget() : null) ?><br />
        <label>upg. to use</label><?php echo input_tag('trans[86]', (isset($trans[86])) ? $trans[86]->getTarget() : null) ?><br />
        <label>upg. to send</label><?php echo input_tag('trans[124]', (isset($trans[124])) ? $trans[124]->getTarget() : null) ?><br />
        <label>send limit</label><?php echo input_tag('trans[125]', (isset($trans[125])) ? $trans[125]->getTarget() : null) ?><br />
        <label>upg. to read</label><?php echo input_tag('trans[77]', (isset($trans[77])) ? $trans[77]->getTarget() : null) ?><br />
        <label>read limit</label><?php echo input_tag('trans[78]', (isset($trans[78])) ? $trans[78]->getTarget() : null) ?><br />
        <label>upg. to reply</label><?php echo input_tag('trans[81]', (isset($trans[81])) ? $trans[81]->getTarget() : null) ?><br />
        <label>reply limit</label><?php echo input_tag('trans[82]', (isset($trans[82])) ? $trans[82]->getTarget() : null) ?><br />
        <label>upg. to post upl.</label><?php echo input_tag('trans[115]', (isset($trans[115])) ? $trans[115]->getTarget() : null) ?><br />
        <label>post photo limit</label><?php echo input_tag('trans[116]', (isset($trans[116])) ? $trans[116]->getTarget() : null) ?><br />
        <label>upg. to see view.</label><?php echo input_tag('trans[84]', (isset($trans[84])) ? $trans[84]->getTarget() : null) ?><br />
        <label>upg. to cont. assist.</label><?php echo input_tag('trans[87]', (isset($trans[87])) ? $trans[87]->getTarget() : null) ?><br />
        <label>cont. assist. limit</label><?php echo input_tag('trans[88]', (isset($trans[88])) ? $trans[88]->getTarget() : null) ?><br />
        <label>upg. to wink</label><?php echo input_tag('trans[117]', (isset($trans[117])) ? $trans[117]->getTarget() : null) ?><br />
        <label>wink limit</label><?php echo input_tag('trans[118]', (isset($trans[118])) ? $trans[118]->getTarget() : null) ?><br />

        <br /><label style="width: 120px;">To Premium members</label><br />
        <label>upg. to send</label><?php echo input_tag('trans[157]', (isset($trans[157])) ? $trans[157]->getTarget() : null) ?><br />
        <label>send limit</label><?php echo input_tag('trans[158]', (isset($trans[158])) ? $trans[158]->getTarget() : null) ?><br />
        <label>upg. to read</label><?php echo input_tag('trans[153]', (isset($trans[153])) ? $trans[153]->getTarget() : null) ?><br />
        <label>read limit</label><?php echo input_tag('trans[154]', (isset($trans[154])) ? $trans[154]->getTarget() : null) ?><br />
        <label>upg. to reply</label><?php echo input_tag('trans[155]', (isset($trans[155])) ? $trans[155]->getTarget() : null) ?><br />
        <label>reply limit</label><?php echo input_tag('trans[156]', (isset($trans[156])) ? $trans[156]->getTarget() : null) ?><br />
        <label>upg. to post upl.</label><?php echo input_tag('trans[159]', (isset($trans[159])) ? $trans[159]->getTarget() : null) ?><br />
        <label>post photo limit</label><?php echo input_tag('trans[160]', (isset($trans[160])) ? $trans[160]->getTarget() : null) ?><br />
        <label>upg. to see view.</label><?php echo input_tag('trans[161]', (isset($trans[161])) ? $trans[161]->getTarget() : null) ?><br />
        <label>upg. to cont. assist.</label><?php echo input_tag('trans[162]', (isset($trans[162])) ? $trans[162]->getTarget() : null) ?><br />
        <label>cont. assist. limit</label><?php echo input_tag('trans[163]', (isset($trans[163])) ? $trans[163]->getTarget() : null) ?><br />
        <label>upg. to wink</label><?php echo input_tag('trans[164]', (isset($trans[164])) ? $trans[164]->getTarget() : null) ?><br />
        <label>wink limit</label><?php echo input_tag('trans[165]', (isset($trans[165])) ? $trans[165]->getTarget() : null) ?><br />

        <br /><label style="width: 120px;">To VIP members</label><br />
        <label>upg. to send</label><?php echo input_tag('trans[126]', (isset($trans[126])) ? $trans[126]->getTarget() : null) ?><br />
        <label>send limit</label><?php echo input_tag('trans[127]', (isset($trans[127])) ? $trans[127]->getTarget() : null) ?><br />
        <label>upg. to read</label><?php echo input_tag('trans[120]', (isset($trans[120])) ? $trans[120]->getTarget() : null) ?><br />
        <label>read limit</label><?php echo input_tag('trans[121]', (isset($trans[121])) ? $trans[121]->getTarget() : null) ?><br />
        <label>upg. to reply</label><?php echo input_tag('trans[122]', (isset($trans[122])) ? $trans[122]->getTarget() : null) ?><br />
        <label>reply limit</label><?php echo input_tag('trans[123]', (isset($trans[123])) ? $trans[123]->getTarget() : null) ?><br />
        <label>upg. to post upl.</label><?php echo input_tag('trans[128]', (isset($trans[128])) ? $trans[128]->getTarget() : null) ?><br />
        <label>post photo limit</label><?php echo input_tag('trans[129]', (isset($trans[129])) ? $trans[129]->getTarget() : null) ?><br />
        <label>upg. to see view.</label><?php echo input_tag('trans[130]', (isset($trans[130])) ? $trans[130]->getTarget() : null) ?><br />
        <label>upg. to cont. assist.</label><?php echo input_tag('trans[131]', (isset($trans[131])) ? $trans[131]->getTarget() : null) ?><br />
        <label>cont. assist. limit</label><?php echo input_tag('trans[132]', (isset($trans[132])) ? $trans[132]->getTarget() : null) ?><br />
        <label>upg. to wink</label><?php echo input_tag('trans[133]', (isset($trans[133])) ? $trans[133]->getTarget() : null) ?><br />
        <label>wink limit</label><?php echo input_tag('trans[134]', (isset($trans[134])) ? $trans[134]->getTarget() : null) ?><br />
    </fieldset>

    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/profilepages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
    <?php include_component('content', 'bottomMenu', array('url' => 'content/profilepage', 'multiCatalogs' => true, 'catId' => $catalog->getCatId()))?>
</form>
