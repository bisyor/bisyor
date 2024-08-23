<?php

namespace backend\controllers\references;

use Yii;
use yii\web\Controller;


class CkeditorController extends Controller
{

    /**
     * Image download from Ckeditor
     */
	public function actionImageUpload()
    {
        if($_FILES['upload']) {
        	$url = null;
        	$message = null; 
	        $funcNum = $_REQUEST['CKEditorFuncNum'];
	        $path = Yii::$app->params['image_site_upload_folder'];
			$folder = 'uploads/ckeditor_images/';

          	if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
          		$message = Yii::t('app', "Please Upload an image.");
          	}
          	else {
          		if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 5*1024*1024) {
          			$message = Yii::t('app', "The image should not exceed 5MB.");
          		}
		        else {
		          	if ( ($_FILES['upload']["type"] != "image/jpg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png")) {
		          		$message = Yii::t('app', "The image type should be JPG , JPEG Or PNG.");
		          	}
	          		else {
		          		if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
		          			$message = Yii::t('app', "Upload Error, Please try again.");
		          		}
				        else {
				            $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
				            //Rename the image here the way you want
				            $name = time() . '.' . $extension; 
				            // Here is the folder where you will save the images
				            $url =  $path . 'ckeditor_images/' . $name;
				            move_uploaded_file( $_FILES['upload']['tmp_name'], $folder . $name );
			        	}
			    	}
			    }
			}
        	echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $funcNum . '", "' . $url . '", "' . $message . '" );</script>';
        }
    }

}
