<?php

namespace Angetl\Reader;

use Angetl\AbstractReader;

class XmlReader extends AbstractReader
{
    protected $recordXpath;
    protected $filename;
    protected $nodes;
    protected $currentRecordId;

    /**
     * @var \DOMXpath
     */
    protected $xpath;

    public function __construct($filename)
    {
        parent::__construct();
        $this->fields = array();
        $this->filename = realpath($filename);
    }

    public function setRecordXpath($xpath)
    {
        $this->recordXpath = $xpath;

        return $this;
    }

    protected function _open()
    {
        $document = new \DOMDocument();
        $document->load($this->filename);

        $this->xpath = new \DOMXPath($document);
        $this->nodes = $this->xpath->query($this->recordXpath);
        $this->currentRecordId = 0;
    }

    protected function _close()
    {
        unset($this->nodes, $this->xpath);
    }

    protected function _read()
    {
        if ($node = $this->nodes->item($this->currentRecordId++)) {
            foreach ($this->fields as $fieldName => $xpath) {
                $this->currentRecord[$fieldName] = $this->xpath->evaluate($xpath, $node);
            }

            return true;
        }

        return false;
    }
}
