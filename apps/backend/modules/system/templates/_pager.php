<?php use_helper('Javascript') ?>
<div id="pager">
    <?php if ($pager->haveToPaginate()): ?>
        <?php echo form_tag(sfContext::getInstance()->getModuleName() . '/' . sfContext::getInstance()->getActionName(), array('method' => 'get', 'id' => 'per_page_form')) ?>
            <fieldset class="form_fields">
            <?php echo input_tag('per_page', ( $sf_request->getParameter('per_page', 0) <= 0 ) ? sfConfig::get('app_pager_default_per_page') : $sf_request->getParameter('per_page')) ?>
            <label for="per_page">per page</label>
            <?php echo link_to_function('&gt;&gt;', 'document.getElementById("per_page_form").submit();') ?>
            </fieldset>
        </form>    
        <span>Page</span>
        <?php foreach ($pager->getLinks(sfConfig::get('app_pager_default_pages')) as $page): ?>
        <?php echo link_to_unless($page == $pager->getPage(), $page, $route . '?page='.$page . @$query_string) ?>
        <?php //echo ($page != $pager->getCurrentMaxLink()) ? '' : '' ?>
        <?php endforeach; ?>
        <div>
          <?php echo link_to('First', $route . '?page=1' . @$query_string) ?>
          <?php echo link_to('Previous', $route . '?page='.$pager->getPreviousPage() . @$query_string) ?>&nbsp;|
          <?php echo link_to('Next', $route . '?page='.$pager->getNextPage() . @$query_string) ?>
          <?php echo link_to('Last', $route . '?page='.$pager->getLastPage(). @$query_string) ?>
        </div>
    <?php endif; ?>
</div>