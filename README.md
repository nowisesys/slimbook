# Slimbook
## Simple XML schema for web page markup and type setting of online books/manuals.

This package provides a simple XML schema targeted at writing technical manuals
in either book (multiple chapters) or page (single chapter) form.

The XML schema can be used on its own or together with the PHP classes provided
by this package. Using the PHP classes, its possible to render the SlimBook XML
document in various formats (e.g. HTML, PDF, DVI, MS Word or LaTeX/TeX). 

Integrate handler.php with Apache to provide an XML based web site.

### Directories:

   o) public:

    This directory contains the XML schema, DTD and some examples. For core users
    doing their own formatting, the slimbook.xsd is all you need.

   o) source:

    This directory contains the PHP code for rendering SlimBook XML schema 
    constraint documents in various output formats.

### Install:

   1. Either install by unpacking the source somewhere outside the web root. You
      need to require the relevant files in your PHP scripts.

   2. Install using composer:

```bash
bash$> composer require nowise/slimbook
```

This command should take care of deploying slimbook along with its 
dependencies.

### Setup:

   The SlimBook handler can be integrated with the Apache web server to dynamic
   render all XML document. Create a config protected file and include in your
   virtual host definition:

```bash
bash$> cd $appdir
bash$> cp config/apache.conf.in config/apache.conf
```

   Edit apache.conf and include it in your Apache configuration file.
