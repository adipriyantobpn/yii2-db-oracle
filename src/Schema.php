<?php
/**
 * Created by
 * User: Adi Priyanto
 * Date: 9/9/2017
 * Time: 9:44 PM
 */

namespace adipriyantobpn\db\oracle;

/**
 * Class Schema
 * @package adipriyantobpn\db\oracle
 */
class Schema extends \yii\db\oci\Schema
{
    /**
     * Returns all schema names in the database, including the default one but not system schemas.
     * @return array all schema names in the database, except system schemas
     * @since 2.0.4
     */
    protected function findSchemaNames()
    {
        $sql = <<<SQL
SELECT
    USERNAME
FROM ALL_USERS U
WHERE
    EXISTS (SELECT 1 FROM ALL_OBJECTS O WHERE O.OWNER = U.USERNAME)
SQL;
        return $this->db->createCommand($sql)->queryColumn();
    }

}