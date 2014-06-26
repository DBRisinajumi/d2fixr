<?php

class m140608_214300_create_table_fped extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `fped_period_date`( `fped_id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `fped_fixr_id` INT UNSIGNED NOT NULL, `fped_start_date` DATE, `fped_end_date` DATE, `fped_month` DATE, PRIMARY KEY (`fped_id`) ) ENGINE=INNODB CHARSET=utf8; 
            ALTER TABLE `fped_period_date` ADD FOREIGN KEY (`fped_fixr_id`) REFERENCES `fixr_fiit_x_ref`(`fixr_id`); 


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
