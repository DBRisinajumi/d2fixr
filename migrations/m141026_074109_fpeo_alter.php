<?php
 
class m141026_074109_fpeo_alter extends CDbMigration
{

    public function up()
    {
        $this->execute("
            ALTER TABLE `fpeo_period_odo`   
              ADD COLUMN `fpeo_start_date` DATE NULL AFTER `fpeo_fixr_id`,
              ADD COLUMN `fpeo_vodo_id` INT UNSIGNED NULL AFTER `fpeo_distance`,
              ADD COLUMN `fpeo_end_date` DATE NULL AFTER `fpeo_start_date`,
              ADD FOREIGN KEY (`fpeo_vodo_id`) REFERENCES `vodo_odometer`(`vodo_id`);              

        ");
    }

    public function down()
    {
        $this->execute("

        ");
    }

    public function safeUp()
    {
        $this->up();
    }

    public function safeDown()
    {
        $this->down();
    }
}


