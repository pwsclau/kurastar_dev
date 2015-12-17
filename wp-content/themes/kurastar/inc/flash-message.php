<?php
if ( ! class_exists('Flash_Message') ) {
	
	session_start();

	class Flash_Message {

		function __construct() {
			add_shortcode( 'flash-messages', array($this, 'flash_messages') );
		}


		function set($message = '', $type = 'updated') {
			if ( $message != '' ) { 

				$_SESSION['wp_flash_message'][$type][] = $message;
			}

		}

		function get() {
			return array_get($_SESSION, 'wp_flash_message');
		}

		function get_value($key) {
			
			if ( $this->get() ) 
				return  array_get($_SESSION['wp_flash_message'], $key);
			else
				return false;
		}


		function recursive_arr($arr, $text = '') {

			if ( is_array($arr) ) {

				

				foreach ($arr as $k => $item) {

					if (is_array($item)) {
						$text .= wpc_recursive_arr($item, $text);
					} else {

						$text .= $item.'<br />';
					}
				}
			} 


			
			return $text;
		
		}

		function flash_messages($echo = true) {

			
			$messages = $this->get();

			$message_text = '';

			if ( ! $this->is_empty() ) {


				foreach ($messages as $type => $message) {


					$msg_text = '';

					$msg_text = $this->recursive_arr($message, $msg_text);

					$message_text .= '<div class="alert alert-warning '.$type.'"><strong>'.$msg_text.'</strong></div>';
				}


			}

			$this->flush();

			if ($echo === false) {
				return $message_text;
			}

			echo $message_text;
		}


		function flush() {

			$_SESSION['wp_flash_message'] = array();
			unset($_SESSION['wp_flash_message']);
		}

		function is_empty() {
			return count($this->get()) == 0;
		}

	}	
}