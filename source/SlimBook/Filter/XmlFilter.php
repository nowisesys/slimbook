<?php

/*
 * Copyright (C) 2015 Anders Lövgren (QNET/BMC CompDept).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace SlimBook\Filter;

use SimpleXMLElement;

/**
 * XML document filter.
 *
 * @author Anders Lövgren (Computing Department at BMC, Uppsala University)
 */
class XmlFilter
{

        /**
         * @var \SimpleXMLElement 
         */
        private $simple;

        /**
         * Constructor.
         * @param \SimpleXMLElement $simple
         */
        public function __construct(\SimpleXMLElement $simple)
        {
                $this->simple = $simple;
        }

        /**
         * Get info object.
         * @return SimpleXMLElement
         */
        public function getInfo()
        {
                return $this->simple->info;
        }

        /**
         * Get filtered array of chapters.
         * @param string $chapter The chapter name filter.
         * @return array
         */
        public function getChapters($chapter = null)
        {
                if ($chapter == null) {
                        if (isset($this->simple->chapter->paragraph)) {
                                $result = array($this->simple->chapter);
                                return $result;
                        } else {
                                $result = $this->simple->chapter;
                                return $result;
                        }
                } else {
                        foreach ($this->simple->chapter as $c) {
                                foreach ($c->attributes() as $a) {
                                        if ($a == $chapter) {
                                                return array($c);
                                        }
                                }
                        }
                }
        }

}
