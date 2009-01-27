These are the best videos of the month, as decided by our members.<br />
The winner is <?php echo $members[0]->getFullName() ?> and she will get £200! Congratulations! <br /><br />
In order to participate in the contest, please upload your video on <a href="http://www.youtube.com" target="_blank" class="sec_link">YouTube.com</a> Write "Polish Romance" tags in the description field. Then copy the video link and paste it on your PolishRomance' <a href="/en/editProfile/photos.html" class="sec_link">Photos</a> page. Please also read <a href="/en/page/best_videos_rules.html" class="sec_link">Polish Romance's Video Contest Rules</a>.

<?php $i=1;foreach($members as $member): ?>
<div class="best_video">
    <div class="left">
        <object width="350" height="325">
            <param name="movie" value="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=1&color1=0x3a3a3a&color2=0x999999&border=0"></param>
            <param name="wmode" value="transparent"></param>
            <embed src="http://www.youtube.com/v/<?php echo $member->getYoutubeVid() ?>&rel=1&color1=0x3a3a3a&color2=0x999999&border=0" type="application/x-shockwave-flash" wmode="transparent" width="350" height="355"></embed>
        </object>    
    </div>
    <div class="right">
        <img src="/images/heart_<?php echo $i ?>.gif" alt="" />
         No. <?php echo $i ?> video of the month, <?php echo $member->getFullName() ?><br />
        <a href="/en/profiles/<?php echo $member->getUsername() ?>.html" class="sec_link">see member's profile</a>
    </div>
</div>
<?php $i++;endforeach; ?>

<div id="participate">
    How to participate. 
    <ul>
        <li>Create a video and upload it on <a href="http://www.youtube.com" target="_blank" class="sec_link">YouTube.com</a> or another video service. Write as much as you can in the description area of the video and make sure to include "Polish Romance" and/ or "PolishRomance.com".</li>
        <li>Copy the location of your video (the embedded URL) and copy it into the video field of your Photos page.</li>
        <li>Relax and wait, There is a chance you may win! </li>
    </ul>
    You are responsible for the content so please do not include anything inappropriate. We will report your video and it will be taken of YouTube or another provider. In addition your profile will be suspended and we may take a legal action against you.<br />
    Please read our <a href="/en/page/best_videos_rules.html" class="sec_link">Polish Romance's Video Contest Rules.</a><br /><br />
    Good Luck! 
</div>