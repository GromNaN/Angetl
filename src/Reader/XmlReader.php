<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Reader;

use Angetl\Record;

class XmlReader extends AbstractReader
{
    protected string $recordXpath = '//';
    protected $nodes;
    protected int $currentNodeId = 0;
    protected \DOMXPath $xpath;

    public function __construct(\DOMDocument $document)
    {
        $this->xpath = new \DOMXPath($document);
    }

    /**
     * Set the main xpath expression to split record nodes.
     *
     * @param string $xpath
     *
     * @return XmlReader
     */
    public function setRecordXpath($xpath)
    {
        $this->recordXpath = $xpath;

        return $this;
    }

    public function read(): ?Record
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

        return null;
    }
}
