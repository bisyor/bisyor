<?php


namespace App\Models\References;


use Illuminate\Support\Facades\Storage;

/**
 * App\Models\References\VacancyResume
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $phone Телефон
 * @property string|null $file Файл
 * @property string|null $description Описания
 * @property int|null $vacancy_id
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume query()
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyResume whereVacancyId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperVacancyResume
 */
class VacancyResume extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    protected $table = 'vacancy_resume';
    protected $fillable = ['name', 'phone', 'file', 'description', 'vacancy_id'];


    /**
     * This function returned model rules, before save for validation
     *
     * @return array
     */
    public static function rules():array{
        return [
            'name' => 'required|max:255',
            'file' => 'mimes:jpg,jpeg,gif,png,doc,pdf,docx|max:4096',
            'phone' => 'required|numeric',
        ];
    }

    /**
     * Foydalanuchi ishga topshirganda malumotlarni saqlagandan so'ng resume fayli mavjuda bo'lsa
     * uni serverlarmizga yuklaydi
     * @param $file
     */
    public function setCv($file)
    {
        $exc = $file->getClientOriginalExtension();
        $resume_name = "resume_" . time() . ".$exc";
        $uploadPath = config('app.resumeRoute');
        Storage::disk('ftp')->put($uploadPath . $resume_name, $file);
        $this->file = $resume_name;
        return $this;
    }
}
