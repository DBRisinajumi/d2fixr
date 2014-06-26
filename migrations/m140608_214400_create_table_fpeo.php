<?php

class m140608_214400_create_table_fpeo extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `fpeo_period_odo`( `fpeo_id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `fpeo_fixr_id` INT UNSIGNED NOT NULL, `fpeo_start_abs_odo` INT UNSIGNED, `fpeo_end_abs_odo` INT UNSIGNED, `fpeo_distance` INT UNSIGNED, PRIMARY KEY (`fpeo_id`) ) ENGINE=INNODB CHARSET=utf8; 
            ALTER TABLE `fpeo_period_odo` ADD FOREIGN KEY (`fpeo_fixr_id`) REFERENCES `fixr_fiit_x_ref`(`fixr_id`); 
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
