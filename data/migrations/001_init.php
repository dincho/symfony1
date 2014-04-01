<?php

/**
 * Migrations between versions 000 and 001.
 */
class Migration001 extends sfMigration
{
    /**
    * Migrate up to version 001.
    */
    public function up()
    {
        $this->loadSql(dirname(__FILE__).'/001_init.sql');
    }

    /**
    * Migrate down to version 000.
    */
    public function down()
    {
        $this->executeSQL('SET FOREIGN_KEY_CHECKS=0');
    
        $this->executeSQL('DROP TABLE schema_info');
        $this->executeSQL('DROP TABLE session_storage');
        $this->executeSQL('DROP TABLE user');
        $this->executeSQL('DROP TABLE ipblock');
        $this->executeSQL('DROP TABLE ipwatch');
        $this->executeSQL('DROP TABLE ip_country');
        $this->executeSQL('DROP TABLE ip_location');
        $this->executeSQL('DROP TABLE ip_blocks');
        $this->executeSQL('DROP TABLE member');
        $this->executeSQL('DROP TABLE member_status');
        $this->executeSQL('DROP TABLE member_counter');
        $this->executeSQL('DROP TABLE member_note');
        $this->executeSQL('DROP TABLE member_login_history');
        $this->executeSQL('DROP TABLE member_rate');
        $this->executeSQL('DROP TABLE desc_question');
        $this->executeSQL('DROP TABLE desc_answer');
        $this->executeSQL('DROP TABLE member_desc_answer');
        $this->executeSQL('DROP TABLE search_crit_desc');
        $this->executeSQL('DROP TABLE member_photo');
        $this->executeSQL('DROP TABLE photo_exif_info');
        $this->executeSQL('DROP TABLE private_photo_permission');
        $this->executeSQL('DROP TABLE stock_photo');
        $this->executeSQL('DROP TABLE profile_view');
        $this->executeSQL('DROP TABLE block');
        $this->executeSQL('DROP TABLE subscription');
        $this->executeSQL('DROP TABLE subscription_details');
        $this->executeSQL('DROP TABLE subscription_history');
        $this->executeSQL('DROP TABLE member_status_history');
        $this->executeSQL('DROP TABLE thread');
        $this->executeSQL('DROP TABLE message');
        $this->executeSQL('DROP TABLE predefined_message');
        $this->executeSQL('DROP TABLE hotlist');
        $this->executeSQL('DROP TABLE wink');
        $this->executeSQL('DROP TABLE feedback');
        $this->executeSQL('DROP TABLE feedback_template');
        $this->executeSQL('DROP TABLE flag');
        $this->executeSQL('DROP TABLE suspended_by_flag');
        $this->executeSQL('DROP TABLE catalogue');
        $this->executeSQL('DROP TABLE trans_unit');
        $this->executeSQL('DROP TABLE trans_collection');
        $this->executeSQL('DROP TABLE msg_collection');
        $this->executeSQL('DROP TABLE static_page');
        $this->executeSQL('DROP TABLE static_page_domain');
        $this->executeSQL('DROP TABLE member_story');
        $this->executeSQL('DROP TABLE homepage_member_story');
        $this->executeSQL('DROP TABLE notification');
        $this->executeSQL('DROP TABLE notification_event');
        $this->executeSQL('DROP TABLE member_notification');
        $this->executeSQL('DROP TABLE pr_mail_message');
        $this->executeSQL('DROP TABLE pr_mail_sum');
        $this->executeSQL('DROP TABLE geo');
        $this->executeSQL('DROP TABLE geo_photo');
        $this->executeSQL('DROP TABLE geo_details');
        $this->executeSQL('DROP TABLE link');
        $this->executeSQL('DROP TABLE open_privacy');
        $this->executeSQL('DROP TABLE homepage_member_photo');
        $this->executeSQL('DROP TABLE member_subscription');
        $this->executeSQL('DROP TABLE member_payment');
        $this->executeSQL('DROP TABLE ipn_history');
        $this->executeSQL('DROP TABLE zong_history');
        $this->executeSQL('DROP TABLE dotpay_history');
        $this->executeSQL('DROP TABLE as_seen_on_logo');
        $this->executeSQL('DROP TABLE sf_setting');
        
        $this->executeSQL('SET FOREIGN_KEY_CHECKS=1');
    }
}
