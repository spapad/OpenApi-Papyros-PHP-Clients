<?php
/**
 * ProtocolNumber
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
 * ProtocolNumber Class Doc Comment
 *
 * @category    Class */
/**
 * @package     Swagger\Client
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ProtocolNumber implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'ProtocolNumber';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'doc_id' => 'string',
        'protocol_year' => 'int',
        'protocol_date' => 'string',
        'protocol_number' => 'string',
        'attachments' => '\Swagger\Client\Model\DocumentInfo[]'
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
        'doc_id' => 'docId',
        'protocol_year' => 'protocolYear',
        'protocol_date' => 'protocolDate',
        'protocol_number' => 'protocolNumber',
        'attachments' => 'attachments'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'doc_id' => 'setDocId',
        'protocol_year' => 'setProtocolYear',
        'protocol_date' => 'setProtocolDate',
        'protocol_number' => 'setProtocolNumber',
        'attachments' => 'setAttachments'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'doc_id' => 'getDocId',
        'protocol_year' => 'getProtocolYear',
        'protocol_date' => 'getProtocolDate',
        'protocol_number' => 'getProtocolNumber',
        'attachments' => 'getAttachments'
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
        $this->container['doc_id'] = isset($data['doc_id']) ? $data['doc_id'] : null;
        $this->container['protocol_year'] = isset($data['protocol_year']) ? $data['protocol_year'] : null;
        $this->container['protocol_date'] = isset($data['protocol_date']) ? $data['protocol_date'] : null;
        $this->container['protocol_number'] = isset($data['protocol_number']) ? $data['protocol_number'] : null;
        $this->container['attachments'] = isset($data['attachments']) ? $data['attachments'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];
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
        return true;
    }


    /**
     * Gets doc_id
     * @return string
     */
    public function getDocId()
    {
        return $this->container['doc_id'];
    }

    /**
     * Sets doc_id
     * @param string $doc_id
     * @return $this
     */
    public function setDocId($doc_id)
    {
        $this->container['doc_id'] = $doc_id;

        return $this;
    }

    /**
     * Gets protocol_year
     * @return int
     */
    public function getProtocolYear()
    {
        return $this->container['protocol_year'];
    }

    /**
     * Sets protocol_year
     * @param int $protocol_year
     * @return $this
     */
    public function setProtocolYear($protocol_year)
    {
        $this->container['protocol_year'] = $protocol_year;

        return $this;
    }

    /**
     * Gets protocol_date
     * @return string
     */
    public function getProtocolDate()
    {
        return $this->container['protocol_date'];
    }

    /**
     * Sets protocol_date
     * @param string $protocol_date
     * @return $this
     */
    public function setProtocolDate($protocol_date)
    {
        $this->container['protocol_date'] = $protocol_date;

        return $this;
    }

    /**
     * Gets protocol_number
     * @return string
     */
    public function getProtocolNumber()
    {
        return $this->container['protocol_number'];
    }

    /**
     * Sets protocol_number
     * @param string $protocol_number
     * @return $this
     */
    public function setProtocolNumber($protocol_number)
    {
        $this->container['protocol_number'] = $protocol_number;

        return $this;
    }

    /**
     * Gets attachments
     * @return \Swagger\Client\Model\DocumentInfo[]
     */
    public function getAttachments()
    {
        return $this->container['attachments'];
    }

    /**
     * Sets attachments
     * @param \Swagger\Client\Model\DocumentInfo[] $attachments
     * @return $this
     */
    public function setAttachments($attachments)
    {
        $this->container['attachments'] = $attachments;

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