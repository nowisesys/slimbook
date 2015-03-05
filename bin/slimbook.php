<?php

use SlimBook\Handler;

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

require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

/**
 * Helper class for parsing command line options.
 */
class Option
{

        public $key;
        public $val;

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
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
class Application
{

        /**
         * Program name.
         * @var string 
         */
        private $prog;
        /**
         *
         * @var Handler 
         */
        private $handler;
        /**
         * The output format.
         * @var string 
         */
        private $format;
        /**
         * The output file.
         * @var string 
         */
        private $output;

        /**
         * Print usage information.
         */
        public function usage()
        {
                printf("%s - SlimBook XML document rendering application\n", $this->prog);
                printf("\n");
                printf("Usage: %s --xmldoc=file [--chapter=name] [--format=str]\n", $this->prog);
                printf("Options:\n");
                printf("  -X file,--xmldoc=file:  The XML document to render.\n");
                printf("  -C name,--chapter=name: Name of chapter to render.\n");
                printf("  -F str,--format=str:    The output format (e.g. html or pdf)\n");
                printf("  -O file,--output=file:  Write output to file (defaults to stdout).\n");
                printf("  -h,--help:              This casual help.\n");
                printf("\n");
                printf("Example:\n");
                printf("  %s --xmldoc=public/citrus.xml --chapter=taxonomy --format=html\n", $this->prog);
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
                $this->prog = basename($_SERVER['SCRIPT_FILENAME']);

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
                                        $this->handler = new Handler($option->val);
                                        break;
                                case "-C":
                                case "--chapter":
                                        $this->handler->setFilter($option->val);
                                        break;
                                case "-F":
                                case "--format":
                                        $this->format = $option->val;
                                        break;
                                case "-O":
                                case "--output":
                                        $this->output = $option->val;
                                        break;
                        }
                }
        }

        /**
         * Process command request.
         */
        public function process()
        {
                try {
                        $formatter = $this->handler->prepare($this->format);
                        $formatter->write(SlimBook\Render\Formatter::WRITE_ALL, $this->output);
                } catch (\Exception $exception) {
                        fprintf(STDERR, "%s: %s\n", $this->prog, $exception->getMessage());
                }
        }

}

$application = new Application();
$application->parse($_SERVER['argc'], $_SERVER['argv']);
$application->process();
