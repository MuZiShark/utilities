<?php 

class ImagickCrop {
	
	protected $im;
	protected $imageUrl = '';		//图片地址
	protected $thumbPath = '';		//缩略图路径
	protected $thumbName = '';		//缩略图名称
	private $thumbMaxWidth = 600;	//缩略图最大宽度
    private $thumbMaxHeight = 0;	//缩略图最大高度
    private $ext='jpg';
    private $dst_file;
	
	public function initImagick($imageUrl, $ext) {
		$this->imageUrl = $imageUrl;
		$this->thumbPath = dirname($imageUrl).'/';
		$this->thumbName = basename($imageUrl, $ext);
		$this->ext = $ext;
	}
	
	public function getImagick() {
		if(!$this->im) {
			$this->im = new Imagick($this->imageUrl);
		}
		return $this->im;
	}
	
	public function destroyImagick() {
		if($this->ext !== 'jpg') {
			unlink($this->imageUrl);
			rename($this->dst_file, $this->thumbPath.$this->thumbName.$this->ext);
		}
		$this->im->clear();
 		$this->im->destroy();
	}
	
	public function imagickCompressImage() {
		self::getImagick();
		$w = $this->im->getImageWidth();
		$h = $this->im->getImageHeight();
		
// 		if($w > $this->thumbMaxWidth) {
// 			$w = $this->thumbMaxWidth;
// 			$h = $this->thumbMaxHeight;
// 		}
		
		$this->im->resizeImage($w, $h, Imagick::FILTER_CATROM, 1);
 		$this->im->setImageFormat('JPEG');
 		$this->im->setImageCompression(Imagick::COMPRESSION_JPEG);
		$a = $this->im->getImageCompressionQuality()*0.75;
		if($a == 0) $a = 75;
		$this->im->setImageCompressionQuality($a);
		$this->im->stripImage();
		$this->dst_file = $this->thumbPath.$this->thumbName.'jpg';
		$this->im->writeImage($this->dst_file);
		$this->destroyImagick();
	}
}

	/**
	 * 取得上传文件的后缀
	 * @param string $filename 文件名
	 * @return string
	 */
	function getExt($filename) {
		$pathinfo = pathinfo($filename);
		return $pathinfo['extension'];
	}

	function solve($path, $traversal=true, $exceptdir=array()) {
		$handle = opendir($path);
		while(($file = readdir($handle)) !== false) {
			$filepath = $path.DIRECTORY_SEPARATOR.$file;
			if($file == "." || $file == "..") {
				continue;
			} else if(is_dir($filepath)) {
				if($traversal) solve($filepath, $traverval, $exceptdir);
			} else {
				$ext = getExt($filepath);
				if(in_array(strtolower($ext), array('jpg','jpeg','png'))) {
					$imagick = new ImagickCrop();
					$imagick->initImagick($filepath, $ext);
					$imagick->imagickCompressImage();
					unset($imagick);
				}
			}
		}
		closedir($handle);
	}


//error_reporting(E_ALL);

$path = '/usr/share/nginx/html/testimg';
solve($path);
echo "finished!";


