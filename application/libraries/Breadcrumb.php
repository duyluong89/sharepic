<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Breadcrumb Class
 *
 * This class manages the breadcrumb object
 *
 * @package		Breadcrumb
 * @version		1.0
 * @author 		Richard Davey <info@richarddavey.com>
 * @copyright 	Copyright (c) 2011, Richard Davey
 * @link		https://github.com/richarddavey/codeigniter-breadcrumb
 */
class Breadcrumb {

	/**
	 * Breadcrumbs stack
	 *
     */
	private $breadcrumbs	= array();
	/**
	 * Options
	 *
	 */
	private $_prefix_crumb = '';
	private $_divider      = '';
	private $_tag_open     = '<ol id="breadcrumb" class="breadcrumb">';
	private $_tag_close    = '</ol>';

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}

		log_message('debug', "Breadcrumb Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	private function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->{'_' . $key}))
				{
					$this->{'_' . $key} = $val;
				}
			}
		}
	}

	function set_divider($str = ''){
		$this->_divider = $str;
	}

	function set_prefix_crumb($str = ''){
		if (!empty($str)){
			$this->_prefix_crumb = $str;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Append crumb to stack
	 *
	 * @access	public
	 * @param	string $title
	 * @param	string $href
	 * @return	void
	 */
	function append_crumb($title, $href = '')
	{
		// no title or href provided
		if (!$title OR !$href) return;

		// add to end
		$this->breadcrumbs[] = array('title' => $title, 'href' => $href);
	}

	// --------------------------------------------------------------------

	/**
	 * Prepend crumb to stack
	 *
	 * @access	public
	 * @param	string $title
	 * @param	string $href
	 * @return	void
	 */
	function prepend_crumb($title, $href)
	{
		// no title or href provided
		if (!$title OR !$href) return;

		// add to start
		array_unshift($this->breadcrumbs, array('title' => $title, 'href' => $href));
	}

	// --------------------------------------------------------------------

	/**
	 * Generate breadcrumb
	 *
	 * @access	public
	 * @return	string
	 */
	function output()
	{
		// breadcrumb found
		if ($this->breadcrumbs) {

			// set output variable
			$output = $this->_tag_open;

			/*if (!empty($this->_prefix_crumb)){
				$output .= '<li class="last">'.$this->_prefix_crumb.'</li>';
			}*/

			// add html to output
			foreach ($this->breadcrumbs as $key => $crumb) {
				// add divider
				// if ($key) $output .= '<li class="divider">'.$this->_divider.'</li>';

				/*# if last element
				if (end(array_keys($this->breadcrumbs)) == $key) {
					$output .= '<span class="last"><a rel="v:url" property="v:title" title="' .$crumb['title']. '" href="' . $crumb['href'] . '">' . $crumb['title'] . '</a></span>';

				# else add link and divider
				} else {
					$output .= '<span class="item"><a rel="v:url" property="v:title" title="' .$crumb['title']. '" href="' . $crumb['href'] . '">' . $crumb['title'] . '</a></span>';
				}*/

				$output .= '<li class="last"><a rel="v:url" property="v:title" title="' .$crumb['title']. '" href="' . $crumb['href'] . '">' . $crumb['title'] . '</a></li>';
			}

			// return html
			return $output . $this->_tag_close . PHP_EOL;
		}

		// return blank string
		return '';
	}

}
// END Breadcrumb Class

/* End of file Breadcrumb.php */
/* Location: ./application/libraries/Breadcrumb.php */