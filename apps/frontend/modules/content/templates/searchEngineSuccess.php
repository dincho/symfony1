<?php use_helper('I18N');?>

<?php echo link_to(__('Click here to return to My Polish Love'), '@homepage');?>
<br />

<?php foreach ($pager->getResults() as $member):?>
<?php echo link_to(Tools::truncate($member->getEssayHeadline(), 40), '@profile?username=' . $member->getUsername()) ?> <br />
<?php endforeach;?>
<?php echo link_to('['.__('More').']', '@search_engine?page='.$pager->getNextPage());?>


