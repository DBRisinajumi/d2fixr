<?php

class m140608_213800_create_table_frep extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `frep_ref_period`( `frep_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT, `frep_model` VARCHAR(50) NOT NULL, `frep_label` VARCHAR(50) NOT NULL, PRIMARY KEY (`frep_id`) ) ENGINE=INNODB CHARSET=utf8; 
            INSERT INTO `frep_ref_period` (`frep_model`, `frep_label`) VALUES ('PeriodMonth', 'Mēneši'); 
            INSERT INTO `frep_ref_period` (`frep_model`, `frep_label`) VALUES ('PeriodOdo', 'Odometrs'); 

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
