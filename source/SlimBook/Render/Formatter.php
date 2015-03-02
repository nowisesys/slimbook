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

use SimpleXMLElement;
use SlimBook\Handler;

/**
 * Interface for output formatter (render classes).
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
interface Formatter
{

        /**
         * The render function.
         * @param Handler $handler The handler object.
         */
        function render(Handler $handler);

        /**
         * Set page/book information.
         * @param SimpleXMLElement $simple
         */
        function setInfo(SimpleXMLElement $simple);

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
}
