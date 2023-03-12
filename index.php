<?php
header("Access-Control-Allow-Origin: *");
function error($state, $message)
{
    if ($state == 'throw') {
        $output = array(
            'Error' => $message
        );
        echo json_encode($output);
    } else if ($state == 'check') {
    }
}
function getInfo()
{
    // 取得情報の選別したい（数字とか文字数とかURLとか）
    if (isset($_GET['name']) && isset($_GET['icon']) && isset($_GET['money']) && isset($_GET['text'])) {
        $name = $_GET['name'];
        $icon = $_GET['icon'];
        $money = $_GET['money'];
        $text = $_GET['text'];
        return [$name, $icon, $money, $text];
    } else {
        error('throw', 'Bad Request: Parameters are missing.');
        return;
    }
}

function color($money)
{
    $money = (int)$money;
    if ($money <= 199) {
        //青
        $topC = '#1565C0';
        $bottomC = '#1565C0';
        $nameFontC = '#ffffffb3';
        $moneyFontC = '#ffffff';
        $textFontC = '#ffffff';
    } else if ($money <= 499) {
        //水色
        $topC = '#00B8D4';
        $bottomC = '#00E5FF';
        $nameFontC = '#000000b3';
        $moneyFontC = '#000000';
        $textFontC = '#000000';
    } else if ($money <= 999) {
        //緑
        $topC = '#00BFA5';
        $bottomC = '#1DE9B6';
        $nameFontC = '#000000b3';
        $moneyFontC = '#000000';
        $textFontC = '#000000';
    } else if ($money <= 1999) {
        //黄色
        $topC = '#FFB300';
        $bottomC = '#FFCA28';
        $nameFontC = '#000000b3';
        $moneyFontC = '#000000';
        $textFontC = '#000000';
    } else if ($money <= 4999) {
        //オレンジ
        $topC = '#E65100';
        $bottomC = '#F57C00';
        $nameFontC = '#ffffffb3';
        $moneyFontC = '#ffffff';
        $textFontC = '#ffffff';
    } else if ($money <= 9999) {
        //マゼンタ
        $topC = '#C2185B';
        $bottomC = '#E91E63';
        $nameFontC = '#ffffffb3';
        $moneyFontC = '#ffffff';
        $textFontC = '#ffffff';
    } else {
        //赤
        $topC = '#D00000';
        $bottomC = '#E62117';
        $nameFontC = '#ffffffb3';
        $moneyFontC = '#ffffff';
        $textFontC = '#ffffff';
    }
    return [$topC, $bottomC, $nameFontC, $moneyFontC, $textFontC];
}

// =========================
// 基本設定

// フォントファイルのパス
$notosansjpFontFile = 'fonts/NotoSansJP.otf';

// 入力情報取得
$info = getInfo();
if ($info == false) {
    return;
} else {
    $name = $info[0];
    $icon = $info[1];
    $money = $info[2];
    $text = $info[3];
}

// 改行後テキスト取得
$url = 'https://api.pocopota.com/break?text=' . urlencode($text) . '&font_size=10.5&box_width=303';
$data = json_decode(file_get_contents($url));
$textArr = $data->result;

// 使用カラー取得
$color = color($money);

// hex形式をrgb形式へ変換
$i = 0;
foreach ($color as $hexC) {
    $redCode = hexdec(substr($hexC, 1, 2));
    $greenCode = hexdec(substr($hexC, 3, 2));
    $blueCode = hexdec(substr($hexC, 5, 2));
    $rgb = [$redCode, $greenCode, $blueCode];

    $color[$i] = $rgb;
    $i++;
}

// icon画像編集
$icon = 'https://api.pocopota.com/icon-maker?size=40&url=' . $icon;

// GDイメージのサイズ
$width = 335;

// 必要な高さの計算
$textHeight = count($textArr) * 11 + (count($textArr) - 1) * 10;
$height = 56 + $textHeight + 32;

// =========================



// GDイメージを作成
$scimage = imagecreatetruecolor($width, $height);

// 使用カラー
$topColor = imagecolorallocate($scimage, $color[0][0], $color[0][1], $color[0][2]);
$bottomColor = imagecolorallocate($scimage, $color[1][0], $color[1][1], $color[1][2]);
$nameFontColor = imagecolorallocatealpha($scimage, $color[2][0], $color[2][1], $color[2][2], 30);
$moneyFontColor = imagecolorallocate($scimage, $color[3][0], $color[3][1], $color[3][2]);
$textFontColor = imagecolorallocate($scimage, $color[4][0], $color[4][1], $color[4][2]);

// 背景を塗りつぶす
imagefill($scimage, 0, 0, $topColor);
ImageFilledRectangle($scimage, 0, 56, $width, $height, $bottomColor);

// 各種文字描画
imagettftext($scimage, 10, 0, 72, 8 + 11, $nameFontColor, $notosansjpFontFile, $name);
imagettftext($scimage, 11, 0, 72, 8 + 11 + 14 + 5, $moneyFontColor, $notosansjpFontFile, '￥' . number_format($money));

// 本文描画
$i = count($textArr) - 1;
foreach ($textArr as $line) {
    $y = $height - 16 - $i * 21;
    imagettftext($scimage, 11, 0, 16, $y, $textFontColor, $notosansjpFontFile, $line);
    $i--;
}

// アイコン画像描画
$iconImage = imagecreatefrompng($icon);
imagecopy($scimage, $iconImage, 16, 8, 0, 0, 40, 40);

// 画像を出力
header('Content-Type: image/png');
imagepng($scimage);

// GDイメージを破棄
imagedestroy($scimage);