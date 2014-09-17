<?php
 
class m140912_084909_auth_Fdm2Dimension2 extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.Fdm2Dimension2.*','0','D2fixr.Fdm2Dimension2',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.Fdm2Dimension2.Create','0','D2fixr.Fdm2Dimension2 module create',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.Fdm2Dimension2.View','0','D2fixr.Fdm2Dimension2 module view',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.Fdm2Dimension2.Update','0','D2fixr.Fdm2Dimension2 module update',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.Fdm2Dimension2.Delete','0','D2fixr.Fdm2Dimension2 module delete',NULL,'N;');
                
            INSERT INTO `authitem` VALUES('D2fixr.Fdm2Dimension2Create', 2, 'D2fixr.Fdm2Dimension2 create', NULL, 'N;');
            INSERT INTO `authitem` VALUES('D2fixr.Fdm2Dimension2Update', 2, 'D2fixr.Fdm2Dimension2 update', NULL, 'N;');
            INSERT INTO `authitem` VALUES('D2fixr.Fdm2Dimension2Delete', 2, 'D2fixr.Fdm2Dimension2 delete', NULL, 'N;');
            INSERT INTO `authitem` VALUES('D2fixr.Fdm2Dimension2View', 2, 'D2fixr.Fdm2Dimension2 view', NULL, 'N;');
            
            INSERT INTO `authitemchild` VALUES('D2fixr.Fdm2Dimension2Create', 'D2fixr.Fdm2Dimension2.Create');
            INSERT INTO `authitemchild` VALUES('D2fixr.Fdm2Dimension2Update', 'D2fixr.Fdm2Dimension2.Update');
            INSERT INTO `authitemchild` VALUES('D2fixr.Fdm2Dimension2Delete', 'D2fixr.Fdm2Dimension2.Delete');
            INSERT INTO `authitemchild` VALUES('D2fixr.Fdm2Dimension2View', 'D2fixr.Fdm2Dimension2.View');

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `authitemchild` WHERE `parent` = 'D2fixr.Fdm2Dimension2Edit';
            DELETE FROM `authitemchild` WHERE `parent` = 'D2fixr.Fdm2Dimension2View';

            DELETE FROM `authitem` WHERE `name` = 'D2fixr.Fdm2Dimension2.*';
            DELETE FROM `authitem` WHERE `name` = 'D2fixr.Fdm2Dimension2.edit';
            DELETE FROM `authitem` WHERE `name` = 'D2fixr.Fdm2Dimension2.fullcontrol';
            DELETE FROM `authitem` WHERE `name` = 'D2fixr.Fdm2Dimension2.readonly';
            DELETE FROM `authitem` WHERE `name` = 'D2fixr.Fdm2Dimension2Edit';
            DELETE FROM `authitem` WHERE `name` = 'D2fixr.Fdm2Dimension2View';
        ");
    }

    public function safeUp()
    {
        $this->up();
    }

    public function safeDown()
    {
        $this->down();
    }
}


