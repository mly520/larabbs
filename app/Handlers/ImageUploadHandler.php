<?php

namespace App\Handlers;

use Image;
/**
 * ハンドラー：画像アップロード
 * Class ImageUploadHandler
 * @package App\Handlers
 */
class ImageUploadHandler
{
    protected $allowed_ext = ['gif', 'png', 'jpeg', 'jpg'];

    public function save($file, $folder, $file_prefix, $max_width=false)
    {
        // フォルダ保存ルール 例：uploads/images/avatars/201805/27/
        // フォルダ分けた方が早い
        $folder_name = "upload/image/$folder/" . date('Ym/d', time());

        $upload_path = public_path() . '/' . $folder_name;
        // ファイルの拡張子を取得
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        // サーバーに保存するファイル名を生成
        $file_name = $file_prefix . '_' . time() . str_random(10) . $extension;
        // アップロード許可する拡張子かどうかチェック
        if(! in_array($extension,$this->allowed_ext))
        {
            return false;
        }
        // 指定した場所へファイルを保存
        $file->move($upload_path, $file_name);
        // ファイルサイズが制御してる場合は画像をリサイズ 'gif'ファイルは対象外
        if($max_width && $extension != 'gif')
        {
            $this->reduceSize($upload_path . '/' . $file_name, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$file_name"
        ];
    }

    /**
     * 画像リサイズ処理　ライブラリーintervention/imageを使用
     *
     * @param $file_path
     * @param $max_width
     */
    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);
        $image->resize($max_width, null, function ($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save();
    }
}