<?php
class GDImageTest extends ImageTest {
	public function setUp() {
		if(!extension_loaded("gd")) {
			$this->markTestSkipped("The GD extension is required");
			$this->skipTest = true;
			parent::setUp();
			return;
		}
	
		parent::setUp();
		
		Image::set_backend("GDBackend");
		
		// Create a test files for each of the fixture references
		$fileIDs = $this->allFixtureIDs('Image');
		foreach($fileIDs as $fileID) {
			$file = DataObject::get_by_id('Image', $fileID);
			
			$image = imagecreatetruecolor(300,300);

			imagepng($image, BASE_PATH."/{$file->Filename}");
			imagedestroy($image);
		
			$file->write();
		}
	}

	public function testLockfileRemovalOnImageDelete() {
		$testFile = $this->objFromFixture('Image', 'deletion_test_image');
		$pathInfo = pathinfo($testFile->getFullPath());
		$lockfile = $pathInfo['dirname'] . '.lock.' . $pathInfo['filename'];
		touch($lockfile); //create .lock file
		$this->assertTrue(file_exists($lockfile));
		$testFile->delete();
		$this->assertFalse(file_exists($lockfile));
	}
}
