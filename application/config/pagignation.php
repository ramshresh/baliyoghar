<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| URI Segment that contains page number
|--------------------------------------------------------------------------
|
| The pagination function automatically determines
| which segment of your URI contains the page
| number. If you need something different
| you can specify it.
|
*/
$config['uri_segment'] = 3;

/*
|--------------------------------------------------------------------------
| Number of "digit" links before and after selected page
|--------------------------------------------------------------------------
|
| The number of “digit” links you would like before and
| after the selected page number. For example, the
| number 2 will place two digits on either side,
| as in the example links at the very top of
| this page.
|
*/
$config['num_links'] = 2;

/*
|--------------------------------------------------------------------------
| Use Page Number
|--------------------------------------------------------------------------
|
| By default, the URI segment will use the starting index
| for the items you are paginating. If you prefer to
| show the the actual page number, set this to TRUE.
|
*/
$config['use_page_numbers'] = TRUE;

/*
|--------------------------------------------------------------------------
| Query String
|--------------------------------------------------------------------------
|
| By default, the pagination library assume you are using
| URI Segments, and constructs your links something
| like: http://example.com/index.php/test/page/20
| If you have $config['enable_query_strings'] set to TRUE
| your links will automatically be re-written using
| Query Strings. This option can also be
| explicitly set. Using $config['page_query_string']
| set to TRUE, the pagination link will
| become:
| http://example.com/index.php?c=test&m=page&per_page=20
|
*/
$config['page_query_string'] = TRUE;


/*
|--------------------------------------------------------------------------
| Default Query String
|--------------------------------------------------------------------------
|
| Note that “per_page” is the default query string
| passed, however can be configured
*/
$config['query_string_segment'] = 'per_page';

/*
|--------------------------------------------------------------------------
| Reuse Query String | CI Version 3.0
|--------------------------------------------------------------------------
|
| By default your Query String arguments (nothing to do
| with other query string options) will be ignored.
| Setting this config to TRUE will add existing
| query string arguments back into the URL
| after the URI segment and before
| the suffix.:
| http://example.com/index.php/test/page/20?query=search%term
| This helps you mix together normal URI Segments as well as query string arguments, which until 3.0 was not possible.
*/
//$config['reuse_query_string'] = FALSE;

/*
 OTHER Config : https://www.codeigniter.com/userguide3/libraries/pagination.html
 $config[‘prefix’] = ‘’;

A custom prefix added to the path. The prefix value will be right before the offset segment.

$config[‘suffix’] = ‘’;

A custom suffix added to the path. The sufix value will be right after the offset segment.

$config[‘use_global_url_suffix’] = FALSE;

When set to TRUE, it will override the $config['suffix'] value and instead set it to the one that you have in $config['url_suffix'] in your application/config/config.php file.

Adding Enclosing Markup
If you would like to surround the entire pagination with some markup you can do it with these two preferences:

$config[‘full_tag_open’] = ‘<p>’;

The opening tag placed on the left side of the entire result.

$config[‘full_tag_close’] = ‘</p>’;

The closing tag placed on the right side of the entire result.

Customizing the First Link
$config[‘first_link’] = ‘First’;

The text you would like shown in the “first” link on the left. If you do not want this link rendered, you can set its value to FALSE.

Note

This value can also be translated via a language file.
$config[‘first_tag_open’] = ‘<div>’;

The opening tag for the “first” link.

$config[‘first_tag_close’] = ‘</div>’;

The closing tag for the “first” link.

$config[‘first_url’] = ‘’;

An alternative URL to use for the “first page” link.

Customizing the Last Link
$config[‘last_link’] = ‘Last’;

The text you would like shown in the “last” link on the right. If you do not want this link rendered, you can set its value to FALSE.

Note

This value can also be translated via a language file.
$config[‘last_tag_open’] = ‘<div>’;

The opening tag for the “last” link.

$config[‘last_tag_close’] = ‘</div>’;

The closing tag for the “last” link.

Customizing the “Next” Link
$config[‘next_link’] = ‘&gt;’;

The text you would like shown in the “next” page link. If you do not want this link rendered, you can set its value to FALSE.

Note

This value can also be translated via a language file.
$config[‘next_tag_open’] = ‘<div>’;

The opening tag for the “next” link.

$config[‘next_tag_close’] = ‘</div>’;

The closing tag for the “next” link.

Customizing the “Previous” Link
$config[‘prev_link’] = ‘&lt;’;

The text you would like shown in the “previous” page link. If you do not want this link rendered, you can set its value to FALSE.

Note

This value can also be translated via a language file.
$config[‘prev_tag_open’] = ‘<div>’;

The opening tag for the “previous” link.

$config[‘prev_tag_close’] = ‘</div>’;

The closing tag for the “previous” link.

Customizing the “Current Page” Link
$config[‘cur_tag_open’] = ‘<b>’;

The opening tag for the “current” link.

$config[‘cur_tag_close’] = ‘</b>’;

The closing tag for the “current” link.

Customizing the “Digit” Link
$config[‘num_tag_open’] = ‘<div>’;

The opening tag for the “digit” link.

$config[‘num_tag_close’] = ‘</div>’;

The closing tag for the “digit” link.

Hiding the Pages
If you wanted to not list the specific pages (for example, you only want “next” and “previous” links), you can suppress their rendering by adding:

$config['display_pages'] = FALSE;
Adding attributes to anchors
If you want to add an extra attribute to be added to every link rendered by the pagination class, you can set them as key/value pairs in the “attributes” config:

// Produces: class="myclass"
$config['attributes'] = array('class' => 'myclass');
Note

Usage of the old method of setting classes via “anchor_class” is deprecated.
Disabling the “rel” attribute
By default the rel attribute is dynamically generated and appended to the appropriate anchors. If for some reason you want to turn it off, you can pass boolean FALSE as a regular attribute

$config['attributes']['rel'] = FALSE;
Class Reference
class CI_Pagination
initialize([$params = array()])
Parameters:
$params (array) – Configuration parameters
Returns:
CI_Pagination instance (method chaining)

Return type:
CI_Pagination

Initializes the Pagination class with your preferred options.

create_links()
Returns:	HTML-formatted pagination
Return type:	string
Returns a “pagination” bar, containing the generated links or an empty string if there’s just a single page.

Next  Previous

*/