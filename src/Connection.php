<?php
/**
 * Created by
 * User: Adi Priyanto
 * Date: 9/9/2017
 * Time: 9:41 PM
 */

namespace adipriyantobpn\db\oracle;

/**
 * Class Connection
 * @package adipriyantobpn\db\oracle
 */
class Connection extends \yii\db\Connection
{
    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        parent::init();
        $this->schemaMap['oci'] = 'adipriyantobpn\db\oracle\Schema';
    }

}