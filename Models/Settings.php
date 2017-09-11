<?php

namespace GDForm\Models;


class Settings
{
    private static $TableName = 'GDFormSettings';
    private $RecaptchaPublicKey;
    private $RecaptchaSecretKey;
    private $HiddenRecaptchaPublicKey;
    private $HiddenRecaptchaSecretKey;
    private $PostsPerPage;
    private $RemoveTablesUninstall = 'off';
    /**
     * @var array
     */
    private $cache = array();

    public static function getTableName()
    {
        return $GLOBALS['wpdb']->prefix . self::$TableName;
    }

    /**
     * @param $key string
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = false)
    {
        if (!in_array($key, $this->cache)) {
            global $wpdb;
            $value = $wpdb->get_var($wpdb->prepare('select Value from ' . self::getTableName() . ' where Name=%s', $key));

            if ( empty($value) ) {
                $this->$key = $default;
            } else {
                $unserialized_value = @unserialize($value);

                if (false !== $unserialized_value || 'b:0;' === $value) {
                    $value = $unserialized_value;
                }

                $this->$key = $value;
            }


            $this->cache[] = $key;

        }

        return $this->$key;
    }

    /**
     * @param $key string
     * @param $value string
     * @return bool
     */
    public function set($key, $value)
    {
        global $wpdb;

        $saved = $wpdb->query($wpdb->prepare('INSERT INTO '.self::getTableName().' (Value,Name) VALUES (%s,%s) ON DUPLICATE KEY UPDATE Value=%s ',$value,$key,$value));

        $this->$key = $value;

        return (bool)$saved;
    }

    public function all()
    {

    }

}