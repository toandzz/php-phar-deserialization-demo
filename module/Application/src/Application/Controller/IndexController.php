<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function uploadAction()
    {
        $message = '';
        $request = $this->getRequest();

        if ($request->isPost()) {
            $file = $this->params()->fromFiles('image');
            $uploadDir = 'public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $target = $uploadDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $message = 'Tải lên thành công.';
            } else {
                $message = 'Tải lên thất bại.';
            }
        }

        return new ViewModel(['message' => $message]);
    }

    public function resizeAction()
    {
        $uploadDir = 'public/uploads/';
        $resizeDir = 'public/resized/';
        if (!is_dir($resizeDir)) {
            mkdir($resizeDir, 0777, true);
        }
        $images = array_diff(scandir($uploadDir), ['.', '..']);
        $message = '';

        $request = $this->getRequest();
        if ($request->isPost()) {
            $filename = $this->params()->fromPost('filename');
            $width = (int)$this->params()->fromPost('width');
            $height = (int)$this->params()->fromPost('height');

            $source = $filename;
            $target = $resizeDir . basename($filename);

            if (file_exists($source)) {
                $cmd = sprintf(
                    'magick.exe %s -resize %dx%d! %s',
                    escapeshellarg($source),
                    $width,
                    $height,
                    escapeshellarg($target)
                );
                exec($cmd, $output, $returnCode);

                if ($returnCode === 0) {
                    $message = 'Resize thành công bằng ImageMagick.';
                } else {
                    $message = 'Lỗi khi resize bằng ImageMagick.';
                }
            } else {
                $message = 'Ảnh không tồn tại trong thư mục uploads.';
            }
        }

        return new ViewModel([
            'images' => $images,
            'message' => $message,
        ]);
    }

    public function downloadAction()
    {
        $resizeDir = 'public/resized/';
        $file = $this->params()->fromQuery('file');
        $path = $resizeDir . $file;

        if ($file && file_exists($path)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            readfile($path);
            exit;
        }

        $images = array_diff(scandir($resizeDir), ['.', '..']);
        return new ViewModel(['images' => $images]);
    }
}
