<?php

if (version_compare(PHP_VERSION, '5.5.0', '<'))
{
	class DateTimeImmutable
	{
		/**
		 * @var DateTime
		 */
		protected $datetime;

		public function __construct($time = "now", \DateTimeZone $timezone = null) {
			$this->datetime = new \DateTime($time, $timezone);
		}

		public static function createFromMutable( \DateTime $datetime) {
			$self = new self();
			$self->datetime = clone $datetime;
			return $self;
		}

		public function __call($name, $arguments) {
			$result = call_user_func([clone $this->datetime, $name], $arguments);
			if ($result instanceof \DateTime)
			{
				$self = new self();
				$self->datetime = $result;
				return $self;
			}
			return $result;
		}

		public static function __callStatic($name, $arguments) {
			$result = \DateTime::$name($arguments);
			if ($result instanceof \DateTime)
			{
				$self = new self();
				$self->datetime = $result;
				return $self;
			}

			return $result;
		}
	}
}


