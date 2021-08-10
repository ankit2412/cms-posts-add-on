<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.auth-test.com
 * @since      1.0.0
 *
 * @package    Cms_Posts_Add_On
 * @subpackage Cms_Posts_Add_On/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cms_Posts_Add_On
 * @subpackage Cms_Posts_Add_On/admin
 * @author     Ankit Jani <ankitj@cmsminds.com>
 */

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Cms_Posts_Add_On_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cms_Posts_Add_On_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cms_Posts_Add_On_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cms-posts-add-on-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cms_Posts_Add_On_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cms_Posts_Add_On_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cms-posts-add-on-admin.js', array( 'jquery' ), $this->version, false );

		$params = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'labels'  => array(
				'export_posts' => __( 'Export csv', $this->plugin_name ),
				'export_posts_xlsx' => __( 'Export xlsx', $this->plugin_name )
			)
		);

		wp_localize_script( $this->plugin_name, 'cms_export_posts_admin', $params );

	}

	public function getPostsData() {
		global $wpdb;
		$res_posts = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` where `post_type`='post' and `post_status`='publish'", OBJECT );

		$posts= [];
		foreach ($res_posts as $key => $post) :

			$posts[$key]['ID'] = $post->ID;
			$posts[$key]['Title'] = $post->post_title;
			$posts[$key]['Content'] = $post->post_content;
			$posts[$key]['Status'] = $post->post_status;
			$posts[$key]['Publish Date'] = $post->post_date;
			$posts[$key]['Modified Date'] = $post->post_modified;

		endforeach;

		return $posts;
	}

	public function cms_export_file( $posts, $type ){
		if( ! empty( $posts ) ) :
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$dataHeader = array_keys( reset($posts) );
			
			for ($i = 0, $l = sizeof($dataHeader); $i < $l; $i++) :
				$sheet->setCellValueByColumnAndRow($i + 1, 1, $dataHeader[$i]);
			endfor;
			
			for ($i = 0, $l = sizeof($posts); $i < $l; $i++) : // row $i
				$j = 0;
				foreach ($posts[$i] as $k => $v) : // column $j
					$sheet->setCellValueByColumnAndRow($j + 1, ($i + 1 + 1), $v);
					$j++;
				endforeach;
			endfor;

			$fileName = "posts-" . date('Y-m-d-H-i-s') . "." . $type;
			
			$writer = IOFactory::createWriter($spreadsheet, $type);
			if( 'Xlsx' == $type ) :
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			else : 
				header('Content-Type: application/x-www-form-urlencoded');
			endif;
        	header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
			header('Cache-Control: max-age=0');
			$writer->save('php://output');

			die();
		endif;
	}

	public function export_file(){
		$posts = $this->getPostsData();
		if( ! empty($posts) && ! empty($_POST['export_type']) ){
			return $this->cms_export_file( $posts, $_POST['export_type'] );
			die();
		}
	}

}
