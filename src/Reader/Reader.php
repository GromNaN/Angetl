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

interface Reader
{
    /**
     * Read the next record.
     *
     * return Record|bool The record read. false is returned at the end.
     */
    public function read();
}
