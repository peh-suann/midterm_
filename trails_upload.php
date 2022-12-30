<?php
header('Content-Type:application/json');
$trail_img = 'trail_image';


$trail_type = [
  'image/png' => '.png',
  'image/jpeg' => '.jpg',
];


$success = false;
$filename = '';
if (!empty($_FILES[$trail_img]) and $_FILES[$trail_img]['error'] === 0) {

  if (empty($trail_type[$_FILES[$trail_img]['type']])) {
    echo json_encode([
      'success' => false,
      'error' => '圖片格式錯誤'
    ]);
    exit;
  }

  $t_t = $trail_type[$_FILES[$trail_img]['type']];
  $filename = sha1(uniqid() . rand()) . $t_t;


  $success = move_uploaded_file(
    $_FILES[$trail_img]['tmp_name'],
    __DIR__ . './trails_uploaded/' . $filename
  );
}

echo json_encode(
  [
    'success' => $success,
    'filename' => $filename
  ]
);
