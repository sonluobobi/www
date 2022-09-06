<?php
namespace entity;

class Group{
	
	const TABLE_NAME = 'gm_usergroup';
	
	  /**
         * 组ID
         * @var Int
         */
        public $groupId   = 'groupId';

        /**
         * 组名字
         * @var String
         */
        public $groupName = 'groupName';

        /**
         * 组表示
         * @var varchar
         */
        public $flag      = 'flag';

        /**
         * 语言选项
         * @var String
         */
        public $languages = 'languages';	
}
