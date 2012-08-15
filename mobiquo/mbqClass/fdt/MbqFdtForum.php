<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum module field definition class
 * 
 * @since  2012-7-18
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqFdtForum extends MbqBaseFdt {
    
    public static $df = array(
        'MbqEtForum' => array(
            'parentRootForumId' => -1,   /* if parent fourm is root forum,then return this value */
            
            'newPost' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isProtected' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isSubscribed' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canSubscribe' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'subOnly' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canPost' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'unreadStickyCount' => array(
                'default' => 0
            ),
            'unreadAnnounceCount' => array(
                'default' => 0
            ),
            'requirePrefix' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canUpload' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            )
        ),
        'MbqEtForumTopic' => array(
            'state' => array(
                'range' => array(
                    'postOk' => 0,
                    'postOkNeedModeration' => 1
                )
            ),
            'isSubscribed' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canSubscribe' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isClosed' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'newPost' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canUpload' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canThank' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canLike' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isLiked' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canDelete' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isDeleted' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canApprove' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isApproved' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canStick' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isSticky' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canClose' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canRename' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canMove' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canReply' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            )
        ),
        'MbqEtForumPost' => array(
            'state' => array(
                'range' => array(
                    'postOk' => 0,
                    'postOkNeedModeration' => 1
                )
            ),
            'isOnline' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canEdit' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canDelete' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'allowSmilies' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canThank' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canLike' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isLiked' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canDelete' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isDeleted' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canApprove' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'isApproved' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            ),
            'canMove' => array(
                'range' => array(
                    'yes' => true,
                    'no' => false
                )
            )
        )
    );
  
}
MbqBaseFdt::$df['MbqFdtForum'] = &MbqFdtForum::$df;

?>