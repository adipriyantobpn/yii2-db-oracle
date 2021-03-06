<?php
/**
 * Created by
 * User: Adi Priyanto
 * Date: 9/9/2017
 * Time: 9:41 PM
 */

namespace adipriyantobpn\db\oracle;
use yii\base\Event;
use yii\db\Exception;

/**
 * Class Connection
 *
 * In this class, by default, it will configure:
 * - DSN, if not configured before, by using specified host, port, and SID properties.
 * - Oracle NLS_DATE_FORMAT (after opening database connection), by using dateFormat property.
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
     * @var string The date format to be used when set/get datetime for Oracle DB.
     * Defaults to `YYYY-MM-DD HH24:MI:SS`.
     */
    public $dateFormat = 'YYYY-MM-DD HH24:MI:SS';

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

            //-- configure date format
            //-- to see Oracle default date format, please execute:
            //--    `SELECT * FROM NLS_SESSION_PARAMETERS WHERE parameter = 'NLS_DATE_FORMAT'`
            $this->on(self::EVENT_AFTER_OPEN, function($event) {
                /* @var $event Event */
                /* @var $sender Connection */
                $sender = $event->sender;
                $sender->createCommand("ALTER SESSION SET NLS_DATE_FORMAT='{$this->dateFormat}'")->execute();
            });
        }
    }

}