<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
