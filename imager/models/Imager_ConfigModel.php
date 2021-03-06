<?php
namespace Craft;

/**
 * Imager by André Elvan
 *
 * @author      André Elvan <http://vaersaagod.no>
 * @package     Imager
 * @copyright   Copyright (c) 2016, André Elvan
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @link        https://github.com/aelvan/Imager-Craft
 */

class Imager_ConfigModel extends BaseModel
{
    var $configOverrideString = '';

    /**
     * Constructor
     * 
     * @param null $overrides
     */
    public function __construct($overrides = null)
    {
        foreach ($this->attributeNames() as $attr) {
            if ($overrides !== null && isset($overrides[$attr])) {
                $this[$attr] = $overrides[$attr];
                $this->_addToOverrideFilestring($attr, $overrides[$attr]);
            } else {
                $this[$attr] = craft()->config->get($attr, 'imager');
            }
        }
        
        if (isset(ImagerService::$craftPositonTranslate[(string)$this->position])) {
            $this->position = ImagerService::$craftPositonTranslate[(string)$this->position];
        } 
            
        $this->position = str_replace('%', '', $this->position);
    }

    protected function defineAttributes()
    {
        return array(
          'imagerSystemPath' => array(AttributeType::String),
          'imagerUrl' => array(AttributeType::String),
          'jpegQuality' => array(AttributeType::Number),
          'pngCompressionLevel' => array(AttributeType::Number),
          'interlace' => array(AttributeType::Mixed),
          'allowUpscale' => array(AttributeType::Bool),
          'resizeFilter' => array(AttributeType::String),
          'smartResizeEnabled' => array(AttributeType::Bool),
          'bgColor' => array(AttributeType::String),
          'position' => array(AttributeType::String),
          'letterbox' => array(AttributeType::Mixed),
          'hashFilename' => array(AttributeType::Bool),
          'hashRemoteUrl' => array(AttributeType::Bool),
          'cacheEnabled' => array(AttributeType::Bool),
          'cacheDuration' => array(AttributeType::Number),
          'cacheDurationRemoteFiles' => array(AttributeType::Number),
          'instanceReuseEnabled' => array(AttributeType::Bool),
          'jpegoptimEnabled' => array(AttributeType::Bool),
          'jpegoptimPath' => array(AttributeType::String),
          'jpegoptimOptionString' => array(AttributeType::String),
          'jpegtranEnabled' => array(AttributeType::Bool),
          'jpegtranPath' => array(AttributeType::String),
          'jpegtranOptionString' => array(AttributeType::String),
          'optipngEnabled' => array(AttributeType::Bool),
          'optipngPath' => array(AttributeType::String),
          'optipngOptionString' => array(AttributeType::String),
          'tinyPngEnabled' => array(AttributeType::Bool),
          'tinyPngApiKey' => array(AttributeType::String),
          'optimizeType' => array(AttributeType::String),
          'logOptimizations' => array(AttributeType::Bool),
          'awsEnabled' => array(AttributeType::Bool),
          'awsAccessKey' => array(AttributeType::String),
          'awsSecretAccessKey' => array(AttributeType::String),
          'awsBucket' => array(AttributeType::String),
          'awsFolder' => array(AttributeType::String),
          'awsCacheDuration' => array(AttributeType::Number),
          'awsRequestHeaders' => array(AttributeType::Mixed),
          'awsStorageType' => array(AttributeType::String),
          'removeMetadata' => array(AttributeType::Bool),
        );
    }

    public function getSetting($name, $transform = null)
    {
        if (isset($transform[$name])) {
            return $transform[$name];
        }
        return $this[$name];
    }

    public function getConfigOverrideString()
    {
        return $this->configOverrideString;
    }

    /**
     * Creates additional file string based on config overrides that is appended to filename
     *
     * @param $transform
     * @return string
     */
    private function _addToOverrideFilestring($k, $v)
    {
        $r = (isset(ImagerService::$transformKeyTranslate[$k]) ? ImagerService::$transformKeyTranslate[$k] : $k) . $v;
        $this->configOverrideString .= '_' . str_replace('%', '', str_replace(array(' ', '.'), '-', $r));
    }

    function __toString()
    {
        return Craft::t($this->url);
    }
}
