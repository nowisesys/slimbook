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

use SlimBook\Handler;

/**
 * HTML output render class.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
class Html implements Formatter
{

        public function render(Handler $handler)
        {
                $xmldoc = $handler->getDocument();
                $chapter = $handler->getChapter();
                print_r($handler);
        }

}