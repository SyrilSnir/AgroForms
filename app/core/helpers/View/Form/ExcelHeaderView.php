<?php

namespace app\core\helpers\View\Form;

/**
 * Description of ExcelHeaderView
 *
 * @author kotov
 */
class ExcelHeaderView
{
    /**
     * 
     * @var string
     */
    private $_title;
    /**
     * 
     * @var int
     */
    private $_length;
    /**
     * 
     * @var bool
     */
    private $_hasChilden;
    /**
     * 
     * @var self[]
     */
    private $_childrenElements = [];
    
    public function __construct(string $_title, int $_length, bool $_hasCildren = false)
    {
        $this->_title = $_title;
        $this->_length = $_length;
        $this->_hasChilden = $_hasCildren;
    }
    public function getTitle(): string
    {
        return $this->_title;
    }

    public function getLength(): int
    {
        return $this->_length;
    }


}
