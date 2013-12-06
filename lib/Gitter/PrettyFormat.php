<?php

/*
 * This file is part of the Gitter library.
 *
 * (c) Klaus Silveira <klaussilveira@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitter;

class PrettyFormat
{
    public function parse($output)
    {
        if (empty($output)) {
            throw new \RuntimeException('No data available');
        }

        $output = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
        $data = $this->iteratorToArray(new \SimpleXmlIterator("<data>$output</data>"));

        return $data['item'];
    }

    protected function iteratorToArray($iterator)
    {
        foreach ($iterator as $key => $item) {
            if ($iterator->hasChildren()) {
                $data[$key][] = $this->iteratorToArray($item);
                continue;
            }

            $data[$key] = trim(strval($item));
        }

        return $data;
    }
}
