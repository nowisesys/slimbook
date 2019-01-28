<?php

/*
 * Copyright (C) 2015-2017 Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University).
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
use SlimBook\Render\Html as HtmlFormatter;
use SlimBook\Render\Latex as LatexFormatter;

/**
 * The handler for SlimBook XML documents.
 *
 * @author Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University)
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
        private $_xmldoc;
        /**
         * The SimpleXML object.
         * @var SimpleXMLElement 
         */
        private $_simple;
        /**
         * The chapter to process.
         * @var string 
         */
        private $_chapter;
        /**
         * The output formatter.
         * @var Formatter 
         */
        private $_formatter;

        /**
         * Constructor.
         * @param string $xmldoc The XML document path.
         */
        public function __construct($xmldoc)
        {
                $this->_xmldoc = $xmldoc;
                $this->_simple = simplexml_load_file($this->_xmldoc, null, 0, self::NS);
        }

        /**
         * Set the chapter to process.
         * @param string $chapter
         */
        public function setFilter($chapter)
        {
                $this->_chapter = $chapter;
        }

        /**
         * Get the chapter to process.
         * @return string
         */
        public function getFilter()
        {
                return $this->_chapter;
        }

        /**
         * Return the XML object.
         * @return SimpleXMLElement
         */
        public function getDocument()
        {
                return $this->_simple;
        }

        /**
         * Set formatter for output.
         * @param type $formatter
         */
        public function setFormatter($formatter)
        {
                $this->_formatter = $formatter;
        }

        /**
         * Get target namespace.
         * @return string The target namespace.
         */
        public function getNamespace()
        {
                foreach ($this->_simple->getNamespaces() as $ns) {
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
                foreach ($this->_simple->getNamespaces() as $prefix => $ns) {
                        if ($ns == self::NS) {
                                return $prefix;
                        }
                }

                return false;
        }

        /**
         * Prepare formatter.
         * 
         * Prepares a formatter for output by initializing it with info and chapters 
         * using the current loaded XML document and filter options. 
         * 
         * The formatter argument is either a string (create new formatter) or an 
         * object (use the passed formatter). If argument is null, then the formatter
         * set by calling setFormatter() is used.
         * 
         * The $formatter can be one of the RENDER_XXX constants defined by the 
         * Formatter interface.
         * 
         * @param string|Formatter $formatter The formatter object or string.
         * @return Formatter
         */
        public function prepare($formatter = null)
        {
                if (!isset($formatter)) {
                        $formatter = $this->_formatter;
                } elseif (is_string($formatter)) {
                        if ($formatter == Formatter::RENDER_HTML) {
                                $formatter = new HtmlFormatter();
                        } elseif ($formatter == Formatter::RENDER_LATEX) {
                                $formatter = new LatexFormatter();
                        } else {
                                throw new \Exception("Unknown formatter '$formatter'");
                        }
                }

                $filter = new XmlFilter($this->_simple);

                $formatter->setInfo($filter->getInfo());
                $formatter->setChapters($filter->getChapters($this->getFilter()));

                return $formatter;
        }

}
