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

namespace SlimBook\CLI;

use SlimBook\Handler;
use SlimBook\Render\Formatter;

// 
// Try to load autoloader in deploy mode first:
// 
if (file_exists(__DIR__ . '/../../../../vendor')) {
        require_once(realpath(__DIR__ . '/../../../../vendor/autoload.php'));   // Deployed
} elseif (file_exists(__DIR__ . '/../vendor')) {
        require_once(realpath(__DIR__ . '/../vendor/autoload.php'));            // Development
} else {
        die(__FILE__ . ":" . __LINE__ . ": No autoload.php was found");
}

/**
 * Helper class for parsing command line options.
 */
class Option
{

        /**
         * The option key.
         * @var string 
         */
        public $key;
        /**
         * The option value.
         * @var string 
         */
        public $val;

        /**
         * Constructor.
         * @param string $arg The option string (e.g. --xmldoc=file).
         */
        public function __construct($arg)
        {
                if (strpos($arg, '=')) {
                        list($this->key, $this->val) = explode('=', $arg);
                } else {
                        list($this->key, $this->val) = array($arg, null);
                }
        }

}

/**
 * SlimBook CLI application.
 *
 * @author Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University)
 */
class Application
{

        /**
         * Program name.
         * @var string 
         */
        private $_prog;
        /**
         *
         * @var Handler 
         */
        private $_handler;
        /**
         * The output format.
         * @var string 
         */
        private $_format;
        /**
         * The output file.
         * @var string 
         */
        private $_output;

        /**
         * Print usage information.
         */
        public function usage()
        {
                printf("%s - SlimBook XML document rendering application\n", $this->_prog);
                printf("\n");
                printf("Usage: %s --xmldoc=file [--chapter=name] [--format=str]\n", $this->_prog);
                printf("Options:\n");
                printf("  -X file,--xmldoc=file:  The XML document to render.\n");
                printf("  -C name,--chapter=name: Name of chapter to render.\n");
                printf("  -F str,--format=str:    The output format (e.g. html or pdf)\n");
                printf("  -O file,--output=file:  Write output to file (defaults to stdout).\n");
                printf("  -h,--help:              This casual help.\n");
                printf("\n");
                printf("Example:\n");
                printf("  %s --xmldoc=public/citrus.xml --chapter=taxonomy --format=html\n", $this->_prog);
                printf("\n");
                printf("Copyright (C) 2015 Anders Lövgren, Computing Department at BMC, Uppsala University.\n");
        }

        /**
         * Parse command line options.
         * @param int $argc The number of options.
         * @param array $argv The array of command line options.
         */
        public function parse($argc, $argv)
        {
                $this->_prog = basename($_SERVER['SCRIPT_FILENAME']);

                for ($i = 0; $i < $argc; $i++) {
                        $option = new Option($argv[$i]);
                        if ($option->key[0] != '-') {
                                continue;
                        }
                        if (!isset($option->val) && isset($argv[$i + 1]) && $argv[$i + 1] != '-') {
                                $option->val = $argv[++$i];
                        }

                        switch ($option->key) {
                                case "-h":
                                case "--help":
                                        $this->usage();
                                        exit(0);
                                case "-X":
                                case "--xmldoc":
                                        $this->_handler = new Handler($option->val);
                                        break;
                                case "-C":
                                case "--chapter":
                                        $this->_handler->setFilter($option->val);
                                        break;
                                case "-F":
                                case "--format":
                                        $this->_format = $option->val;
                                        break;
                                case "-O":
                                case "--output":
                                        $this->_output = $option->val;
                                        break;
                        }
                }
        }

        /**
         * Process command request.
         */
        public function process()
        {
                if (!isset($this->_handler)) {
                        return;
                }
                try {
                        $formatter = $this->_handler->prepare($this->_format);
                        $formatter->write(Formatter::WRITE_ALL, $this->_output);
                } catch (\Exception $exception) {
                        fprintf(STDERR, "%s: %s\n", $this->_prog, $exception->getMessage());
                }
        }

}

$application = new Application();
$application->parse($_SERVER['argc'], $_SERVER['argv']);
$application->process();
