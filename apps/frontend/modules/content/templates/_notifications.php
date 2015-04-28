<?php use_helper('Javascript'); ?>

<script src="//js.pusher.com/2.2/pusher.min.js"></script>
<script type="text/javascript">
    Pusher.log = function(message) {
        if (window.console && window.console.log) {
            window.console.log(message);
        }
    };

    var noteLifetime = <?php echo sfConfig::get('app_settings_member_notification_lifetime', 7000); ?>;
    var appKey = '<?php echo sfConfig::get("app_pusher_key"); ?>';
    var userId = <?php echo $sf_user->getId(); ?>;
    var authEndpoint = '<?php echo url_for('ajax/pusher'); ?>';

    var pusher = new Pusher(appKey, {
        authEndpoint: authEndpoint
    });

    var channel = pusher.subscribe('private-notifications-' + userId);
    channel.bind('notification', function(data) {
        show_notification(data, noteLifetime);
    });
</script>
