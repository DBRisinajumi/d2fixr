<?php

class m140822_103201_alter_fret extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `fret_ref_type`   
              ADD COLUMN `fret_period_fret_id_list` VARCHAR(100) CHARSET ASCII NULL AFTER `fret_view_form`;

            
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
