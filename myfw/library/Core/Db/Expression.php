<?php
class Core_Db_Expression
{

    private $expression;

	/**
	 * Skip parameter binding on values.
	 * @var bool
	 */
	public $skipBinding;

	/**
	 * Use OR statement instead of AND
	 * @var bool
	 */
	public $useOrStatement;

    function  __construct($expression, $useOrStatement=FALSE, $skipBinding=FALSE) {
        $this->expression = $expression;
		$this->useOrStatement = $useOrStatement;
		$this->skipBinding = $skipBinding;
    }

    function  __toString() {
        return $this->expression;
    }
}
