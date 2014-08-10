<?php

class m140805_192900_alter_fixr extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fixr_fiit_x_ref` DROP FOREIGN KEY `fixr_fiit_x_ref_ibfk_6`; 
            ALTER TABLE `fixr_fiit_x_ref` DROP FOREIGN KEY `fixr_fiit_x_ref_ibfk_2`; 
            ALTER TABLE `fixr_fiit_x_ref`   
                CHANGE `fixr_position_fret_id` `fixr_position_fret_id` TINYINT(3) UNSIGNED NULL,
                CHANGE `fixr_period_fret_id` `fixr_period_fret_id` TINYINT(3) UNSIGNED NULL;
            ALTER TABLE `fixr_fiit_x_ref` ADD FOREIGN KEY (`fixr_position_fret_id`) REFERENCES `fret_ref_type`(`fret_id`); 
            ALTER TABLE `fixr_fiit_x_ref` ADD FOREIGN KEY (`fixr_period_fret_id`) REFERENCES `fret_ref_type`(`fret_id`); 
            DROP TABLE `frep_ref_period`;
            
        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{

	}

	/**
	 * Creates initial version of the table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
