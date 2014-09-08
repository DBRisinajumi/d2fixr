<?php

class m140908_170202_chg_fret_id_type extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fdm3_dimension3` DROP FOREIGN KEY `fdm3_dimension3_ibfk_1`; 
            ALTER TABLE `fdda_dim_data` DROP FOREIGN KEY `fdda_dim_data_ibfk_1`; 
            ALTER TABLE `fdm2_dimension2` DROP FOREIGN KEY `fdm2_dimension2_ibfk_1`; 
            ALTER TABLE `fixr_fiit_x_ref` DROP FOREIGN KEY `fixr_fiit_x_ref_ibfk_7`; 
            ALTER TABLE `fixr_fiit_x_ref` DROP FOREIGN KEY `fixr_fiit_x_ref_ibfk_6`; 
            ALTER TABLE `fddp_dim_data_period` DROP FOREIGN KEY `fddp_dim_data_period_ibfk_4`; 

            ALTER TABLE `fret_ref_type`   
              CHANGE `fret_id` `fret_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT;

            ALTER TABLE `fdm3_dimension3`   
              CHANGE `fdm3_fret_id` `fdm3_fret_id` SMALLINT UNSIGNED NOT NULL;

            ALTER TABLE `fdda_dim_data`   
              CHANGE `fdda_fret_id` `fdda_fret_id` SMALLINT UNSIGNED NOT NULL;

            ALTER TABLE `fdm2_dimension2`   
              CHANGE `fdm2_fret_id` `fdm2_fret_id` SMALLINT UNSIGNED NOT NULL;

            ALTER TABLE `fixr_fiit_x_ref`   
              CHANGE `fixr_position_fret_id` `fixr_position_fret_id` SMALLINT UNSIGNED NULL;

            ALTER TABLE `fixr_fiit_x_ref`   
              CHANGE `fixr_period_fret_id` `fixr_period_fret_id` SMALLINT UNSIGNED NULL;

              ALTER TABLE `fddp_dim_data_period`   
              CHANGE `fddp_fret_id` `fddp_fret_id` SMALLINT UNSIGNED NOT NULL;

            ALTER TABLE `fdm3_dimension3` ADD FOREIGN KEY (`fdm3_fret_id`) REFERENCES `fret_ref_type`(`fret_id`); 
            ALTER TABLE `fdda_dim_data` ADD FOREIGN KEY (`fdda_fret_id`) REFERENCES `fret_ref_type`(`fret_id`); 
            ALTER TABLE `fdm2_dimension2` ADD FOREIGN KEY (`fdm2_fret_id`) REFERENCES `fret_ref_type`(`fret_id`);
            ALTER TABLE `fixr_fiit_x_ref` ADD FOREIGN KEY (`fixr_position_fret_id`) REFERENCES `fret_ref_type`(`fret_id`);
            ALTER TABLE `fixr_fiit_x_ref` ADD FOREIGN KEY (`fixr_period_fret_id`) REFERENCES `fret_ref_type`(`fret_id`);
            ALTER TABLE  `fddp_dim_data_period` ADD FOREIGN KEY (`fddp_fret_id`) REFERENCES `fret_ref_type`(`fret_id`);
            
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
