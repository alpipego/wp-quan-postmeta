# quan-postmeta
Replace headspace for title and description
Use of [Advanced Custom Fields Pro](http://www.advancedcustomfields.com/pro/) required

Added fields are
* `quan_meta_title` (string)
* `quan_meta_description` (string)
* `quan_meta_robots` (array)
* `quan_meta_language` (string) [ISO 639-1 Language Code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes)
* `quan_meta_hreflang` (repeater)
    * `quan_meta_hreflang_code` (string) [ISO 639-1 Language Code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) &amp; [ISO 3166-1 alpha-2 Country Code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
    * `quan_meta_hreflang_url` (string/url)

To correctly display the language add `<?php language_attributes(); ?>` to the `html` tag, see: [`languages_attributes()`](https://codex.wordpress.org/Function_Reference/language_attributes)
