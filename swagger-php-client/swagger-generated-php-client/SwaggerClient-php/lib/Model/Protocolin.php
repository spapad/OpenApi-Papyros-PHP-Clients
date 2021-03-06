<?php
/**
 * Protocolin
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * test
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 1.0.2
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;

/**
 * Protocolin Class Doc Comment
 *
 * @category    Class */
/**
 * @package     Swagger\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Protocolin implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'Protocolin';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'sender_id' => 'int',
        'sender_protocol' => 'string',
        'sender_protocol_date' => 'string',
        'doc_category' => 'int',
        'theme' => 'string',
        'ada' => 'string',
        'description' => 'string',
        'main_doc' => '\Swagger\Client\Model\DocumentDto',
        'attached_doc' => '\Swagger\Client\Model\DocumentDto[]'
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'sender_id' => 'senderId',
        'sender_protocol' => 'senderProtocol',
        'sender_protocol_date' => 'senderProtocolDate',
        'doc_category' => 'docCategory',
        'theme' => 'theme',
        'ada' => 'ada',
        'description' => 'description',
        'main_doc' => 'mainDoc',
        'attached_doc' => 'attachedDoc'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'sender_id' => 'setSenderId',
        'sender_protocol' => 'setSenderProtocol',
        'sender_protocol_date' => 'setSenderProtocolDate',
        'doc_category' => 'setDocCategory',
        'theme' => 'setTheme',
        'ada' => 'setAda',
        'description' => 'setDescription',
        'main_doc' => 'setMainDoc',
        'attached_doc' => 'setAttachedDoc'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'sender_id' => 'getSenderId',
        'sender_protocol' => 'getSenderProtocol',
        'sender_protocol_date' => 'getSenderProtocolDate',
        'doc_category' => 'getDocCategory',
        'theme' => 'getTheme',
        'ada' => 'getAda',
        'description' => 'getDescription',
        'main_doc' => 'getMainDoc',
        'attached_doc' => 'getAttachedDoc'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['sender_id'] = isset($data['sender_id']) ? $data['sender_id'] : null;
        $this->container['sender_protocol'] = isset($data['sender_protocol']) ? $data['sender_protocol'] : null;
        $this->container['sender_protocol_date'] = isset($data['sender_protocol_date']) ? $data['sender_protocol_date'] : null;
        $this->container['doc_category'] = isset($data['doc_category']) ? $data['doc_category'] : null;
        $this->container['theme'] = isset($data['theme']) ? $data['theme'] : null;
        $this->container['ada'] = isset($data['ada']) ? $data['ada'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['main_doc'] = isset($data['main_doc']) ? $data['main_doc'] : null;
        $this->container['attached_doc'] = isset($data['attached_doc']) ? $data['attached_doc'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];
        if ($this->container['sender_id'] === null) {
            $invalid_properties[] = "'sender_id' can't be null";
        }
        if ($this->container['theme'] === null) {
            $invalid_properties[] = "'theme' can't be null";
        }
        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        if ($this->container['sender_id'] === null) {
            return false;
        }
        if ($this->container['theme'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets sender_id
     * @return int
     */
    public function getSenderId()
    {
        return $this->container['sender_id'];
    }

    /**
     * Sets sender_id
     * @param int $sender_id Υποχρεωτικό πεδίο
     * @return $this
     */
    public function setSenderId($sender_id)
    {
        $this->container['sender_id'] = $sender_id;

        return $this;
    }

    /**
     * Gets sender_protocol
     * @return string
     */
    public function getSenderProtocol()
    {
        return $this->container['sender_protocol'];
    }

    /**
     * Sets sender_protocol
     * @param string $sender_protocol
     * @return $this
     */
    public function setSenderProtocol($sender_protocol)
    {
        $this->container['sender_protocol'] = $sender_protocol;

        return $this;
    }

    /**
     * Gets sender_protocol_date
     * @return string
     */
    public function getSenderProtocolDate()
    {
        return $this->container['sender_protocol_date'];
    }

    /**
     * Sets sender_protocol_date
     * @param string $sender_protocol_date
     * @return $this
     */
    public function setSenderProtocolDate($sender_protocol_date)
    {
        $this->container['sender_protocol_date'] = $sender_protocol_date;

        return $this;
    }

    /**
     * Gets doc_category
     * @return int
     */
    public function getDocCategory()
    {
        return $this->container['doc_category'];
    }

    /**
     * Sets doc_category
     * @param int $doc_category
     * @return $this
     */
    public function setDocCategory($doc_category)
    {
        $this->container['doc_category'] = $doc_category;

        return $this;
    }

    /**
     * Gets theme
     * @return string
     */
    public function getTheme()
    {
        return $this->container['theme'];
    }

    /**
     * Sets theme
     * @param string $theme Υποχρεωτικό πεδίο
     * @return $this
     */
    public function setTheme($theme)
    {
        $this->container['theme'] = $theme;

        return $this;
    }

    /**
     * Gets ada
     * @return string
     */
    public function getAda()
    {
        return $this->container['ada'];
    }

    /**
     * Sets ada
     * @param string $ada
     * @return $this
     */
    public function setAda($ada)
    {
        $this->container['ada'] = $ada;

        return $this;
    }

    /**
     * Gets description
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets main_doc
     * @return \Swagger\Client\Model\DocumentDto
     */
    public function getMainDoc()
    {
        return $this->container['main_doc'];
    }

    /**
     * Sets main_doc
     * @param \Swagger\Client\Model\DocumentDto $main_doc
     * @return $this
     */
    public function setMainDoc($main_doc)
    {
        $this->container['main_doc'] = $main_doc;

        return $this;
    }

    /**
     * Gets attached_doc
     * @return \Swagger\Client\Model\DocumentDto[]
     */
    public function getAttachedDoc()
    {
        return $this->container['attached_doc'];
    }

    /**
     * Sets attached_doc
     * @param \Swagger\Client\Model\DocumentDto[] $attached_doc
     * @return $this
     */
    public function setAttachedDoc($attached_doc)
    {
        $this->container['attached_doc'] = $attached_doc;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\Swagger\Client\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\Swagger\Client\ObjectSerializer::sanitizeForSerialization($this));
    }
}
