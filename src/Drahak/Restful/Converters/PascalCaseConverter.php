<?php
namespace Drahak\Restful\Converters;

use Drahak\Restful\Utils\Strings;
use Nette\SmartObject;

/**
 * PascalCaseConverter
 * @package Drahak\Restful\Converters
 * @author Drahomír Hanák
 */
class PascalCaseConverter implements IConverter
{
    use SmartObject;

	/**
	 * Converts resource data keys to PascalCase
	 * @param array $resource
	 * @return array
	 */
	public function convert(array $resource)
	{
		$this->convertToPascal($resource);
		return $resource;
	}

	/**
	 * Convert array keys to camel case
	 * @param array|\Traversable $array
	 */
	private function convertToPascal(&$array)
	{
		if ($array instanceof \Traversable) {
			$array = iterator_to_array($array);
		}

		foreach (array_keys($array) as $key) {
			$value = &$array[$key];
			unset($array[$key]);

			$transformedKey = Strings::toPascalCase($key);
			if (is_array($value) || $value instanceof \Traversable) {
				$this->convertToPascal($value);
			}
			$array[$transformedKey] = $value;
			unset($value);
		}
	}

}
