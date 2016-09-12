<?php

/**
 * Хелпер для работы со строками, ограниченными какими-либо знаками.
 * Примеры:
 * выборка всех конструкций "[{widget alias="foo"}]";
 * заменить все конструкции "[{setting alias="foo"}]" на значение настройки и т.д.
 *
 * @property string $bracketStart Начало конструкции
 * @property string $bracketEnd Окончание конструкции
 * @property string $text Строка для обработки
 * @property closure $closure Замыкание для применения к каждой конструкции
 * @property regex $regex Регулярное выражение дя поиска конструкций
 */
class Partioneer
{
	public $bracketStart;
	public $bracketEnd;
	public $text;
	public $closure = NULL;
	private $regex = '//';

	// Конструктор класса. Требует открывающую, закрывающую конструкцию, сtроку для обработки и, если необходимо, замыкание
	function __construct($start, $end, $text, $closure = null)
	{
		$this->bracketStart = preg_quote($start, '/');
		$this->bracketEnd = preg_quote($end, '/');
		$this->text = $text;
		if (is_callable($closure)) {
			$this->closure = $closure;
		}
		if (strlen($bracketEnd) > 0) {
			$this->regex = '/' . $this->bracketStart . '([^' .$this->bracketEnd. ']*)' . $this->bracketEnd . '/';
		} else {
			$this->regex = '/' . $this->bracketStart . '(.*)/';
		}
	}

	// Поиск всех конструкций и замена их в исходном тексте на результат применения замыкания
	public function execute()
	{
		if (!is_callable($this->closure)) {
			throw new Exception("Closure function can't be called");
		}
		return preg_replace_callback($this->regex, $this->closure, $this->text);
		
	}

	// Возврат всех найденных конструкций в виде массива
	public function getArray()
	{
		preg_match_all($this->regex, $this->text, $result);
		return $result[1];
	}

}
