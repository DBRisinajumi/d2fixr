<?php

class m140905_144501_mod_fdsp extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fddp_dim_data_period` 
                CHANGE `fddp_fdst_id` `fddp_fdst_id` TINYINT(3) UNSIGNED NULL COMMENT 'dimension split type', 
                ADD COLUMN `fddp_cd` ENUM('C','D') DEFAULT 'C' NOT NULL COMMENT 'Credit/Debit' AFTER `fddp_fdst_id`, 
                ADD COLUMN `fddp_fdst_ref_id` INT UNSIGNED NULL COMMENT 'link on ref table record' AFTER `fddp_cd`; 

            
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
