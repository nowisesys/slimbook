<?php

use SlimBook\Handler;
use SlimBook\Render\Html as HtmlFormatter;

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

/*
 * Render SlimBook XML document.
 * 
 * Users are encourage to customize this handler.
 * 
 * Author: Anders Lövgren
 * Date:   2015-03-02
 */

require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

//$xml = simplexml_load_file('/var/www/localhost/htdocs/slimbook/book.xml', 'SimpleXMLElement', 0, 'ns1', true);
//print_r($xml);
//print_r($xml->getNamespaces());
//print_r($xml->children());
//exit(1);

$xml = simplexml_load_file('/var/www/localhost/htdocs/slimbook/book.xml');
print_r($xml);
print_r($xml->getNamespaces());
print_r($xml->children('ns1', true));
exit(1);

$xmldoc = sprintf("%s%s", filter_input(INPUT_SERVER, 'DOCUMENT_ROOT'), filter_input(INPUT_SERVER, 'SCRIPT_NAME'));

$handler = new Handler($xmldoc);
$handler->setFormatter(new HtmlFormatter());
$handler->setChapter(filter_input(INPUT_GET, 'chapter'));
$handler->output();
