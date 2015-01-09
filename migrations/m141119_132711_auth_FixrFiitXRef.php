<?php
 
class m141119_132711_auth_FixrFiitXRef extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.FixrFiitXRef.*','0','D2fixr.FixrFiitXRef',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.FixrFiitXRef.Create','0','D2fixr.FixrFiitXRef module create',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.FixrFiitXRef.View','0','D2fixr.FixrFiitXRef module view',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.FixrFiitXRef.Update','0','D2fixr.FixrFiitXRef module update',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.FixrFiitXRef.Delete','0','D2fixr.FixrFiitXRef module delete',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('D2fixr.FixrFiitXRef.Menu','0','D2fixr.FixrFiitXRef show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `authitem` WHERE `name`= 'D2fixr.FixrFiitXRef.*';
            DELETE FROM `authitem` WHERE `name`= 'D2fixr.FixrFiitXRef.Create';
            DELETE FROM `authitem` WHERE `name`= 'D2fixr.FixrFiitXRef.View';
            DELETE FROM `authitem` WHERE `name`= 'D2fixr.FixrFiitXRef.Update';
            DELETE FROM `authitem` WHERE `name`= 'D2fixr.FixrFiitXRef.Delete';
            DELETE FROM `authitem` WHERE `name`= 'D2fixr.FixrFiitXRef.Menu';

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


