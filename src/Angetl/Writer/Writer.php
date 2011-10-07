<?php

namespace Angetl\Writer;

interface Writer
{
    function open();
    function write(array $record);
    function close();
}
