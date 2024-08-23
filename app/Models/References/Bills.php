<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBills
 */
class Bills extends Model
{
    const STATUS_NEZAVERSHEN = 1;
    const STATUS_ZAVERSHEN = 2;
    const STATUS_OTMEN = 3;
    const STATUS_OBRABOT = 4;
    const TYPE_PAY = 1;
    const TYPE_PPRIZ = 2;
    const TYPE_REMOTE = 3;
    const TYPE_NON = 4;
    const TYPE_PAY_SER = 5;
    const MIN_BALANCE = 1;

    protected $table = 'bills';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'user_balance',
        'service_id',
        'svc_activate',
        'svc_settings',
        'item_id',
        'type',
        'psystem',
        'amount',
        'money',
        'currency_id',
        'date_cr',
        'date_pay',
        'status',
        'description',
        'details',
        'ip',
        'promocode_id'
    ];

    /**
     * Foydalanuvchilar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Tranzaksiya xolatini aniqlash
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function statusDesc()
    {
        if ($this->status == $this::STATUS_NEZAVERSHEN) {
            return trans('messages.Bills Not finished');
        }
        if ($this->status == $this::STATUS_ZAVERSHEN) {
            return trans('messages.Bills Completed');
        }
        if ($this->status == $this::STATUS_OTMEN) {
            return trans('messages.Bills Canceled');
        }
        return trans('messages.Bills Being processed');
    }

    /**
     * Statusga qarab jadval qatorlarini rangini aniqlash
     *
     * @return string
     */
    public function trClass()
    {
        if ($this->status == $this::STATUS_NEZAVERSHEN) {
            return 'table-warning';
        }
        if ($this->status == $this::STATUS_ZAVERSHEN) {
            return 'table-info';
        }
        if ($this->status == $this::STATUS_OTMEN) {
            return 'table-danger';
        }
        return 'table-light';
    }

    /**
     * Turlarni nomini qaytarish
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function typeDesc()
    {
        if ($this->type == $this::TYPE_PAY) {
            return trans('messages.Bills Refill');
        }
        if ($this->type == $this::TYPE_PPRIZ) {
            return trans('messages.Bills Present');
        }
        if ($this->type == $this::TYPE_REMOTE) {
            return trans('messages.Bills Account write-off');
        }
        return trans('messages.Bills Service payment');
    }

    /**
     * To'lov qilingan sananai qaytarish
     *
     * @return false|string|null
     */
    public function getDatePay()
    {
        if ($this->date_cr != null) {
            return date('H:i d.m.Y', strtotime($this->date_cr));
        }
        return null;
    }

    public static function getHistory($user)
    {
        $bills = Bills::where(['user_id' => $user->id])->orderBy('id', 'desc')->get();
        $result = [];
        foreach ($bills as $value) {
            $result [] = [
                'id' => $value->id,
                //'userFio' => $value->user->getUserFio(),
                'date_pay' => $value->getDatePay(),
                'amount' => number_format($value->amount, 0, '.', ' ') . ' ' . trans('messages.Sum'),
                'description' => $value->description,
                'status' => $value->status,
                'type' => $value->type,
                'trClass' => $value->trClass(),
                'typeDesc' => $value->typeDesc(),
                'statusDesc' => $value->statusDesc(),
            ];
        }
        return $result;
    }
}
