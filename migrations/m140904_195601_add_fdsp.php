<?php

class m140904_195601_add_fdsp extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
                CREATE TABLE `fdsp_dimension_split`( `fdsp_id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `fdsp_fdm1_id` TINYINT UNSIGNED NOT NULL, `fdsp_fdm2_id` INT UNSIGNED, `fdsp_fdm3_id` INT UNSIGNED, `fdsp_fdst_id` TINYINT UNSIGNED NOT NULL, `fdsp_procenti` TINYINT UNSIGNED NOT NULL, `fdsp_notes` TEXT, PRIMARY KEY (`fdsp_id`) ) ENGINE=INNODB CHARSET=utf8; 
                ALTER TABLE `fdsp_dimension_split` ADD FOREIGN KEY (`fdsp_fdm1_id`) REFERENCES `eu`.`fdm1_dimension1`(`fdm1_id`); 
                ALTER TABLE `fdsp_dimension_split` ADD FOREIGN KEY (`fdsp_fdm2_id`) REFERENCES `eu`.`fdm2_dimension2`(`fdm2_id`); 
                ALTER TABLE `fdsp_dimension_split` ADD FOREIGN KEY (`fdsp_fdm3_id`) REFERENCES `eu`.`fdm3_dimension3`(`fdm3_id`); 
                CREATE TABLE `fdst_dim_split_type`( 
                    `fdst_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT, 
                    `fdst_code` CHAR(10) NOT NULL, 
                    `fdst_name` VARCHAR(20) NOT NULL, 
                    `fdst_notes` TEXT, 
                    PRIMARY KEY (`fdst_id`) ) ENGINE=INNODB CHARSET=utf8;
                ALTER TABLE `fdsp_dimension_split` ADD FOREIGN KEY (`fdsp_fdst_id`) REFERENCES `eu`.`fdst_dim_split_type`(`fdst_id`); 
                ALTER TABLE `fddp_dim_data_period` ADD COLUMN `fddp_fdst_id` TINYINT UNSIGNED NULL AFTER `fddp_fdm3_id`; 
                ALTER TABLE `fddp_dim_data_period` ADD FOREIGN KEY (`fddp_fdst_id`) REFERENCES `eu`.`fdst_dim_split_type`(`fdst_id`); 

            
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
