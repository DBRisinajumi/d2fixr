<?php

class m140605_110900_create_table_fixr extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
                CREATE TABLE  IF NOT EXISTS `fixr_fiit_x_ref` (
                    `fixr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `fixr_fiit_id` int(10) unsigned NOT NULL,
                    `fixr_fret_id` tinyint(3) unsigned DEFAULT NULL,
                    `fixr_ref_id` int(10) unsigned DEFAULT NULL,
                    `fuxr_fcrn_date` date NOT NULL,
                    `fuxr_fcrn_id` tinyint(3) unsigned NOT NULL,
                    `fuxr_amt` decimal(10,2) DEFAULT NULL,
                    `fuxr_base_fcrn_id` tinyint(3) unsigned NOT NULL,
                    `fixr_base_amt` decimal(10,2) unsigned DEFAULT NULL,
                    `fixr_start_date` date DEFAULT NULL,
                    `fixr_months` smallint(10) unsigned DEFAULT NULL,
                    `fixr_end_date` date DEFAULT NULL,
                    `fixr_start_abs_odo` int(10) unsigned DEFAULT NULL,
                    `fixr_km` int(10) unsigned DEFAULT NULL,
                    `fixr_end_abs_odo` int(10) unsigned DEFAULT NULL,
                    PRIMARY KEY (`fixr_id`),
                    KEY `fixr_fiit_id` (`fixr_fiit_id`),
                    KEY `fixr_fret_id` (`fixr_fret_id`),
                    KEY `fuxr_fcrn_id` (`fuxr_fcrn_id`),
                    KEY `fuxr_base_fcrn_id` (`fuxr_base_fcrn_id`),
                    CONSTRAINT `fixr_fiit_x_ref_ibfk_1` FOREIGN KEY (`fixr_fiit_id`) REFERENCES `fiit_invoice_item` (`fiit_id`),
                    CONSTRAINT `fixr_fiit_x_ref_ibfk_2` FOREIGN KEY (`fixr_fret_id`) REFERENCES `fret_ref_type` (`fret_id`),
                    CONSTRAINT `fixr_fiit_x_ref_ibfk_3` FOREIGN KEY (`fuxr_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`),
                    CONSTRAINT `fixr_fiit_x_ref_ibfk_4` FOREIGN KEY (`fuxr_base_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8


        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
		$this->execute("
            $this->dropTable('fixr_fiit_x_ref');
        ");
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
