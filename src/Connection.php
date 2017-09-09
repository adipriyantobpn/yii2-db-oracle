<?php
/**
 * Created by
 * User: Adi Priyanto
 * Date: 9/9/2017
 * Time: 9:41 PM
 */

namespace adipriyantobpn\db\oracle;
use yii\db\Exception;

/**
 * Class Connection
 *
 * In this class, by default, it will configure:
 * - DSN, if not configured before, by using specified host, port, and SID properties.
 *
 * @package adipriyantobpn\db\oracle
 */
class Connection extends \yii\db\Connection
{
    /**
     * @var string The hostname for establishing Oracle DB connection.
     * Can be IP address, or domain name.
     * If DSN is not configured, this properties is mandatory.
     */
    public $host;

    /**
     * @var int The port for establishing Oracle DB connection.
     * Defaults to `1521` as default Oracle connection port.
     * If DSN is not configured, this properties is mandatory.
     */
    public $port = 1521;

    /**
     * @var string The SID for establishing Oracle DB connection.
     * If DSN is not configured, this properties is mandatory.
     */
    public $sid;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     *
     * @throws Exception If dsn is not configured, then host, port, or SID properties must be set.
     * Otherwise yii\db\Exception will be thrown.
     */
    public function init()
    {
        //-- initialize parent::init
        parent::init();

        //-- use extended Oracle schema, instead of default yii\db\oci\Schema
        $this->schemaMap['oci'] = 'adipriyantobpn\db\oracle\Schema';

        $requiredProperties = [
            'host',
            'port',
            'sid'
        ];

        //-- configure DSN if it is empty
        if (empty($this->dsn)) {
            //-- check mandatory properties needed by DSN
            foreach ($requiredProperties as $property) {
                if (empty($this->$property)) {
                    throw new Exception("{$property} property is empty");
                }
            }
            //-- configure DSN
            $this->dsn = "oci:dbname=(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST={$this->host})(PORT={$this->port})))(CONNECT_DATA=(SID={$this->sid})))";
        }
    }

}