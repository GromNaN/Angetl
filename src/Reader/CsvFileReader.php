<?php

declare(strict_types=1);

/*
 * This file is part of gromnan/angetl.
 * (c) Jérôme Tamarelle <https://github.com/GromNaN>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Angetl\Reader;

class CsvFileReader extends CsvReader
{
    /**
     * Constructor.
     *
     * @see CsvReader::__construct()
     *
     * @param string    $filename   Path to the file
     * @param array     $options    Reader's options
     */
    public function __construct($filename, array $options = [])
    {
        if (!is_file($filename)) {
            throw new \InvalidArgumentException(sprintf('Invalid file name: "%s"', $filename));
        }
        if (false === $handle = fopen($filename, 'r')) {
            throw new \RuntimeException(sprintf('Unable to read file "%s"', $filename));
        }

        parent::__construct($handle, $options);
    }
}
