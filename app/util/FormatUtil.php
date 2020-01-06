<?php

class FormatUtil {
	
	private function createFormatter($property) {
		return new MessageFormatter(FORMATTER_LANG_ET, $property);
	}
	
	public static function formatString($property, ...$values) {
		$messageFormatter = $this->createFormatter($property);
		return $messageFormatter->format($values);
	}
}
