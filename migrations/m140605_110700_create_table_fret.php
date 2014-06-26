<?php

class m140605_110700_create_table_fret extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
                CREATE TABLE  IF NOT EXISTS  `fret_ref_type` (
                  `fret_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
                  `fret_model` varchar(50) NOT NULL,
                  `fret_label` varchar(50) NOT NULL,
                  PRIMARY KEY (`fret_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8

        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
		$this->execute("
            $this->dropTable('fret_ref_type');
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
