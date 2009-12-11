<?php use_helper('Javascript') ?>
<div id="pager">
        <?php echo form_tag(sfContext::getInstance()->getModuleName() . '/' . sfContext::getInstance()->getActionName(), array('method' => 'post', 'id' => 'per_page_form')) ?>
            <fieldset class="form_fields">
            <?php echo input_tag('per_page', $limit) ?>
            <label for="per_page">per page</label>
            <?php echo link_to_function('&gt;&gt;', 'document.getElementById("per_page_form").submit();') ?>
            </fieldset>
        </form>    

        <div>
          <?php echo link_to_unless($page == 1, 'Previous', $route . '?page='.($page-1) . '&per_page='.$limit) ?>&nbsp;|
          <?php echo link_to('Next', $route . '?page='.($page+1) . '&per_page='.$limit) ?>
        </div>
</div>