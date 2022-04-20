using cast with accessor

// model

protected $casts = [
        'adv_to_recover' => 'decimal:2',
        'adv_recovered' => 'decimal:2',
        'adv_balance' => 'decimal:2',
    ];

    /**
     * Get the
     *
     * @param  string  $value
     * @return string
     */
    public function getAdvBalanceAttribute()
    {
        return $this->castAttribute('adv_balance', $this->attributes['adv_to_recover'] - $this->attributes['adv_recovered']);
    }
}

// view

<td  class="text-right">{{$medi->adv_balance}}</td>
