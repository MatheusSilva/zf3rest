<?php
namespace Application\Util;

use Zend\I18n\Translator\Translator as ZendI18nTranslator;
use Zend\Validator\Translator\TranslatorInterface;

/**
 * Class Translator
 *
 * The Zend validator expects a translator that implements a specific interface
 * The zend i18n translator does not implement this interface
 * the zend-mvc translator did but it's being refactored
 * Related issued
 *   https://github.com/zendframework/zend-validator/issues/142
 *   https://github.com/zendframework/zend-validator/issues/95
 * @package Application\Util
 */
class Translator extends ZendI18nTranslator implements TranslatorInterface
{
    // nothing to do here as both modules share the same translator api
}

