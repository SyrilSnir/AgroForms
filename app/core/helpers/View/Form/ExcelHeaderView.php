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
    private $_isGroup;
    /**
     * 
     * @var bool
     */
    private $_isMultiColumns;
    /**
     * 
     * @var self[]
     */
    private $_childrenElements = [];
    
    public function __construct(string $_title, int $_length, bool $isGroup = false,$isMultiColumns = false)
    {
        $this->_title = $_title;
        $this->_length = $_length;
        $this->_isGroup = $isGroup;
        $this->_isMultiColumns = $isMultiColumns;
    }
    public function getTitle(): string
    {
        return $this->_title;
    }

    public function getLength(): int
    {
        return $this->_length;
    }
    
    public function addChild(ExcelHeaderView $child): void
    {
        array_push($this->_childrenElements, $child);
    }
    
    public function hasChildren(): bool
    {
        return !empty($this->_childrenElements);
    }
    
    public function getChildren(): array
    {
        return $this->_childrenElements;
    }

    public function isGroup(): bool 
    {
        return $this->_isGroup;
    }
    
    public function isMultiColumns(): bool
    {
        return $this->_isMultiColumns;
    }


}
