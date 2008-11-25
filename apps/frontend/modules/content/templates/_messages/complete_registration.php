<?php slot('header_title') ?>
    <?php echo __('Complete Registration') ?>
<?php end_slot(); ?>
<?php                            
$member = $sf_user->getProfile();
//take decision on witch step is the registration procces
if (! $member->getFirstName()) //1. Step 1 - registration
{
    $url = 'registration/index';
} elseif (! $member->getBirthDay()) //2. Step 2 - self description 
{
    $url = 'registration/selfDescription';
} elseif (! $member->getEssayHeadline()) //3. Step - essay 
{
    $url = 'registration/essay';
} elseif ($member->countMemberPhotos() <= 0) //Step 4 - Photos
{
    $url = 'registration/photos';
} elseif ( $member->mustFillIMBRA() ) //Step 5 - IMBRA (if US citizen)
{
    $url = 'IMBRA/index';
} else {
    throw new sfException('Unknown registration step');
}
?>

<?php echo __('Welcome back. You may finish your registration <a href="{REGISTRATION_URL}" class="sec_link">here</a>.', array('{REGISTRATION_URL}' => url_for($url))) ?>