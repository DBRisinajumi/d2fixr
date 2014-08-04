<?php

class m140803_105100_alter_fret extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fret_ref_type`   
              CHANGE `fret_model` `fret_model` VARCHAR(50) CHARSET ASCII NOT NULL,
              ADD COLUMN `fret_model_fixr_id_field` VARCHAR(100) CHARSET ASCII NULL AFTER `fret_model`,
              ADD COLUMN `fret_modelpk_field` VARCHAR(100) CHARSET ASCII NULL AFTER `fret_model_fixr_id_field`,
              CHANGE `fret_label` `fret_label` VARCHAR(250) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
              ADD COLUMN `fret_finv_type` ENUM('in','out') DEFAULT 'out'   NOT NULL AFTER `fret_label`,
              ADD COLUMN `fret_controller_action` VARCHAR(100) CHARSET ASCII NULL AFTER `fret_finv_type`,
              ADD COLUMN `fret_view_form` VARCHAR(100) NULL AFTER `fret_controller_action`;
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
