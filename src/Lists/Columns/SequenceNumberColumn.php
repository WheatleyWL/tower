<?php


namespace zedsh\tower\Lists\Columns;

class SequenceNumberColumn extends BaseColumn
{
    public $sequenceNumber = 0;

    public function render()
    {
        $this->sequenceNumber++;

        return $this->sequenceNumber;
    }
}
