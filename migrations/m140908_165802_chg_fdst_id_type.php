<?php

class m140908_165801_chg_fdst_id_type extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fddp_dim_data_period` DROP FOREIGN KEY `fddp_dim_data_period_ibfk_8`; 
            ALTER TABLE `fdsp_dimension_split` DROP FOREIGN KEY `fdsp_dimension_split_ibfk_4`; 

              ALTER TABLE `fdst_dim_split_type`   
              CHANGE `fdst_id` `fdst_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT;

              ALTER TABLE `fdsp_dimension_split`   
              CHANGE `fdsp_fdst_id` `fdsp_fdst_id` SMALLINT UNSIGNED NOT NULL;

              ALTER TABLE `fddp_dim_data_period`   
              CHANGE `fddp_fdst_id` `fddp_fdst_id` SMALLINT UNSIGNED NULL  COMMENT 'dimension split type';


            ALTER TABLE `fdsp_dimension_split` ADD FOREIGN KEY (`fdsp_fdst_id`) REFERENCES `fdst_dim_split_type`(`fdst_id`);   
            ALTER TABLE `fddp_dim_data_period` ADD FOREIGN KEY (`fddp_fdst_id`) REFERENCES `fdst_dim_split_type`(`fdst_id`); 
            
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
