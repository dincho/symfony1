<?php echo __("Oops. You have abandoned the payment process.", array('%URL_FOR_PAYMENT%' => url_for('subscription/payment?subscription_id='. $sf_request->getParameter('subscription_id')))); ?>
