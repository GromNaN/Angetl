<?php

namespace Angetl\Reader;

class RssReader extends XmlReader
{
    public function __construct($filename)
    {
        parent::__construct($filename);

        $this
            ->setRecordXpath('//channel/item')
            ->addField('title', 'string(title/text())')
            ->addField('link', 'string(link/text())')
            ->addField('description', 'string(description/text())')
            ->addField('pubDate', 'string(pubDate/text())')
            ->addField('guid', 'string(guid/text())')
        ;
    }

}
