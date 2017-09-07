<?php

/*
 * Copyright (C) 2015-2017 Anders Lövgren (QNET/BMC CompDept).
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

namespace SlimBook\Render;

use Exception;
use SimpleXMLElement;

/**
 * Base class for all concrete formatter classes.
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
abstract class FormatterBase implements Formatter
{

        /**
         * The page info.
         * @var SimpleXMLElement 
         */
        protected $_info;
        /**
         * The page chapters.
         * @var SimpleXMLElement 
         */
        protected $_chapters = array();
        /**
         * The output stream.
         * @var resource 
         */
        private $_stream;

        /**
         * Set page/book information.
         * @param SimpleXMLElement $simple
         */
        public function setInfo($simple)
        {
                $this->_info = $simple;
        }

        /**
         * Add chapter to render.
         * @param SimpleXMLElement $simple
         */
        public function addChapter($simple)
        {
                $this->_chapters[] = $simple;
        }

        /**
         * Set array of chapters to render.
         * @param array $simple Array of simple XML objects.
         */
        public function setChapters($simple)
        {
                $this->_chapters = $simple;
        }

        /**
         * Set chapter to render.
         * @param SimpleXMLElement $simple
         */
        public function setChapter($simple)
        {
                $this->_chapters = array($simple);
        }

        /**
         * Write document content.
         * 
         * @param int $mode The write mode. One or more of the WRITE_XXX constants.
         * @param resource|string $file The output stream or destination file.
         */
        abstract public function write($mode = Formatter::WRITE_ALL, $file = null);

        /**
         * Open stream and start output buffering.
         * @param string $file The destination file.
         * @throws Exception
         */
        protected function open($file)
        {
                if (isset($file)) {
                        if (is_resource($file)) {
                                $this->_stream = $file;
                        } else {
                                $this->_stream = fopen($file, "w");
                        }
                        if (!is_resource($this->_stream)) {
                                throw new Exception("Invalid output stream");
                        } else {
                                ob_start();
                        }
                }
        }

        /**
         * Close output buffering and flush content to opened stream.
         */
        protected function close()
        {
                if (isset($this->_stream)) {
                        fwrite($this->_stream, ob_get_clean());
                }
        }

}
