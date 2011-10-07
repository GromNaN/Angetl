<?php

namespace Angetl\Reader;

interface Reader
{
    function open();
    function read();
    function close();
}
