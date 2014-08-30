<?php

class m140830_151701_init extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;


            /* Create table in target */
            CREATE TABLE `fdda_dim_data`(
                `fdda_id` INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fdda_fixr_id` INT(10) UNSIGNED NOT NULL  , 
                `fdda_fret_id` TINYINT(3) UNSIGNED NOT NULL  , 
                `fdda_fdm2_id` INT(10) UNSIGNED NOT NULL  , 
                `fdda_fdm3_id` INT(10) UNSIGNED NOT NULL  , 
                `fdda_amt` INT(10) UNSIGNED NULL  , 
                `fdda_date_from` DATE NULL  , 
                `fdda_date_to` DATE NULL  , 
                PRIMARY KEY (`fdda_id`) , 
                KEY `fdda_fret_id`(`fdda_fret_id`) , 
                KEY `fdda_fdm2_id`(`fdda_fdm2_id`) , 
                KEY `fdda_fdm3_id`(`fdda_fdm3_id`) , 
                KEY `fdda_fixr_id`(`fdda_fixr_id`) , 
                CONSTRAINT `fdda_dim_data_ibfk_1` 
                FOREIGN KEY (`fdda_fret_id`) REFERENCES `fret_ref_type` (`fret_id`) , 
                CONSTRAINT `fdda_dim_data_ibfk_2` 
                FOREIGN KEY (`fdda_fdm2_id`) REFERENCES `fdm2_dimension2` (`fdm2_id`) , 
                CONSTRAINT `fdda_dim_data_ibfk_3` 
                FOREIGN KEY (`fdda_fdm3_id`) REFERENCES `fdm3_dimension3` (`fdm3_id`) , 
                CONSTRAINT `fdda_dim_data_ibfk_4` 
                FOREIGN KEY (`fdda_fixr_id`) REFERENCES `fixr_fiit_x_ref` (`fixr_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';

            CREATE TABLE `fddp_dim_data_period`(
                `fddp_id` BIGINT(20) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fddp_fdda_id` INT(10) UNSIGNED NOT NULL  COMMENT 'data record' , 
                `fddp_fdpe_id` INT(10) UNSIGNED NOT NULL  COMMENT 'period' , 
                `fddp_amt` INT(11) NOT NULL  COMMENT 'amount' , 
                `fddp_fixr_id` INT(10) UNSIGNED NOT NULL  COMMENT 'Imvoice item expense position' , 
                `fddp_fret_id` TINYINT(3) UNSIGNED NOT NULL  COMMENT 'level1' , 
                `fddp_fdm2_id` INT(10) UNSIGNED NOT NULL  COMMENT 'level2' , 
                `fddp_fdm3_id` INT(10) UNSIGNED NOT NULL  COMMENT 'level3' , 
                PRIMARY KEY (`fddp_id`) , 
                KEY `fddp_fdda_id`(`fddp_fdda_id`) , 
                KEY `fddp_fdpe_id`(`fddp_fdpe_id`) , 
                KEY `fddp_fixr_id`(`fddp_fixr_id`) , 
                KEY `fddp_fret_id`(`fddp_fret_id`) , 
                KEY `fddp_fdm2_id`(`fddp_fdm2_id`) , 
                KEY `fddp_fdm3_id`(`fddp_fdm3_id`) , 
                CONSTRAINT `fddp_dim_data_period_ibfk_6` 
                FOREIGN KEY (`fddp_fdm3_id`) REFERENCES `fdm3_dimension3` (`fdm3_id`) , 
                CONSTRAINT `fddp_dim_data_period_ibfk_1` 
                FOREIGN KEY (`fddp_fdda_id`) REFERENCES `fdda_dim_data` (`fdda_id`) , 
                CONSTRAINT `fddp_dim_data_period_ibfk_2` 
                FOREIGN KEY (`fddp_fdpe_id`) REFERENCES `fdpe_dim_period` (`fdpe_id`) , 
                CONSTRAINT `fddp_dim_data_period_ibfk_3` 
                FOREIGN KEY (`fddp_fixr_id`) REFERENCES `fixr_fiit_x_ref` (`fixr_id`) , 
                CONSTRAINT `fddp_dim_data_period_ibfk_4` 
                FOREIGN KEY (`fddp_fret_id`) REFERENCES `fret_ref_type` (`fret_id`) , 
                CONSTRAINT `fddp_dim_data_period_ibfk_5` 
                FOREIGN KEY (`fddp_fdm2_id`) REFERENCES `fdm2_dimension2` (`fdm2_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';

            CREATE TABLE `fdm2_dimension2`(
                `fdm2_id` INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fdm2_fret_id` TINYINT(3) UNSIGNED NOT NULL  , 
                `fdm2_ref_id` INT(10) UNSIGNED NULL  , 
                `fdm2_code` VARCHAR(10) COLLATE utf8_general_ci NULL  , 
                `fdm2_name` VARCHAR(50) COLLATE utf8_general_ci NULL  , 
                `fdm2_hidden` TINYINT(4) NULL  DEFAULT 0 , 
                PRIMARY KEY (`fdm2_id`) , 
                KEY `fdm2_fret_id`(`fdm2_fret_id`) , 
                CONSTRAINT `fdm2_dimension2_ibfk_1` 
                FOREIGN KEY (`fdm2_fret_id`) REFERENCES `fret_ref_type` (`fret_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';

            CREATE TABLE `fdm3_dimension3`(
                `fdm3_id` INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fdm3_fret_id` TINYINT(3) UNSIGNED NOT NULL  , 
                `fdm3_ref_id` INT(10) UNSIGNED NULL  , 
                `fdm3_fdm2_id` INT(10) UNSIGNED NOT NULL  , 
                `fdm3_code` VARCHAR(10) COLLATE utf8_general_ci NULL  , 
                `fdm3_name` VARCHAR(50) COLLATE utf8_general_ci NULL  , 
                `fdm3_hidden` TINYINT(4) NULL  DEFAULT 0 , 
                PRIMARY KEY (`fdm3_id`) , 
                KEY `fdm3_fret_id`(`fdm3_fret_id`) , 
                KEY `fdm3_fdm2_id`(`fdm3_fdm2_id`) , 
                CONSTRAINT `fdm3_dimension3_ibfk_1` 
                FOREIGN KEY (`fdm3_fret_id`) REFERENCES `fret_ref_type` (`fret_id`) , 
                CONSTRAINT `fdm3_dimension3_ibfk_2` 
                FOREIGN KEY (`fdm3_fdm2_id`) REFERENCES `fdm2_dimension2` (`fdm2_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';


            CREATE TABLE `fdpe_dim_period`(
                `fdpe_id` INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fdpe_type` ENUM('Montly') COLLATE utf8_general_ci NOT NULL  , 
                `fdpe_dt_from` DATETIME NOT NULL  , 
                `fdpe_dt_to` DATETIME NOT NULL  , 
                PRIMARY KEY (`fdpe_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';

            CREATE TABLE `fixr_fiit_x_ref`(
                `fixr_id` INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fixr_fiit_id` INT(10) UNSIGNED NOT NULL  , 
                `fixr_position_fret_id` TINYINT(3) UNSIGNED NULL  , 
                `fixr_period_fret_id` TINYINT(3) UNSIGNED NULL  , 
                `fixr_fcrn_date` DATE NOT NULL  , 
                `fixr_fcrn_id` TINYINT(3) UNSIGNED NOT NULL  , 
                `fixr_amt` DECIMAL(10,2) NULL  , 
                `fixr_base_fcrn_id` TINYINT(3) UNSIGNED NOT NULL  , 
                `fixr_base_amt` DECIMAL(10,2) UNSIGNED NULL  , 
                PRIMARY KEY (`fixr_id`) , 
                KEY `fixr_fiit_id`(`fixr_fiit_id`) , 
                KEY `fixr_fcrn_id`(`fixr_fcrn_id`) , 
                KEY `fixr_base_fcrn_id`(`fixr_base_fcrn_id`) , 
                KEY `fixr_position_fret_id`(`fixr_position_fret_id`) , 
                KEY `fixr_period_fret_id`(`fixr_period_fret_id`) , 
                CONSTRAINT `fixr_fiit_x_ref_ibfk_1` 
                FOREIGN KEY (`fixr_fiit_id`) REFERENCES `fiit_invoice_item` (`fiit_id`) , 
                CONSTRAINT `fixr_fiit_x_ref_ibfk_4` 
                FOREIGN KEY (`fixr_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`) , 
                CONSTRAINT `fixr_fiit_x_ref_ibfk_5` 
                FOREIGN KEY (`fixr_base_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`) , 
                CONSTRAINT `fixr_fiit_x_ref_ibfk_6` 
                FOREIGN KEY (`fixr_position_fret_id`) REFERENCES `fret_ref_type` (`fret_id`) , 
                CONSTRAINT `fixr_fiit_x_ref_ibfk_7` 
                FOREIGN KEY (`fixr_period_fret_id`) REFERENCES `fret_ref_type` (`fret_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';

            CREATE TABLE `fped_period_date`(
                `fped_id` INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fped_fixr_id` INT(10) UNSIGNED NOT NULL  , 
                `fped_start_date` DATE NULL  , 
                `fped_end_date` DATE NULL  , 
                `fped_month` DATE NULL  , 
                PRIMARY KEY (`fped_id`) , 
                KEY `fped_fixr_id`(`fped_fixr_id`) , 
                CONSTRAINT `fped_period_date_ibfk_1` 
                FOREIGN KEY (`fped_fixr_id`) REFERENCES `fixr_fiit_x_ref` (`fixr_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';

            CREATE TABLE `fpeo_period_odo`(
                `fpeo_id` INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fpeo_fixr_id` INT(10) UNSIGNED NOT NULL  , 
                `fpeo_start_abs_odo` INT(10) UNSIGNED NULL  , 
                `fpeo_end_abs_odo` INT(10) UNSIGNED NULL  , 
                `fpeo_distance` INT(10) UNSIGNED NULL  , 
                PRIMARY KEY (`fpeo_id`) , 
                KEY `fpeo_fixr_id`(`fpeo_fixr_id`) , 
                CONSTRAINT `fpeo_period_odo_ibfk_1` 
                FOREIGN KEY (`fpeo_fixr_id`) REFERENCES `fixr_fiit_x_ref` (`fixr_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';

            CREATE TABLE `fret_ref_type`(
                `fret_id` TINYINT(3) UNSIGNED NOT NULL  AUTO_INCREMENT , 
                `fret_model` VARCHAR(50) COLLATE ascii_general_ci NOT NULL  , 
                `fret_model_fixr_id_field` VARCHAR(100) COLLATE ascii_general_ci NULL  , 
                `fret_modelpk_field` VARCHAR(100) COLLATE ascii_general_ci NULL  , 
                `fret_label` VARCHAR(250) COLLATE utf8_general_ci NOT NULL  , 
                `fret_finv_type` ENUM('in','out') COLLATE utf8_general_ci NOT NULL  DEFAULT 'out' , 
                `fret_controller_action` VARCHAR(100) COLLATE ascii_general_ci NULL  , 
                `fret_view_form` VARCHAR(100) COLLATE utf8_general_ci NULL  , 
                `fret_period_fret_id_list` VARCHAR(100) COLLATE ascii_general_ci NULL  , 
                PRIMARY KEY (`fret_id`) 
            ) ENGINE=INNODB DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';


            ALTER TABLE `vexp_expenses`
                ADD CONSTRAINT `vexp_expenses_ibfk_3` 
                FOREIGN KEY (`vexp_fixr_id`) REFERENCES `fixr_fiit_x_ref` (`fixr_id`) ;

            ALTER TABLE `vtdc_truck_doc`
                ADD CONSTRAINT `vtdc_truck_doc_ibfk_3` 
                FOREIGN KEY (`vtdc_fixr_id`) REFERENCES `fixr_fiit_x_ref` (`fixr_id`) ;

            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;

            
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
