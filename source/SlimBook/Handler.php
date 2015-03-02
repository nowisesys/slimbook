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
use SlimBook\Render\Formatter;

/**
 * The handler for SLimBook XML documents.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
class Handler
{

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
         * Load and return SimpleXML object.
         * @return SimpleXMLElement
         */
        public function getDocument()
        {
                if (!isset($this->simple)) {
                        $this->simple = simplexml_load_file($this->xmldoc);
                }
                
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
         * Output document using current set output formatter.
         */
        public function output()
        {
                $this->formatter->render($this);
        }

}
