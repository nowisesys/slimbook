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
 * Interface for output formatter (render classes).
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
interface Formatter
{

        /**
         * HTML rendition.
         */
        const RENDER_HTML = "html";
        /**
         * Write document title.
         */
        const WRITE_TITLE = 1;
        /**
         * Write table of content (TOC).
         */
        const WRITE_TOC = 2;
        /**
         * Write document body.
         */
        const WRITE_BODY = 4;
        /**
         * Write document footer.
         */
        const WRITE_FOOTER = 8;
        /**
         * Write all document parts.
         */
        const WRITE_ALL = 15;

        /**
         * Set page/book information.
         * @param SimpleXMLElement $simple
         */
        function setInfo($simple);

        /**
         * Add chapter to render.
         * @param SimpleXMLElement $simple
         */
        function addChapter($simple);

        /**
         * Set array of chapters to render.
         * @param array $simple Array of simple XML objects.
         */
        function setChapters($simple);

        /**
         * Set chapter to render.
         * @param SimpleXMLElement $simple
         */
        function setChapter($simple);

        /**
         * Write document content.
         * 
         * @param int $mode The write mode. One or more of the WRITE_XXX constants.
         * @param resource|string $file The output stream or destination file.
         */
        function write($mode = Formatter::WRITE_ALL, $file = null);
}
