<?php

namespace Angetl\Reader;

use Angetl\Record;

class XmlReader extends AbstractReader
{
    protected $recordXpath = '//';
    protected $nodes;
    protected $currentNodeId = 0;
    /**
     * @var \DOMXpath
     */
    protected $xpath;

    public function __construct(\DOMDocument $document)
    {
        parent::__construct();
        $this->xpath = new \DOMXPath($document);
    }

    /**
     * Set the main xpath expression to split record nodes.
     *
     * @param string $xpath
     * @return XmlReader
     */
    public function setRecordXpath($xpath)
    {
        $this->recordXpath = $xpath;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        if (null === $this->nodes) {
            $this->nodes = $this->xpath->query($this->recordXpath);
        }

        if ($node = $this->nodes->item($this->currentNodeId++)) {
            $record = new Record();
            foreach ($this->fields as $fieldName => $xpath) {
                $record[$fieldName] = $this->xpath->evaluate($xpath, $node);
            }

            return $record;
        }

        return false;
    }
}
