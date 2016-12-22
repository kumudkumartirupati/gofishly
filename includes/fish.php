<?php
	require_once(LIB_PATH.DS.'db.php');
	class Fish extends DbObject {	
		protected static $table_name="fish";
		protected static $db_fields = array('id', 'type', 'breed', 'img_ful', 'img_tmb', 'hasPrm');
		public $id;
		public $type;
		public $breed;
		public $img_ful;
		public $img_tmb;
		public $hasPrm;
		private $temp_img_ful;
		private $temp_img_tmb;
		protected $upload_img_ful="full";
		protected $upload_img_tmb="thumb";
		public function attach_img_ful($file) {
			$mimes = array('image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/vnd.microsoft.icon', 'image/tiff', 'image/svg+xml', 'image/x-icon');
			if ($file['size'] > 5242880 || $file['size'] == 0) {
				return false;
			} elseif (!in_array($file['type'], $mimes)) {
				return false;
			} elseif ($file['error'] != 0) {
				return false;
			} else {
				$this->temp_img_ful  = $file['tmp_name'];
				$file_data = pathinfo(basename($file['name']));
				$this->img_ful = uniqid() . '.' . $file_data['extension'];
				$file_path = UPLOAD_PATH.DS. $this->upload_img_ful .DS. $this->img_ful;
				while(file_exists($file_path)) {
					$this->img_ful = uniqid() . '.' . $file_data['extension'];
					$file_path = UPLOAD_PATH.DS. $this->upload_img_ful .DS. $this->img_ful;
				}
				return true;
			}
		}
		public function save_img_ful() {
			if(empty($this->img_ful) || empty($this->temp_img_ful)) {
				return false;
			}
			$target_path = UPLOAD_PATH.DS. $this->upload_img_ful .DS. $this->img_ful;
			if(move_uploaded_file($this->temp_img_ful, $target_path)) {
				return true;
			} else {
				return false;
			}
		}
		public function attach_img_tmb($file) {
			$mimes = array('image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/vnd.microsoft.icon', 'image/tiff', 'image/svg+xml', 'image/x-icon');
			if ($file['size'] > 262144 || $file['size'] == 0) {
				return false;
			} elseif (!in_array($file['type'], $mimes)) {
				return false;
			} elseif ($file['error'] != 0) {
				return false;
			} else {
				$this->temp_img_tmb  = $file['tmp_name'];
				$file_data = pathinfo(basename($file['name']));
				$this->img_tmb = uniqid() . '.' . $file_data['extension'];
				$file_path = UPLOAD_PATH.DS. $this->upload_img_tmb .DS. $this->img_tmb;
				while(file_exists($file_path)) {
					$this->img_tmb = uniqid() . '.' . $file_data['extension'];
					$file_path = UPLOAD_PATH.DS. $this->upload_img_tmb .DS. $this->img_tmb;
				}
				return true;
			}
		}
		public function save_img_tmb() {
			if(empty($this->img_tmb) || empty($this->temp_img_tmb)) {
				return false;
			}
			$target_path = UPLOAD_PATH.DS. $this->upload_img_tmb .DS. $this->img_tmb;
			if(move_uploaded_file($this->temp_img_tmb, $target_path)) {
				return true;
			} else {
				return false;
			}
		}
		public function add_fish() {
			if($this->create()) {
				$this->unset_temp_files();
				return true;
			} else {
				return false;
			}
		}
		public function update_fish() {
			if($this->update()) {
				$this->unset_temp_files();
				return true;
			} else {
				return false;
			}
		}
		public function delete_fish() {
			if($this->delete()) {
				$this->destroy_img_ful();
				$this->destroy_img_tmb();
				return true;
			} else {
				return false;
			}
		}
		public function unset_temp_files() {
			if(isset($this->temp_img_ful)) {unset($this->temp_img_ful);}
			if(isset($this->temp_img_tmb)) {unset($this->temp_img_tmb);}
		}
		public function destroy_img_ful() {
			$target_path = UPLOAD_PATH.DS.$this->image_path_ful();
			return unlink($target_path) ? true : false;
		}
		public function image_path_ful() {
			return $this->upload_img_ful.DS.$this->img_ful;
		}
		public function destroy_img_tmb() {
			$target_path = UPLOAD_PATH.DS.$this->image_path_tmb();
			return unlink($target_path) ? true : false;
		}
		public function image_path_tmb() {
			return $this->upload_img_tmb.DS.$this->img_tmb;
		}
	}
?>