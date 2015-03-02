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

namespace SlimBook;

use SimpleXMLElement;
use SlimBook\Filter\XmlFilter;
use SlimBook\Render\Formatter;

/**
 * The handler for SLimBook XML documents.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
class Handler
{
        /**
         * The SlimBook namespace.
         */
        const NS = 'http://it.bmc.uu.se/compdept/slimbook';

        /**
         * The XML document path.
         * @var string 
         */
        private $xmldoc;
        /**
         * The SimpleXML object.
         * @var \SimpleXMLElement 
         */
        private $simple;
        /**
         * The chapter to process.
         * @var string 
         */
        private $chapter;
        /**
         * The output formatter.
         * @var Formatter 
         */
        private $formatter;

        /**
         * Constructor.
         * @param string $xmldoc The XML document path.
         */
        public function __construct($xmldoc)
        {
                $this->xmldoc = $xmldoc;
                $this->simple = simplexml_load_file($this->xmldoc, null, 0, self::NS);
        }

        /**
         * Set the chapter to process.
         * @param string $chapter
         */
        public function setChapter($chapter)
        {
                $this->chapter = $chapter;
        }

        /**
         * Get the chapter to process.
         * @return string
         */
        public function getChapter()
        {
                return $this->chapter;
        }

        /**
         * Return the XML object.
         * @return SimpleXMLElement
         */
        public function getDocument()
        {
                return $this->simple;
        }

        /**
         * Set formatter for output.
         * @param type $formatter
         */
        public function setFormatter($formatter)
        {
                $this->formatter = $formatter;
        }

        /**
         * Get target namespace.
         * @return string The target namespace.
         */
        public function getNamespace()
        {
                foreach ($this->simple->getNamespaces() as $ns) {
                        if ($ns == self::NS) {
                                return $ns;
                        }
                }

                return null;
        }

        /**
         * Get target namespace prefix.
         * @return string|boolean The target namespace prefix or false if not set.
         */
        public function getPrefix()
        {
                foreach ($this->simple->getNamespaces() as $prefix => $ns) {
                        if ($ns == self::NS) {
                                return $prefix;
                        }
                }

                return false;
        }

        /**
         * Output document using current set output formatter.
         */
        public function output()
        {
                $filter = new XmlFilter($this->simple);

                $this->formatter->setInfo($filter->getInfo());
                $this->formatter->setChapters($filter->getChapters($this->getChapter()));

                $this->formatter->render($this, $this->getNamespace());
        }

}
