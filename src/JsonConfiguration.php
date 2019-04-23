<?php
/**
 * Copyright 2019 Jens Fischer
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Created by Th3Shadowbroker https://m4taiori.io
 * GitHub: https://github.com/th3shadowbroker
 * Date: 19.04.2019
 * Time: 19:54
 */

namespace github\th3shadowbroker\json_config;

/**
 * Class JsonConfiguration
 *
 * A really basic implementation of JSON configuration files.
 *
 * @package github\th3shadowbroker\json_config
 */
class JsonConfiguration
{

    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $configuration;

    /**
     * JsonConfiguration constructor.
     * @param string $file The file the configuration is loaded from and saved to.
     */
    function __construct($file = null)
    {
        $this->file = $file;
        $this->configuration = !is_null($file) && file_exists($file) ? json_decode( file_get_contents($file), true ) : [];
    }

    /**
     * Set multiple defaults.
     * @param array $arr The array that contains multiple defaults in form of an associative array.
     */
    public function setDefaults($arr)
    {
        foreach ( $arr as $key => $val )
        {
            $this->setDefault($key, $val);
        }
    }

    /**
     * Sets a certain setting to the given value if it's not
     * already set.
     * @param string $key The key.
     * @param mixed $val The value.
     */
    public function setDefault($key, $val)
    {
        if ( !$this->exists($key) ) $this->set($key, $val);
    }

    /**
     * @param string $key The config key. Use dots to separate the array layers.
     * @return array|mixed
     */
    public function get($key)
    {
        $current = &$this->configuration;
        foreach ( explode('.', $key) as $keyPart )
        {
            $current = &$current[$keyPart];
        }
        return $current;
    }

    /**
     * Set a setting. Use dots to separate the array layers.
     * @param string $key Its key.
     * @param mixed $val Its value.
     */
    public function set($key, $val)
    {
        $current = &$this->configuration;
        foreach ( explode('.', $key) as $keyPart )
        {
            $current = &$current[$keyPart];
        }
        $current = $val;
    }

    /**
     * Returns true if the given key is already set.
     * @param string $key The key that should be checked.
     * @return bool
     */
    public function exists($key)
    {
        try
        {
            return !is_null($this->get($key));
        }
        catch (Exception $exception)
        {
            return false;
        }
    }

    /**
     * Saves the configuration to the given location. If the location is
     * null. The locations the file was loaded from will be used instead.
     * @param string $file The file to save to.
     * @param bool $overwrite True if the file should be overwritten.
     */
    public function save($file = null, $overwrite = true)
    {
        $dest = is_null($file) ? $this->file : $file;
        if ($overwrite || file_exists($dest)) file_put_contents($dest, json_encode($this->configuration, JSON_PRETTY_PRINT));
    }

}
