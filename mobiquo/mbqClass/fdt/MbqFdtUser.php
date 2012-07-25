<?php

defined('MBQ_IN_IT') or exit;

/**
 * user module field definition class
 * 
 * @since  2012-7-18
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqFdtUser extends MbqBaseFdt {
    
    public static $df = array(
        'MbqEtUser' => array(
            'canPm' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canSendPm' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canModerate' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canSearch' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canWhosonline' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canUploadAvatar' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isOnline' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'acceptPm' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'iFollowU' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'uFollowMe' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'acceptFollow' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canBan' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isBan' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canMarkSpam' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isSpam' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            )
        )
    );
  
}
MbqBaseFdt::$df['MbqFdtUser'] = &MbqFdtUser::$df;

?>