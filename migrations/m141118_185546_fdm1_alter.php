<?php

class m141118_185546_fdm1_alter extends EDbMigration
{
	public function up()
	{
        
        $this->execute("
            ALTER TABLE `fdm1_dimension1`   
                CHANGE `fdm1_code` `fdm1_code` VARCHAR(10) CHARSET utf8 COLLATE utf8_general_ci NULL;
            ");
        
	}

	public function down()
	{
		echo "m141118_185546_fdm1_alter does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}