<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait PictureTrait
{
    /**
     * خزّن صورة وأعد رابطها العام.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string رابط الصورة
     */
    public static function storePicture(UploadedFile $file, string $directory = 'uploads'): string
    {

        $disk = Storage::disk('public');

        // اسم فريد للملف
        $filename = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

        // تخزين في القرص المحدّد (public)
        $path = $file->storeAs($directory, $filename, 'public');

        return $disk->url($path);
    }

    /**
     * احذف صورة سابقة إن وُجدت.
     *
     * @param string|null $url
     * @return void
     */
    public static function destroyPicture(?string $url): void
    {
        if (!$url) {
            return;
        }

        $disk = Storage::disk('public');

        // نحصل على المسار النسبي داخل القرص
        $relativePath = str_replace($disk->url('/'), '', $url);

        $disk->delete($relativePath);
    }

    /**
     * حدِّث الصورة القديمة بصورة جديدة (إن وُجدت)، وأعِد الرابط النهائي.
     *
     * @param UploadedFile|null $file
     * @param string|null $oldUrl
     * @param string $directory
     * @return string|null
     */
    public static function updatePicture(?UploadedFile $file, ?string $oldUrl, string $directory = 'uploads'): ?string
    {
        // إذا لم يُرسل ملف جديد أبقِ على القديم
        if (!$file) {
            return $oldUrl;
        }

        // احذف القديم ثم خزّن الجديد
        self::destroyPicture($oldUrl);

        return self::storePicture($file, $directory);
    }
}
