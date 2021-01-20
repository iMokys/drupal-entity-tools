<?php

namespace Drupal\Utility;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Entity\FieldableEntityInterface;

/**
 * Set of Entity utility methods.
 *
 * @package Drupal\Utility
 */
trait EntityToolsTrait {

  /**
   * Helper function to get a field if field exists.
   *
   * @param \Drupal\Core\Entity\FieldableEntityInterface|\Drupal\Core\Entity\EntityInterface $entity
   *   The entity containing the field.
   * @param string $field_name
   *   The machine name of a field.
   *
   * @return \Drupal\Core\Field\FieldItemListInterface|null
   *   The field object or null if field not exist.
   */
  public static function getField(FieldableEntityInterface $entity, string $field_name): ?FieldItemListInterface {
    if ($entity instanceof FieldableEntityInterface && $entity->hasField($field_name)) {
      return $entity->get($field_name);
    }
    return NULL;
  }

  /**
   * Helper function to check if field exist and get its data value.
   *
   * @param \Drupal\Core\Entity\FieldableEntityInterface|\Drupal\Core\Entity\EntityInterface $entity
   *   The entity containing the field.
   * @param string $field_name
   *   Field machine name.
   * @param mixed $default_value
   *   Default value to return if field doesn't exist or has no value.
   *
   * @return mixed
   *   Return field data value.
   */
  public static function getFieldValue(FieldableEntityInterface $entity, string $field_name, $default_value = NULL) {
    if ($field = static::getField($entity, $field_name)) {
      return $field->getValue() ?? $default_value;
    }
    return $default_value;
  }

  /**
   * Helper function to get a field string if field exists.
   *
   * @param \Drupal\Core\Entity\FieldableEntityInterface|\Drupal\Core\Entity\EntityInterface $entity
   *   The entity containing the field.
   * @param string $field_name
   *   The machine name of a field.
   *
   * @return string
   *   The string of a field or an empty string if field is not exist.
   */
  public static function getFieldString(FieldableEntityInterface $entity, string $field_name): string {
    if ($field = static::getField($entity, $field_name)) {
      return $field->getString();
    }
    return '';
  }

  /**
   * Helper function to check if field exist and get it property.
   *
   * @param \Drupal\Core\Entity\FieldableEntityInterface|\Drupal\Core\Entity\EntityInterface $entity
   *   The entity containing the data to be displayed.
   * @param string $field_name
   *   Machine field name.
   * @param string $property
   *   The name of the property (e.g. foaf:name)
   *
   * @return mixed
   *   Return null or an entity property.
   */
  public static function getFieldProperty(FieldableEntityInterface $entity, string $field_name, $property = 'value') {
    if ($field = static::getField($entity, $field_name)) {
      return $field->{$property};
    }
    return NULL;
  }

  /**
   * Check if field exist and get an array of properties of every value.
   *
   * @param \Drupal\Core\Entity\FieldableEntityInterface|\Drupal\Core\Entity\EntityInterface $entity
   *   The entity containing the field.
   * @param string $field_name
   *   Field machine name.
   * @param string $property
   *   The name of the property (e.g. value[name])
   * @param mixed $default_value
   *   Default value to return if field doesn't exist or has no value.
   *
   * @return mixed
   *   Return field data value.
   */
  public static function getFieldValueProperty(FieldableEntityInterface $entity, string $field_name, $property = 'value', $default_value = []) {
    $ret = [];
    if ($field = static::getField($entity, $field_name)) {
      $value = $field->getValue() ?? $default_value;
    }
    if (!is_array($value)) {
      return $default_value;
    }
    foreach ($value as $delta => $properties) {
      if (!isset($properties[$property])) {
        continue;
      }

      $ret[$delta] = $properties[$property];
    }
    return $ret;
  }

}
