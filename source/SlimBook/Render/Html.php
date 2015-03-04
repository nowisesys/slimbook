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

/**
 * HTML output render class.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
class Html extends FormatterBase
{

        public function write($mode = Formatter::WRITE_ALL, $file = null)
        {
                $this->open($file);

                if ($mode & Formatter::WRITE_TITLE) {
                        $this->writeTitle();
                }
                if ($mode & Formatter::WRITE_TOC) {
                        $this->writeTOC();
                }
                if ($mode & Formatter::WRITE_BODY) {
                        $this->writeBody();
                }
                if ($mode & Formatter::WRITE_FOOTER) {
                        $this->writeFooter();
                }

                $this->close();
        }

        private function writeTitle()
        {
                if (count($this->chapters) == 1) {
                        printf("<title>%s - %s</title>\n", $this->info->title, $this->chapters[0]['title']);
                } else {
                        printf("<title>%s</title>\n", $this->info->title);
                }
        }

        private function writeTOC()
        {
                
        }

        private function writeBody()
        {
                
        }

        private function writeFooter()
        {
                
        }

}
