<?php

class m140608_214200_alter_table_fixr extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fixr_fiit_x_ref` DROP COLUMN `fixr_ref_id`, DROP COLUMN `fixr_start_date`, DROP COLUMN `fixr_months`, DROP COLUMN `fixr_end_date`, DROP COLUMN `fixr_start_abs_odo`, DROP COLUMN `fixr_km`, DROP COLUMN `fixr_end_abs_odo`, ADD COLUMN `fixr_frep_id` TINYINT UNSIGNED NULL AFTER `fixr_fret_id`, CHANGE `fuxr_fcrn_date` `fixr_fcrn_date` DATE NOT NULL, CHANGE `fuxr_fcrn_id` `fixr_fcrn_id` TINYINT(3) UNSIGNED NOT NULL, CHANGE `fuxr_amt` `fixr_amt` DECIMAL(10,2) NULL, CHANGE `fuxr_base_fcrn_id` `fixr_base_fcrn_id` TINYINT(3) UNSIGNED NOT NULL, DROP FOREIGN KEY `fixr_fiit_x_ref_ibfk_3`, DROP FOREIGN KEY `fixr_fiit_x_ref_ibfk_4`; 
            ALTER TABLE `fixr_fiit_x_ref` ADD FOREIGN KEY (`fixr_frep_id`) REFERENCES `frep_ref_period`(`frep_id`); 
            ALTER TABLE `fixr_fiit_x_ref` ADD FOREIGN KEY (`fixr_fcrn_id`) REFERENCES `fcrn_currency`(`fcrn_id`); 
            ALTER TABLE `fixr_fiit_x_ref` ADD FOREIGN KEY (`fixr_base_fcrn_id`) REFERENCES `fcrn_currency`(`fcrn_id`); 

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
