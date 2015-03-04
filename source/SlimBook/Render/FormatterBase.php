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
        protected $info;
        /**
         * The page chapters.
         * @var SimpleXMLElement 
         */
        protected $chapters = array();
        /**
         * The output stream.
         * @var resource 
         */
        private $stream;

        public function setInfo($simple)
        {
                $this->info = $simple;
        }

        public function addChapter($simple)
        {
                $this->chapters[] = $simple;
        }

        public function setChapters($simple)
        {
                $this->chapters = $simple;
        }

        public function setChapter($simple)
        {
                $this->chapters = array($simple);
        }

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
                                $this->stream = $file;
                        } else {
                                $this->stream = fopen($file, "w");
                        }
                        if (!is_resource($this->stream)) {
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
                if (isset($this->stream)) {
                        fwrite($this->stream, ob_get_clean());
                }
        }

}
