<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Writer;

use Angetl\Record;

interface Writer
{
    /**
     * Write a record.
     *
     * @param Record $record record to write
     */
    public function write(Record $record): void;
}
