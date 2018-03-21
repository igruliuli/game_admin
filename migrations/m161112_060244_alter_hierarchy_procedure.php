<?php

use yii\db\Migration;

class m161112_060244_alter_hierarchy_procedure extends Migration
{

    public function up()
    {
        $this->execute("
            CREATE OR REPLACE FUNCTION calculate_hierarchy()
            RETURNS void LANGUAGE plpgsql AS $$
            BEGIN
                            
                -- drop old hierarchy table            
                DROP TABLE IF EXISTS user_hierarchy;

                -- create user hierarchy table
                DROP TABLE IF EXISTS account_hierarchy;
                
                CREATE TABLE account_hierarchy (
                    id INT NOT NULL,
                    parent_id INT,
                    hierarchy_level  INT,
                    hierarchy_path BIT VARYING(32000)
                );
                
                WITH RECURSIVE cteBuildPath AS (
                SELECT 
                    anchor.id, 
                    anchor.parent_id, 
                    1 as hierarchy_level,
                    CAST(
                        CAST(anchor.id AS BIT(32)) AS bit varying
                        ) as hierarchy_path
                 FROM accounts AS anchor
                 WHERE parent_id IS NULL
                 UNION ALL
                 SELECT recur.id, 
                    recur.parent_id,
                    cte.hierarchy_level + 1 as hierarchy_level,
                    CAST( --This does the concatenation to build hierarchy_path
                        cte.hierarchy_path || CAST(recur.id AS BIT(32))
                    AS BIT VARYING) as hierarchy_path
                 FROM accounts AS recur
                 INNER JOIN cteBuildPath AS cte 
                    ON cte.id = recur.parent_id
               )              
               INSERT INTO account_hierarchy
                SELECT 
                    coalesce(sorted.id,0) as id,
                    sorted.parent_id,
                    coalesce(sorted.hierarchy_level,0) as hierarchy_level,
                    coalesce(sorted.hierarchy_path,sorted.hierarchy_path) as hierarchy_path
                FROM cteBuildPath AS sorted;
            END
            $$
        ");

        $this->execute("SELECT calculate_hierarchy()");
    }

    public function down()
    {
        $this->execute("DROP function calculate_hierarchy()");
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
