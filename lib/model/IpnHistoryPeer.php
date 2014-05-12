<?php

/**
 * Subclass for performing query and update operations on the 'ipn_history' table.
 *
 *
 *
 * @package lib.model
 */
class IpnHistoryPeer extends BaseIpnHistoryPeer
{
    public static function retreiveByTxnID($id)
    {
        $c = new Criteria();
        $c->add(IpnHistoryPeer::TXN_ID, $id);

        return IpnHistoryPeer::doSelectOne($c);
    }
}
