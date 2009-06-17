<?php use_helper('Javascript') ?>
<div id="pager">
    <?php if ($pager->haveToPaginate()): ?>
        <?php $per_page = $pager->getMaxPerPage() ?>
        <?php echo form_tag(sfContext::getInstance()->getModuleName() . '/' . sfContext::getInstance()->getActionName(), array('method' => 'post', 'id' => 'per_page_form')) ?>
            <fieldset class="form_fields">
            <?php echo input_tag('per_page', $per_page) ?>
            <label for="per_page">per page</label>
            <?php echo link_to_function('&gt;&gt;', 'document.getElementById("per_page_form").submit();') ?>
            </fieldset>
        </form>    
        <span>Page</span>
        <?php foreach ($pager->getLinks(sfConfig::get('app_pager_default_pages')) as $page): ?>
        <?php echo link_to_unless($page == $pager->getPage(), $page, $route . '?page='.$page . '&per_page=' .$per_page . @$query_string) ?>
        <?php endforeach; ?>
        <div>
          <?php echo link_to('First', $route . '?page=1' . '&per_page=' .$per_page . @$query_string) ?>
          <?php echo link_to_unless($pager->getPage() == 1, 'Previous', $route . '?page='.$pager->getPreviousPage() . '&per_page=' .$per_page . @$query_string) ?>&nbsp;|
          <?php echo link_to_unless($pager->getPage() == $pager->getLastPage(), 'Next', $route . '?page='.$pager->getNextPage() . '&per_page=' .$per_page . @$query_string) ?>
          <?php echo link_to('Last', $route . '?page='.$pager->getLastPage() . '&per_page=' .$per_page . @$query_string) ?>
        </div>
    <?php endif; ?>
</div>