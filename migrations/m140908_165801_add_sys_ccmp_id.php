<?php

class m140908_165801_add_sys_ccmp_id extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fdda_dim_data`   
              ADD COLUMN `fdda_sys_ccmp_id` INT UNSIGNED NULL AFTER `fdda_id`;
            ALTER TABLE `fdm1_dimension1`   
              ADD COLUMN `fdm1_sys_ccmp_id` INT UNSIGNED NULL AFTER `fdm1_id`;
            ALTER TABLE `fdm2_dimension2`   
              ADD COLUMN `fdm2_sys_ccmp_id` INT UNSIGNED NULL AFTER `fdm2_id`;
            ALTER TABLE `fdm3_dimension3`   
              ADD COLUMN `fdm3_sys_ccmp_id` INT UNSIGNED NULL AFTER `fdm3_id`;
            ALTER TABLE `fddp_dim_data_period`   
              ADD COLUMN `fddp_sys_ccmp_id` INT UNSIGNED NULL AFTER `fddp_id`;
            ALTER TABLE `fdsp_dimension_split`   
              ADD COLUMN `fdsp_sys_ccmp_id` INT UNSIGNED NULL AFTER `fdsp_id`;
            ALTER TABLE `fdst_dim_split_type`   
              ADD COLUMN `fdst_sys_ccmp_id` INT UNSIGNED NULL AFTER `fdst_id`;
            ALTER TABLE `fret_ref_type`   
              ADD COLUMN `fret_sys_ccmp_id` INT UNSIGNED NULL AFTER `fret_id`;

            
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
